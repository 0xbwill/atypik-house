<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Filament\Facades\Filament;
use Filament\Navigation\NavigationItem;

class FilamentServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap services.
     */
    public function boot()
    {
        Filament::serving(function () {
            Filament::registerNavigationItems([
                NavigationItem::make('Retourner à l\'accueil')
                    ->url('/')
                    ->icon('heroicon-o-home')
                    ->group('Accueil') // Place cet élément dans le groupe "Accueil"
                    ->sort(-1), // Utilisation d'un tri négatif pour le placer en haut de la liste
            ]);
        });
    }
}
