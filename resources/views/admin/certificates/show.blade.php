@extends('layouts.admin')

@section('title', 'Certificate Details')

@section('content')
<div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <x-admin.card>
            <div class="flex justify-between items-center mb-6">
                <h1 class="text-2xl font-semibold" @themeColor('text')>Certificate Details</h1>
                <div class="flex space-x-2">
                    <x-admin.button-primary href="{{ route('admin.certificates.edit', $certificate) }}">
                        Edit Certificate
                    </x-admin.button-primary>
                    <x-admin.button-secondary href="{{ route('admin.certificates.index') }}">
                        Back to Certificates
                    </x-admin.button-secondary>
                </div>
            </div>

            <div class="bg-gray-50 p-6 rounded-lg shadow">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <h2 class="text-lg font-semibold mb-4" @themeColor('text')>Certificate Information</h2>
                        
                        <div class="mb-4">
                            <label class="block text-sm font-medium mb-1" @themeColor('text-light')>Name</label>
                            <div class="font-semibold" @themeColor('text')>{{ $certificate->name }}</div>
                        </div>
                        
                        <div class="mb-4">
                            <label class="block text-sm font-medium mb-1" @themeColor('text-light')>Issuer</label>
                            <div @themeColor('text')>{{ $certificate->issuer }}</div>
                        </div>

                        <div class="mb-4">
                            <label class="block text-sm font-medium mb-1" @themeColor('text-light')>Issue Date</label>
                            <div @themeColor('text')>{{ $certificate->issue_date->format('F d, Y') }}</div>
                        </div>

                        <div class="mb-4">
                            <label class="block text-sm font-medium mb-1" @themeColor('text-light')>Expiry Date</label>
                            <div @themeColor('text')>
                                @if($certificate->expiry_date)
                                    {{ $certificate->expiry_date->format('F d, Y') }}
                                    @if(!$certificate->is_valid)
                                        <span class="ml-2 bg-red-100 text-red-800 text-xs font-medium px-2.5 py-0.5 rounded">Expired</span>
                                    @endif
                                @else
                                    <span class="text-gray-500">No expiration date</span>
                                @endif
                            </div>
                        </div>
                    </div>
                    
                    <div>
                        <h2 class="text-lg font-semibold mb-4" @themeColor('text')>Verification Details</h2>
                        
                        <div class="mb-4">
                            <label class="block text-sm font-medium mb-1" @themeColor('text-light')>Credential ID</label>
                            <div @themeColor('text')>
                                @if($certificate->credential_id)
                                    <code class="bg-gray-100 px-2 py-1 rounded">{{ $certificate->credential_id }}</code>
                                @else
                                    <span class="text-gray-500">Not provided</span>
                                @endif
                            </div>
                        </div>
                        
                        <div class="mb-4">
                            <label class="block text-sm font-medium mb-1" @themeColor('text-light')>Verification URL</label>
                            <div>
                                @if($certificate->proof_url)
                                    <a href="{{ $certificate->proof_url }}" target="_blank" class="flex items-center" style="color: var(--color-primary, #774C0C);">
                                        {{ Str::limit($certificate->proof_url, 40) }}
                                        <svg class="w-4 h-4 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"></path>
                                        </svg>
                                    </a>
                                @else
                                    <span class="text-gray-500">Not provided</span>
                                @endif
                            </div>
                        </div>
                        
                        <div class="mt-8">
                            <div class="flex items-center">
                                <div class="flex-shrink-0">
                                    @if($certificate->is_valid)
                                        <div class="rounded-full p-2" style="background-color: var(--color-primary-50, #fef3c7);">
                                            <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg" style="color: var(--color-primary, #774C0C);">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                            </svg>
                                        </div>
                                    @else
                                        <div class="rounded-full p-2 bg-red-50">
                                            <svg class="h-6 w-6 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                            </svg>
                                        </div>
                                    @endif
                                </div>
                                <div class="ml-3">
                                    <h3 class="text-sm font-medium" @themeColor('text')>Status</h3>
                                    <p class="text-sm" @themeColor('text-light')>
                                        @if($certificate->is_valid)
                                            This certificate is currently valid.
                                        @else
                                            @if($certificate->expiry_date && $certificate->expiry_date->isPast())
                                                This certificate has expired.
                                            @else
                                                This certificate is not active.
                                            @endif
                                        @endif
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                
                @if($certificate->description)
                    <div class="mt-6 pt-6 border-t border-gray-200">
                        <h2 class="text-lg font-semibold mb-4" @themeColor('text')>Description</h2>
                        <div class="prose prose-sm max-w-none" @themeColor('text')>
                            {!! nl2br(e($certificate->description)) !!}
                        </div>
                    </div>
                @endif
                
                @if($certificate->image)
                    <div class="mt-6 pt-6 border-t border-gray-200">
                        <h2 class="text-lg font-semibold mb-4" @themeColor('text')>Certificate Image</h2>
                        <div class="mt-2">
                            <a href="{{ asset('storage/'.$certificate->image) }}" target="_blank">
                                <img src="{{ asset('storage/'.$certificate->image) }}" alt="{{ $certificate->name }}" class="max-w-md rounded-lg shadow-md hover:shadow-lg transition-shadow duration-300">
                            </a>
                        </div>
                    </div>
                @endif
            </div>
            
        </x-admin.card>
    </div>
</div>
@endsection