@extends('layouts.admin')

@section('title', 'Project Details')

@section('content')
<div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <x-admin.card>
            <div class="flex justify-between items-center mb-6">
                <h1 class="text-2xl font-semibold" @themeColor('text')>{{ $project->title }}</h1>
                <div class="flex space-x-2">
                    <x-admin.button-primary href="{{ route('admin.projects.edit', $project) }}">
                        Edit Project
                    </x-admin.button-primary>
                    <x-admin.button-secondary href="{{ route('admin.projects.index') }}">
                        Back to Projects
                    </x-admin.button-secondary>
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <div class="md:col-span-1">
                    <div class="bg-gray-100 p-4 rounded-lg h-full">
                        @if($project->image)
                            <img src="{{ asset('storage/' . $project->image) }}" alt="{{ $project->title }}" class="w-full h-auto rounded-lg mb-4">
                        @else
                            <div class="w-full h-48 bg-gray-200 flex items-center justify-center rounded-lg mb-4">
                                <span @themeColor('text-light')>No Image Available</span>
                            </div>
                        @endif

                        <div class="mt-4 space-y-2">
                            <h3 class="text-lg font-medium" @themeColor('text')>Project Links</h3>
                            @if($project->github_url)
                                <div>
                                    <span @themeColor('text-light') class="font-medium">GitHub:</span>
                                    <a href="{{ $project->github_url }}" target="_blank" style="color: var(--color-primary, #774C0C);" class="hover:underline ml-1 break-all">
                                        {{ $project->github_url }}
                                    </a>
                                </div>
                            @endif
                            @if($project->demo_url)
                                <div>
                                    <span @themeColor('text-light') class="font-medium">Live Demo:</span>
                                    <a href="{{ $project->demo_url }}" target="_blank" style="color: var(--color-primary, #774C0C);" class="hover:underline ml-1 break-all">
                                        {{ $project->demo_url }}
                                    </a>
                                </div>
                            @endif
                        </div>

                        <div class="mt-4">
                            <h3 class="text-lg font-medium" @themeColor('text')>Created</h3>
                            <p @themeColor('text-light')>{{ $project->created_at->format('F j, Y, g:i a') }}</p>
                        </div>

                        <div class="mt-4">
                            <h3 class="text-lg font-medium" @themeColor('text')>Last Updated</h3>
                            <p @themeColor('text-light')>{{ $project->updated_at->format('F j, Y, g:i a') }}</p>
                        </div>
                    </div>
                </div>

                <div class="md:col-span-2">
                    <div class="mb-6">
                        <h3 class="text-lg font-medium mb-2" @themeColor('text')>Description</h3>
                        <div class="bg-gray-50 p-4 rounded-lg">
                            <p class="whitespace-pre-line" @themeColor('text')>{{ $project->description }}</p>
                        </div>
                    </div>

                    <div>
                        <h3 class="text-lg font-medium mb-2" @themeColor('text')>Technologies Used</h3>
                        <div class="flex flex-wrap gap-2">
                            @forelse($project->technologies_array as $technology)
                                <span class="px-3 py-1 rounded-full text-sm" style="background-color: var(--color-primary-50, #fef3c7); color: var(--color-primary, #774C0C);">{{ $technology }}</span>
                            @empty
                                <p @themeColor('text-light')>No technologies specified</p>
                            @endforelse
                        </div>
                    </div>
                </div>
            </div>
        </x-admin.card>
    </div>
</div>
@endsection