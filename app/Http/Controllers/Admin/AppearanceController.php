<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;
use App\Models\Setting;

class AppearanceController extends Controller
{
    protected $defaultSettings = [
        'primary_color' => '#774C0C',
        'primary_color_dark' => '#5d3a08',
        'primary_color_light' => '#f3e6d8',
        'secondary_color' => '#1E293B',
        'secondary_color_dark' => '#0f172a',
        'secondary_color_light' => '#e2e8f0',
        'accent_color' => '#047857',
        'text_color' => '#1E293B',
        'text_color_light' => '#475569',
    ];

    public function index()
    {
        $uiSettings = $this->getUISettings();
        
        // To debug
        // dd($themeSettings); 
        
        return view('admin.appearance.index', compact('uiSettings'));
    }

    public function update(Request $request)
    {
        $validated = $request->validate([
            'ui' => 'required|array',
            'ui.*' => 'required|string',
        ]);
        
        // Start a database transaction
        \DB::beginTransaction();
        
        try {
            // Process the color variants
            foreach ($validated['ui'] as $key => $value) {
                // For color variants, process them to generate real color values
                if (preg_match('/primary_color_(\d+)$/', $key, $matches)) {
                    $variant = $matches[1];
                    $baseColor = $validated['ui']['primary_color'];
                    
                    // Convert base color to RGB
                    list($r, $g, $b) = sscanf($baseColor, "#%02x%02x%02x");
                    
                    // Adjust brightness based on variant
                    switch ($variant) {
                        case '50': $factor = 0.95; break;
                        case '100': $factor = 0.9; break;
                        case '200': $factor = 0.75; break;
                        case '300': $factor = 0.6; break;
                        case '400': $factor = 0.45; break;
                        case '500': $factor = 0.3; break;
                        case '600': $factor = 0.15; break;
                        case '700': $factor = 0; break;
                        case '800': $factor = -0.15; break;
                        case '900': $factor = -0.3; break;
                        default: $factor = 0;
                    }
                    
                    // Generate new color
                    if ($factor > 0) {
                        // Lighter
                        $r = round($r + (255 - $r) * $factor);
                        $g = round($g + (255 - $g) * $factor);
                        $b = round($b + (255 - $b) * $factor);
                    } else {
                        // Darker
                        $factor = abs($factor);
                        $r = round($r * (1 - $factor));
                        $g = round($g * (1 - $factor));
                        $b = round($b * (1 - $factor));
                    }
                    
                    $value = sprintf("#%02x%02x%02x", $r, $g, $b);
                }
                
                // Save setting to database
                Setting::updateOrCreate(
                    ['key' => $key, 'type' => 'ui'],
                    ['value' => $value]
                );
                
                // Also save base colors to theme settings
                if (in_array($key, ['primary_color', 'secondary_color', 'accent_color', 'text_color', 'text_color_light'])) {
                    Setting::updateOrCreate(
                        ['key' => $key, 'type' => 'theme'],
                        ['value' => $value]
                    );
                }
            }
            
            // Clear the cache
            \Illuminate\Support\Facades\Cache::forget('ui_settings');
            \Illuminate\Support\Facades\Cache::forget('theme_settings');
            
            \DB::commit();
            
            return redirect()->back()->with('success', 'UI settings updated successfully');
        } catch (\Exception $e) {
            \DB::rollBack();
            \Illuminate\Support\Facades\Log::error('Failed to update UI settings: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Failed to update settings: ' . $e->getMessage())->withInput();
        }
    }

    public function reset()
    {
        try {
            // Reset both theme and UI settings
            $this->saveThemeSettings($this->defaultSettings);
            $this->saveToDatabase($this->defaultSettings);
            
            return redirect()->route('admin.appearance')->with('success', 'Theme reset to default values.');
        } catch (\Exception $e) {
            Log::error('Failed to reset theme: ' . $e->getMessage());
            return redirect()->route('admin.appearance')->with('error', 'Failed to reset theme: ' . $e->getMessage());
        }
    }

    protected function getUISettings()
    {
        // Try to get settings from cache first
        $uiSettings = Cache::remember('ui_settings', 3600, function () {
            // Get UI settings from database
            $dbSettings = Setting::where('type', 'ui')
                ->pluck('value', 'key')
                ->toArray();
                
            // If missing critical settings, get theme settings and generate UI settings
            if (empty($dbSettings) || !isset($dbSettings['primary_color'])) {
                $themeSettings = $this->getThemeSettings();
                
                // Ensure primary_color is set in UI settings
                if (!isset($dbSettings['primary_color']) && isset($themeSettings['primary_color'])) {
                    Setting::updateOrCreate(
                        ['key' => 'primary_color', 'type' => 'ui'],
                        ['value' => $themeSettings['primary_color']]
                    );
                    
                    $dbSettings['primary_color'] = $themeSettings['primary_color'];
                }
                
                // Generate UI color shades if needed
                if (isset($themeSettings['primary_color'])) {
                    $this->generateUISettings($themeSettings);
                    
                    // Re-fetch settings after generation
                    $dbSettings = Setting::where('type', 'ui')
                        ->pluck('value', 'key')
                        ->toArray();
                }
            }
            
            // Merge with defaults to ensure all necessary values exist
            $defaults = [
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
                'text_color' => '#1E293B',
                'text_color_light' => '#475569',
            ];
            
            return array_merge($defaults, $dbSettings);
        });
        
        return $uiSettings;
    }

    protected function getThemeSettings()
    {
        // Try to get settings from cache first
        return Cache::remember('theme_settings', 3600, function () {
            // Try to get settings from database first
            try {
                $dbSettings = Setting::where('type', 'theme')
                    ->pluck('value', 'key')
                    ->toArray();
                
                if (!empty($dbSettings)) {
                    return array_merge($this->defaultSettings, $dbSettings);
                }
            } catch (\Exception $e) {
                Log::warning('Failed to get theme settings from database: ' . $e->getMessage());
                // Continue to file storage
            }
            
            // Fall back to file storage if database approach failed
            try {
                if (Storage::disk('local')->exists('theme_settings.json')) {
                    $settings = json_decode(Storage::disk('local')->get('theme_settings.json'), true);
                    if (is_array($settings)) {
                        return array_merge($this->defaultSettings, $settings);
                    }
                }
            } catch (\Exception $e) {
                Log::warning('Failed to get theme settings from file: ' . $e->getMessage());
                // Fall back to default settings
            }
            
            // Return default settings if all else fails
            return $this->defaultSettings;
        });
    }

    protected function saveThemeSettings(array $settings)
    {
        try {
            Storage::disk('local')->put('theme_settings.json', json_encode($settings));
        } catch (\Exception $e) {
            Log::error('Failed to save theme settings to file: ' . $e->getMessage());
        }
    }
    
    protected function saveToDatabase(array $settings)
    {
        try {
            foreach ($settings as $key => $value) {
                // Save to theme settings
                Setting::updateOrCreate(
                    ['key' => $key, 'type' => 'theme'],
                    ['value' => $value]
                );
                
                // Also save base colors directly to UI settings
                if (in_array($key, ['primary_color', 'secondary_color', 'accent_color', 'text_color', 'text_color_light'])) {
                    Setting::updateOrCreate(
                        ['key' => $key, 'type' => 'ui'],
                        ['value' => $value]
                    );
                }
            }
            
            // Generate UI settings based on theme settings
            $this->generateUISettings($settings);
            
            // Clear any cached settings
            Cache::forget('theme_settings');
            Cache::forget('ui_settings');
        } catch (\Exception $e) {
            Log::error('Failed to save theme settings to database: ' . $e->getMessage());
            throw $e;
        }
    }
    
    protected function generateUISettings(array $settings)
    {
        if (!isset($settings['primary_color'])) {
            return;
        }
        
        // Extract the RGB values from the primary color
        list($r, $g, $b) = sscanf($settings['primary_color'], "#%02x%02x%02x");
        
        // Define UI color shades
        $uiSettings = [
            'primary_color' => $settings['primary_color'], // Also save the base color as UI setting
            'primary_color_50' => $this->adjustBrightness($r, $g, $b, 0.95),
            'primary_color_100' => $this->adjustBrightness($r, $g, $b, 0.9),
            'primary_color_200' => $this->adjustBrightness($r, $g, $b, 0.75),
            'primary_color_300' => $this->adjustBrightness($r, $g, $b, 0.6),
            'primary_color_400' => $this->adjustBrightness($r, $g, $b, 0.45),
            'primary_color_500' => $this->adjustBrightness($r, $g, $b, 0.3),
            'primary_color_600' => $this->adjustBrightness($r, $g, $b, 0.15),
            'primary_color_700' => $this->adjustBrightness($r, $g, $b, 0),
            'primary_color_800' => $this->adjustBrightness($r, $g, $b, -0.15),
            'primary_color_900' => $this->adjustBrightness($r, $g, $b, -0.3),
        ];
        
        // Save all UI color settings to the database
        foreach ($uiSettings as $key => $value) {
            Setting::updateOrCreate(
                ['key' => $key, 'type' => 'ui'],
                ['value' => $value]
            );
        }
        
        // If secondary color is set, also add it
        if (isset($settings['secondary_color'])) {
            Setting::updateOrCreate(
                ['key' => 'secondary_color', 'type' => 'ui'],
                ['value' => $settings['secondary_color']]
            );
        }
        
        // Handle text colors
        if (isset($settings['text_color'])) {
            Setting::updateOrCreate(
                ['key' => 'text_color', 'type' => 'ui'],
                ['value' => $settings['text_color']]
            );
        }
        
        if (isset($settings['text_color_light'])) {
            Setting::updateOrCreate(
                ['key' => 'text_color_light', 'type' => 'ui'],
                ['value' => $settings['text_color_light']]
            );
        }
    }
    
    protected function adjustBrightness($r, $g, $b, $factor)
    {
        if ($factor > 0) {
            // Lighter
            $r = round($r + (255 - $r) * $factor);
            $g = round($g + (255 - $g) * $factor);
            $b = round($b + (255 - $b) * $factor);
        } else {
            // Darker
            $factor = abs($factor);
            $r = round($r * (1 - $factor));
            $g = round($g * (1 - $factor));
            $b = round($b * (1 - $factor));
        }
        
        return sprintf("#%02x%02x%02x", $r, $g, $b);
    }
}