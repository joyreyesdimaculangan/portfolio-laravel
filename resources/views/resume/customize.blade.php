@extends('layouts.app')

@section('title', 'Customize Your Resume')

@section('content')
<div class="py-12">
    <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
            <div class="p-6 bg-white border-b border-gray-200">
                <h1 class="text-2xl font-bold text-gray-800 mb-6">Generate Your Resume/CV</h1>
                
                <div class="mb-8">
                    <p class="text-gray-600">Your resume will be generated based on the information in your portfolio. Choose which sections to include below.</p>
                </div>
                
                <form action="{{ route('resume.pdf') }}" method="GET" class="space-y-6">
                    <div class="bg-gray-50 p-4 rounded-lg">
                        <h2 class="text-lg font-medium text-gray-700 mb-4">Customize Sections</h2>
                        
                        <div class="space-y-4">
                            @if(isset($personalInfo['resume_objective']))
                            <div>
                                <label class="inline-flex items-center">
                                    <input type="checkbox" name="sections[]" value="objective" class="rounded border-gray-300 text-[#774C0C] shadow-sm focus:border-[#774C0C] focus:ring focus:ring-[#774C0C] focus:ring-opacity-50" checked>
                                    <span class="ml-2">Professional Summary</span>
                                </label>
                            </div>
                            @endif
                            
                            @if($hasExperiences)
                            <div>
                                <label class="inline-flex items-center">
                                    <input type="checkbox" name="sections[]" value="experience" class="rounded border-gray-300 text-[#774C0C] shadow-sm focus:border-[#774C0C] focus:ring focus:ring-[#774C0C] focus:ring-opacity-50" checked>
                                    <span class="ml-2">Professional Experience</span>
                                </label>
                            </div>
                            @endif
                            
                            @if($hasEducation)
                            <div>
                                <label class="inline-flex items-center">
                                    <input type="checkbox" name="sections[]" value="education" class="rounded border-gray-300 text-[#774C0C] shadow-sm focus:border-[#774C0C] focus:ring focus:ring-[#774C0C] focus:ring-opacity-50" checked>
                                    <span class="ml-2">Education</span>
                                </label>
                            </div>
                            @endif
                            
                            @if($hasSkills)
                            <div>
                                <label class="inline-flex items-center">
                                    <input type="checkbox" name="sections[]" value="skills" class="rounded border-gray-300 text-[#774C0C] shadow-sm focus:border-[#774C0C] focus:ring focus:ring-[#774C0C] focus:ring-opacity-50" checked>
                                    <span class="ml-2">Skills</span>
                                </label>
                            </div>
                            @endif
                            
                            @if($hasCertificates)
                            <div>
                                <label class="inline-flex items-center">
                                    <input type="checkbox" name="sections[]" value="certificates" class="rounded border-gray-300 text-[#774C0C] shadow-sm focus:border-[#774C0C] focus:ring focus:ring-[#774C0C] focus:ring-opacity-50" checked>
                                    <span class="ml-2">Certifications</span>
                                </label>
                            </div>
                            @endif
                            
                            @if($hasProjects)
                            <div>
                                <label class="inline-flex items-center">
                                    <input type="checkbox" name="sections[]" value="projects" class="rounded border-gray-300 text-[#774C0C] shadow-sm focus:border-[#774C0C] focus:ring focus:ring-[#774C0C] focus:ring-opacity-50" checked>
                                    <span class="ml-2">Selected Projects</span>
                                </label>
                            </div>
                            @endif
                        </div>
                    </div>
                    
                    <div class="flex flex-wrap gap-4">
                        <button type="submit" class="px-6 py-3 bg-[#774C0C] hover:bg-[#5d3a08] text-white font-medium rounded-md transition-colors duration-300">
                            Preview Resume
                        </button>
                        
                        <button type="submit" name="download" value="1" class="px-6 py-3 bg-gray-600 hover:bg-gray-700 text-white font-medium rounded-md transition-colors duration-300">
                            Download PDF
                        </button>
                        
                        @auth
                        <a href="{{ route('admin.resume.settings') }}" class="px-6 py-3 bg-blue-600 hover:bg-blue-700 text-white font-medium rounded-md transition-colors duration-300">
                            Edit Resume Info
                        </a>
                        @endauth
                    </div>
                </form>
                
                <div class="mt-8 pt-6 border-t border-gray-200">
                    <h3 class="text-lg font-medium text-gray-800 mb-4">Resume Information</h3>
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <h4 class="text-sm font-medium text-gray-500">Name</h4>
                            <p class="mt-1">{{ $personalInfo['name'] ?? 'Not set' }}</p>
                        </div>
                        
                        <div>
                            <h4 class="text-sm font-medium text-gray-500">Email</h4>
                            <p class="mt-1">{{ $personalInfo['email'] ?? 'Not set' }}</p>
                        </div>
                        
                        @if(isset($personalInfo['phone']))
                        <div>
                            <h4 class="text-sm font-medium text-gray-500">Phone</h4>
                            <p class="mt-1">{{ $personalInfo['phone'] }}</p>
                        </div>
                        @endif
                        
                        @if(isset($personalInfo['location']))
                        <div>
                            <h4 class="text-sm font-medium text-gray-500">Location</h4>
                            <p class="mt-1">{{ $personalInfo['location'] }}</p>
                        </div>
                        @endif
                    </div>
                    
                    @if(isset($personalInfo['resume_objective']))
                    <div class="mt-4">
                        <h4 class="text-sm font-medium text-gray-500">Professional Summary</h4>
                        <p class="mt-1">{{ $personalInfo['resume_objective'] }}</p>
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection