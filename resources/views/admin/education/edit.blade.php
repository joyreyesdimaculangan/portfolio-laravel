@extends('layouts.admin')

@section('title', 'Education')

@section('content')
<div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
            <div class="p-6 bg-white border-b border-gray-200">
                <div class="flex justify-between items-center mb-6">
                    <h1 class="text-2xl font-semibold" @themeColor('text')>Edit Education</h1>
                    <x-admin.button-secondary href="{{ route('admin.education.index') }}">
                        Back to Education
                    </x-admin.button-secondary>
                </div>

                @if(session('success'))
                    <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
                        {{ session('success') }}
                    </div>
                @endif

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

                <form action="{{ route('admin.education.update', $education) }}" method="POST">
                    @csrf
                    @method('PUT')
                    
                    <div class="mb-4">
                        <label for="institution" class="block text-sm font-bold mb-2" @themeColor('text-light')>Institution *</label>
                        <input type="text" name="institution" id="institution" value="{{ old('institution', $education->institution) }}" class="shadow appearance-none border rounded w-full py-2 px-3 leading-tight focus:outline-none focus:shadow-outline @error('institution') border-red-500 @enderror" @themeColor('text') required>
                        @error('institution')
                            <p class="text-red-500 text-xs italic mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                    
                    <div class="mb-4">
                        <label for="degree" class="block text-sm font-bold mb-2" @themeColor('text-light')>Degree *</label>
                        <input type="text" name="degree" id="degree" value="{{ old('degree', $education->degree) }}" class="shadow appearance-none border rounded w-full py-2 px-3 leading-tight focus:outline-none focus:shadow-outline @error('degree') border-red-500 @enderror" @themeColor('text') required>
                        @error('degree')
                            <p class="text-red-500 text-xs italic mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                    
                    <div class="mb-4">
                        <label for="field_of_study" class="block text-sm font-bold mb-2" @themeColor('text-light')>Field of Study</label>
                        <input type="text" name="field_of_study" id="field_of_study" value="{{ old('field_of_study', $education->field_of_study) }}" class="shadow appearance-none border rounded w-full py-2 px-3 leading-tight focus:outline-none focus:shadow-outline @error('field_of_study') border-red-500 @enderror" @themeColor('text')>
                        @error('field_of_study')
                            <p class="text-red-500 text-xs italic mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                        <div>
                            <label for="start_date" class="block text-sm font-bold mb-2" @themeColor('text-light')>Start Date *</label>
                            <input type="date" name="start_date" id="start_date" value="{{ old('start_date', $education->start_date->format('Y-m-d')) }}" class="shadow appearance-none border rounded w-full py-2 px-3 leading-tight focus:outline-none focus:shadow-outline @error('start_date') border-red-500 @enderror" @themeColor('text') required>
                            @error('start_date')
                                <p class="text-red-500 text-xs italic mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                        
                        <div>
                            <label for="end_date" class="block text-sm font-bold mb-2" @themeColor('text-light')>End Date</label>
                            <input type="date" name="end_date" id="end_date" value="{{ old('end_date', $education->end_date ? $education->end_date->format('Y-m-d') : '') }}" class="shadow appearance-none border rounded w-full py-2 px-3 leading-tight focus:outline-none focus:shadow-outline @error('end_date') border-red-500 @enderror" @themeColor('text') {{ old('ongoing', $education->ongoing) ? 'disabled' : '' }}>
                            @error('end_date')
                                <p class="text-red-500 text-xs italic mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                    
                    <div class="mb-4">
                        <label class="inline-flex items-center">
                            <input type="checkbox" name="ongoing" id="ongoing" value="1" {{ old('ongoing', $education->ongoing) ? 'checked' : '' }} class="rounded border-gray-300" style="color: var(--color-primary, #774C0C); --tw-ring-color: var(--color-primary, #774C0C);" onchange="toggleEndDate(this.checked)">
                            <span class="ml-2 text-sm font-medium" @themeColor('text-light')>Currently studying here</span>
                        </label>
                    </div>
                    
                    <div class="mb-4">
                        <label for="location" class="block text-sm font-bold mb-2" @themeColor('text-light')>Location</label>
                        <input type="text" name="location" id="location" value="{{ old('location', $education->location) }}" class="shadow appearance-none border rounded w-full py-2 px-3 leading-tight focus:outline-none focus:shadow-outline @error('location') border-red-500 @enderror" @themeColor('text')>
                        @error('location')
                            <p class="text-red-500 text-xs italic mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                    
                    <div class="mb-4">
                        <label for="description" class="block text-sm font-bold mb-2" @themeColor('text-light')>Description</label>
                        <textarea name="description" id="description" rows="4" class="shadow appearance-none border rounded w-full py-2 px-3 leading-tight focus:outline-none focus:shadow-outline @error('description') border-red-500 @enderror" @themeColor('text')>{{ old('description', $education->description) }}</textarea>
                        @error('description')
                            <p class="text-red-500 text-xs italic mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="flex items-center justify-end">
                        <button type="submit" class="px-4 py-2 text-white rounded-md" style="background-color: var(--color-primary, #774C0C); transition-duration: var(--transition-speed);">
                            Update Education
                        </button>
                    </div>
                </form>

                <hr class="my-8">

                <div class="flex justify-end">
                    <form action="{{ route('admin.education.destroy', $education) }}" method="POST" class="inline-block" onsubmit="return confirm('Are you sure you want to delete this education record? This action cannot be undone.')">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="px-4 py-2 text-white rounded-md" style="background-color: var(--color-danger, #EF4444); transition-duration: var(--transition-speed);">
                            Delete Education
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    function toggleEndDate(isOngoing) {
        const endDateField = document.getElementById('end_date');
        
        if (isOngoing) {
            endDateField.value = '';
            endDateField.disabled = true;
        } else {
            endDateField.disabled = false;
        }
    }
    
    // Initialize on page load
    document.addEventListener('DOMContentLoaded', function() {
        toggleEndDate(document.getElementById('ongoing').checked);
    });
</script>
@endsection