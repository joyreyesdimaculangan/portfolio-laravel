<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Admin - @yield('title')</title>
    
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    
    <!-- Define CSS Variables -->
    <style>
        :root {
            /* Primary Colors */
            --color-primary: {{ $ui['primary_color'] ?? '#774C0C' }};
            --color-primary-50: {{ $ui['primary_color_50'] ?? '#fef3c7' }};
            --color-primary-100: {{ $ui['primary_color_100'] ?? '#fde68a' }};
            --color-primary-200: {{ $ui['primary_color_200'] ?? '#fcd34d' }};
            --color-primary-300: {{ $ui['primary_color_300'] ?? '#fbbf24' }};
            --color-primary-400: {{ $ui['primary_color_400'] ?? '#f59e0b' }};
            --color-primary-500: {{ $ui['primary_color_500'] ?? '#d97706' }};
            --color-primary-600: {{ $ui['primary_color_600'] ?? '#b45309' }};
            --color-primary-700: {{ $ui['primary_color_700'] ?? '#92400e' }};
            --color-primary-800: {{ $ui['primary_color_800'] ?? '#78350f' }};
            --color-primary-900: {{ $ui['primary_color_900'] ?? '#774C0C' }};
            
            /* Secondary Colors */
            --color-secondary: {{ $ui['secondary_color'] ?? '#1E293B' }};
            
            /* Text Colors */
            --color-text: {{ $ui['text_color'] ?? '#1E293B' }};
            --color-text-light: {{ $ui['text_color_light'] ?? '#475569' }};

            --color-text-on-primary: white;
            --color-text-on-primary-hover: white;
        }

        [x-cloak] { display: none !important; }

        .hide-scrollbar {
            -ms-overflow-style: none;  /* IE and Edge */
            scrollbar-width: none;  /* Firefox */
        }
        
        .hide-scrollbar::-webkit-scrollbar {
            display: none;  /* Chrome, Safari and Opera */
            width: 0;
            height: 0;
        }

        /* Add this to your existing CSS in the admin.blade.php head section */
        .hover-contrast-aware:hover .hover-text {
            color: white !important;
        }

        /* Make sure SVG elements are white too */
        .hover-contrast-aware:hover svg.hover-text {
            color: white !important;
            fill: white !important;
            stroke: white !important;
        }

        /* For mobile button */
        .hover-contrast-aware:hover svg {
            stroke: var(--color-text-on-primary-hover) !important;
        }

        /* For the mobile menu button */
        button.md\:hidden.hover\:bg-primary-800:hover svg {
            stroke: var(--color-text-on-primary-hover) !important;
        }
        
        /* Custom scrollbar */
        ::-webkit-scrollbar {
            width: 8px;
            height: 8px;
        }
        
        ::-webkit-scrollbar-track {
            background: #f1f1f1;
        }
        
        ::-webkit-scrollbar-thumb {
            background: {{ $uiSettings["primary_color_600"] ?? "#b45309" }};
            border-radius: 4px;
        }
        
        ::-webkit-scrollbar-thumb:hover {
            background: {{ $uiSettings["primary_color_800"] ?? "#78350f" }};
        }
    
        .z-10 { z-index: 10; }
        .z-20 { z-index: 20; }
        .z-30 { z-index: 30; }
    
        @media (max-width: 768px) {
            .md\:pl-64 {
                padding-left: 0;
            }
        }
            
        /* Fix sidebar scrolling */
        @media (min-width: 768px) {
            .md\:h-screen {
                height: 100vh;
                max-height: 100vh;
            }
            
            .sidebar-content {
                height: calc(100vh - 4rem); 
                overflow-y: auto;
            }
        }
        
        /* Ensure content flows beneath the fixed header */
        main {
            min-height: calc(100vh - 4rem - 3rem); 
            font-family:'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            font-size: 1rem;
        }
    </style>
    
    <!-- Include Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        primary: {
                            50: '{{ $uiSettings["primary_color_50"] ?? "#fef3c7" }}',
                            100: '{{ $uiSettings["primary_color_100"] ?? "#fde68a" }}',
                            200: '{{ $uiSettings["primary_color_200"] ?? "#fcd34d" }}',
                            300: '{{ $uiSettings["primary_color_300"] ?? "#fbbf24" }}',
                            400: '{{ $uiSettings["primary_color_400"] ?? "#f59e0b" }}',
                            500: '{{ $uiSettings["primary_color_500"] ?? "#d97706" }}',
                            600: '{{ $uiSettings["primary_color_600"] ?? "#b45309" }}',
                            700: '{{ $uiSettings["primary_color_700"] ?? "#92400e" }}',
                            800: '{{ $uiSettings["primary_color_800"] ?? "#78350f" }}',
                            900: '{{ $uiSettings["primary_color_900"] ?? "#774C0C" }}',
                        }
                    }
                }
            }
        }
    </script>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Function to detect if a color is dark
            function isColorDark(hexColor) {
                // Handle values with or without #
                if (!hexColor || hexColor.trim() === '') {
                    return false;
                }
                
                hexColor = hexColor.trim().replace('#', '');
                
                // Handle rgb() format
                if (hexColor.startsWith('rgb')) {
                    const rgbMatch = hexColor.match(/(\d+),\s*(\d+),\s*(\d+)/);
                    if (rgbMatch) {
                        const r = parseInt(rgbMatch[1]);
                        const g = parseInt(rgbMatch[2]);
                        const b = parseInt(rgbMatch[3]);
                        const luminance = (0.299 * r + 0.587 * g + 0.114 * b) / 255;
                        return luminance < 0.5;
                    }
                    return false;
                }
                
                // Handle hex format
                try {
                    const r = parseInt(hexColor.substring(0,2), 16);
                    const g = parseInt(hexColor.substring(2,4), 16);
                    const b = parseInt(hexColor.substring(4,6), 16);
                    
                    // Calculate luminance - standard formula for perceived brightness
                    const luminance = (0.299 * r + 0.587 * g + 0.114 * b) / 255;
                    return luminance < 0.5;
                } catch (e) {
                    return false;
                }
            }
            
            // Get primary color
            const primaryColor = getComputedStyle(document.documentElement).getPropertyValue('--color-primary').trim();
            const primaryColor800 = getComputedStyle(document.documentElement).getPropertyValue('--color-primary-800').trim();
            
            // Set text contrast CSS variables based on darkness
            document.documentElement.style.setProperty('--color-text-on-primary', isColorDark(primaryColor) ? 'white' : '#1E293B');
            document.documentElement.style.setProperty('--color-text-on-primary-hover', isColorDark(primaryColor800) ? 'white' : '#1E293B');
            
            // Apply to hover elements
            const hoverElements = document.querySelectorAll('.hover-contrast-aware');
            hoverElements.forEach(el => {
                el.addEventListener('mouseenter', function() {
                    this.querySelectorAll('.hover-text').forEach(text => {
                        text.style.color = getComputedStyle(document.documentElement).getPropertyValue('--color-text-on-primary-hover');
                    });
                });
                
                el.addEventListener('mouseleave', function() {
                    this.querySelectorAll('.hover-text').forEach(text => {
                        text.style.color = '';
                    });
                });
            });
        });
    </script>
    
    <!-- Alpine.js -->
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    
    @yield('head')
    </head>
    <body class="bg-gray-100 font-sans antialiased text-gray-800">
        <div x-data="{ sidebarOpen: false }">
            <!-- Top navigation bar -->
            <nav class="bg-white text-white shadow-md fixed w-full z-30">
                <div class="mx-auto px-4">
                    <div class="flex items-center justify-between h-16">
                        <div class="flex items-center">
                            <!-- Mobile menu button -->
                            <button @click="sidebarOpen = !sidebarOpen" class="md:hidden inline-flex items-center justify-center p-2 rounded-md hover:bg-primary-800 focus:outline-none">
                                <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                                    <path :class="{'hidden': sidebarOpen, 'inline-flex': !sidebarOpen}" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                                    <path :class="{'hidden': !sidebarOpen, 'inline-flex': sidebarOpen}" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                                </svg>
                            </button>
                            
                            <!-- Logo -->
                            <a href="{{ route('admin.dashboard') }}" class="flex-shrink-0 flex items-center ml-4 md:ml-0">
                                <span class="font-bold text-xl" @themeColor('text')>Portfolio Admin</span>
                            </a>
                        </div>
                        
                        <div class="hidden md:block">
                            <div class="flex items-center">
                                <!-- View Site -->
                                <a href="{{ url('/') }}" target="_blank" 
                                class="px-3 py-2 rounded-md text-sm font-medium hover:bg-primary-800 transition-colors flex items-center hover-contrast-aware"
                                @themeColor('text')>
                                    <svg class="w-4 h-4 mr-1 hover-text" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"></path>
                                    </svg>
                                    <span class="hover-text">View Site</span>
                                </a>

                                
                                <!-- Settings dropdown -->
                                <div class="ml-3 relative" x-data="{ open: false }">
                                    <div>
                                        <button @click="open = !open" class="flex items-center rounded-full focus:outline-none">
                                            <div class="flex items-center px-3 py-2 rounded-md text-sm font-medium hover:bg-primary-800 transition-colors hover-contrast-aware">
                                                <span @themeColor('text') class="hover-text">{{ auth()->user()->name ?? 'Admin' }}</span>
                                                <svg class="ml-2 -mr-0.5 h-4 w-4 hover-text" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" @themeColor('text')>
                                                    <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                                                </svg>
                                            </div>
                                        </button>
                                    </div>
                                    
                                    <div x-show="open" 
                                        @click.away="open = false"
                                        x-cloak
                                        class="origin-top-right absolute right-0 mt-2 w-48 rounded-md shadow-lg z-30">
                                        <div class="py-1 bg-white rounded-md shadow-xs">
                                            <a href="{{ route('profile.edit') }}" class="flex items-center px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                                                <svg class="mr-3 h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                                                </svg>
                                                My Profile
                                            </a>
                                            
                                            <a href="{{ route('admin.appearance') }}" class="flex items-center px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                                                <svg class="mr-3 h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21a4 4 0 01-4-4V5a2 2 0 012-2h4a2 2 0 012 2v12a4 4 0 01-4 4zm0 0h12a2 2 0 002-2v-4a2 2 0 00-2-2h-2.343M11 7.343l1.657-1.657a2 2 0 012.828 0l2.829 2.829a2 2 0 010 2.828l-8.486 8.485M7 17h.01"></path>
                                                </svg>
                                                Appearance
                                            </a>
                                            
                                            <div class="border-t border-gray-100"></div>
                                            <form method="POST" action="{{ route('logout') }}">
                                                @csrf
                                                <button type="submit" class="flex w-full items-center px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                                                    <svg class="mr-3 h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path>
                                                    </svg>
                                                    Sign Out
                                                </button>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Mobile profile dropdown -->
                        <div class="md:hidden flex items-center">
                            <a href="{{ url('/') }}" target="_blank" class="p-2 rounded-md hover:bg-primary-800 transition-colors">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"></path>
                                </svg>
                            </a>
                        </div>
                    </div>
                </div>
            </nav>
            
            <!-- Sidebar -->
            <div x-cloak :class="{'block': sidebarOpen, 'hidden': !sidebarOpen}" @click="sidebarOpen = false" class="fixed inset-0 bg-gray-800 bg-opacity-50 transition-opacity md:hidden z-10"></div>
            
            <div :class="{'translate-x-0': sidebarOpen, '-translate-x-full': !sidebarOpen}" 
            class="fixed top-0 left-0 h-full w-64 transition duration-300 transform bg-white z-20 md:translate-x-0 shadow-lg overflow-hidden pt-16">
                <div class="h-full flex-1 flex flex-col pt-5 pb-4 overflow-y-auto hide-scrollbar">
                    
                    <div class="px-4">
                        <div class="flex items-center mb-2">
                            <span class="font-medium text-sm text-gray-500">CONTENT MANAGEMENT</span>
                        </div>
                        <nav class="mt-2 space-y-1">
                            <a href="{{ route('admin.dashboard') }}" class="{{ request()->routeIs('admin.dashboard') ? 'bg-primary-50 text-primary-900' : 'text-gray-600 hover:bg-primary-50 hover:text-primary-900' }} group flex items-center px-3 py-2 text-sm font-medium rounded-md transition-colors">
                                <svg class="{{ request()->routeIs('admin.dashboard') ? 'text-primary-900' : 'text-gray-400 group-hover:text-primary-900' }} mr-3 h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path>
                                </svg>
                                Dashboard
                            </a>

                            <a href="{{ route('admin.personal-info.index') }}" class="{{ request()->routeIs('admin.personal-info.*') ? 'bg-primary-50 text-primary-900' : 'text-gray-600 hover:bg-primary-50 hover:text-primary-900' }} group flex items-center px-3 py-2 text-sm font-medium rounded-md transition-colors">
                                <svg class="{{ request()->routeIs('admin.personal-info.*') ? 'text-primary-900' : 'text-gray-400 group-hover:text-primary-900' }} mr-3 h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                                </svg>
                                Personal Info
                            </a>
                            
                            <a href="{{ route('admin.projects.index') }}" class="{{ request()->routeIs('admin.projects.*') ? 'bg-primary-50 text-primary-900' : 'text-gray-600 hover:bg-primary-50 hover:text-primary-900' }} group flex items-center px-3 py-2 text-sm font-medium rounded-md transition-colors">
                                <svg class="{{ request()->routeIs('admin.projects.*') ? 'text-primary-900' : 'text-gray-400 group-hover:text-primary-900' }} mr-3 h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path>
                                </svg>
                                Projects
                            </a>
                            
                            <a href="{{ route('admin.skills.index') }}" class="{{ request()->routeIs('admin.skills.*') ? 'bg-primary-50 text-primary-900' : 'text-gray-600 hover:bg-primary-50 hover:text-primary-900' }} group flex items-center px-3 py-2 text-sm font-medium rounded-md transition-colors">
                                <svg class="{{ request()->routeIs('admin.skills.*') ? 'text-primary-900' : 'text-gray-400 group-hover:text-primary-900' }} mr-3 h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                                </svg>
                                Skills
                            </a>
                            
                            <a href="{{ route('admin.experiences.index') }}" class="{{ request()->routeIs('admin.experiences.*') ? 'bg-primary-50 text-primary-900' : 'text-gray-600 hover:bg-primary-50 hover:text-primary-900' }} group flex items-center px-3 py-2 text-sm font-medium rounded-md transition-colors">
                                <svg class="{{ request()->routeIs('admin.experiences.*') ? 'text-primary-900' : 'text-gray-400 group-hover:text-primary-900' }} mr-3 h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                                </svg>
                                Experience
                            </a>
                            
                            <a href="{{ route('admin.education.index') }}" class="{{ request()->routeIs('admin.education.*') ? 'bg-primary-50 text-primary-900' : 'text-gray-600 hover:bg-primary-50 hover:text-primary-900' }} group flex items-center px-3 py-2 text-sm font-medium rounded-md transition-colors">
                                <svg class="{{ request()->routeIs('admin.education.*') ? 'text-primary-900' : 'text-gray-400 group-hover:text-primary-900' }} mr-3 h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path d="M12 14l9-5-9-5-9 5 9 5z"></path>
                                    <path d="M12 14l6.16-3.422a12.083 12.083 0 01.665 6.479A11.952 11.952 0 0012 20.055a11.952 11.952 0 00-6.824-2.998 12.078 12.078 0 01.665-6.479L12 14z"></path>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 14l9-5-9-5-9 5 9 5zm0 0l6.16-3.422a12.083 12.083 0 01.665 6.479A11.952 11.952 0 0012 20.055a11.952 11.952 0 00-6.824-2.998 12.078 12.078 0 01.665-6.479L12 14zm-4 6v-7.5l4-2.222"></path>
                                </svg>
                                Education
                            </a>
                            
                            <a href="{{ route('admin.certificates.index') }}" class="{{ request()->routeIs('admin.certificates.*') ? 'bg-primary-50 text-primary-900' : 'text-gray-600 hover:bg-primary-50 hover:text-primary-900' }} group flex items-center px-3 py-2 text-sm font-medium rounded-md transition-colors">
                                <svg class="{{ request()->routeIs('admin.certificates.*') ? 'text-primary-900' : 'text-gray-400 group-hover:text-primary-900' }} mr-3 h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                                Certificates
                            </a>
                        </nav>
                    </div>
                    
                    <div class="px-4 mt-6">
                        <div class="flex items-center mb-2">
                            <span class="font-medium text-sm text-gray-500">SITE SETTINGS</span>
                        </div>
                        <nav class="mt-2 space-y-1">
                            <a href="{{ route('admin.resume.settings') }}" class="{{ request()->routeIs('admin.resume.*') ? 'bg-primary-50 text-primary-900' : 'text-gray-600 hover:bg-primary-50 hover:text-primary-900' }} group flex items-center px-3 py-2 text-sm font-medium rounded-md transition-colors">
                                <svg class="{{ request()->routeIs('admin.resume.*') ? 'text-primary-900' : 'text-gray-400 group-hover:text-primary-900' }} mr-3 h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                </svg>
                                Resume
                            </a>
                            
                            <a href="{{ route('admin.appearance') }}" class="{{ request()->routeIs('admin.appearance') ? 'bg-primary-50 text-primary-900' : 'text-gray-600 hover:bg-primary-50 hover:text-primary-900' }} group flex items-center px-3 py-2 text-sm font-medium rounded-md transition-colors">
                                <svg class="{{ request()->routeIs('admin.appearance') ? 'text-primary-900' : 'text-gray-400 group-hover:text-primary-900' }} mr-3 h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21a4 4 0 01-4-4V5a2 2 0 012-2h4a2 2 0 012 2v12a4 4 0 01-4 4zm0 0h12a2 2 0 002-2v-4a2 2 0 00-2-2h-2.343M11 7.343l1.657-1.657a2 2 0 012.828 0l2.829 2.829a2 2 0 010 2.828l-8.486 8.485M7 17h.01"></path>
                                </svg>
                                Appearance
                            </a>
                        </nav>
                    </div>
                    
                    <div class="px-4 mt-auto mb-8">
                        <div class="pt-4 border-t border-gray-200">
                            <a href="{{ route('resume.customize') }}" target="_blank" class="flex justify-center items-center p-3 bg-primary-900 hover:bg-primary-800 text-white rounded-lg transition-colors">
                                <span class="font-medium">View Resume</span>
                                <svg class="w-4 h-4 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"></path>
                                </svg>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        
            <!-- Main content -->
            <div class="md:pl-64 flex flex-col flex-1">
                <main class="flex-1 pt-16">
                    
                    
                    @yield('content')
                </main>
            </div>
        </div>
    
        @yield('scripts')
    </body>
</html>