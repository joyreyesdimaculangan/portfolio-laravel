@extends('layouts.app')

@section('title', 'About Me')

@section('content')
<section class="min-h-screen bg-gradient-to-b from-white to-amber-50 py-20">
    <div class="container mx-auto px-6 md:px-10 lg:px-12">
        <!-- Header Section -->
        <div class="text-center mb-16 animate-fade-in-up">
            <h1 class="text-4xl md:text-5xl font-bold text-[#774C0C] font-montserrat mb-6">
                About Me
            </h1>
            <div class="flex justify-center items-center gap-3">
                <p class="text-lg md:text-xl text-gray-800 font-light">Get to know me better</p>
            </div>
        </div>

        <!-- Main Content -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-12 items-start">
            <!-- Left Column - Personal Info -->
            <div class="space-y-8 animate-fade-in-up delay-200">
                <div class="bg-white rounded-2xl shadow-lg p-8 space-y-6">
                    <h2 class="text-2xl font-bold text-[#774C0C] font-montserrat">Personal Information</h2>
                    
                    <div class="space-y-4">
                        <div class="flex items-center space-x-4">
                            <span class="text-[#774C0C]">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                                          d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                                </svg>
                            </span>
                            <div>
                                <p class="text-sm text-gray-500">Full Name</p>
                                <p class="font-medium">{{ $personalInfo['name'] ?? 'Joy R. Dimaculangan' }}</p>
                            </div>
                        </div>

                        <div class="flex items-center space-x-4">
                            <span class="text-[#774C0C]">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                                          d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                                </svg>
                            </span>
                            <div>
                                <p class="text-sm text-gray-500">Role</p>
                                <p class="font-medium">{{ $personalInfo['role'] ?? 'IT Student | Web Developer' }}</p>
                            </div>
                        </div>

                        <div class="flex items-center space-x-4">
                            <span class="text-[#774C0C]">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                                          d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                                </svg>
                            </span>
                            <div>
                                <p class="text-sm text-gray-500">Email</p>
                                <p class="font-medium">{{ $personalInfo['email'] ?? 'joyreyesdimaculangan@gmail.com' }}</p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Education Section -->
                <div class="bg-white rounded-2xl shadow-lg p-8 space-y-6">
                    <h2 class="text-2xl font-bold text-[#774C0C] font-montserrat">Education</h2>
                    <div class="space-y-6">
                        @forelse($education as $edu)
                            <div class="flex space-x-4">
                                <div class="flex-shrink-0 mt-1">
                                    <div class="w-3 h-3 rounded-full bg-[#774C0C]"></div>
                                </div>
                                <div>
                                    <h3 class="font-semibold">{{ $edu->institution }}</h3>
                                    <p class="text-sm text-gray-500">{{ $edu->degree }}
                                        @if($edu->field_of_study)
                                            - {{ $edu->field_of_study }}
                                        @endif
                                    </p>
                                    <p class="text-sm text-gray-500">{{ $edu->date_range }}</p>
                                    @if($edu->description)
                                        <p class="text-sm text-gray-600 mt-1">{{ $edu->description }}</p>
                                    @endif
                                </div>
                            </div>
                        @empty
                            <p class="text-gray-500 text-sm">No education history to display.</p>
                        @endforelse
                    </div>
                </div>

                <!-- Journey Section -->
                <div class="bg-white rounded-2xl shadow-lg p-8 space-y-6">
                    <h2 class="text-2xl font-bold text-[#774C0C] font-montserrat">My Journey</h2>
                    <p class="text-gray-700 leading-relaxed">
                        {{ $personalInfo['journey'] ?? 'I started as a 
                     Campus Ambassador for WiTech Batangas, where I connected my campus with tech initiatives, organized events, and promoted technology accessibility. I also became a Mentee at Angular Philippines, deepening my web development skills through hands-on projects and mentorship. Recently, I took on the role of Lead Learner at DevCon Kids, guiding young learners in understanding tech fundamentals—a rewarding experiences that strengthened my communication and teaching skills. Most recently, my internship at Marvill Web Development has given me practical experiences in real-world projects, enhancing my technical skills, teamwork, and understanding of professional development workflows.These experiencess have shaped me into a passionate learner, dedicated to making a positive impact through technology.' }}
                    </p>
                </div>

                <!-- Skills Section -->
                <div class="bg-white rounded-2xl shadow-lg p-8 space-y-6">
                    <h2 class="text-2xl font-bold text-[#774C0C] font-montserrat">Skills & Expertise</h2>
                    @forelse($skillsByCategory as $category => $skills)
                        <h3 class="font-semibold text-[#774C0C] mt-4 mb-2">{{ $category }}</h3>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            @foreach($skills as $skill)
                                <div class="space-y-2">
                                    <p class="font-medium">{{ $skill->name }}</p>
                                    <div class="w-full bg-gray-200 rounded-full h-2">
                                        <div class="bg-[#774C0C] h-2 rounded-full" style="width: {{ $skill->proficiency }}%"></div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @empty
                        <p class="text-gray-500 text-sm">No skills to display.</p>
                    @endforelse
                </div>
            </div>

            <!-- Right Column - About Content -->
            <div class="space-y-8 animate-fade-in-up delay-300">
                <!-- experiences Section -->
                <div class="bg-white rounded-2xl shadow-lg p-8 space-y-6">
                    <h2 class="text-2xl font-bold text-[#774C0C] font-montserrat">Experiences</h2>
                    <div class="space-y-8">
                        @forelse($experiences as $experiences)
                            <div class="relative pl-8 pb-8 border-l-2 border-amber-100 last:pb-0">
                                <div class="absolute -left-[9px] top-0 w-4 h-4 rounded-full bg-[#774C0C]"></div>
                                <div class="space-y-2">
                                    <span class="inline-flex items-center px-3 py-1 rounded-full text-sm 
                                            bg-amber-100 text-[#774C0C]">
                                        {{ $experiences->date_range }}
                                    </span>
                                    <h3 class="text-lg font-semibold text-gray-900">{{ $experiences->title }}</h3>
                                    <p class="text-[#774C0C] font-medium">{{ $experiences->company }}
                                        @if($experiences->location)
                                            - {{ $experiences->location }}
                                        @endif
                                    </p>
                                    <p class="text-gray-600 text-sm leading-relaxed">
                                        {{ $experiences->description }}
                                    </p>
                                    
                                    @if(count($experiences->achievements_array) > 0)
                                        <ul class="mt-2 space-y-1 text-sm text-gray-600 list-disc list-inside">
                                            @foreach($experiences->achievements_array as $achievement)
                                                <li>{{ $achievement }}</li>
                                            @endforeach
                                        </ul>
                                    @endif
                                </div>
                            </div>
                        @empty
                            <p class="text-gray-500 text-sm">No experiences to display.</p>
                        @endforelse
                    </div>
                </div>

                <!-- Certificates Section -->
                <div class="bg-white rounded-2xl shadow-lg p-8 space-y-6">
                    <h2 class="text-2xl font-bold text-[#774C0C] font-montserrat">Certificates</h2>
                    <div class="grid gap-6">
                        <!-- Certificate Item -->
                        @forelse($certificates as $certificate)
                            <div class="group relative overflow-hidden rounded-lg hover:shadow-md 
                                    transition-all duration-300 bg-amber-50/30">
                                <div class="p-6">
                                    <div class="flex items-start gap-4">
                                        <!-- Certificate Icon -->
                                        <div class="flex-shrink-0">
                                            <div class="w-12 h-12 rounded-full bg-amber-100 flex items-center 
                                                    justify-center text-[#774C0C] group-hover:bg-[#774C0C] 
                                                    group-hover:text-white transition-colors duration-300">
                                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                                                        d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/>
                                                </svg>
                                            </div>
                                        </div>

                                        <!-- Certificate Content -->
                                        <div class="space-y-2 flex-1">
                                            <h3 class="font-semibold text-gray-900">{{ $certificate->name }}</h3>
                                            <p class="text-sm text-gray-600">{{ $certificate->issuer }}</p>
                                            <div class="flex items-center gap-2 text-sm text-gray-500">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                                                        d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                                </svg>
                                                <span>Issued: {{ $certificate->issue_date->format('F Y') }}</span>
                                            </div>
                                            @if($certificate->credential_id)
                                                <p class="text-xs text-gray-500">Credential ID: {{ $certificate->credential_id }}</p>
                                            @endif
                                        </div>

                                        <!-- View Button -->
                                        @if($certificate->proof_url)
                                            <a href="{{ $certificate->proof_url }}" 
                                            class="flex items-center gap-1 text-sm font-medium text-[#774C0C] hover:text-amber-700 transition-colors duration-300"
                                            target="_blank"
                                            rel="noopener noreferrer">
                                                <span>View</span>
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                                                        d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"/>
                                                </svg>
                                            </a>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        @empty
                            <p class="text-gray-500 text-sm">No certificates to display.</p>
                        @endforelse
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection