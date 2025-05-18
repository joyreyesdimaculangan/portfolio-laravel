@extends('layouts.admin')

@section('title', 'Education Details')

@section('content')
<div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <x-admin.card>
            <div class="flex justify-between items-center mb-6">
                <h1 class="text-2xl font-semibold" @themeColor('text')>Education Details</h1>
                <div class="flex space-x-2">
                    <x-admin.button-primary href="{{ route('admin.education.edit', $education) }}">
                        Edit Education
                    </x-admin.button-primary>
                    <x-admin.button-secondary href="{{ route('admin.education.index') }}">
                        Back to Education
                    </x-admin.button-secondary>
                </div>
            </div>

            <div class="bg-gray-50 p-6 rounded-lg shadow">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <h2 class="text-lg font-semibold mb-4" @themeColor('text')>Institution Information</h2>
                        
                        <div class="mb-4">
                            <label class="block text-sm font-medium mb-1" @themeColor('text-light')>Institution</label>
                            <div class="font-semibold" @themeColor('text')>{{ $education->institution }}</div>
                        </div>
                        
                        <div class="mb-4">
                            <label class="block text-sm font-medium mb-1" @themeColor('text-light')>Location</label>
                            <div @themeColor('text')>{{ $education->location ?? 'Not specified' }}</div>
                        </div>
                        
                        <div class="mb-4">
                            <label class="block text-sm font-medium mb-1" @themeColor('text-light')>Degree</label>
                            <div @themeColor('text')>{{ $education->degree }}</div>
                        </div>
                        
                        <div class="mb-4">
                            <label class="block text-sm font-medium mb-1" @themeColor('text-light')>Field of Study</label>
                            <div @themeColor('text')>{{ $education->field_of_study ?? 'Not specified' }}</div>
                        </div>
                    </div>
                    
                    <div>
                        <h2 class="text-lg font-semibold mb-4" @themeColor('text')>Timeline</h2>
                        
                        <div class="mb-4">
                            <label class="block text-sm font-medium mb-1" @themeColor('text-light')>Start Date</label>
                            <div @themeColor('text')>{{ $education->start_date->format('F Y') }}</div>
                        </div>
                        
                        <div class="mb-4">
                            <label class="block text-sm font-medium mb-1" @themeColor('text-light')>
                                {{ $education->ongoing ? 'Status' : 'End Date' }}
                            </label>
                            <div @themeColor('text')>
                                @if($education->ongoing)
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium" style="color: var(--color-primary, #774C0C); background-color: var(--color-primary-50, #fef3c7);">
                                        Currently Studying
                                    </span>
                                @else
                                    {{ $education->end_date ? $education->end_date->format('F Y') : 'Not specified' }}
                                @endif
                            </div>
                        </div>
                        
                        <div class="mb-4">
                            <label class="block text-sm font-medium mb-1" @themeColor('text-light')>Duration</label>
                            <div @themeColor('text')>{{ $education->duration }}</div>
                        </div>
                        
                        <div class="mt-8">
                            <div class="flex items-center">
                                <div class="flex-shrink-0">
                                    @if($education->ongoing)
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
                                        @if($education->ongoing)
                                            Currently pursuing this education.
                                        @else
                                            This education has been completed.
                                        @endif
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                
                @if($education->description)
                    <div class="mt-6 pt-6 border-t border-gray-200">
                        <h2 class="text-lg font-semibold mb-4" @themeColor('text')>Description</h2>
                        <div class="prose prose-sm max-w-none bg-white border border-gray-200 rounded-md p-4" @themeColor('text')>
                            {!! nl2br(e($education->description)) !!}
                        </div>
                    </div>
                @endif
            </div>
        </x-admin.card>
    </div>
</div>
@endsection