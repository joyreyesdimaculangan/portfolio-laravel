{{-- filepath: c:\laragon\www\myfirstlaravel\resources\views\admin\appearance\settings.blade.php --}}
@extends('layouts.admin')

@section('title', 'Appearance Settings')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="mb-8">
        <h1 class="text-3xl font-bold text-gray-800">Appearance Settings</h1>
        <p class="mt-2 text-gray-600">Customize the look and feel of your admin interface</p>
    </div>
    
    @if(session('success'))
        <div class="mb-6 p-4 bg-green-50 border-l-4 border-green-500 text-green-700">
            {{ session('success') }}
        </div>
    @endif
    
    @if(session('error'))
        <div class="mb-6 p-4 bg-red-50 border-l-4 border-red-500 text-red-700">
            {{ session('error') }}
        </div>
    @endif
    
    @if($errors->any())
        <div class="mb-6 p-4 bg-red-50 border-l-4 border-red-500 text-red-700">
            <ul class="list-disc pl-5">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif
    
    @php
        // Use the UI settings if available or defaults
        $ui = $uiSettings ?? [
            'primary_color' => '#774C0C',
            'primary_color_dark' => '#5d3a08', 
            'primary_color_light' => '#f3e6d8',
            'secondary_color' => '#1E293B',
            'secondary_color_dark' => '#0f172a',
            'secondary_color_light' => '#e2e8f0',
            'accent_color' => '#047857',
            'text_color' => '#1E293B',
            'text_color_light' => '#475569'
        ];
    @endphp
    
    <div class="bg-white rounded-lg shadow-md overflow-hidden"
         x-data="{ 
            primaryColor: '{{ $ui['primary_color'] }}',
            primaryColorDark: '{{ $ui['primary_color_dark'] ?? '#5d3a08' }}',
            primaryColorLight: '{{ $ui['primary_color_light'] ?? '#f3e6d8' }}',
            secondaryColor: '{{ $ui['secondary_color'] ?? '#1E293B' }}',
            secondaryColorDark: '{{ $ui['secondary_color_dark'] ?? '#0f172a' }}',
            secondaryColorLight: '{{ $ui['secondary_color_light'] ?? '#e2e8f0' }}',
            accentColor: '{{ $ui['accent_color'] ?? '#047857' }}',
            textColor: '{{ $ui['text_color'] ?? '#1E293B' }}',
            textColorLight: '{{ $ui['text_color_light'] ?? '#475569' }}',
            presets: {
                default: {
                    primary: '#774C0C',
                    primaryDark: '#5d3a08',
                    primaryLight: '#f3e6d8',
                    secondary: '#1E293B',
                    secondaryDark: '#0f172a',
                    secondaryLight: '#e2e8f0',
                    accent: '#047857',
                    textColor: '#1E293B',
                    textColorLight: '#475569'
                },
                dark: {
                    primary: '#3B82F6',
                    primaryDark: '#2563EB',
                    primaryLight: '#DBEAFE',
                    secondary: '#111827',
                    secondaryDark: '#030712',
                    secondaryLight: '#6B7280',
                    accent: '#10B981',
                    textColor: '#f3f4f6',
                    textColorLight: '#d1d5db'
                },
                earth: {
                    primary: '#84CC16',
                    primaryDark: '#65A30D',
                    primaryLight: '#ECFCCB',
                    secondary: '#422006',
                    secondaryDark: '#1C0A00',
                    secondaryLight: '#D7CFC7',
                    accent: '#EA580C',
                    textColor: '#292524',
                    textColorLight: '#78716c'
                },
                ocean: {
                    primary: '#0891B2',
                    primaryDark: '#0E7490',
                    primaryLight: '#CFFAFE',
                    secondary: '#083344',
                    secondaryDark: '#042F2E',
                    secondaryLight: '#BAE6FD',
                    accent: '#EC4899',
                    textColor: '#0c4a6e',
                    textColorLight: '#0369a1'
                },
                vibrant: {
                    primary: '#8B5CF6',
                    primaryDark: '#7C3AED',
                    primaryLight: '#EDE9FE',
                    secondary: '#4C1D95',
                    secondaryDark: '#4338CA',
                    secondaryLight: '#C4B5FD',
                    accent: '#EC4899',
                    textColor: '#4c1d95',
                    textColorLight: '#7e22ce'
                }
            },
            applyPreset(preset) {
                this.primaryColor = this.presets[preset].primary;
                this.primaryColorDark = this.presets[preset].primaryDark;
                this.primaryColorLight = this.presets[preset].primaryLight;
                this.secondaryColor = this.presets[preset].secondary;
                this.secondaryColorDark = this.presets[preset].secondaryDark;
                this.secondaryColorLight = this.presets[preset].secondaryLight;
                this.accentColor = this.presets[preset].accent;
                this.textColor = this.presets[preset].textColor;
                this.textColorLight = this.presets[preset].textColorLight;
            }
        }">
        
        <div class="border-b border-gray-200">
            <div class="p-6">
                <h2 class="text-lg font-medium text-gray-900">Theme Presets</h2>
                <p class="text-sm text-gray-500 mb-4">Choose a preset or customize your own</p>
                
                <div class="flex flex-wrap gap-4">
                    <button type="button" @click="applyPreset('default')" class="px-4 py-2 bg-amber-700 hover:bg-amber-800 text-white rounded-md">Default</button>
                    <button type="button" @click="applyPreset('dark')" class="px-4 py-2 bg-blue-500 hover:bg-blue-600 text-white rounded-md">Dark Blue</button>
                    <button type="button" @click="applyPreset('earth')" class="px-4 py-2 bg-lime-500 hover:bg-lime-600 text-white rounded-md">Earth</button>
                    <button type="button" @click="applyPreset('ocean')" class="px-4 py-2 bg-cyan-600 hover:bg-cyan-700 text-white rounded-md">Ocean</button>
                    <button type="button" @click="applyPreset('vibrant')" class="px-4 py-2 bg-violet-500 hover:bg-violet-600 text-white rounded-md">Vibrant</button>
                </div>
            </div>
        </div>
        
        <form action="{{ route('admin.appearance.update') }}" method="POST" class="p-6">
            @csrf
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <h2 class="text-lg font-medium text-gray-900 mb-4">Primary Colors</h2>
                    
                    <div class="mb-4">
                        <label for="primary_color" class="block text-sm font-medium text-gray-700">Primary Color</label>
                        <div class="mt-1 flex items-center">
                            <input type="color" x-model="primaryColor" name="ui[primary_color]" id="primary_color" class="h-10 w-10 border border-gray-300 rounded-md shadow-sm">
                            <input type="text" x-model="primaryColor" class="ml-2 block w-full rounded-md border-gray-300 shadow-sm focus:border-primary-500 focus:ring-primary-500">
                        </div>
                    </div>
                    
                    <div class="mb-4">
                        <label for="primary_color_dark" class="block text-sm font-medium text-gray-700">Primary Dark</label>
                        <div class="mt-1 flex items-center">
                            <input type="color" x-model="primaryColorDark" name="ui[primary_color_dark]" id="primary_color_dark" class="h-10 w-10 border border-gray-300 rounded-md shadow-sm">
                            <input type="text" x-model="primaryColorDark" class="ml-2 block w-full rounded-md border-gray-300 shadow-sm focus:border-primary-500 focus:ring-primary-500">
                        </div>
                    </div>
                    
                    <div class="mb-4">
                        <label for="primary_color_light" class="block text-sm font-medium text-gray-700">Primary Light</label>
                        <div class="mt-1 flex items-center">
                            <input type="color" x-model="primaryColorLight" name="ui[primary_color_light]" id="primary_color_light" class="h-10 w-10 border border-gray-300 rounded-md shadow-sm">
                            <input type="text" x-model="primaryColorLight" class="ml-2 block w-full rounded-md border-gray-300 shadow-sm focus:border-primary-500 focus:ring-primary-500">
                        </div>
                    </div>

                    <div class="mb-4">
                        <label for="text_color" class="block text-sm font-medium text-gray-700">Text Color</label>
                        <div class="mt-1 flex items-center">
                            <input type="color" x-model="textColor" name="ui[text_color]" id="text_color" class="h-10 w-10 border border-gray-300 rounded-md shadow-sm">
                            <input type="text" x-model="textColor" class="ml-2 block w-full rounded-md border-gray-300 shadow-sm focus:border-primary-500 focus:ring-primary-500">
                        </div>
                    </div>
                    
                    <div class="mb-4">
                        <label for="text_color_light" class="block text-sm font-medium text-gray-700">Text Color Light</label>
                        <div class="mt-1 flex items-center">
                            <input type="color" x-model="textColorLight" name="ui[text_color_light]" id="text_color_light" class="h-10 w-10 border border-gray-300 rounded-md shadow-sm">
                            <input type="text" x-model="textColorLight" class="ml-2 block w-full rounded-md border-gray-300 shadow-sm focus:border-primary-500 focus:ring-primary-500">
                        </div>
                    </div>
                </div>
                
                <div>
                    <h2 class="text-lg font-medium text-gray-900 mb-4">Secondary & Accent Colors</h2>
                    
                    <div class="mb-4">
                        <label for="secondary_color" class="block text-sm font-medium text-gray-700">Secondary Color</label>
                        <div class="mt-1 flex items-center">
                            <input type="color" x-model="secondaryColor" name="ui[secondary_color]" id="secondary_color" class="h-10 w-10 border border-gray-300 rounded-md shadow-sm">
                            <input type="text" x-model="secondaryColor" class="ml-2 block w-full rounded-md border-gray-300 shadow-sm focus:border-primary-500 focus:ring-primary-500">
                        </div>
                    </div>
                    
                    <div class="mb-4">
                        <label for="secondary_color_dark" class="block text-sm font-medium text-gray-700">Secondary Dark</label>
                        <div class="mt-1 flex items-center">
                            <input type="color" x-model="secondaryColorDark" name="ui[secondary_color_dark]" id="secondary_color_dark" class="h-10 w-10 border border-gray-300 rounded-md shadow-sm">
                            <input type="text" x-model="secondaryColorDark" class="ml-2 block w-full rounded-md border-gray-300 shadow-sm focus:border-primary-500 focus:ring-primary-500">
                        </div>
                    </div>
                    
                    <div class="mb-4">
                        <label for="secondary_color_light" class="block text-sm font-medium text-gray-700">Secondary Light</label>
                        <div class="mt-1 flex items-center">
                            <input type="color" x-model="secondaryColorLight" name="ui[secondary_color_light]" id="secondary_color_light" class="h-10 w-10 border border-gray-300 rounded-md shadow-sm">
                            <input type="text" x-model="secondaryColorLight" class="ml-2 block w-full rounded-md border-gray-300 shadow-sm focus:border-primary-500 focus:ring-primary-500">
                        </div>
                    </div>
                    
                    <div class="mb-4">
                        <label for="accent_color" class="block text-sm font-medium text-gray-700">Accent Color</label>
                        <div class="mt-1 flex items-center">
                            <input type="color" x-model="accentColor" name="ui[accent_color]" id="accent_color" class="h-10 w-10 border border-gray-300 rounded-md shadow-sm">
                            <input type="text" x-model="accentColor" class="ml-2 block w-full rounded-md border-gray-300 shadow-sm focus:border-primary-500 focus:ring-primary-500">
                        </div>
                    </div>

                    <!-- Generate primary color variants -->
                    <input type="hidden" name="ui[primary_color_50]" x-bind:value="primaryColor + '50'">
                    <input type="hidden" name="ui[primary_color_100]" x-bind:value="primaryColor + '100'">
                    <input type="hidden" name="ui[primary_color_200]" x-bind:value="primaryColor + '200'">
                    <input type="hidden" name="ui[primary_color_300]" x-bind:value="primaryColor + '300'">
                    <input type="hidden" name="ui[primary_color_400]" x-bind:value="primaryColor + '400'">
                    <input type="hidden" name="ui[primary_color_500]" x-bind:value="primaryColor + '500'">
                    <input type="hidden" name="ui[primary_color_600]" x-bind:value="primaryColor + '600'">
                    <input type="hidden" name="ui[primary_color_700]" x-bind:value="primaryColor + '700'">
                    <input type="hidden" name="ui[primary_color_800]" x-bind:value="primaryColor + '800'">
                    <input type="hidden" name="ui[primary_color_900]" x-bind:value="primaryColor + '900'">
                </div>
            </div>
            
            <div class="mt-6 border-t border-gray-200 pt-6">
                <h2 class="text-lg font-medium text-gray-900 mb-4">Preview</h2>
                
                <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                    <div class="p-4 rounded-md shadow-md" :style="{ backgroundColor: primaryColor, color: primaryColorLight }">
                        <h3 class="font-bold mb-2">Primary Color</h3>
                        <p>This is example text showing how your primary color looks.</p>
                        <button type="button" class="mt-2 px-4 py-2 rounded-md" :style="{ backgroundColor: primaryColorDark, color: primaryColorLight }">Button</button>
                    </div>
                    
                    <div class="p-4 rounded-md shadow-md" :style="{ backgroundColor: secondaryColor, color: secondaryColorLight }">
                        <h3 class="font-bold mb-2">Secondary Color</h3>
                        <p>This is example text showing how your secondary color looks.</p>
                        <button type="button" class="mt-2 px-4 py-2 rounded-md" :style="{ backgroundColor: secondaryColorDark, color: secondaryColorLight }">Button</button>
                    </div>
                    
                    <div class="p-4 rounded-md shadow-md bg-white">
                        <h3 class="font-bold mb-2" :style="{ color: primaryColor }">Accent Elements</h3>
                        <p :style="{ color: textColor }">Regular text with <a href="#" :style="{ color: accentColor }">accent links</a> and other elements.</p>
                        <button type="button" class="mt-2 px-4 py-2 rounded-md text-white" :style="{ backgroundColor: accentColor }">Accent Button</button>
                    </div>
                </div>
            </div>
            
            <div class="mt-6 flex justify-between">
                <button type="button" onclick="window.location.reload()" class="px-6 py-2 bg-gray-200 hover:bg-gray-300 text-gray-800 font-medium rounded-md">
                    Reset Changes
                </button>
                <button type="submit" class="px-6 py-2 bg-primary-600 hover:bg-primary-700 text-white font-medium rounded-md">
                    Save Changes
                </button>
            </div>
        </form>
    </div>
</div>
@endsection