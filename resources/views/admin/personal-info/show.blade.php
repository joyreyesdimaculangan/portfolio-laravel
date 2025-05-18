@extends('layouts.admin')

@section('title', 'Personal Info')

@section('content')
<div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <x-admin.card>
            <div class="flex justify-between items-center mb-6">
                <h1 class="text-2xl font-semibold" @themeColor('text')>Personal Information Details</h1>
                <div class="flex space-x-2">
                    <x-admin.button-primary href="{{ route('admin.personal-info.edit', $personalInfo) }}">
                        Edit Information
                    </x-admin.button-primary>
                    <x-admin.button-secondary href="{{ route('admin.personal-info.index') }}">
                        Back to Information
                    </x-admin.button-secondary>
                </div>
            </div>

            <div class="bg-gray-50 p-6 rounded-lg shadow">
                <div class="grid grid-cols-1 gap-6">
                    <div>
                        <div class="mb-4">
                            <label class="block text-sm font-medium mb-1" @themeColor('text-light')>Key</label>
                            <div class="font-mono bg-gray-100 p-2 rounded" @themeColor('text')>{{ $personalInfo->key }}</div>
                        </div>
                        
                        <div class="mb-4">
                            <label class="block text-sm font-medium mb-1" @themeColor('text-light')>Section</label>
                            <div @themeColor('text')>{{ $personalInfo->section ?? 'Not categorized' }}</div>
                        </div>

                        <div class="mb-4">
                            <label class="block text-sm font-medium mb-1" @themeColor('text-light')>Type</label>
                            <div class="inline-flex px-2 py-1 rounded-full text-xs font-medium" style="background-color: var(--color-primary-50, #fef3c7); color: var(--color-primary, #774C0C);">
                                {{ $personalInfo->type }}
                            </div>
                        </div>
                        
                        <div class="mb-4">
                            <label class="block text-sm font-medium mb-1" @themeColor('text-light')>Value</label>
                            @if($personalInfo->type == 'image')
                                <div class="bg-gray-100 p-4 rounded border">
                                    <img src="{{ Storage::url($personalInfo->value) }}" alt="{{ $personalInfo->key }}" class="max-h-64 object-contain">
                                </div>
                            @elseif($personalInfo->type == 'file')
                                <div class="bg-gray-100 p-4 rounded border">
                                    <a href="{{ Storage::url($personalInfo->value) }}" target="_blank" class="flex items-center" style="color: var(--color-primary, #774C0C);">
                                        <svg class="h-6 w-6 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3M3 17V7a2 2 0 012-2h6l2 2h6a2 2 0 012 2v8a2 2 0 01-2 2H5a2 2 0 01-2-2z" />
                                        </svg>
                                        Download File
                                    </a>
                                </div>
                            @else
                                <div class="bg-gray-100 p-4 rounded border whitespace-pre-wrap" @themeColor('text')>{{ $personalInfo->value }}</div>
                            @endif
                        </div>
                        
                        <div class="mb-4">
                            <label class="block text-sm font-medium mb-1" @themeColor('text-light')>Visibility</label>
                            <div>
                                @if($personalInfo->is_public)
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium" style="color: #065f46; background-color: #d1fae5;">
                                        <svg class="h-3 w-3 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                        </svg>
                                        Public
                                    </span>
                                @else
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-gray-100" @themeColor('text-light')>
                                        <svg class="h-3 w-3 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l18 18" />
                                        </svg>
                                        Private
                                    </span>
                                @endif
                            </div>
                        </div>
                        
                        <div class="mb-4">
                            <label class="block text-sm font-medium mb-1" @themeColor('text-light')>Last Updated</label>
                            <div @themeColor('text')>{{ $personalInfo->updated_at->format('F j, Y, g:i a') }}</div>
                        </div>
                    </div>

                    <div class="mt-6 pt-4 border-t border-gray-200">
                        <h3 class="text-md font-semibold mb-2" @themeColor('text')>Access in Templates</h3>
                        <div class="bg-gray-800 text-green-400 p-3 rounded font-mono text-sm overflow-x-auto">
                            <code>{{ '\{\{ $personalInfo[\'' . $personalInfo->key . '\'] ?? \'\' \}\}' }}</code>
                        </div>
                        <p class="text-sm mt-1" @themeColor('text-lighter')>Use this code in your blade templates to display this value</p>
                    </div>
                </div>
            </div>
        </x-admin.card>
    </div>
</div>
@endsection