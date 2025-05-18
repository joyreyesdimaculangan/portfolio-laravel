@extends('layouts.admin')

@section('title', 'Personal Information')

@section('content')
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-3xl font-bold text-gray-800">Personal Information</h1>
        <a href="{{ route('admin.personal-info.create') }}" class="px-4 py-2 bg-[#774C0C] text-white rounded hover:bg-amber-700 transition">Add New</a>
    </div>

    <!-- Tabs for different sections -->
    <div class="mb-6 border-b border-gray-200">
        <ul class="flex flex-wrap -mb-px text-sm font-medium text-center">
            <li class="mr-2">
                <button class="section-tab inline-block p-4 border-b-2 border-transparent rounded-t-lg hover:text-gray-600 hover:border-gray-300 active" data-section="home">Home</button>
            </li>
            <li class="mr-2">
                <button class="section-tab inline-block p-4 border-b-2 border-transparent rounded-t-lg hover:text-gray-600 hover:border-gray-300" data-section="about">About</button>
            </li>
            <li class="mr-2">
                <button class="section-tab inline-block p-4 border-b-2 border-transparent rounded-t-lg hover:text-gray-600 hover:border-gray-300" data-section="contact">Contact</button>
            </li>
        </ul>
    </div>

    @foreach($personalInfoBySection as $section => $items)
        <div id="section-{{ $section }}" class="section-content bg-white rounded-lg shadow overflow-hidden" style="{{ $section !== 'home' ? 'display: none;' : '' }}">
            <div class="overflow-x-auto">
                <table class="w-full">
                    <thead class="bg-gray-50 text-left">
                        <tr>
                            <th class="px-6 py-3 text-xs font-medium text-gray-500 uppercase tracking-wider">Key</th>
                            <th class="px-6 py-3 text-xs font-medium text-gray-500 uppercase tracking-wider">Value</th>
                            <th class="px-6 py-3 text-xs font-medium text-gray-500 uppercase tracking-wider">Type</th>
                            <th class="px-6 py-3 text-xs font-medium text-gray-500 uppercase tracking-wider">Public</th>
                            <th class="px-6 py-3 text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200">
                        @foreach($items as $item)
                            <tr>
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">{{ $item->key }}</td>
                                <td class="px-6 py-4 text-sm text-gray-500">
                                    @if($item->type == 'image')
                                        <img src="{{ asset('storage/' . $item->value) }}" class="h-10 w-auto" alt="{{ $item->key }}">
                                    @elseif($item->type == 'file')
                                        <a href="{{ asset('storage/' . $item->value) }}" class="text-[#774C0C] hover:underline" target="_blank">View File</a>
                                    @elseif($item->type == 'html')
                                        <div class="line-clamp-2">{{ strip_tags($item->value) }}</div>
                                    @else
                                        <div class="line-clamp-2">{{ $item->value }}</div>
                                    @endif
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $item->type }}</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                    <span class="px-2 py-1 text-xs rounded-full {{ $item->is_public ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                        {{ $item->is_public ? 'Yes' : 'No' }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium space-x-2">
                                    <a href="{{ route('admin.personal-info.edit', $item->id) }}" class="text-amber-600 hover:text-amber-900">Edit</a>
                                    <form class="inline-block" method="POST" action="{{ route('admin.personal-info.destroy', $item->id) }}" onsubmit="return confirm('Are you sure you want to delete this item?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-red-600 hover:text-red-900">Delete</button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    @endforeach
    
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const tabs = document.querySelectorAll('.section-tab');
            const sections = document.querySelectorAll('.section-content');
            
            tabs.forEach(tab => {
                tab.addEventListener('click', () => {
                    // Remove active class from all tabs
                    tabs.forEach(t => t.classList.remove('active', 'text-[#774C0C]', 'border-[#774C0C]'));
                    
                    // Add active class to current tab
                    tab.classList.add('active', 'text-[#774C0C]', 'border-[#774C0C]');
                    
                    // Hide all sections
                    sections.forEach(s => s.style.display = 'none');
                    
                    // Show selected section
                    const section = tab.dataset.section;
                    document.getElementById(`section-${section}`).style.display = 'block';
                });
            });
        });
    </script>
@endsection