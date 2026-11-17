<?php

namespace App\Providers\Filament;

use App\Filament\Widgets\DashboardHighlights;
use App\Filament\Widgets\SiteOverview;
use App\Filament\Widgets\VisitsChart;
use Filament\Http\Middleware\Authenticate;
use Filament\Http\Middleware\AuthenticateSession;
use Filament\Http\Middleware\DisableBladeIconComponents;
use Filament\Http\Middleware\DispatchServingFilamentEvent;
use Filament\Pages\Dashboard;
use Filament\Panel;
use Filament\PanelProvider;
use Filament\Support\Colors\Color;
use Illuminate\Cookie\Middleware\AddQueuedCookiesToResponse;
use Illuminate\Cookie\Middleware\EncryptCookies;
use Illuminate\Foundation\Http\Middleware\PreventRequestForgery;
use Illuminate\Routing\Middleware\SubstituteBindings;
use Illuminate\Session\Middleware\StartSession;
use Illuminate\View\Middleware\ShareErrorsFromSession;

class AdminPanelProvider extends PanelProvider
{
    public function panel(Panel $panel): Panel
    {
        return $panel
            ->default()
            ->id('admin')
            ->path('admin')
            ->brandName(config('app.name'))
            ->favicon(asset('favicon.svg').'?v='.filemtime(public_path('favicon.svg')))
            ->theme(asset('css/filament/admin/theme.css').'?v='.filemtime(public_path('css/filament/admin/theme.css')))
            ->login()
            ->sidebarCollapsibleOnDesktop()
            ->colors([
                'primary' => [
                    50 => '#eaf6f6',
                    100 => '#d4eeef',
                    200 => '#b4dfe1',
                    300 => '#85c9cc',
                    400 => '#54b2b8',
                    500 => '#0b7c83',
                    600 => '#075f66',
                    700 => '#064a50',
                    800 => '#073b40',
                    900 => '#082e32',
                    950 => '#051e21',
                ],
                'gray' => Color::Slate,
            ])
            ->discoverResources(in: app_path('Filament/Resources'), for: 'App\Filament\Resources')
            ->discoverPages(in: app_path('Filament/Pages'), for: 'App\Filament\Pages')
            ->pages([
                Dashboard::class,
            ])
            ->discoverWidgets(in: app_path('Filament/Widgets'), for: 'App\Filament\Widgets')
            ->widgets([
                VisitsChart::class,
                SiteOverview::class,
                DashboardHighlights::class,
            ])
            ->middleware([
                EncryptCookies::class,
                AddQueuedCookiesToResponse::class,
                StartSession::class,
                AuthenticateSession::class,
                ShareErrorsFromSession::class,
                PreventRequestForgery::class,
                SubstituteBindings::class,
                DisableBladeIconComponents::class,
                DispatchServingFilamentEvent::class,
            ])
            ->authMiddleware([
                Authenticate::class,
            ]);
    }
}
