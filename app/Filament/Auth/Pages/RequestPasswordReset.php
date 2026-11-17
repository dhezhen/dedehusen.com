<?php

namespace App\Filament\Auth\Pages;

use App\Notifications\SynchronousPasswordReset;
use DanHarrin\LivewireRateLimiting\Exceptions\TooManyRequestsException;
use Filament\Auth\Pages\PasswordReset\RequestPasswordReset as BaseRequestPasswordReset;
use Filament\Facades\Filament;
use Filament\Models\Contracts\FilamentUser;
use Filament\Notifications\Notification;
use Filament\Support\Components\Attributes\Exposed;
use Illuminate\Auth\Events\PasswordResetLinkSent;
use Illuminate\Auth\Passwords\PasswordBroker;
use Illuminate\Contracts\Auth\CanResetPassword;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Password;
use LogicException;
use SensitiveParameter;
use Throwable;

class RequestPasswordReset extends BaseRequestPasswordReset
{
    #[Exposed]
    public function request(): void
    {
        try {
            $this->rateLimit(2);
        } catch (TooManyRequestsException $exception) {
            $this->getRateLimitedNotification($exception)?->send();

            return;
        }

        if (config('mail.default') !== 'smtp' || blank(config('mail.mailers.smtp.host'))) {
            Notification::make()
                ->title('Email belum dikonfigurasi')
                ->body('Admin perlu mengisi pengaturan SMTP di dashboard sebelum tautan reset dapat dikirim.')
                ->danger()
                ->send();

            return;
        }

        $data = $this->form->getState();

        try {
            $status = Password::broker(Filament::getAuthPasswordBroker())->sendResetLink(
                $this->getCredentialsFromFormData($data),
                function (CanResetPassword $user, #[SensitiveParameter] string $token): void {
                    if ($user instanceof FilamentUser && ! $user->canAccessPanel(Filament::getCurrentOrDefaultPanel())) {
                        return;
                    }

                    if (! method_exists($user, 'notify')) {
                        throw new LogicException('The password reset user must support notifications.');
                    }

                    $notification = new SynchronousPasswordReset($token);
                    $notification->url = Filament::getResetPasswordUrl($token, $user);

                    $user->notify($notification);

                    if (class_exists(PasswordResetLinkSent::class)) {
                        event(new PasswordResetLinkSent($user));
                    }
                },
            );
        } catch (Throwable $exception) {
            Log::warning('Password reset email delivery failed.', [
                'exception_class' => $exception::class,
            ]);

            Notification::make()
                ->title('Email reset gagal dikirim')
                ->body('Periksa pengaturan SMTP di dashboard atau hubungi admin situs.')
                ->danger()
                ->send();

            return;
        }

        if ($status !== PasswordBroker::RESET_LINK_SENT) {
            $this->getFailureNotification($status)?->send();

            return;
        }

        $this->getSentNotification($status)?->send();
        $this->form->fill();
    }
}
