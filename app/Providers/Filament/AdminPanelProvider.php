<?php

namespace App\Providers\Filament;

use Filament\Http\Middleware\Authenticate;
use Filament\Http\Middleware\AuthenticateSession;
use Filament\Http\Middleware\DisableBladeIconComponents;
use Filament\Http\Middleware\DispatchServingFilamentEvent;
use Filament\Panel;
use Filament\PanelProvider;
use Filament\Support\Colors\Color;
use Filament\View\PanelsRenderHook;
use Filament\Navigation\NavigationGroup;
use Illuminate\Cookie\Middleware\AddQueuedCookiesToResponse;
use Illuminate\Cookie\Middleware\EncryptCookies;
use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken;
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
            ->login()
            ->colors([
                'primary' => Color::Hex('#5B2C6F'),
                'danger' => Color::Hex('#DC2626'),
                'success' => Color::Hex('#2E7D32'),
                'warning' => Color::Hex('#E65100'),
                'info' => Color::Hex('#1565C0'),
            ])
            ->brandName('BLOSSOM')
            ->brandLogo(asset('assets/blossom-logo.png'))
            ->favicon(asset('assets/blossom-logo.png'))
            ->font('inter')
            ->brandLogoHeight('2.5rem')
            ->darkMode(false)
            ->spa()
            ->globalSearch(true)
            ->sidebarCollapsibleOnDesktop()
            ->navigationGroups([
                NavigationGroup::make('Content')
                    ->icon('heroicon-o-document-text'),
                NavigationGroup::make('Management')
                    ->icon('heroicon-o-cog-6-tooth'),
                NavigationGroup::make('Settings')
                    ->icon('heroicon-o-adjustments-horizontal'),
                NavigationGroup::make('Administration')
                    ->icon('heroicon-o-cog-6-tooth'),
            ])
            ->renderHook(
                PanelsRenderHook::STYLES_AFTER,
                fn () => new \Illuminate\Support\HtmlString(
                    '<style>' . file_get_contents(public_path('assets/css/admin.css')) . '</style>'
                ),
            )
            ->middleware([
                EncryptCookies::class,
                AddQueuedCookiesToResponse::class,
                StartSession::class,
                AuthenticateSession::class,
                ShareErrorsFromSession::class,
                VerifyCsrfToken::class,
                SubstituteBindings::class,
                DisableBladeIconComponents::class,
                DispatchServingFilamentEvent::class,
            ])
            ->authMiddleware([
                Authenticate::class,
            ])
            ->discoverResources(in: app_path('Filament/Resources'), for: 'App\\Filament\\Resources')
            ->discoverPages(in: app_path('Filament/Pages'), for: 'App\\Filament\\Pages')
            ->discoverWidgets(in: app_path('Filament/Widgets'), for: 'App\\Filament\\Widgets')
            ->pages([
                \Filament\Pages\Dashboard::class,
                \App\Filament\Pages\ManageSettings::class,
            ])
            ->widgets([
                \Filament\Widgets\AccountWidget::class,
            ]);
    }
}
