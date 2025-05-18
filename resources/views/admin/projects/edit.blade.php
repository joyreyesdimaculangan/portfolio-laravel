@extends('layouts.admin')

@section('title', 'Edit Project')

@section('content')
<div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <x-admin.card>
            <div class="flex justify-between items-center mb-6">
                <h1 class="text-2xl font-semibold" @themeColor('text')>Edit Project</h1>
                <div class="flex space-x-2">
                    <x-admin.button-secondary href="{{ route('admin.projects.index') }}">
                        Back to Projects
                    </x-admin.button-secondary>
                </div>
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

            <!-- MAIN PROJECT UPDATE FORM -->
            <form action="{{ route('admin.projects.update', $project) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                
                <div class="mb-4">
                    <label for="title" class="block text-sm font-bold mb-2" @themeColor('text-light')>Project Title *</label>
                    <input type="text" name="title" id="title" value="{{ old('title', $project->title) }}" class="shadow appearance-none border rounded w-full py-2 px-3 leading-tight focus:outline-none focus:shadow-outline @error('title') border-red-500 @enderror" @themeColor('text') required>
                    @error('title')
                        <p class="text-red-500 text-xs italic mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div class="mb-4">
                    <label for="description" class="block text-sm font-bold mb-2" @themeColor('text-light')>Description *</label>
                    <textarea name="description" id="description" rows="5" class="shadow appearance-none border rounded w-full py-2 px-3 leading-tight focus:outline-none focus:shadow-outline @error('description') border-red-500 @enderror" @themeColor('text') required>{{ old('description', $project->description) }}</textarea>
                    @error('description')
                        <p class="text-red-500 text-xs italic mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div class="mb-4">
                    <label for="technologies" class="block text-sm font-bold mb-2" @themeColor('text-light')>Technologies (comma-separated)</label>
                    <input type="text" name="technologies" id="technologies" value="{{ old('technologies', $project->technologies_string) }}" placeholder="PHP, Laravel, MySQL, Tailwind CSS" class="shadow appearance-none border rounded w-full py-2 px-3 leading-tight focus:outline-none focus:shadow-outline @error('technologies') border-red-500 @enderror" @themeColor('text')>
                    @error('technologies')
                        <p class="text-red-500 text-xs italic mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                    <div>
                        <label for="github_url" class="block text-sm font-bold mb-2" @themeColor('text-light')>GitHub URL</label>
                        <input type="url" name="github_url" id="github_url" value="{{ old('github_url', $project->github_url) }}" placeholder="https://github.com/yourusername/project" class="shadow appearance-none border rounded w-full py-2 px-3 leading-tight focus:outline-none focus:shadow-outline @error('github_url') border-red-500 @enderror" @themeColor('text')>
                        @error('github_url')
                            <p class="text-red-500 text-xs italic mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="demo_url" class="block text-sm font-bold mb-2" @themeColor('text-light')>Demo URL</label>
                        <input type="url" name="demo_url" id="demo_url" value="{{ old('demo_url', $project->demo_url) }}" placeholder="https://example.com" class="shadow appearance-none border rounded w-full py-2 px-3 leading-tight focus:outline-none focus:shadow-outline @error('demo_url') border-red-500 @enderror" @themeColor('text')>
                        @error('demo_url')
                            <p class="text-red-500 text-xs italic mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
                
                <!-- Featured and Sort Order fields -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                    <div>
                        <label for="sort_order" class="block text-sm font-bold mb-2" @themeColor('text-light')>Sort Order</label>
                        <input type="number" name="sort_order" id="sort_order" value="{{ old('sort_order', $project->sort_order) }}" class="shadow appearance-none border rounded w-full py-2 px-3 leading-tight focus:outline-none focus:shadow-outline @error('sort_order') border-red-500 @enderror" @themeColor('text')>
                        @error('sort_order')
                            <p class="text-red-500 text-xs italic mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                    
                    <div class="flex items-center mt-8">
                        <input type="checkbox" name="featured" id="featured" value="1" {{ old('featured', $project->featured) ? 'checked' : '' }} class="rounded border-gray-300" style="color: var(--color-primary, #774C0C); --tw-ring-color: var(--color-primary, #774C0C);">
                        <label for="featured" class="ml-2 block text-sm font-bold" @themeColor('text-light')>Feature this project</label>
                        @error('featured')
                            <p class="text-red-500 text-xs italic mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <div class="mb-6">
                    <label class="block text-sm font-bold mb-2" @themeColor('text-light')>Current Image</label>
                    @if($project->image)
                        <div class="mb-2">
                            <img src="{{ asset('storage/' . $project->image) }}" alt="Current Project Image" class="h-40 w-auto object-contain border rounded p-1">
                        </div>
                    @else
                        <p @themeColor('text-light')>No image currently attached to this project</p>
                    @endif
                    
                    <label for="image" class="block text-sm font-bold mb-2 mt-4" @themeColor('text-light')>{{ $project->image ? 'Replace Image' : 'Add Image' }}</label>
                    <input type="file" name="image" id="image" accept="image/*" onchange="previewImage()" class="border border-gray-300 p-2 w-full rounded-md @error('image') border-red-500 @enderror">
                    <img id="imagePreview" class="hidden mt-2 h-40 w-auto object-contain border rounded p-1" src="#" alt="Image Preview">
                    <p class="text-sm mt-1" @themeColor('text-lighter')>Supported formats: JPEG, PNG, JPG, GIF. Max size: 2MB.</p>
                    @error('image')
                        <p class="text-red-500 text-xs italic mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div class="flex items-center justify-end">
                    <x-admin.button-primary type="submit">
                        Update Project
                    </x-admin.button-primary>
                </div>
            </form>

            <hr class="my-8">

            @if($project->image)
                <div class="mb-8">
                    <form action="{{ route('admin.projects.remove-image', $project) }}" method="POST" class="inline-block" onsubmit="return confirm('Are you sure you want to remove the image?')">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="text-red-600 hover:text-red-900 text-sm">Remove current image</button>
                    </form>
                </div>
            @endif
            
            <div class="flex justify-end">
                <form action="{{ route('admin.projects.destroy', $project) }}" method="POST" class="inline-block" onsubmit="return confirm('Are you sure you want to delete this project? This action cannot be undone.')">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="px-4 py-2 text-white rounded-md" style="background-color: var(--color-danger, #EF4444); hover:opacity-90">
                        Delete Project
                    </button>
                </form>
            </div>
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

