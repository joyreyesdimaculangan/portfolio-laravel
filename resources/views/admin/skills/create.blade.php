@extends('layouts.admin')

@section('title', 'Add New Skill')

@section('content')
<div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <x-admin.card>
            <div class="flex justify-between items-center mb-6">
                <h1 class="text-2xl font-semibold" @themeColor('text')>Add New Skill</h1>
                <x-admin.button-secondary href="{{ route('admin.skills.index') }}">
                    Back to Skills
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

            <form action="{{ route('admin.skills.store') }}" method="POST">
                @csrf
                
                <div class="mb-4">
                    <label for="name" class="block text-sm font-bold mb-2" @themeColor('text-light')>Skill Name *</label>
                    <input type="text" name="name" id="name" value="{{ old('name') }}" class="shadow appearance-none border rounded w-full py-2 px-3 leading-tight focus:outline-none focus:shadow-outline @error('name') border-red-500 @enderror" @themeColor('text') required>
                    @error('name')
                        <p class="text-red-500 text-xs italic mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div class="mb-4">
                    <label for="category" class="block text-sm font-bold mb-2" @themeColor('text-light')>Category</label>
                    <input list="categories" name="category" id="category" value="{{ old('category') }}" placeholder="e.g. Frontend, Backend, Tools" class="shadow appearance-none border rounded w-full py-2 px-3 leading-tight focus:outline-none focus:shadow-outline @error('category') border-red-500 @enderror" @themeColor('text')>
                    <datalist id="categories">
                        @foreach($categories as $category)
                            <option value="{{ $category }}">
                        @endforeach
                    </datalist>
                    @error('category')
                        <p class="text-red-500 text-xs italic mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div class="mb-4">
                    <label for="proficiency" class="block text-sm font-bold mb-2" @themeColor('text-light')>Proficiency (0-100) *</label>
                    <div class="flex items-center">
                        <input type="range" name="proficiency" id="proficiency" value="{{ old('proficiency', 75) }}" min="0" max="100" step="1" class="w-full mr-4 @error('proficiency') border-red-500 @enderror" style="accent-color: var(--color-primary, #774C0C);" oninput="updateProficiencyValue(this.value)">
                        <input type="number" id="proficiencyValue" value="{{ old('proficiency', 75) }}" min="0" max="100" class="w-16 shadow appearance-none border rounded py-2 px-3 leading-tight focus:outline-none focus:shadow-outline" @themeColor('text') readonly>
                    </div>
                    @error('proficiency')
                        <p class="text-red-500 text-xs italic mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div class="mb-6">
                    <label for="sort_order" class="block text-sm font-bold mb-2" @themeColor('text-light')>Display Order</label>
                    <input type="number" name="sort_order" id="sort_order" value="{{ old('sort_order') }}" placeholder="Leave blank for automatic ordering" class="shadow appearance-none border rounded w-full py-2 px-3 leading-tight focus:outline-none focus:shadow-outline @error('sort_order') border-red-500 @enderror" @themeColor('text')>
                    <span class="text-sm" @themeColor('text-lighter')>Lower numbers appear first. Leave empty to automatically place at the end.</span>
                    @error('sort_order')
                        <p class="text-red-500 text-xs italic mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div class="flex items-center justify-end">
                    <x-admin.button-primary type="submit">
                        Add Skill
                    </x-admin.button-primary>
                </div>
            </form>
        </x-admin.card>
    </div>
</div>

<script>
    function updateProficiencyValue(value) {
        document.getElementById('proficiencyValue').value = value;
    }
</script>
@endsection