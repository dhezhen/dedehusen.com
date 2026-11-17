<?php

namespace App\Providers;

use App\Models\SiteSetting;
use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Contracts\Encryption\DecryptException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        $this->configureMailFromSiteSettings();

        RateLimiter::for('contact', fn (Request $request) => Limit::perHour(30)->by(hash_hmac('sha256', (string) $request->ip(), config('app.key'))));

        View::composer('layouts.site', function ($view): void {
            $settings = Cache::rememberForever('site-settings', fn () => SiteSetting::query()->first()?->attributesToArray());

            $view->with('settings', $settings ? new SiteSetting($settings) : null);
        });
    }

    private function configureMailFromSiteSettings(): void
    {
        if (app()->runningInConsole() || ! Schema::hasTable('site_settings')) {
            return;
        }

        $settings = SiteSetting::query()->first();

        if ($settings === null) {
            return;
        }

        if (filled($settings->contact_mail_to)) {
            config()->set('mail.contact_to', $settings->contact_mail_to);
        }

        if (blank($settings->smtp_host) || blank($settings->smtp_port) || blank($settings->smtp_from_address)) {
            return;
        }

        try {
            $smtpPassword = $settings->smtp_password;
        } catch (DecryptException) {
            return;
        }

        config()->set([
            'mail.default' => 'smtp',
            'mail.mailers.smtp.transport' => 'smtp',
            'mail.mailers.smtp.url' => null,
            'mail.mailers.smtp.scheme' => $settings->smtp_scheme ?: null,
            'mail.mailers.smtp.host' => $settings->smtp_host,
            'mail.mailers.smtp.port' => $settings->smtp_port,
            'mail.mailers.smtp.username' => $settings->smtp_username ?: config('mail.mailers.smtp.username'),
            'mail.mailers.smtp.password' => $smtpPassword ?: config('mail.mailers.smtp.password'),
            'mail.from.address' => $settings->smtp_from_address,
            'mail.from.name' => $settings->smtp_from_name ?: config('app.name'),
        ]);
    }
}
