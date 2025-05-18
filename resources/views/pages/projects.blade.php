@extends('layouts.app')

@section('title', 'Projects')

@section('content')
<section class="min-h-screen bg-gradient-to-b from-white to-amber-50 py-20">
    <div class="container mx-auto px-6 md:px-10 lg:px-12">
        <!-- Header Section -->
        <div class="text-center mb-16 animate-fade-in-up">
            <h1 class="text-4xl md:text-5xl font-bold text-[#774C0C] font-montserrat mb-6">
                My Projects
            </h1>
            <div class="flex justify-center items-center gap-3">
                <p class="text-lg md:text-xl text-gray-800 font-light">Showcasing my creative work</p>
            </div>
        </div>

        <!-- Project Grid -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
            <!-- Project Card -->
            @forelse($allProjects as $project)
                <div class="group bg-white rounded-2xl shadow-lg overflow-hidden transition-all duration-300 hover:shadow-xl animate-fade-in-up flex flex-col min-h-[600px]">
                    <!-- Project Image -->
                    <div class="relative overflow-hidden h-[250px] w-full">
                        @if($project->image)
                            <img src="{{ asset('storage/' . $project->image) }}" 
                                alt="{{ $project->title ?? $project->project_title }}" 
                                class="w-full h-full object-contain bg-gray-100 group-hover:scale-110 transition-transform duration-500"
                            />
                        @else
                            <div class="w-full h-full flex items-center justify-center bg-gray-100">
                                <span class="text-gray-400">No image available</span>
                            </div>
                        @endif
                        <div class="absolute inset-0 bg-[#774C0C]/60 flex items-center justify-center 
                                    opacity-0 group-hover:opacity-100 transition-opacity duration-300">
                            
                            @if($project->demo_url)
                                <a href="{{ $project->demo_url }}" 
                                    class="px-6 py-3 bg-white text-[#774C0C] rounded-lg font-medium transform -translate-y-4 group-hover:translate-y-0 transition-transform duration-300" 
                                    target="_blank" 
                                    rel="noopener noreferrer">
                                        View Project
                                </a>
                            @elseif($project->github_url)
                                <a href="{{ $project->github_url }}" 
                                    class="px-6 py-3 bg-white text-[#774C0C] rounded-lg font-medium 
                                    transform -translate-y-4 group-hover:translate-y-0 
                                    transition-transform duration-300" 
                                    target="_blank" 
                                    rel="noopener noreferrer">
                                        View Code
                                </a>
                            @else
                                <span class="px-6 py-3 bg-white text-gray-400 rounded-lg font-medium 
                                transform -translate-y-4 group-hover:translate-y-0 
                                transition-transform duration-300 cursor-default">
                                    No Link Available
                                </span>
                            @endif
                        </div>
                    </div>

                    <!-- Project Info -->
                    <div class="flex flex-col flex-1 p-6">
                        <h3 class="text-xl font-bold text-gray-900 mb-4 min-h-[5rem] line-clamp-3">{{ $project->title }}</h3>
                        <p class="text-gray-600 text-sm mb-6 min-h-[3.5rem] line-clamp-3">
                            {{ $project->description }}
                        </p>
                        
                        <!-- Technologies Used -->
                        <div class="flex flex-wrap gap-2 mb-6">
                            @foreach($project->technologies as $technology)
                                <span class="px-2 py-1 bg-[#774C0C] text-white rounded-full text-xs font-medium">
                                    {{ $technology }}
                                </span>
                            @endforeach
                        </div>

                        <!-- Links -->
                        <div class="flex items-center justify-between pt-4">
                            @if($project->demo_url)
                                <a href="{{ $project->demo_url }}" class="text-[#774C0C] hover:text-amber-700 font-medium text-sm flex items-center gap-1 transition-colors duration-300" target="_blank" rel="noopener noreferrer">
                                    <span>Live Demo</span>
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                                            d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"/>
                                    </svg>
                                </a>
                            @else
                                <span class="text-gray-400 text-sm">No Demo Available</span>
                            @endif
                            
                            @if($project->github_url)
                                <a href="{{ $project->github_url }}" 
                                class="text-gray-600 hover:text-[#774C0C] transition-colors duration-300" target="_blank" rel="noopener noreferrer">
                                    <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24">
                                        <path d="M12 0c-6.626 0-12 5.373-12 12 0 5.302 3.438 9.8 8.207 11.387.599.111.793-.261.793-.577v-2.234c-3.338.726-4.033-1.416-4.033-1.416-.546-1.387-1.333-1.756-1.333-1.756-1.089-.745.083-.729.083-.729 1.205.084 1.839 1.237 1.839 1.237 1.07 1.834 2.807 1.304 3.492.997.107-.775.418-1.305.762-1.604-2.665-.305-5.467-1.334-5.467-5.931 0-1.311.469-2.381 1.236-3.221-.124-.303-.535-1.524.117-3.176 0 0 1.008-.322 3.301 1.23.957-.266 1.983-.399 3.003-.404 1.02.005 2.047.138 3.006.404 2.291-1.552 3.297-1.23 3.297-1.23.653 1.653.242 2.874.118 3.176.77.84 1.235 1.911 1.235 3.221 0 4.609-2.807 5.624-5.479 5.921.43.372.823 1.102.823 2.222v3.293c0 .319.192.694.801.576 4.765-1.589 8.199-6.086 8.199-11.386 0-6.627-5.373-12-12-12z"/>
                                    </svg>
                                </a>
                            @endif
                        </div>
                    </div>
                </div>
            @empty
                <div class="col-span-1 md:col-span-2 lg:col-span-3 text-center py-12">
                    <p class="text-gray-600 text-lg">No projects available yet. Check back soon!</p>
                </div>
            @endforelse
        </div>
    </div>
</section>
@endsection