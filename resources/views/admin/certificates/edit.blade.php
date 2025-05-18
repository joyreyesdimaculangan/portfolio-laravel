@extends('layouts.admin')

@section('title', 'Edit Certificate')

@section('content')
<div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
            <div class="p-6 bg-white border-b border-gray-200">
                <div class="flex justify-between items-center mb-6">
                    <h1 class="text-2xl font-semibold" @themeColor('text')>Edit Certificate</h1>
                    <x-admin.button-secondary href="{{ route('admin.certificates.index') }}">
                        Back to Certificates
                    </x-admin.button-secondary>
                </div>

                @if ($errors->any())
                    <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">
                        <strong class="font-bold">Please fix the following errors:</strong>
                        <ul class="list-disc list-inside mt-2">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form action="{{ route('admin.certificates.update', $certificate) }}" method="POST">
                    @csrf
                    @method('PUT')
                    
                    <div class="mb-4">
                        <label for="name" class="block text-sm font-bold mb-2" @themeColor('text-light')>Certificate Name *</label>
                        <input type="text" name="name" id="name" value="{{ old('name', $certificate->name) }}" class="shadow appearance-none border rounded w-full py-2 px-3 leading-tight focus:outline-none focus:shadow-outline @error('name') border-red-500 @enderror" @themeColor('text') required>
                        @error('name')
                            <p class="text-red-500 text-xs italic mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="mb-4">
                        <label for="issuer" class="block text-sm font-bold mb-2" @themeColor('text-light')>Issuer *</label>
                        <input type="text" name="issuer" id="issuer" value="{{ old('issuer', $certificate->issuer) }}" class="shadow appearance-none border rounded w-full py-2 px-3 leading-tight focus:outline-none focus:shadow-outline @error('issuer') border-red-500 @enderror" @themeColor('text') required>
                        @error('issuer')
                            <p class="text-red-500 text-xs italic mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="mb-4">
                        <label for="issue_date" class="block text-sm font-bold mb-2" @themeColor('text-light')>Issue Date *</label>
                        <input type="date" name="issue_date" id="issue_date" value="{{ old('issue_date', $certificate->issue_date->format('Y-m-d')) }}" class="shadow appearance-none border rounded w-full py-2 px-3 leading-tight focus:outline-none focus:shadow-outline @error('issue_date') border-red-500 @enderror" @themeColor('text') required>
                        @error('issue_date')
                            <p class="text-red-500 text-xs italic mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="mb-4">
                        <label for="expiry_date" class="block text-sm font-bold mb-2" @themeColor('text-light')>Expiry Date (if applicable)</label>
                        <input type="date" name="expiry_date" id="expiry_date" value="{{ old('expiry_date', $certificate->expiry_date ? $certificate->expiry_date->format('Y-m-d') : '') }}" class="shadow appearance-none border rounded w-full py-2 px-3 leading-tight focus:outline-none focus:shadow-outline @error('expiry_date') border-red-500 @enderror" @themeColor('text')>
                        @error('expiry_date')
                            <p class="text-red-500 text-xs italic mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="mb-4">
                        <label for="credential_id" class="block text-sm font-bold mb-2" @themeColor('text-light')>Credential ID</label>
                        <input type="text" name="credential_id" id="credential_id" value="{{ old('credential_id', $certificate->credential_id) }}" class="shadow appearance-none border rounded w-full py-2 px-3 leading-tight focus:outline-none focus:shadow-outline @error('credential_id') border-red-500 @enderror" @themeColor('text')>
                        @error('credential_id')
                            <p class="text-red-500 text-xs italic mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="mb-6">
                        <label for="proof_url" class="block text-sm font-bold mb-2" @themeColor('text-light')>Verification URL</label>
                        <input type="url" name="proof_url" id="proof_url" value="{{ old('proof_url', $certificate->proof_url) }}" placeholder="https://" class="shadow appearance-none border rounded w-full py-2 px-3 leading-tight focus:outline-none focus:shadow-outline @error('proof_url') border-red-500 @enderror" @themeColor('text')>
                        @error('proof_url')
                            <p class="text-red-500 text-xs italic mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="flex items-center justify-end">
                        <button type="submit" class="px-4 py-2 text-white rounded-md" style="background-color: var(--color-primary, #774C0C); hover:opacity-90">
                            Update Certificate
                        </button>
                    </div>
                </form>

                <hr class="my-8">

                <div class="flex justify-end">
                    <form action="{{ route('admin.certificates.destroy', $certificate) }}" method="POST" class="inline-block" onsubmit="return confirm('Are you sure you want to delete this certificate? This action cannot be undone.')">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="px-4 py-2 text-white rounded-md" style="background-color: var(--color-danger, #EF4444); hover:opacity-90">
                            Delete Certificate
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection