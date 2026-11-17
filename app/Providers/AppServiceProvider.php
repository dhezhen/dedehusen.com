<?php

namespace App\Providers;

use App\Models\SiteSetting;
use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\RateLimiter;
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
        RateLimiter::for('contact', fn (Request $request) => Limit::perHour(30)->by(hash_hmac('sha256', (string) $request->ip(), config('app.key'))));

        View::composer('layouts.site', function ($view): void {
            $settings = Cache::rememberForever('site-settings', fn () => SiteSetting::query()->first()?->attributesToArray());

            $view->with('settings', $settings ? new SiteSetting($settings) : null);
        });
    }
}
