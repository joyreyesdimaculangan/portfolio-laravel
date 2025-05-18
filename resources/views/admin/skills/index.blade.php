@extends('layouts.admin')

@section('title', 'Skills')

@section('content')
<div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <x-admin.card>
            <div class="flex justify-between items-center mb-6">
                <h1 class="text-2xl font-semibold" @themeColor('text')>Manage Skills</h1>
                <x-admin.button-primary href="{{ route('admin.skills.create') }}">
                    <i class="fas fa-plus mr-2"></i> Add New Skill
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

            <!-- Filter Section -->
            <div class="mb-6 bg-gray-50 p-4 rounded-lg">
                <h2 class="text-lg font-medium mb-3" @themeColor('text')>Filter Skills</h2>
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                    <div>
                        <label for="categoryFilter" class="block text-sm font-medium mb-1" @themeColor('text-light')>Category</label>
                        <select id="categoryFilter" class="w-full border-gray-300 rounded-md shadow-sm" style="--tw-ring-color: var(--color-primary, #774C0C);">
                            <option value="">All Categories</option>
                            @foreach($skillsByCategory->keys() as $category)
                                <option value="{{ $category }}">{{ $category ?? 'Uncategorized' }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
            </div>

            <div class="overflow-x-auto bg-white rounded-lg shadow">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider" @themeColor('text-light')>
                                Name
                            </th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider" @themeColor('text-light')>
                                Category
                            </th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider" @themeColor('text-light')>
                                Proficiency
                            </th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider" @themeColor('text-light')>
                                Order
                            </th>
                            <th scope="col" class="px-6 py-3 text-right text-xs font-medium uppercase tracking-wider" @themeColor('text-light')>
                                Actions
                            </th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @forelse(collect($skillsByCategory)->flatten() as $skill)
                            <tr class="skill-row" data-category="{{ $skill->category }}">
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm font-medium" @themeColor('text')>{{ $skill->name }}</div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm" @themeColor('text-light')>{{ $skill->category ?? 'Uncategorized' }}</div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="w-full bg-gray-200 rounded-full h-2.5 mb-1">
                                        <div class="h-2.5 rounded-full" style="width: {{ $skill->proficiency }}%; background-color: var(--color-primary, #774C0C);"></div>
                                    </div>
                                    <span class="text-xs" @themeColor('text-light')>{{ $skill->proficiency }}%</span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm" @themeColor('text-light')>{{ $skill->order }}</div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                    <div class="flex justify-end space-x-2">
                                        <x-admin.button-secondary href="{{ route('admin.skills.show', $skill) }}" class="px-3 py-1">
                                            View
                                        </x-admin.button-secondary>
                                        
                                        <x-admin.button-secondary href="{{ route('admin.skills.edit', $skill) }}" class="px-3 py-1">
                                            Edit
                                        </x-admin.button-secondary>
                                        
                                        <form action="{{ route('admin.skills.destroy', $skill) }}" method="POST" class="inline-block" onsubmit="return confirm('Are you sure you want to delete this skill? This action cannot be undone.')">
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
                                        <h3 class="mt-2 text-lg font-medium" @themeColor('text')>No skills found</h3>
                                        <p class="mt-1 text-sm" @themeColor('text-light')>Get started by creating a new skill.</p>
                                    </div>
                                    <x-admin.button-primary href="{{ route('admin.skills.create') }}">
                                        Add Your First Skill
                                    </x-admin.button-primary>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            <div class="mt-6">
                <x-admin-pagination :paginator="$skills" resource-name="skills" />
            </div>
        </x-admin.card>
    </div>
</div>

<script>
    // Simple filter for skills by category
    document.addEventListener('DOMContentLoaded', function() {
        const categoryFilter = document.getElementById('categoryFilter');
        
        categoryFilter.addEventListener('change', function() {
            const selectedCategory = this.value;
            const skillRows = document.querySelectorAll('.skill-row');
            
            skillRows.forEach(row => {
                const category = row.dataset.category || '';
                
                if (!selectedCategory || category === selectedCategory) {
                    row.style.display = '';
                } else {
                    row.style.display = 'none';
                }
            });
        });
    });
</script>
@endsection