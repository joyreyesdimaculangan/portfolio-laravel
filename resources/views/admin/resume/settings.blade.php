@extends('layouts.admin')

@section('title', 'Resume Settings')

@section('content')
<div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <x-admin.card>
            <div class="flex justify-between items-center mb-6">
                <h1 class="text-2xl font-semibold" @themeColor('text')>Resume Settings</h1>
                <div class="flex space-x-2">
                    <a href="{{ route('resume.pdf') }}" target="_blank" class="inline-flex items-center px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white" style="background-color: var(--color-primary, #774C0C); transition-duration: var(--transition-speed);">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                        </svg>
                        Preview Resume
                    </a>
                </div>
            </div>

            @if(session('success'))
                <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
                    {{ session('success') }}
                </div>
            @endif

            <form action="/admin/resume/settings" method="POST">
                @csrf
                
                <div class="mb-6">
                    <h2 class="text-lg font-semibold mb-4 pb-2 border-b" @themeColor('text')>Personal Information</h2>
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label for="name" class="block text-sm font-bold mb-2" @themeColor('text-light')>Full Name *</label>
                            <input type="text" id="name" name="name" value="{{ old('name', $infoArray['name'] ?? '') }}"
                                class="shadow appearance-none border rounded w-full py-2 px-3 leading-tight focus:outline-none focus:shadow-outline @error('name') border-red-500 @enderror" @themeColor('text') required>
                            @error('name')
                                <p class="text-red-500 text-xs italic mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                        
                        <div>
                            <label for="email" class="block text-sm font-bold mb-2" @themeColor('text-light')>Email *</label>
                            <input type="email" id="email" name="email" value="{{ old('email', $infoArray['email'] ?? '') }}"
                                class="shadow appearance-none border rounded w-full py-2 px-3 leading-tight focus:outline-none focus:shadow-outline @error('email') border-red-500 @enderror" @themeColor('text') required>
                            @error('email')
                                <p class="text-red-500 text-xs italic mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                        
                        <div>
                            <label for="phone" class="block text-sm font-bold mb-2" @themeColor('text-light')>Phone Number</label>
                            <input type="text" id="phone" name="phone" value="{{ old('phone', $infoArray['phone'] ?? '') }}"
                                class="shadow appearance-none border rounded w-full py-2 px-3 leading-tight focus:outline-none focus:shadow-outline @error('phone') border-red-500 @enderror" @themeColor('text')>
                            @error('phone')
                                <p class="text-red-500 text-xs italic mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                        
                        <div>
                            <label for="location" class="block text-sm font-bold mb-2" @themeColor('text-light')>Location</label>
                            <input type="text" id="location" name="location" value="{{ old('location', $infoArray['location'] ?? '') }}"
                                placeholder="City, Country" 
                                class="shadow appearance-none border rounded w-full py-2 px-3 leading-tight focus:outline-none focus:shadow-outline @error('location') border-red-500 @enderror" @themeColor('text')>
                            @error('location')
                                <p class="text-red-500 text-xs italic mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                </div>
                
                <div class="mb-6">
                    <h2 class="text-lg font-semibold mb-4 pb-2 border-b" @themeColor('text')>Professional Summary</h2>
                    
                    <div>
                        <label for="resume_objective" class="block text-sm font-bold mb-2" @themeColor('text-light')>Resume Objective/Summary</label>
                        <textarea id="resume_objective" name="resume_objective" rows="4" 
                            class="shadow appearance-none border rounded w-full py-2 px-3 leading-tight focus:outline-none focus:shadow-outline @error('resume_objective') border-red-500 @enderror" @themeColor('text')>{{ old('resume_objective', $infoArray['resume_objective'] ?? '') }}</textarea>
                        <p class="text-sm mt-1" @themeColor('text-lighter')>A brief overview of your professional background and career goals.</p>
                        @error('resume_objective')
                            <p class="text-red-500 text-xs italic mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
                
                <div class="mb-6">
                    <h2 class="text-lg font-semibold mb-4 pb-2 border-b" @themeColor('text')>Social & Professional Links</h2>
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label for="linkedin_url" class="block text-sm font-bold mb-2" @themeColor('text-light')>LinkedIn Profile</label>
                            <input type="url" id="linkedin_url" name="linkedin_url" value="{{ old('linkedin_url', $infoArray['linkedin_url'] ?? '') }}"
                                placeholder="https://linkedin.com/in/yourprofile" 
                                class="shadow appearance-none border rounded w-full py-2 px-3 leading-tight focus:outline-none focus:shadow-outline @error('linkedin_url') border-red-500 @enderror" @themeColor('text')>
                            @error('linkedin_url')
                                <p class="text-red-500 text-xs italic mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                        
                        <div>
                            <label for="github_url" class="block text-sm font-bold mb-2" @themeColor('text-light')>GitHub Profile</label>
                            <input type="url" id="github_url" name="github_url" value="{{ old('github_url', $infoArray['github_url'] ?? '') }}"
                                placeholder="https://github.com/yourusername"
                                class="shadow appearance-none border rounded w-full py-2 px-3 leading-tight focus:outline-none focus:shadow-outline @error('github_url') border-red-500 @enderror" @themeColor('text')>
                            @error('github_url')
                                <p class="text-red-500 text-xs italic mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                        
                        <div>
                            <label for="portfolio_url" class="block text-sm font-bold mb-2" @themeColor('text-light')>Portfolio Website</label>
                            <input type="url" id="portfolio_url" name="portfolio_url" value="{{ old('portfolio_url', $infoArray['portfolio_url'] ?? '') }}"
                                placeholder="https://yourportfolio.com"
                                class="shadow appearance-none border rounded w-full py-2 px-3 leading-tight focus:outline-none focus:shadow-outline @error('portfolio_url') border-red-500 @enderror" @themeColor('text')>
                            @error('portfolio_url')
                                <p class="text-red-500 text-xs italic mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                </div>
                
                <div class="mb-6">
                    <h2 class="text-lg font-semibold mb-4 pb-2 border-b" @themeColor('text')>Resume Styling</h2>
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label for="accent_color" class="block text-sm font-bold mb-2" @themeColor('text-light')>Accent Color</label>
                            <div class="flex items-center">
                                <input type="color" id="accent_color" name="accent_color" value="{{ old('accent_color', $infoArray['accent_color'] ?? '#774C0C') }}"
                                    class="h-8 w-12 rounded-md border p-0 @error('accent_color') border-red-500 @enderror">
                                <input type="text" value="{{ old('accent_color', $infoArray['accent_color'] ?? '#774C0C') }}" 
                                    class="ml-2 px-3 py-2 border rounded-md w-32 text-sm" @themeColor('text') id="color_text" readonly>
                            </div>
                            <p class="text-sm mt-1" @themeColor('text-lighter')>Color used for headings and accents in your resume.</p>
                            @error('accent_color')
                                <p class="text-red-500 text-xs italic mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                        
                        <div>
                            <label for="font_family" class="block text-sm font-bold mb-2" @themeColor('text-light')>Font Style</label>
                            <select id="font_family" name="font_family" 
                                class="shadow appearance-none border rounded w-full py-2 px-3 leading-tight focus:outline-none focus:shadow-outline @error('font_family') border-red-500 @enderror" @themeColor('text')>
                                <option value="helvetica" {{ (old('font_family', $infoArray['font_family'] ?? '') == 'helvetica') ? 'selected' : '' }}>Helvetica (Default)</option>
                                <option value="times" {{ (old('font_family', $infoArray['font_family'] ?? '') == 'times') ? 'selected' : '' }}>Times New Roman</option>
                                <option value="arial" {{ (old('font_family', $infoArray['font_family'] ?? '') == 'arial') ? 'selected' : '' }}>Arial</option>
                                <option value="courier" {{ (old('font_family', $infoArray['font_family'] ?? '') == 'courier') ? 'selected' : '' }}>Courier</option>
                            </select>
                            <p class="text-sm mt-1" @themeColor('text-lighter')>Font family used throughout the resume.</p>
                            @error('font_family')
                                <p class="text-red-500 text-xs italic mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                </div>
                
                <div class="flex justify-between items-center">
                    <div>
                        <x-admin.button-primary type="submit">
                            Save Settings
                        </x-admin.button-primary>
                        
                        <x-admin.button-secondary href="{{ route('resume.pdf') }}" target="_blank">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                            </svg>
                            Preview Resume
                        </x-admin.button-secondary>
                    </div>
                    
                    <div class="text-right">
                        <p class="text-sm" @themeColor('text-lighter')>
                            Last updated: 
                            @if(isset($infoArray['updated_at']) && !empty($infoArray['updated_at']))
                                {{ Carbon\Carbon::parse($infoArray['updated_at'])
                                    ->setTimezone('Asia/Manila')
                                    ->format('M d, Y h:i A') }} PST
                            @else
                                Never
                            @endif
                        </p>
                    </div>
                </div>
            </form>
        </x-admin.card>
        
        <div class="mt-8">
            <x-admin.card>
                <h2 class="text-xl font-semibold mb-4" @themeColor('text')>Resume Content Sections</h2>
                <p class="mb-6" @themeColor('text-light')>The following sections are populated from your portfolio data:</p>
                
                <ul class="space-y-4">
                    <li class="flex items-start">
                        <svg class="h-5 w-5 mt-0.5 mr-2" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg" style="color: var(--color-primary, #774C0C);">
                            <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd" />
                        </svg>
                        <div>
                            <h3 class="font-medium" @themeColor('text')>Experience</h3>
                            <p class="text-sm" @themeColor('text-light')>Pulled from your work experience entries. <a href="{{ route('admin.experiences.index') }}" class="hover:underline" style="color: var(--color-primary, #774C0C);">Manage experiences</a>.</p>
                        </div>
                    </li>
                    
                    <li class="flex items-start">
                        <svg class="h-5 w-5 mt-0.5 mr-2" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg" style="color: var(--color-primary, #774C0C);">
                            <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd" />
                        </svg>
                        <div>
                            <h3 class="font-medium" @themeColor('text')>Education</h3>
                            <p class="text-sm" @themeColor('text-light')>Pulled from your education entries. <a href="{{ route('admin.education.index') }}" class="hover:underline" style="color: var(--color-primary, #774C0C);">Manage education</a>.</p>
                        </div>
                    </li>
                    
                    <li class="flex items-start">
                        <svg class="h-5 w-5 mt-0.5 mr-2" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg" style="color: var(--color-primary, #774C0C);">
                            <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd" />
                        </svg>
                        <div>
                            <h3 class="font-medium" @themeColor('text')>Skills</h3>
                            <p class="text-sm" @themeColor('text-light')>Pulled from your skills entries. <a href="{{ route('admin.skills.index') }}" class="hover:underline" style="color: var(--color-primary, #774C0C);">Manage skills</a>.</p>
                        </div>
                    </li>
                    
                    <li class="flex items-start">
                        <svg class="h-5 w-5 mt-0.5 mr-2" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg" style="color: var(--color-primary, #774C0C);">
                            <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd" />
                        </svg>
                        <div>
                            <h3 class="font-medium" @themeColor('text')>Certifications</h3>
                            <p class="text-sm" @themeColor('text-light')>Pulled from your certification entries. <a href="{{ route('admin.certificates.index') }}" class="hover:underline" style="color: var(--color-primary, #774C0C);">Manage certificates</a>.</p>
                        </div>
                    </li>
                    
                    <li class="flex items-start">
                        <svg class="h-5 w-5 mt-0.5 mr-2" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg" style="color: var(--color-primary, #774C0C);">
                            <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd" />
                        </svg>
                        <div>
                            <h3 class="font-medium" @themeColor('text')>Featured Projects</h3>
                            <p class="text-sm" @themeColor('text-light')>Pulled from projects marked as featured. <a href="{{ route('admin.projects.index') }}" class="hover:underline" style="color: var(--color-primary, #774C0C);">Manage projects</a>.</p>
                        </div>
                    </li>
                </ul>
            </x-admin.card>
        </div>
    </div>
</div>

<script>
    // Update text input when color picker changes
    document.getElementById('accent_color').addEventListener('input', function(e) {
        document.getElementById('color_text').value = e.target.value;
    });
</script>
@endsection