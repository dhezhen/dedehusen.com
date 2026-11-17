<?php

namespace App\Notifications;

use Illuminate\Auth\Notifications\ResetPassword as BaseResetPassword;
use Illuminate\Notifications\Messages\MailMessage;

class SynchronousPasswordReset extends BaseResetPassword
{
    public string $url;

    public function toMail($notifiable): MailMessage
    {
        return parent::toMail($notifiable)->mailer('smtp');
    }

    protected function resetUrl(mixed $notifiable): string
    {
        return $this->url;
    }
}
