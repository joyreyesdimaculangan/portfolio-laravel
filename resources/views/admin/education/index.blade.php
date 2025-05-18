@extends('layouts.admin')

@section('title', 'Education')

@section('content')
<div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <x-admin.card>
            00<div class="flex justify-between items-center mb-6">
                <h1 class="text-2xl font-semibold" @themeColor('text')>Manage Education</h1>
                <x-admin.button-primary href="{{ route('admin.education.create') }}">
                    <i class="fas fa-plus mr-2"></i> Add New Education
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
                                    Institution
                                </th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider" @themeColor('text-light')>
                                    Degree
                                </th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider" @themeColor('text-light')>
                                    Duration
                                </th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider" @themeColor('text-light')>
                                    Location
                                </th>
                                <th scope="col" class="px-6 py-3 text-right text-xs font-medium uppercase tracking-wider" @themeColor('text-light')>
                                    Actions
                                </th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @forelse($education as $edu)
                                <tr>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="text-sm font-medium" @themeColor('text')>{{ $edu->institution }}</div>
                                        <div class="text-sm" @themeColor('text-light')>{{ $edu->field_of_study }}</div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="text-sm" @themeColor('text')>{{ $edu->degree }}</div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="text-sm" @themeColor('text')>{{ $edu->date_range }}</div>
                                        @if($edu->ongoing)
                                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                                Current
                                            </span>
                                        @endif
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="text-sm" @themeColor('text')>{{ $edu->location }}</div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                        <div class="flex justify-end space-x-2">
                                            <x-admin.button-secondary href="{{ route('admin.education.show', $edu) }}" class="px-3 py-1 rounded">
                                                View
                                            </x-admin.button-secondary>

                                            <x-admin.button-secondary href="{{ route('admin.education.edit', $edu) }}" class="px-3 py-1 rounded">
                                                Edit
                                            </x-admin.button-secondary>

                                            <form action="{{ route('admin.education.destroy', $edu) }}" method="POST" class="inline-block" onsubmit="return confirm('Are you sure you want to delete this education record? This action cannot be undone.')">
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
                                            <h3 class="mt-2 text-lg font-medium" @themeColor('text')>No education records found</h3>
                                            <p class="mt-1 text-sm" @themeColor('text-light')>Get started by creating your education history.</p>
                                        </div>
                                        <x-admin.button-primary href="{{ route('admin.education.create') }}">
                                            Add Your First Education
                                        </x-admin.button-primary>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                <div class="mt-6">
                    <x-admin-pagination :paginator="$education" resource-name="education records" />
                </div>
            </div>
        </x-admin.card>
    </div>
</div>
@endsection