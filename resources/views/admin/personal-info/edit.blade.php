@extends('layouts.admin')

@section('title', 'Edit Personal Info')

@section('content')
<div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <x-admin.card>
            <div class="flex justify-between items-center mb-6">
                <h1 class="text-2xl font-semibold" @themeColor('text')>Edit Personal Information</h1>
                <x-admin.button-secondary href="{{ route('admin.personal-info.index') }}">
                    Back to Personal Information
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

            <form action="{{ route('admin.personal-info.update', $personalInfo) }}" method="POST" enctype="multipart/form-data" novalidate>
                @csrf
                @method('PUT')
                <input type="hidden" name="original_key" value="{{ $personalInfo->key }}">
                <input type="hidden" name="is_file_type" id="is_file_type" value="{{ in_array(old('type', $personalInfo->type), ['image', 'file']) ? '1' : '0' }}">
                
                <div class="mb-4">
                    <label for="key" class="block text-sm font-bold mb-2" @themeColor('text-light')>Key Identifier *</label>
                    <select name="key" id="key" class="shadow appearance-none border rounded w-full py-2 px-3 leading-tight focus:outline-none focus:shadow-outline" @themeColor('text') required>
                        <optgroup label="Personal Information">
                            <option value="name" {{ old('key', $personalInfo->key) == 'name' ? 'selected' : '' }}>Name</option>
                            <option value="role" {{ old('key', $personalInfo->key) == 'role' ? 'selected' : '' }}>Role/Position</option>
                            <option value="profile_image" {{ old('key', $personalInfo->key) == 'profile_image' ? 'selected' : '' }}>Profile Image</option>
                            <option value="tagline" {{ old('key', $personalInfo->key) == 'tagline' ? 'selected' : '' }}>Tagline</option>
                            <option value="description" {{ old('key', $personalInfo->key) == 'description' ? 'selected' : '' }}>Description</option>
                            <option value="about_me" {{ old('key', $personalInfo->key) == 'about_me' ? 'selected' : '' }}>About Me (Long)</option>
                            <option value="journey" {{ old('key', $personalInfo->key) == 'journey' ? 'selected' : '' }}>Journey/Bio</option>
                        </optgroup>
                        <optgroup label="Contact Information">
                            <option value="email" {{ old('key', $personalInfo->key) == 'email' ? 'selected' : '' }}>Email Address</option>
                            <option value="phone" {{ old('key', $personalInfo->key) == 'phone' ? 'selected' : '' }}>Phone Number</option>
                            <option value="location" {{ old('key', $personalInfo->key) == 'location' ? 'selected' : '' }}>Location</option>
                            <option value="address" {{ old('key', $personalInfo->key) == 'address' ? 'selected' : '' }}>Full Address</option>
                            <option value="availability" {{ old('key', $personalInfo->key) == 'availability' ? 'selected' : '' }}>Availability</option>
                        </optgroup>
                        <optgroup label="Social Media">
                            <option value="linkedin" {{ old('key', $personalInfo->key) == 'linkedin' ? 'selected' : '' }}>LinkedIn URL</option>
                            <option value="github" {{ old('key', $personalInfo->key) == 'github' ? 'selected' : '' }}>GitHub URL</option>
                            <option value="twitter" {{ old('key', $personalInfo->key) == 'twitter' ? 'selected' : '' }}>Twitter URL</option>
                            <option value="instagram" {{ old('key', $personalInfo->key) == 'instagram' ? 'selected' : '' }}>Instagram URL</option>
                            <option value="facebook" {{ old('key', $personalInfo->key) == 'facebook' ? 'selected' : '' }}>Facebook URL</option>
                            <option value="youtube" {{ old('key', $personalInfo->key) == 'youtube' ? 'selected' : '' }}>YouTube URL</option>
                        </optgroup>
                        <optgroup label="Professional">
                            <option value="resume_url" {{ old('key', $personalInfo->key) == 'resume_url' ? 'selected' : '' }}>Resume URL</option>
                            <option value="resume_summary" {{ old('key', $personalInfo->key) == 'resume_summary' ? 'selected' : '' }}>Resume Summary</option>
                            <option value="objective" {{ old('key', $personalInfo->key) == 'objective' ? 'selected' : '' }}>Career Objective</option>
                            <option value="skills_summary" {{ old('key', $personalInfo->key) == 'skills_summary' ? 'selected' : '' }}>Skills Summary</option>
                        </optgroup>
                        <optgroup label="Website Elements">
                            <option value="contact_form_text" {{ old('key', $personalInfo->key) == 'contact_form_text' ? 'selected' : '' }}>Contact Form Text</option>
                            <option value="office_hours" {{ old('key', $personalInfo->key) == 'office_hours' ? 'selected' : '' }}>Office Hours</option>
                            <option value="meta_description" {{ old('key', $personalInfo->key) == 'meta_description' ? 'selected' : '' }}>Meta Description</option>
                            <option value="meta_keywords" {{ old('key', $personalInfo->key) == 'meta_keywords' ? 'selected' : '' }}>Meta Keywords</option>
                        </optgroup>
                        <optgroup label="Other">
                            <option value="custom" {{ old('key', $personalInfo->key) == 'custom' || !in_array(old('key', $personalInfo->key), [
                                'name', 'role', 'profile_image', 'tagline', 'description', 'about_me', 'journey', 
                                'email', 'phone', 'location', 'address', 'availability',
                                'linkedin', 'github', 'twitter', 'instagram', 'facebook', 'youtube',
                                'resume_url', 'resume_summary', 'objective', 'skills_summary',
                                'contact_form_text', 'office_hours', 'meta_description', 'meta_keywords'
                            ]) ? 'selected' : '' }}>Custom Key...</option>
                        </optgroup>
                    </select>
                    <p class="text-sm mt-1" @themeColor('text-lighter')>
                        Select the key for this information
                    </p>
                </div>

                <div id="custom_key_container" class="mb-4 {{ 
                    old('key', $personalInfo->key) == 'custom' || 
                    !in_array(old('key', $personalInfo->key), [
                        'name', 'role', 'profile_image', 'tagline', 'description', 'about_me', 'journey', 
                        'email', 'phone', 'location', 'address', 'availability',
                        'linkedin', 'github', 'twitter', 'instagram', 'facebook', 'youtube',
                        'resume_url', 'resume_summary', 'objective', 'skills_summary',
                        'contact_form_text', 'office_hours', 'meta_description', 'meta_keywords'
                    ]) ? '' : 'hidden' }}">
                    <label for="custom_key" class="block text-sm font-bold mb-2" @themeColor('text-light')>Custom Key Name *</label>
                    <input type="text" name="custom_key" id="custom_key" value="{{ 
                        old('custom_key', 
                        (!in_array($personalInfo->key, [
                            'name', 'role', 'profile_image', 'tagline', 'description', 'about_me', 'journey', 
                            'email', 'phone', 'location', 'address', 'availability',
                            'linkedin', 'github', 'twitter', 'instagram', 'facebook', 'youtube',
                            'resume_url', 'resume_summary', 'objective', 'skills_summary',
                            'contact_form_text', 'office_hours', 'meta_description', 'meta_keywords'
                        ]) ? $personalInfo->key : '')) 
                    }}" class="shadow appearance-none border rounded w-full py-2 px-3 leading-tight focus:outline-none focus:shadow-outline" @themeColor('text')>
                    <p class="text-sm mt-1" @themeColor('text-lighter')>Enter a unique identifier for this custom information</p>
                </div>

                <div class="mb-4">
                    <label for="section" class="block text-sm font-bold mb-2" @themeColor('text-light')>Section *</label>
                    <select name="section" id="section" class="shadow appearance-none border rounded w-full py-2 px-3 leading-tight focus:outline-none focus:shadow-outline" @themeColor('text') required>
                        <option value="">-- Select Section --</option>
                        <option value="Home" {{ old('section', $personalInfo->section) == 'Home' ? 'selected' : '' }}>Home</option>
                        <option value="About" {{ old('section', $personalInfo->section) == 'About' ? 'selected' : '' }}>About</option>
                        <option value="Contact" {{ old('section', $personalInfo->section) == 'Contact' ? 'selected' : '' }}>Contact</option>
                        <option value="Social" {{ old('section', $personalInfo->section) == 'Social' ? 'selected' : '' }}>Social Media</option>
                        <option value="Resume" {{ old('section', $personalInfo->section) == 'Resume' ? 'selected' : '' }}>Resume</option>
                        <option value="Other" {{ old('section', $personalInfo->section) == 'Other' ? 'selected' : '' }}>Other</option>
                    </select>
                    <p class="text-sm mt-1" @themeColor('text-lighter')>
                        The section is for organization only. Keys like "name" will be available in all sections.
                    </p>
                </div>

                <div class="mb-4">
                    <label for="type" class="block text-sm font-bold mb-2" @themeColor('text-light')>Value Type *</label>
                    <select name="type" id="type" class="shadow border rounded w-full py-2 px-3 leading-tight focus:outline-none focus:shadow-outline" @themeColor('text') required onchange="toggleValueInput()">
                        <option value="text" {{ old('type', $personalInfo->type) == 'text' ? 'selected' : '' }}>Short Text</option>
                        <option value="textarea" {{ old('type', $personalInfo->type) == 'textarea' ? 'selected' : '' }}>Long Text</option>
                        <option value="html" {{ old('type', $personalInfo->type) == 'html' ? 'selected' : '' }}>HTML Content</option>
                        <option value="url" {{ old('type', $personalInfo->type) == 'url' ? 'selected' : '' }}>URL/Link</option>
                        <option value="email" {{ old('type', $personalInfo->type) == 'email' ? 'selected' : '' }}>Email Address</option>
                        <option value="phone" {{ old('type', $personalInfo->type) == 'phone' ? 'selected' : '' }}>Phone Number</option>
                        <option value="image" {{ old('type', $personalInfo->type) == 'image' ? 'selected' : '' }}>Image Upload</option>
                        <option value="file" {{ old('type', $personalInfo->type) == 'file' ? 'selected' : '' }}>File Upload</option>
                    </select>
                </div>

                <!-- Current value display for files/images -->
                @if(in_array($personalInfo->type, ['image', 'file']))
                    <div class="mb-4 p-4 bg-gray-50 rounded">
                        <h3 class="font-medium mb-2" @themeColor('text')>Current {{ ucfirst($personalInfo->type) }}:</h3>
                        @if($personalInfo->type == 'image')
                            <div class="mb-2">
                                <img src="{{ asset($personalInfo->value) }}" alt="{{ $personalInfo->key }}" class="max-w-xs h-auto">
                            </div>
                        @else
                            <div class="mb-2">
                                <a href="{{ asset($personalInfo->value) }}" target="_blank" style="color: var(--color-primary, #774C0C);" class="hover:underline">
                                    View Current File
                                </a>
                            </div>
                        @endif
                        <p class="text-sm" @themeColor('text-lighter')>Upload a new file below to replace the current one</p>
                    </div>
                @endif

                <div id="value_container" class="mb-4 {{ in_array(old('type', $personalInfo->type), ['image', 'file']) ? 'hidden' : '' }}">
                    <label for="value" class="block text-sm font-bold mb-2" @themeColor('text-light')>Value *</label>
                    <textarea name="value" id="value" rows="4" class="shadow appearance-none border rounded w-full py-2 px-3 leading-tight focus:outline-none focus:shadow-outline" @themeColor('text')>{{ old('value', $personalInfo->value) }}</textarea>
                    <p id="html_help" class="text-sm mt-1 {{ old('type', $personalInfo->type) === 'html' ? '' : 'hidden' }}" @themeColor('text-lighter')>
                        You can use HTML tags for formatting.
                    </p>
                </div>

                <div id="file_container" class="mb-4 {{ in_array(old('type', $personalInfo->type), ['image', 'file']) ? '' : 'hidden' }}">
                    <label for="file_upload" class="block text-sm font-bold mb-2" @themeColor('text-light')>File/Image Upload</label>
                    <input type="file" name="file_upload" id="file_upload" class="shadow appearance-none border rounded w-full py-2 px-3 leading-tight focus:outline-none focus:shadow-outline" @themeColor('text')>
                    <p class="text-sm mt-1" @themeColor('text-lighter')>Leave empty to keep the current file</p>
                </div>

                <div class="mb-6">
                    <input type="hidden" name="is_public" value="0">
                    
                    <label class="flex items-center cursor-pointer">
                        <input type="checkbox" name="is_public" value="1" class="rounded border-gray-300 focus:ring focus:ring-offset-0 focus:ring-opacity-50" 
                            style="color: var(--color-primary, #774C0C); --tw-ring-color: var(--color-primary, #774C0C);" 
                            {{ old('is_public', $personalInfo->is_public) ? 'checked' : '' }}>
                        <span class="ml-2 text-sm font-bold" @themeColor('text-light')>Public Information</span>
                    </label>
                    <p class="text-sm mt-1" @themeColor('text-lighter')>Check if this information should be visible to website visitors</p>
                </div>

                <div class="flex items-center justify-end">
                    <x-admin.button-primary type="submit">
                        Update Information
                    </x-admin.button-primary>
                </div>
            </form>

            <hr class="my-8">

            <div class="flex justify-end">
                <form action="{{ route('admin.personal-info.destroy', $personalInfo) }}" method="POST" class="inline-block" onsubmit="return confirm('Are you sure you want to delete this information? This action cannot be undone.')">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="px-4 py-2 rounded-md text-white" style="background-color: var(--color-danger, #EF4444); transition-duration: var(--transition-speed);">
                        Delete Information
                    </button>
                </form>
            </div>
        </x-admin.card>
    </div>
</div>

<script>
    function toggleValueInput() {
        const type = document.getElementById('type').value;
        const valueContainer = document.getElementById('value_container');
        const fileContainer = document.getElementById('file_container');
        const fileUpload = document.getElementById('file_upload');
        const isFileTypeField = document.getElementById('is_file_type');
        
        // Determine if this is a file type
        const isFileType = (type === 'image' || type === 'file');
        
        // Update the hidden field value
        isFileTypeField.value = isFileType ? '1' : '0';
        
        console.log('[toggleValueInput] Type:', type, 'Is File Type:', isFileType);
        
        if (isFileType) {
            // For file types
            valueContainer.classList.add('hidden');
            fileContainer.classList.remove('hidden');
            
            // Remove name attribute from text value to prevent conflicts
            const valueField = document.getElementById('value');
            if (valueField) {
                valueField.removeAttribute('required');
            }
            
            // Add a hidden input with a placeholder value for validation bypass
            let placeholderInput = document.getElementById('value_placeholder');
            if (!placeholderInput) {
                placeholderInput = document.createElement('input');
                placeholderInput.type = 'hidden';
                placeholderInput.name = 'value';
                placeholderInput.id = 'value_placeholder';
                placeholderInput.value = 'file_upload_placeholder';
                document.querySelector('form').appendChild(placeholderInput);
            }
            
            // Show appropriate help text
            document.querySelectorAll('.file-help').forEach(el => {
                el.classList.add('hidden');
            });
            
            if (type === 'image') {
                document.getElementById('image_help')?.classList.remove('hidden');
            } else {
                document.getElementById('file_help')?.classList.remove('hidden');
            }
            
            // When editing, file upload is optional
            fileUpload.removeAttribute('required');
        } else {
            // For non-file types
            valueContainer.classList.remove('hidden');
            fileContainer.classList.add('hidden');
            
            // Remove placeholder if it exists
            const placeholder = document.getElementById('value_placeholder');
            if (placeholder) placeholder.remove();
            
            // Remove file upload name and required attributes
            if (fileUpload) {
                fileUpload.removeAttribute('name');
                fileUpload.removeAttribute('required');
                fileUpload.value = ''; // Clear any selected file
            }
            
            // Restore required attribute to value field
            const valueField = document.getElementById('value');
            if (valueField) {
                valueField.setAttribute('name', 'value');
                valueField.setAttribute('required', 'required');
            }
            
            // Show/hide HTML help text
            document.getElementById('html_help')?.classList.toggle('hidden', type !== 'html');
            
            // Adjust input placeholder based on the selected type
            if (valueField) {
                switch(type) {
                    case 'url':
                        valueField.setAttribute('placeholder', 'https://example.com');
                        break;
                    case 'email':
                        valueField.setAttribute('placeholder', 'example@email.com');
                        break;
                    case 'phone':
                        valueField.setAttribute('placeholder', '123-456-7890');
                        break;
                    default:
                        valueField.removeAttribute('placeholder');
                }
            }
        }
    }
    
    // Handle custom key container visibility
    function toggleCustomKeyContainer() {
        const keySelect = document.getElementById('key');
        const customKeyContainer = document.getElementById('custom_key_container');
        const customKeyInput = document.getElementById('custom_key');
        
        const standardKeys = [
            'name', 'role', 'profile_image', 'tagline', 'description', 'about_me', 'journey', 
            'email', 'phone', 'location', 'address', 'availability',
            'linkedin', 'github', 'twitter', 'instagram', 'facebook', 'youtube',
            'resume_url', 'resume_summary', 'objective', 'skills_summary',
            'contact_form_text', 'office_hours', 'meta_description', 'meta_keywords'
        ];
        
        if (keySelect.value === 'custom' || !standardKeys.includes(keySelect.value)) {
            customKeyContainer.classList.remove('hidden');
            customKeyInput.setAttribute('required', 'required');
        } else {
            customKeyContainer.classList.add('hidden');
            customKeyInput.removeAttribute('required');
        }
    }
    
    // Run on page load
    document.addEventListener('DOMContentLoaded', function() {
        // Initialize the form state
        toggleValueInput();
        toggleCustomKeyContainer();
        
        // Set up event listeners
        document.getElementById('type').addEventListener('change', toggleValueInput);
        document.getElementById('key').addEventListener('change', toggleCustomKeyContainer);
        
        // Fix for form submission with file types
        document.querySelector('form').addEventListener('submit', function(e) {
            const type = document.getElementById('type').value;
            const isFileType = (type === 'image' || type === 'file');
            
            console.log('Form submission - Type:', type, 'Is file type:', isFileType);
            
            if (isFileType) {
                // For file types
                // Add a hidden placeholder value if needed
                let placeholderInput = document.getElementById('value_placeholder');
                if (!placeholderInput) {
                    placeholderInput = document.createElement('input');
                    placeholderInput.type = 'hidden';
                    placeholderInput.name = 'value';
                    placeholderInput.id = 'value_placeholder';
                    placeholderInput.value = 'file_upload_placeholder';
                    this.appendChild(placeholderInput);
                }
                
                // Remove name attribute and required from text value to prevent conflicts
                const valueField = document.getElementById('value');
                if (valueField) {
                    valueField.removeAttribute('required');
                }
                
                // When editing, file upload is optional
                const fileUpload = document.getElementById('file_upload');
                fileUpload.removeAttribute('required');
            } else {
                // For non-file types
                // Remove the file_upload name attribute
                const fileUpload = document.getElementById('file_upload');
                if (fileUpload) {
                    fileUpload.removeAttribute('name');
                    fileUpload.removeAttribute('required');
                }
                
                // Remove any placeholder
                const placeholder = document.getElementById('value_placeholder');
                if (placeholder) placeholder.remove();
                
                // Restore value field name and required
                const valueField = document.getElementById('value');
                if (valueField) {
                    valueField.setAttribute('name', 'value');
                    valueField.setAttribute('required', 'required');
                }
            }
        });

        document.querySelectorAll('label.flex.items-center').forEach(label => {
        label.addEventListener('click', function(e) {
            if (e.target.tagName !== 'INPUT') {
                const checkbox = this.querySelector('input[type="checkbox"]');
                if (checkbox) {
                    checkbox.checked = !checkbox.checked;
                    // Trigger a change event to ensure any listeners respond
                    checkbox.dispatchEvent(new Event('change'));
                }
            }
        });
    });
});
</script>
@endsection