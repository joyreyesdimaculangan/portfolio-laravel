@extends('layouts.admin')

@section('title', 'Add New Experience')

@section('content')
<div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <x-admin.card>
            <div class="flex justify-between items-center mb-6">
                <h1 class="text-2xl font-semibold" @themeColor('text')>Add New Experience</h1>
                <x-admin.button-secondary href="{{ route('admin.experiences.index') }}">
                    Back to Work Experiences
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

            <form action="{{ route('admin.experiences.store') }}" method="POST">
                @csrf
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                    <div>
                        <label for="title" class="block text-sm font-bold mb-2" @themeColor('text-light')>Job Title *</label>
                        <input type="text" name="title" id="title" value="{{ old('title') }}" class="shadow appearance-none border rounded w-full py-2 px-3 leading-tight focus:outline-none focus:shadow-outline @error('title') border-red-500 @enderror" @themeColor('text') required>
                        @error('title')
                            <p class="text-red-500 text-xs italic mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="company" class="block text-sm font-bold mb-2" @themeColor('text-light')>Company *</label>
                        <input type="text" name="company" id="company" value="{{ old('company') }}" class="shadow appearance-none border rounded w-full py-2 px-3 leading-tight focus:outline-none focus:shadow-outline @error('company') border-red-500 @enderror" @themeColor('text') required>
                        @error('company')
                            <p class="text-red-500 text-xs italic mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <div class="mb-6">
                    <label for="location" class="block text-sm font-bold mb-2" @themeColor('text-light')>Location</label>
                    <input type="text" name="location" id="location" value="{{ old('location') }}" class="shadow appearance-none border rounded w-full py-2 px-3 leading-tight focus:outline-none focus:shadow-outline @error('location') border-red-500 @enderror" @themeColor('text')>
                    @error('location')
                        <p class="text-red-500 text-xs italic mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                    <div>
                        <label for="start_date" class="block text-sm font-bold mb-2" @themeColor('text-light')>Start Date *</label>
                        <input type="date" name="start_date" id="start_date" value="{{ old('start_date') }}" class="shadow appearance-none border rounded w-full py-2 px-3 leading-tight focus:outline-none focus:shadow-outline @error('start_date') border-red-500 @enderror" @themeColor('text') required>
                        @error('start_date')
                            <p class="text-red-500 text-xs italic mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="end_date" class="block text-sm font-bold mb-2" @themeColor('text-light')>End Date</label>
                        <input type="date" name="end_date" id="end_date" value="{{ old('end_date') }}" class="shadow appearance-none border rounded w-full py-2 px-3 leading-tight focus:outline-none focus:shadow-outline @error('end_date') border-red-500 @enderror" @themeColor('text') {{ old('ongoing') ? 'disabled' : '' }}>
                        @error('end_date')
                            <p class="text-red-500 text-xs italic mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <div class="mb-6">
                    <label class="inline-flex items-center">
                        <input type="checkbox" name="ongoing" id="ongoing" value="1" {{ old('ongoing') ? 'checked' : '' }} class="rounded border-gray-300" style="color: var(--color-primary, #774C0C); --tw-ring-color: var(--color-primary, #774C0C);" onchange="toggleEndDate(this)">
                        <span class="ml-2 text-sm font-medium" @themeColor('text-light')>I currently work here</span>
                    </label>
                </div>
                
                <div class="mb-6">
                    <label for="description" class="block text-sm font-bold mb-2" @themeColor('text-light')>Description</label>
                    <textarea name="description" id="description" rows="4" class="shadow appearance-none border rounded w-full py-2 px-3 leading-tight focus:outline-none focus:shadow-outline @error('description') border-red-500 @enderror" @themeColor('text')>{{ old('description') }}</textarea>
                    <p class="text-xs mt-1" @themeColor('text-lighter')>Provide a short description of your role and responsibilities.</p>
                    @error('description')
                        <p class="text-red-500 text-xs italic mt-1">{{ $message }}</p>
                    @enderror
                </div>
                
                <div class="mb-6">
                    <label for="achievements" class="block text-sm font-bold mb-2" @themeColor('text-light')>Key Achievements</label>
                    <textarea name="achievements" id="achievements" rows="5" class="shadow appearance-none border rounded w-full py-2 px-3 leading-tight focus:outline-none focus:shadow-outline @error('achievements') border-red-500 @enderror" @themeColor('text')>{{ old('achievements') }}</textarea>
                    <p class="text-xs mt-1" @themeColor('text-lighter')>Each line will be displayed as a separate achievement bullet point.</p>
                    @error('achievements')
                        <p class="text-red-500 text-xs italic mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div class="flex items-center justify-end">
                    <x-admin.button-primary type="submit">
                        Add Experience
                    </x-admin.button-primary>
                </div>
            </form>
        </x-admin.card>
    </div>
</div>

<script>
    function toggleEndDate(checkbox) {
        const endDateField = document.getElementById('end_date');
        
        if (checkbox.checked) {
            endDateField.disabled = true;
            endDateField.value = '';
        } else {
            endDateField.disabled = false;
        }
    }
</script>
@endsection