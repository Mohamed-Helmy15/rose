<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;

class MenuServiceProvider extends ServiceProvider
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
    public function boot(): void
    {
        // Use a view composer to dynamically load menu data
        View::composer('*', function ($view) {
            $locale = app()->getLocale();
            $menuFile = $locale == 'en' 
                ? base_path('resources/menu/verticalMenu.json')
                : base_path('resources/menu/verticalMenu_ar.json');
            
            $verticalMenuJson = file_get_contents($menuFile);
            $verticalMenuData = json_decode($verticalMenuJson);

            $view->with('menuData', [$verticalMenuData]);
        });
    }
}