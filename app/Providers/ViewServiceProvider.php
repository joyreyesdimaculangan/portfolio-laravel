<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;
use App\Models\Setting;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Log;

class ViewServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        // Only try to load settings if the table exists
        if (Schema::hasTable('settings')) {
            // Define default UI settings
            $defaultUiSettings = [
                'primary_color' => '#774C0C',
                'primary_color_50' => '#fef3c7',
                'primary_color_100' => '#fde68a',
                'primary_color_200' => '#fcd34d',
                'primary_color_300' => '#fbbf24',
                'primary_color_400' => '#f59e0b',
                'primary_color_500' => '#d97706',
                'primary_color_600' => '#b45309',
                'primary_color_700' => '#92400e',
                'primary_color_800' => '#78350f',
                'primary_color_900' => '#774C0C',
                'secondary_color' => '#1E293B',
                'secondary_color_light' => '#e2e8f0', // Added secondary variations
                'secondary_color_dark' => '#0f172a',  // Added secondary variations
                'accent_color' => '#047857',
                'text_color' => '#1E293B',
                'text_color_light' => '#475569',
                'text_color_lighter' => '#94a3b8',    // Added lighter text option
                'border_color' => '#e2e8f0',          // Added border color
            ];
            
            // Share UI settings with all admin views
            View::composer(['layouts.admin', 'admin.*', 'components.admin.*'], function ($view) use ($defaultUiSettings) {
                // Cache settings for better performance
                $uiSettings = Cache::remember('ui_settings', 3600, function () use ($defaultUiSettings) {
                    try {
                        $dbSettings = Setting::where('type', 'ui')
                            ->pluck('value', 'key')
                            ->toArray();
                        
                        // Log UI settings loaded from DB for debugging
                        if (config('app.debug')) {
                            Log::debug('UI Settings loaded from DB', ['count' => count($dbSettings)]);
                        }
                        
                        // Merge with defaults, with DB values taking precedence
                        return array_merge($defaultUiSettings, $dbSettings);
                    } catch (\Exception $e) {
                        Log::error('Error loading UI settings: ' . $e->getMessage());
                        return $defaultUiSettings;
                    }
                });
                
                // Pass to view with both variable names for compatibility
                $view->with('ui', $uiSettings);
                $view->with('uiSettings', $uiSettings);
            });
            
            // Share theme settings with appearance view
            View::composer('admin.appearance.index', function ($view) use ($defaultUiSettings) {
                $themeSettings = Cache::remember('theme_settings', 3600, function () {
                    try {
                        return Setting::where('type', 'theme')
                            ->pluck('value', 'key')
                            ->toArray();
                    } catch (\Exception $e) {
                        Log::error('Error loading theme settings: ' . $e->getMessage());
                        return [];
                    }
                });
                
                // Also pass UI settings to appearance page
                $view->with('themeSettings', $themeSettings);
                $view->with('defaultUiSettings', $defaultUiSettings);
            });
        }
    }
}