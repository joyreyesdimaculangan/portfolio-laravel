@extends('layouts.admin')

@section('title', 'Experience Details')

@section('content')
<div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <x-admin.card>
            <div class="flex justify-between items-center mb-6">
                <h1 class="text-2xl font-semibold" @themeColor('text')>Experience Details</h1>
                <div class="flex space-x-2">
                    <x-admin.button-primary href="{{ route('admin.experiences.edit', $experience) }}">
                        Edit Experience
                    </x-admin.button-primary>
                    <x-admin.button-secondary href="{{ route('admin.experiences.index') }}">
                        Back to Experiences
                    </x-admin.button-secondary>
                </div>
            </div>

            <div class="bg-gray-50 p-6 rounded-lg shadow">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <h2 class="text-lg font-semibold mb-4" @themeColor('text')>Job Information</h2>
                        
                        <div class="mb-4">
                            <label class="block text-sm font-medium mb-1" @themeColor('text-light')>Company/Organization</label>
                            <div class="font-semibold" @themeColor('text')>{{ $experience->company }}</div>
                        </div>
                        
                        <div class="mb-4">
                            <label class="block text-sm font-medium mb-1" @themeColor('text-light')>Position</label>
                            <div @themeColor('text')>{{ $experience->position }}</div>
                        </div>
                        
                        <div class="mb-4">
                            <label class="block text-sm font-medium mb-1" @themeColor('text-light')>Location</label>
                            <div @themeColor('text')>{{ $experience->location ?? 'Not specified' }}</div>
                        </div>
                    </div>
                    
                    <div>
                        <h2 class="text-lg font-semibold mb-4" @themeColor('text')>Duration</h2>
                        
                        <div class="mb-4">
                            <label class="block text-sm font-medium mb-1" @themeColor('text-light')>Start Date</label>
                            <div @themeColor('text')>{{ $experience->start_date->format('M Y') }}</div>
                        </div>
                        
                        <div class="mb-4">
                            <label class="block text-sm font-medium mb-1" @themeColor('text-light')>End Date</label>
                            <div @themeColor('text')>
                                @if($experience->ongoing)
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium" style="color: var(--color-primary, #774C0C); background-color: var(--color-primary-50, #fef3c7);">Present</span>
                                @else
                                    {{ $experience->end_date ? $experience->end_date->format('M Y') : 'Not specified' }}
                                @endif
                            </div>
                        </div>
                        
                        <div class="mb-4">
                            <label class="block text-sm font-medium mb-1" @themeColor('text-light')>Duration</label>
                            <div @themeColor('text')>{{ $experience->date_range }}</div>
                        </div>
                        
                        <div class="mt-8">
                            <div class="flex items-center">
                                <div class="flex-shrink-0">
                                    @if($experience->ongoing)
                                        <div class="rounded-full p-2" style="background-color: var(--color-primary-50, #fef3c7);">
                                            <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg" style="color: var(--color-primary, #774C0C);">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                            </svg>
                                        </div>
                                    @else
                                        <div class="rounded-full p-2" style="background-color: var(--color-primary-50, #fef3c7);">
                                            <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg" style="color: var(--color-primary, #774C0C);">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                            </svg>
                                        </div>
                                    @endif
                                </div>
                                <div class="ml-3">
                                    <h3 class="text-sm font-medium" @themeColor('text')>Status</h3>
                                    <p class="text-sm" @themeColor('text-light')>
                                        @if($experience->ongoing)
                                            Currently employed at this position.
                                        @else
                                            This position has been completed.
                                        @endif
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="mt-6">
                    <h2 class="text-lg font-semibold mb-2" @themeColor('text')>Description</h2>
                    <div class="prose max-w-none border rounded-lg p-4 bg-white" @themeColor('text')>
                        {!! nl2br(e($experience->description)) !!}
                    </div>
                </div>
                
                @if(count($experience->achievements_array) > 0)
                    <div class="mt-6">
                        <h2 class="text-lg font-semibold mb-2" @themeColor('text')>Key Achievements</h2>
                        <ul class="list-disc pl-5 space-y-1">
                            @foreach($experience->achievements_array as $achievement)
                                <li @themeColor('text')>{{ $achievement }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif
            </div>
        </x-admin.card>
    </div>
</div>
@endsection