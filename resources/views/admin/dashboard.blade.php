@extends('layouts.admin')

@section('title', 'Dashboard')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="flex justify-between items-center mb-8">
        <h1 class="text-3xl font-bold text-gray-800">Dashboard</h1>
        <div class="text-right">
            <p class="text-sm text-gray-600">
                {{ now()->setTimezone('Asia/Manila')->format('l, M d, Y') }} | <span id="liveClock" class="font-medium"></span>
            </p>
        </div>
    </div>
    
    <!-- Overview Stats -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-6 gap-6 mb-8">
        <div class="bg-white rounded-lg shadow-md overflow-hidden border-t-4" style="border-color: var(--color-primary);">
            <div class="p-5">
                <div class="flex items-center">
                    <div class="flex-shrink-0 rounded-full p-3" style="background-color: var(--color-primary-50, #fef3c7);">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" style="color: var(--color-primary, #774C0C);">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                                d="M8 9l3 3-3 3m5 0h3M5 20h14a2 2 0 002-2V6a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                        </svg>
                    </div>
                    <div class="ml-4">
                        <h2 class="text-sm font-medium text-gray-600">Projects</h2>
                        <p class="text-2xl font-bold text-gray-800">{{ $stats['projects'] }}</p>
                    </div>
                </div>
                <div class="mt-4 border-t pt-2">
                    <a href="{{ route('admin.projects.index') }}" class="text-sm flex items-center" style="color: var(--color-primary, #774C0C);">
                        Manage Projects
                        <svg class="w-4 h-4 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                        </svg>
                    </a>
                </div>
            </div>
        </div>
        
        <div class="bg-white rounded-lg shadow-md overflow-hidden border-t-4" style="border-color: var(--color-primary, #774C0C);">
            <div class="p-5">
                <div class="flex items-center">
                    <div class="flex-shrink-0 rounded-full p-3" style="background-color: var(--color-primary-50, #fef3c7);">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" style="color: var(--color-primary, #774C0C);">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                            d="M9.663 17h4.673M12 3v1m6.364 1.636l-.707.707M21 12h-1M4 12H3m3.343-5.657l-.707-.707m2.828 9.9a5 5 0 117.072 0l-.548.547A3.374 3.374 0 0014 18.469V19a2 2 0 11-4 0v-.531c0-.895-.356-1.754-.988-2.386l-.548-.547z"/>
                        </svg>
                    </div>
                    <div class="ml-4">
                        <h2 class="text-sm font-medium text-gray-600">Skills</h2>
                        <p class="text-2xl font-bold text-gray-800">{{ $stats['skills'] }}</p>
                    </div>
                </div>
                <div class="mt-4 border-t pt-2">
                    <a href="{{ route('admin.skills.index') }}" class="text-sm flex items-center" style="color: var(--color-primary, #774C0C);">
                        Manage Skills
                        <svg class="w-4 h-4 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                        </svg>
                    </a>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-lg shadow-md overflow-hidden border-t-4" style="border-color: var(--color-primary);">
            <div class="p-5">
                <div class="flex items-center">
                    <div class="flex-shrink-0 rounded-full p-3" style="background-color: var(--color-primary-50, #fef3c7);">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" style="color: var(--color-primary, #774C0C);">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                            d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                        </svg>
                    </div>
                    <div class="ml-4">
                        <h2 class="text-sm font-medium text-gray-600">Experiences</h2>
                        <p class="text-2xl font-bold text-gray-800">{{ $stats['experiences'] }}</p>
                    </div>
                </div>
                <div class="mt-4 border-t pt-2">
                    <a href="{{ route('admin.projects.index') }}" class="text-sm flex items-center" style="color: var(--color-primary, #774C0C);">
                        Manage Experiences
                        <svg class="w-4 h-4 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                        </svg>
                    </a>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-lg shadow-md overflow-hidden border-t-4" style="border-color: var(--color-primary);">
            <div class="p-5">
                <div class="flex items-center">
                    <div class="flex-shrink-0 rounded-full p-3" style="background-color: var(--color-primary-50, #fef3c7);">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" style="color: var(--color-primary, #774C0C);">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                            d="M12 14l9-5-9-5-9 5 9 5zm0 0l6.16-3.422a12.083 12.083 0 01.665 6.479A11.952 11.952 0 0012 20.055a11.952 11.952 0 00-6.824-2.998 12.078 12.078 0 01.665-6.479L12 14zm-4 6v-7.5l4-2.222"/>
                        </svg>
                    </div>
                    <div class="ml-4">
                        <h2 class="text-sm font-medium text-gray-600">Education</h2>
                        <p class="text-2xl font-bold text-gray-800">{{ $stats['education'] }}</p>
                    </div>
                </div>
                <div class="mt-4 border-t pt-2">
                    <a href="{{ route('admin.projects.index') }}" class="text-sm flex items-center" style="color: var(--color-primary, #774C0C);">
                        Manage Education
                        <svg class="w-4 h-4 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                        </svg>
                    </a>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-lg shadow-md overflow-hidden border-t-4" style="border-color: var(--color-primary);">
            <div class="p-5">
                <div class="flex items-center">
                    <div class="flex-shrink-0 rounded-full p-3" style="background-color: var(--color-primary-50, #fef3c7);">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" style="color: var(--color-primary, #774C0C);">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                            d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/>
                        </svg>
                    </div>
                    <div class="ml-4">
                        <h2 class="text-sm font-medium text-gray-600">Certificates</h2>
                        <p class="text-2xl font-bold text-gray-800">{{ $stats['certificates'] }}</p>
                    </div>
                </div>
                <div class="mt-4 border-t pt-2">
                    <a href="{{ route('admin.projects.index') }}" class="text-sm flex items-center" style="color: var(--color-primary, #774C0C);">
                        Manage Certificates
                        <svg class="w-4 h-4 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                        </svg>
                    </a>
                </div>
            </div>
        </div>
        
        <div class="bg-white rounded-lg shadow-md overflow-hidden border-t-4" style="border-color: var(--color-primary, #774C0C);">
            <div class="p-5">
                <div class="flex items-center">
                    <div class="flex-shrink-0 rounded-full p-3" style="background-color: var(--color-primary-50, #fef3c7);">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" style="color: var(--color-primary, #774C0C);">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                        </svg>
                    </div>
                    <div class="ml-4">
                        <h2 class="text-sm font-medium text-gray-600">Messages</h2>
                        <p class="text-2xl font-bold text-gray-800">{{ $stats['unread_messages'] }}</p>
                        @if($stats['unread_messages'] > 0)
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-red-100 text-red-800">
                                {{ $stats['unread_messages'] }} unread
                            </span>
                        @endif
                    </div>
                </div>
                <div class="mt-4 border-t pt-2">
                    <a href="{{ route('admin.messages.index') }}" class="text-sm flex items-center" style="color: var(--color-primary, #774C0C);">
                        View Messages
                        <svg class="w-4 h-4 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                        </svg>
                    </a>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Main Dashboard Content -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        
        <!-- Recent Activity & Stats -->
        <div class="lg:col-span-3">
            <!-- Recent Projects -->
            <div class="bg-white rounded-lg shadow-md overflow-hidden mb-8">
                <div class="px-6 py-4 flex justify-between items-center" style="background-color: var(--color-primary, #774C0C);">
                    <h2 class="text-xl font-semibold text-white">Recent Projects</h2>
                    <a href="{{ route('admin.projects.index') }}" class="text-sm hover:underline" style="color: var(--color-primary-100, #fde68a);">View All</a>
                </div>
                <div class="p-6">
                    @if(isset($recentProjects) && $recentProjects->count() > 0)
                        <div class="divide-y divide-gray-200">
                            @foreach($recentProjects as $project)
                                <div class="py-4 flex items-center">
                                    @if($project->featured_image)
                                        <img src="{{ asset($project->featured_image) }}" alt="{{ $project->title }}" class="h-12 w-12 object-cover rounded">
                                    @else
                                        <div class="h-12 w-12 rounded flex items-center justify-center" 
                                            style="background-color: var(--color-primary-50, #fef3c7); color: var(--color-primary, #774C0C);">
                                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path>
                                            </svg>
                                        </div>
                                    @endif
                                    <div class="ml-4 flex-1">
                                        <h3 class="text-sm font-medium text-gray-900">{{ $project->title }}</h3>
                                        <p class="text-xs text-gray-500 truncate">{{ $project->short_description }}</p>
                                    </div>
                                    <div>
                                        <a href="{{ route('admin.projects.edit', $project->id) }}" style="color: var(--color-primary, #774C0C);" class="hover:opacity-80">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"></path>
                                            </svg>
                                        </a>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <div class="py-8 text-center">
                            <p class="text-gray-500">No projects found.</p>
                            <a href="{{ route('admin.projects.create') }}" class="inline-block mt-2 text-sm hover:underline" style="color: var(--color-primary, #774C0C);">Create your first project</a>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Live Clock Script -->
<script>
    function updateClock() {
        const now = new Date();
        const options = { 
            hour: '2-digit', 
            minute: '2-digit', 
            second: '2-digit',
            hour12: true
        };
        document.getElementById('liveClock').textContent = now.toLocaleTimeString('en-US', options) + ' PST';
    }
    
    // Update clock immediately
    updateClock();
    
    // Update every second
    setInterval(updateClock, 1000);
</script>
@endsection