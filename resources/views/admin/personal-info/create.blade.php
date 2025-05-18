@extends('layouts.admin')

@section('title', 'Add Personal Information')

@section('content')
<div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <x-admin.card>
            <div class="flex justify-between items-center mb-6">
                <h1 class="text-2xl font-semibold" @themeColor('text')>Add Personal Information</h1>
                <x-admin.button-secondary href="{{ route('admin.personal-info.index') }}">
                    Back to Information
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

            <form action="{{ route('admin.personal-info.store') }}" method="POST" enctype="multipart/form-data" novalidate>
                @csrf
                @method('POST')
                <input type="hidden" id="is_file_type" name="is_file_type" value="{{ in_array(old('type', 'text'), ['image', 'file']) ? '1' : '0' }}">
                <div class="mb-4">
                    <label for="key" class="block text-sm font-bold mb-2" @themeColor('text-light')>Key Identifier *</label>
                    <select name="key" id="key" class="shadow appearance-none border rounded w-full py-2 px-3 leading-tight focus:outline-none focus:shadow-outline" @themeColor('text') required>
                        <option value="">-- Select Key --</option>
                        <optgroup label="Personal Information">
                            <option value="name" {{ old('key') == 'name' ? 'selected' : '' }}>Name</option>
                            <option value="role" {{ old('key') == 'role' ? 'selected' : '' }}>Role/Position</option>
                            <option value="tagline" {{ old('key') == 'tagline' ? 'selected' : '' }}>Tagline</option>
                            <option value="description" {{ old('key') == 'description' ? 'selected' : '' }}>Description</option>
                            <option value="profile_image" {{ old('key') == 'profile_image' ? 'selected' : '' }}>Profile Image</option>
                            <option value="journey" {{ old('key') == 'journey' ? 'selected' : '' }}>Journey/Bio</option>
                        </optgroup>
                        <optgroup label="Contact Information">
                            <option value="email" {{ old('key') == 'email' ? 'selected' : '' }}>Email Address</option>
                            <option value="phone" {{ old('key') == 'phone' ? 'selected' : '' }}>Phone Number</option>
                            <option value="location" {{ old('key') == 'location' ? 'selected' : '' }}>Location</option>
                            <option value="address" {{ old('key') == 'address' ? 'selected' : '' }}>Full Address</option>
                            <option value="availability" {{ old('key') == 'availability' ? 'selected' : '' }}>Availability</option>
                        </optgroup>
                        <optgroup label="Social Media">
                            <option value="linkedin" {{ old('key') == 'linkedin' ? 'selected' : '' }}>LinkedIn URL</option>
                            <option value="github" {{ old('key') == 'github' ? 'selected' : '' }}>GitHub URL</option>
                            <option value="twitter" {{ old('key') == 'twitter' ? 'selected' : '' }}>Twitter URL</option>
                            <option value="instagram" {{ old('key') == 'instagram' ? 'selected' : '' }}>Instagram URL</option>
                            <option value="facebook" {{ old('key') == 'facebook' ? 'selected' : '' }}>Facebook URL</option>
                            <option value="youtube" {{ old('key') == 'youtube' ? 'selected' : '' }}>YouTube URL</option>
                        </optgroup>
                        <optgroup label="Professional">
                            <option value="resume_url" {{ old('key') == 'resume_url' ? 'selected' : '' }}>Resume URL</option>
                            <option value="resume_summary" {{ old('key') == 'resume_summary' ? 'selected' : '' }}>Resume Summary</option>
                            <option value="objective" {{ old('key') == 'objective' ? 'selected' : '' }}>Career Objective</option>
                            <option value="skills_summary" {{ old('key') == 'skills_summary' ? 'selected' : '' }}>Skills Summary</option>
                        </optgroup>
                        <optgroup label="Website Elements">
                            <option value="contact_form_text" {{ old('key') == 'contact_form_text' ? 'selected' : '' }}>Contact Form Text</option>
                            <option value="office_hours" {{ old('key') == 'office_hours' ? 'selected' : '' }}>Office Hours</option>
                            <option value="meta_description" {{ old('key') == 'meta_description' ? 'selected' : '' }}>Meta Description</option>
                            <option value="meta_keywords" {{ old('key') == 'meta_keywords' ? 'selected' : '' }}>Meta Keywords</option>
                        </optgroup>
                        <optgroup label="Other">
                            <option value="custom" {{ old('key') == 'custom' ? 'selected' : '' }}>Custom Key...</option>
                        </optgroup>
                    </select>
                    <p class="text-sm mt-1" @themeColor('text-lighter')>
                        The section is for organization only. Keys like "name" will be available in all sections.
                    </p>
                </div>
                
                <div id="custom_key_container" class="mb-4 {{ old('key') == 'custom' ? '' : 'hidden' }}">
                    <label for="custom_key" class="block text-sm font-bold mb-2" @themeColor('text-light')>Custom Key Name *</label>
                    <input type="text" name="custom_key" id="custom_key" value="{{ old('custom_key') }}" class="shadow appearance-none border rounded w-full py-2 px-3 leading-tight focus:outline-none focus:shadow-outline" @themeColor('text')>
                    <p class="text-sm mt-1" @themeColor('text-lighter')>Enter a unique identifier for this custom information (letters, numbers, underscores only)</p>
                </div>

                <div class="mb-4">
                    <label for="section" class="block text-sm font-bold mb-2" @themeColor('text-light')>Section *</label>
                    <select name="section" id="section" class="shadow appearance-none border rounded w-full py-2 px-3 leading-tight focus:outline-none focus:shadow-outline" @themeColor('text') required>
                        <option value="">-- Select Section --</option>
                        <option value="Home" {{ old('section') == 'Home' ? 'selected' : '' }}>Home</option>
                        <option value="About" {{ old('section') == 'About' ? 'selected' : '' }}>About</option>
                        <option value="Contact" {{ old('section') == 'Contact' ? 'selected' : '' }}>Contact</option>
                        <option value="Social" {{ old('section') == 'Social' ? 'selected' : '' }}>Social Media</option>
                        <option value="Resume" {{ old('section') == 'Resume' ? 'selected' : '' }}>Resume</option>
                        <option value="Other" {{ old('section') == 'Other' ? 'selected' : '' }}>Other</option>
                    </select>
                </div>

                <div class="mb-4">
                    <label for="type" class="block text-sm font-bold mb-2" @themeColor('text-light')>Value Type *</label>
                    <select name="type" id="type" class="shadow appearance-none border rounded w-full py-2 px-3 leading-tight focus:outline-none focus:shadow-outline" @themeColor('text') onchange="toggleValueInput()" required>
                        <option value="text" {{ old('type') == 'text' ? 'selected' : '' }}>Short Text</option>
                        <option value="textarea" {{ old('type') == 'textarea' ? 'selected' : '' }}>Long Text</option>
                        <option value="html" {{ old('type') == 'html' ? 'selected' : '' }}>HTML Content</option>
                        <option value="url" {{ old('type') == 'url' ? 'selected' : '' }}>URL/Link</option>
                        <option value="email" {{ old('type') == 'email' ? 'selected' : '' }}>Email Address</option>
                        <option value="phone" {{ old('type') == 'phone' ? 'selected' : '' }}>Phone Number</option>
                        <option value="image" {{ old('type') == 'image' ? 'selected' : '' }}>Image Upload</option>
                        <option value="file" {{ old('type') == 'file' ? 'selected' : '' }}>File Upload</option>
                    </select>
                    <p class="text-sm mt-1" @themeColor('text-lighter')>Select the type of value you want to store</p>
                </div>
                
                <div id="value_container" class="mb-4 {{ in_array(old('type', 'text'), ['image', 'file']) ? 'hidden' : '' }}">
                    <label for="value_text" class="block text-sm font-bold mb-2" @themeColor('text-light')>Value *</label>
                    
                    {{-- Short Text Input --}}
                    <div class="input-field {{ old('type', 'text') == 'text' ? '' : 'hidden' }}" id="text_input">
                        <input type="text" name="value" id="value_text" value="{{ old('value') }}" 
                            class="shadow appearance-none border rounded w-full py-2 px-3 leading-tight focus:outline-none focus:shadow-outline" @themeColor('text')>
                    </div>
                
                    {{-- Long Text / HTML Input --}}
                    <div class="input-field {{ in_array(old('type'), ['textarea', 'html']) ? '' : 'hidden' }}" id="textarea_input">
                        <textarea name="value" id="value_textarea" rows="8" 
                            class="shadow appearance-none border rounded w-full py-2 px-3 leading-tight focus:outline-none focus:shadow-outline" @themeColor('text')>{{ old('value') }}</textarea>
                        <div id="html_help" class="{{ old('type') == 'html' ? '' : 'hidden' }} text-sm mt-1" @themeColor('text-lighter')>
                            You can use HTML tags in this field.
                        </div>
                    </div>
                
                    {{-- URL Input --}}
                    <div class="input-field {{ old('type') == 'url' ? '' : 'hidden' }}" id="url_input">
                        <input type="url" name="value" id="value_url" value="{{ old('value') }}" placeholder="https://example.com"
                            class="shadow appearance-none border rounded w-full py-2 px-3 leading-tight focus:outline-none focus:shadow-outline" @themeColor('text')>
                    </div>
                
                    {{-- Email Input --}}
                    <div class="input-field {{ old('type') == 'email' ? '' : 'hidden' }}" id="email_input">
                        <input type="email" name="value" id="value_email" value="{{ old('value') }}" placeholder="you@example.com"
                            class="shadow appearance-none border rounded w-full py-2 px-3 leading-tight focus:outline-none focus:shadow-outline" @themeColor('text')>
                    </div>
                
                    {{-- Phone Input --}}
                    <div class="input-field {{ old('type') == 'phone' ? '' : 'hidden' }}" id="phone_input">
                        <input type="tel" name="value" id="value_phone" value="{{ old('value') }}" placeholder="+63 XXX XXX XXXX"
                            class="shadow appearance-none border rounded w-full py-2 px-3 leading-tight focus:outline-none focus:shadow-outline" @themeColor('text')>
                    </div>
                </div>
                
                <div id="file_container" class="mb-4 {{ in_array(old('type'), ['image', 'file']) ? '' : 'hidden' }}">
                    <label for="file_upload" class="block text-sm font-bold mb-2" @themeColor('text-light')>File/Image Upload *</label>
                    <input type="file" name="file_upload" id="file_upload" class="shadow appearance-none border rounded w-full py-2 px-3 leading-tight focus:outline-none focus:shadow-outline" @themeColor('text')>
                    <div id="image_help" class="{{ old('type') == 'image' ? '' : 'hidden' }} text-sm mt-1" @themeColor('text-lighter')>
                        Upload an image file (JPG, PNG, GIF, SVG).
                    </div>
                    <div id="file_help" class="{{ old('type') == 'file' ? '' : 'hidden' }} text-sm mt-1" @themeColor('text-lighter')>
                        Upload any file (PDF, DOC, etc.).
                    </div>
                </div>

                <div class="mb-6">
                    <input type="hidden" name="is_public" value="0">
                    <label class="flex items-center">
                        <input type="checkbox" name="is_public" value="1" class="rounded border-gray-300" style="color: var(--color-primary, #774C0C); --tw-ring-color: var(--color-primary, #774C0C);" {{ old('is_public', true) ? 'checked' : '' }}>
                        <span class="ml-2 text-sm font-bold" @themeColor('text-light')>Public Information</span>
                    </label>
                    <p class="text-sm mt-1" @themeColor('text-lighter')>Check if this information should be visible to website visitors</p>
                </div>

                <div id="hidden_value_container" style="display: none;">
                    <input type="hidden" id="hidden_value" name="hidden_value" value="placeholder">
                </div>

                <div class="flex items-center justify-end">
                    <x-admin.button-primary type="submit">
                        Save Information
                    </x-admin.button-primary>
                </div>
            </form>
        </x-admin.card>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Initialize the form state
        toggleValueInput();
        
        // Set up event listener for type changes
        document.getElementById('type').addEventListener('change', function() {
            toggleValueInput();
        });
        
        // Set up event listener for key changes
        document.getElementById('key').addEventListener('change', function() {
            const key = this.value;
            const customKeyContainer = document.getElementById('custom_key_container');
            const customKey = document.getElementById('custom_key');
            
            if (key === 'custom') {
                customKeyContainer.classList.remove('hidden');
                customKey.setAttribute('required', 'required');
            } else {
                customKeyContainer.classList.add('hidden');
                customKey.removeAttribute('required');
            }
        });
        
        // Set up form submission handler
        document.querySelector('form').addEventListener('submit', function(event) {
            const type = document.getElementById('type').value;
            const isFileType = (type === 'image' || type === 'file');
            
            console.log('Form submission attempt:');
            console.log('- Type:', type);
            console.log('- Is file type:', isFileType);
            
            // For file types, ensure we have a placeholder value
            if (isFileType) {
                // For file types, ensure file upload has name attribute and value fields don't
                document.getElementById('file_upload').setAttribute('name', 'file_upload');
                
                // Disable all text inputs to prevent them from being submitted
                document.querySelectorAll('#value_container input, #value_container textarea').forEach(input => {
                    input.removeAttribute('name');
                    input.removeAttribute('required');
                });

                // Make sure we have a placeholder value for file types
                let placeholderInput = document.getElementById('value_placeholder');
                if (!placeholderInput) {
                    placeholderInput = document.createElement('input');
                    placeholderInput.type = 'hidden';
                    placeholderInput.name = 'value';
                    placeholderInput.id = 'value_placeholder';
                    placeholderInput.value = 'file_upload_placeholder';
                    this.appendChild(placeholderInput);
                }
                
                // Check if file is selected (for new entries)
                if (document.getElementById('file_upload').files.length === 0) {
                    // In edit form, we may have an existing file
                    const hasExistingFile = document.querySelector('.mb-4.p-4.bg-gray-50') !== null;
                    
                    if (!hasExistingFile) {
                        event.preventDefault();
                        alert('Please select a file to upload.');
                        document.getElementById('file_upload').focus();
                        return false;
                    }
                }
            } else {
                // For non-file types, make sure file input doesn't interfere
                const fileUpload = document.getElementById('file_upload');
                fileUpload.removeAttribute('name');
                fileUpload.removeAttribute('required');

                // For non-file types, remove any placeholder values
                const placeholder = document.getElementById('value_placeholder');
                if (placeholder) placeholder.remove();
                
                // Ensure the appropriate input field has a value
                const activeField = document.querySelector('.input-field:not(.hidden)');
                if (activeField) {
                    const input = activeField.querySelector('input, textarea');
                    if (input) {
                        input.name = 'value';
                        input.required = true;
                        
                        if (!input.value.trim()) {
                            event.preventDefault();
                            alert('Please enter a value.');
                            input.focus();
                            return false;
                        }
                    }
                }
                
                // Make sure other inactive input fields are ignored (but not disabled)
                document.querySelectorAll('.input-field.hidden input, .input-field.hidden textarea').forEach(input => {
                    // Remove name attribute to prevent submission
                    input.removeAttribute('name');
                    input.removeAttribute('required');
                });
            }
        });
    });

    function toggleValueInput() {
        // Get form elements
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

             // Remove any existing value inputs' name attributes
            document.querySelectorAll('#value_container input, #value_container textarea').forEach(input => {
                input.removeAttribute('name');
                input.removeAttribute('required');
            });
            
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
            
            // Enable file upload
            fileUpload.classList.remove('hidden');
            fileUpload.setAttribute('name', 'file_upload');
            fileUpload.required = true;
            
            // Show appropriate help text
            document.querySelectorAll('#image_help, #file_help').forEach(el => {
                el.classList.add('hidden');
            });
            
            if (type === 'image') {
                document.getElementById('image_help')?.classList.remove('hidden');
            } else {
                document.getElementById('file_help')?.classList.remove('hidden');
            }
        } else {
            // For non-file types
            valueContainer.classList.remove('hidden');
            fileContainer.classList.add('hidden');
            
            // Remove placeholder if it exists
            const placeholder = document.getElementById('value_placeholder');
            if (placeholder) placeholder.remove();
            
            // Disable file upload and remove required attribute
            fileUpload.classList.add('hidden');
            fileUpload.required = false;
            fileUpload.value = ''; // Clear any selected file
            fileUpload.removeAttribute('name'); // Remove name attribute to prevent submission
            
            // Hide all value input fields first
            document.querySelectorAll('.input-field').forEach(field => {
                field.classList.add('hidden');
                
                // Reset the name attribute on all inputs
                const inputs = field.querySelectorAll('input, textarea');
                inputs.forEach(input => {
                    input.removeAttribute('name');
                    input.removeAttribute('required');
                });
            });
            
            // Show appropriate field based on type
            let activeField = null;
            
            switch (type) {
                case 'text':
                    activeField = document.getElementById('text_input');
                    break;
                case 'textarea':
                case 'html':
                    activeField = document.getElementById('textarea_input');
                    break;
                case 'url':
                    activeField = document.getElementById('url_input');
                    break;
                case 'email':
                    activeField = document.getElementById('email_input');
                    break;
                case 'phone':
                    activeField = document.getElementById('phone_input');
                    break;
            }
            
            // Show the active field
            if (activeField) {
                activeField.classList.remove('hidden');
                const input = activeField.querySelector('input, textarea');
                if (input) {
                    input.name = 'value';
                    input.required = true;
                }
            }
            
            // Show/hide HTML help text
            if (document.getElementById('html_help')) {
                document.getElementById('html_help').classList.toggle('hidden', type !== 'html');
            }
        }
    }
</script>
@endsection