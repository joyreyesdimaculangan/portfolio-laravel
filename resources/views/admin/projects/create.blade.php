@extends('layouts.admin')

@section('title', 'Add New Project')

@section('content')
<div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <x-admin.card>
            <div class="flex justify-between items-center mb-6">
                <h1 class="text-2xl font-semibold" @themeColor('text')>Add New Project</h1>
                <x-admin.button-secondary href="{{ route('admin.projects.index') }}">
                    Back to Projects
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

            <form action="{{ route('admin.projects.store') }}" method="POST" enctype="multipart/form-data">
                @csrf

                <div class="mb-4">
                    <label for="title" class="block text-sm font-bold mb-2" @themeColor('text-light')>Project Title *</label>
                    <input type="text" name="title" id="title" value="{{ old('title') }}" class="shadow appearance-none border rounded w-full py-2 px-3 leading-tight focus:outline-none focus:shadow-outline @error('title') border-red-500 @enderror" @themeColor('text') required>
                    @error('title')
                        <p class="text-red-500 text-xs italic mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div class="mb-4">
                    <label for="description" class="block text-sm font-bold mb-2" @themeColor('text-light')>Description *</label>
                    <textarea name="description" id="description" rows="5" class="shadow appearance-none border rounded w-full py-2 px-3 leading-tight focus:outline-none focus:shadow-outline @error('description') border-red-500 @enderror" @themeColor('text') required>{{ old('description') }}</textarea>
                    @error('description')
                        <p class="text-red-500 text-xs italic mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div class="mb-4">
                    <label for="technologies" class="block text-sm font-bold mb-2" @themeColor('text-light')>Technologies (comma-separated)</label>
                    <input type="text" name="technologies" id="technologies" value="{{ old('technologies') }}" placeholder="PHP, Laravel, MySQL, Tailwind CSS" class="shadow appearance-none border rounded w-full py-2 px-3 leading-tight focus:outline-none focus:shadow-outline @error('technologies') border-red-500 @enderror" @themeColor('text')>
                    @error('technologies')
                        <p class="text-red-500 text-xs italic mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                    <div>
                        <label for="github_url" class="block text-sm font-bold mb-2" @themeColor('text-light')>GitHub URL</label>
                        <input type="url" name="github_url" id="github_url" value="{{ old('github_url') }}" placeholder="https://github.com/yourusername/project" class="shadow appearance-none border rounded w-full py-2 px-3 leading-tight focus:outline-none focus:shadow-outline @error('github_url') border-red-500 @enderror" @themeColor('text')>
                        @error('github_url')
                            <p class="text-red-500 text-xs italic mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="demo_url" class="block text-sm font-bold mb-2" @themeColor('text-light')>Demo URL</label>
                        <input type="url" name="demo_url" id="demo_url" value="{{ old('demo_url') }}" placeholder="https://example.com" class="shadow appearance-none border rounded w-full py-2 px-3 leading-tight focus:outline-none focus:shadow-outline @error('demo_url') border-red-500 @enderror" @themeColor('text')>
                        @error('demo_url')
                            <p class="text-red-500 text-xs italic mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <div class="mb-6">
                    <label for="image" class="block text-sm font-bold mb-2" @themeColor('text-light')>Project Image *</label>
                    <input type="file" name="image" id="image" accept="image/*" onchange="previewImage()" class="border border-gray-300 p-2 w-full rounded-md @error('image') border-red-500 @enderror" required>
                    <img id="imagePreview" class="hidden mt-2 h-40 w-auto object-contain border rounded p-1" src="#" alt="Image Preview">
                    <p class="text-sm mt-1" @themeColor('text-lighter')>Supported formats: JPEG, PNG, JPG, GIF. Max size: 2MB.</p>
                    @error('image')
                        <p class="text-red-500 text-xs italic mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div class="flex items-center justify-end">
                    <x-admin.button-primary type="submit">
                        Create Project
                    </x-admin.button-primary>
                </div>
            </form>
        </x-admin.card>
    </div>
</div>

<script>
    function previewImage() {
        const file = document.getElementById("image").files[0];
        const preview = document.getElementById("imagePreview");
        
        if (file) {
            const reader = new FileReader();
            reader.onload = function(e) {
                preview.src = e.target.result;
                preview.classList.remove("hidden");
            };
            reader.readAsDataURL(file);
        }
    }
</script>
@endsection