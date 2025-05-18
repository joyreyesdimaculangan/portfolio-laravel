<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Blade;

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
        Blade::component('layouts.guest', 'guest-layout');
        Blade::component('layouts.app', 'app-layout');

        Blade::directive('themeColor', function ($expression) {
            return "<?php echo 'style=\"color: var(--color-' . $expression . ');\"'; ?>";
        });

        Blade::directive('themeBg', function ($expression) {
            return "<?php echo 'style=\"background-color: var(--color-' . $expression . ');\"'; ?>";
        });
        
        Blade::directive('themeBorder', function ($expression) {
            return "<?php echo 'style=\"border-color: var(--color-' . $expression . ');\"'; ?>";
        });
    }
}
