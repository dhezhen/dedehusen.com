<?php

namespace App\Filament\Resources\SiteSettings\Pages;

use App\Filament\Resources\SiteSettings\SiteSettingResource;
use Filament\Actions\Action;
use Filament\Actions\DeleteAction;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\EditRecord;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Throwable;

class EditSiteSetting extends EditRecord
{
    protected static string $resource = SiteSettingResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Action::make('sendSmtpTest')
                ->label('Kirim email uji')
                ->action(function (): void {
                    $recipient = auth()->user()?->email;

                    if (blank($recipient)) {
                        Notification::make()
                            ->title('Alamat email admin tidak tersedia')
                            ->danger()
                            ->send();

                        return;
                    }

                    try {
                        Mail::mailer('smtp')->raw(
                            'Email ini menguji pengaturan SMTP dari dashboard admin.',
                            fn ($message) => $message
                                ->to($recipient)
                                ->subject('Uji pengaturan email'),
                        );

                        Notification::make()
                            ->title('Email uji berhasil dikirim')
                            ->body('Periksa kotak masuk alamat email admin Anda.')
                            ->success()
                            ->send();
                    } catch (Throwable $exception) {
                        Log::warning('SMTP test email failed.', [
                            'exception_class' => $exception::class,
                        ]);

                        Notification::make()
                            ->title('Email uji gagal dikirim')
                            ->body('Periksa host, port, enkripsi, dan kredensial SMTP.')
                            ->danger()
                            ->send();
                    }
                }),
            DeleteAction::make(),
        ];
    }
}
