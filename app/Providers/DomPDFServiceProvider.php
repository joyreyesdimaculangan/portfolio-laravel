<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\App;
use Barryvdh\DomPDF\ServiceProvider as DomPDFBaseServiceProvider;

class DomPDFServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        // Register the Barryvdh\DomPDF\ServiceProvider
        App::register(DomPDFBaseServiceProvider::class);
        
        // Add facade alias
        $this->app->alias('PDF', \Barryvdh\DomPDF\Facade\PDF::class);
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        //
    }
}
