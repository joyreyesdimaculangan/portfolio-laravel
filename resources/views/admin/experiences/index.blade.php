@extends('layouts.admin')

@section('title', 'Experiences')

@section('content')
<div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <x-admin.card>
            <div class="flex justify-between items-center mb-6">
                <h1 class="text-2xl font-semibold" @themeColor('text')>Manage Experiences</h1>
                <x-admin.button-primary href="{{ route('admin.experiences.create') }}">
                    <i class="fas fa-plus mr-2"></i> Add New Experience
                </x-admin.button-primary>
            </div>

            @if(session('success'))
                <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
                    {{ session('success') }}
                </div>
            @endif

            @if(session('error'))
                <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">
                    {{ session('error') }}
                </div>
            @endif

            <div class="overflow-x-auto bg-white rounded-lg shadow">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider" @themeColor('text-light')>
                                Job Title
                            </th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider" @themeColor('text-light')>
                                Company
                            </th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider" @themeColor('text-light')>
                                Duration
                            </th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider" @themeColor('text-light')>
                                Status
                            </th>
                            <th scope="col" class="px-6 py-3 text-right text-xs font-medium uppercase tracking-wider" @themeColor('text-light')>
                                Actions
                            </th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @forelse($experiences as $experience)
                            <tr class="hover:bg-gray-50">
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm font-medium" @themeColor('text')>{{ $experience->title }}</div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm" @themeColor('text')>{{ $experience->company }}</div>
                                    @if($experience->location)
                                        <div class="text-xs" @themeColor('text-light')>{{ $experience->location }}</div>
                                    @endif
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm" @themeColor('text')>{{ $experience->date_range }}</div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    @if($experience->ongoing)
                                        <span class="px-2 py-1 text-xs font-semibold rounded-full" style="color: var(--color-primary, #774C0C); background-color: var(--color-primary-50, #fef3c7);">
                                            Current
                                        </span>
                                    @else
                                        <span class="px-2 py-1 text-xs font-semibold rounded-full bg-gray-100 text-gray-800">
                                            Past
                                        </span>
                                    @endif
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                    <div class="flex justify-end space-x-2">
                                        <x-admin.button-secondary href="{{ route('admin.experiences.show', $experience) }}" class="px-3 py-1">
                                            View
                                        </x-admin.button-secondary>
                                        
                                        <x-admin.button-secondary href="{{ route('admin.experiences.edit', $experience) }}" class="px-3 py-1">
                                            Edit
                                        </x-admin.button-secondary>
                                        
                                        <form action="{{ route('admin.experiences.destroy', $experience) }}" method="POST" class="inline-block" onsubmit="return confirm('Are you sure you want to delete this experience? This action cannot be undone.')">
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
                                <td colspan="5" class="px-6 py-10 text-center">
                                    <div class="mb-4">
                                        <svg class="mx-auto h-12 w-12" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true" @themeColor('text-light')>
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                        </svg>
                                        <h3 class="mt-2 text-lg font-medium" @themeColor('text')>No experiences found</h3>
                                        <p class="mt-1 text-sm" @themeColor('text-light')>Get started by adding your work experiences.</p>
                                    </div>
                                    <x-admin.button-primary href="{{ route('admin.experiences.create') }}">
                                        Add Your First Experience
                                    </x-admin.button-primary>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            
            @if(isset($experiences) && method_exists($experiences, 'links'))
                <div class="mt-4">
                    {{ $experiences->links() }}
                </div>
            @endif

            <div class="mt-6">
                <x-admin-pagination :paginator="$experiences" resource-name="experiences" />
            </div>
        </x-admin.card>
    </div>
</div>
@endsection