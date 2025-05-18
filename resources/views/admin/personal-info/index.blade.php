@extends('layouts.admin')

@section('title', 'Personal Info')

@section('content')
<div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <x-admin.card>
            <div class="flex justify-between items-center mb-6">
                <h1 class="text-2xl font-semibold" @themeColor('text')>Manage Personal Information</h1>
                <x-admin.button-primary href="{{ route('admin.personal-info.create') }}">
                    <i class="fas fa-plus mr-2"></i> Add New Information
                </x-admin.button-primary>
            </div>

            @if(session('success'))
                <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
                    {{ session('success') }}
                </div>
            @endif

            <!-- Filter Section -->
            <div class="mb-6 bg-gray-50 p-4 rounded-lg">
                <form action="{{ route('admin.personal-info.index') }}" method="GET" class="flex items-center space-x-4">
                    <div class="flex-grow">
                        <label for="section" class="block text-sm font-medium mb-1" @themeColor('text-light')>Filter by Section</label>
                        <select id="section" name="section" class="w-full border-gray-300 rounded-md shadow-sm" style="--tw-ring-color: var(--color-primary, #774C0C);" onchange="this.form.submit()">
                            <option value="">All Sections</option>
                            @foreach($sections as $sectionOption)
                                <option value="{{ $sectionOption }}" {{ $section == $sectionOption ? 'selected' : '' }}>
                                    {{ ucfirst($sectionOption) }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="pt-6">
                        <x-admin.button-secondary type="submit">
                            Apply
                        </x-admin.button-secondary>
                        @if($section)
                            <a href="{{ route('admin.personal-info.index') }}" class="ml-2 inline-flex items-center px-4 py-2 border border-gray-300 rounded-md shadow-sm text-sm font-medium" style="color: var(--color-text, #1E293B); background-color: white;">
                                Clear
                            </a>
                        @endif
                    </div>
                </form>
            </div>

            <div class="overflow-x-auto bg-white rounded-lg shadow">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider" @themeColor('text-light')>
                                Key
                            </th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider" @themeColor('text-light')>
                                Value
                            </th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider" @themeColor('text-light')>
                                Section
                            </th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider" @themeColor('text-light')>
                                Type
                            </th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider" @themeColor('text-light')>
                                Public
                            </th>
                            <th scope="col" class="px-6 py-3 text-right text-xs font-medium uppercase tracking-wider" @themeColor('text-light')>
                                Actions
                            </th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @forelse($personalInfo as $info)
                            <tr>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm font-medium" @themeColor('text')>{{ $info->key }}</div>
                                </td>
                                <td class="px-6 py-4">
                                    @if($info->type == 'image')
                                        <img src="{{ Storage::url($info->value) }}" alt="{{ $info->key }}" class="h-10 w-auto object-cover">
                                    @elseif($info->type == 'file')
                                        <a href="{{ Storage::url($info->value) }}" target="_blank" class="hover:underline text-sm" style="color: var(--color-primary, #774C0C);">
                                            View File
                                        </a>
                                    @else
                                        <div class="text-sm truncate max-w-xs" @themeColor('text-light')>{{ Str::limit($info->value, 100) }}</div>
                                    @endif
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm" @themeColor('text-light')>{{ $info->section ?? 'None' }}</div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium" style="background-color: var(--color-primary-50, #fef3c7); color: var(--color-primary, #774C0C);">
                                        {{ $info->type }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm">
                                        @if($info->is_public)
                                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">Yes</span>
                                        @else
                                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-gray-100 text-gray-800">No</span>
                                        @endif
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                    <div class="flex justify-end space-x-2">
                                        <x-admin.button-secondary href="{{ route('admin.personal-info.show', $info) }}" class="px-3 py-1">
                                            View
                                        </x-admin.button-secondary>
                                        
                                        <x-admin.button-secondary href="{{ route('admin.personal-info.edit', $info) }}" class="px-3 py-1">
                                            Edit
                                        </x-admin.button-secondary>
                                        
                                        <form action="{{ route('admin.personal-info.destroy', $info) }}" method="POST" class="inline-block" onsubmit="return confirm('Are you sure you want to delete this information? This action cannot be undone.')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="text-red-600 hover:text-red-900 bg-red-100 hover:bg-red-200 px-3 py-2 rounded">
                                                Delete
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="px-6 py-10 text-center">
                                    <div class="mb-4">
                                        <svg class="mx-auto h-12 w-12" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true" @themeColor('text-light')>
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                        </svg>
                                        <h3 class="mt-2 text-lg font-medium" @themeColor('text')>No personal information found</h3>
                                        <p class="mt-1 text-sm" @themeColor('text-light')>Get started by creating your first information entry.</p>
                                    </div>
                                    <x-admin.button-primary href="{{ route('admin.personal-info.create') }}">
                                        Add Your First Information Entry
                                    </x-admin.button-primary>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            <div class="mt-6">
                <x-admin-pagination :paginator="$personalInfo" resource-name="personal info items" />
            </div>
        </x-admin.card>
    </div>
</div>
@endsection