@extends('./layouts/app')

@section('title', 'Home')

@section('content')
<section class="min-h-screen w-full bg-gradient-to-b from-white to-amber-50 flex items-center py-24">
    <div class="container mx-auto px-4 md:px-8 lg:px-16">
        <div class="flex flex-col md:flex-row items-start justify-between gap-12 lg:gap-16">
            <!-- Left Content -->
            <div class="w-full md:w-1/2 space-y-12">
                <div class="space-y-10">
                    
                    <!-- Main Heading -->
                    <div class="space-y-8 animate-fade-in-up delay-200">
                        <span class="block text-2xl md:text-3xl text-black tracking-wide font-medium">
                            Hello there, I am
                        </span>
                        <h1 class="text-4xl md:text-5xl lg:text-7xl font-bold text-[#774C0C] 
                                 font-montserrat tracking-wider leading-tight uppercase">
                            {{ $personalInfo['name'] ?? 'JOY R. DIMACULANGAN'}}
                        </h1>
                        <span class="block text-2xl md:text-3xl text-black tracking-wide font-medium">
                            
                        </span>
                    </div>

                    <!-- Description -->
                    <div class="space-y-10 animate-fade-in-up delay-300">
                        <p class="text-lg md:text-xl text-gray-700 leading-relaxed font-light max-w-2xl">
                            <span class="font-medium text-[#774C0C]">
                                {{ $personalInfo['tagline'] ?? 'Passionate about bridging technology and community impact,'}}
                            </span> 
                                {{ $personalInfo['description'] ?? 'I blend technical expertise with leadership skills to create meaningful solutions. 
                            As an emerging IT professional, I thrive on collaborative projects that push 
                            boundaries and foster inclusive innovation.' }}
                        </p>

                            <!-- Action Buttons -->
                            <div class="flex flex-col sm:flex-row gap-6 pt-6">
                                <a href="{{ route('about') }}" 
                                class="group inline-flex items-center justify-center px-8 py-3 
                                    text-base font-medium text-white bg-[#774C0C] hover:bg-amber-800 rounded-lg 
                                    transition-all duration-300">
                                <span class="flex items-center">
                                    Learn more about me
                                    <svg class="w-5 h-5 ml-2 transform group-hover:translate-x-1 transition-transform" 
                                        fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                                            d="M13 7l5 5m0 0l-5 5m5-5H6" />
                                    </svg>
                                </span>
                            </a>

                            <a href="{{ route('download.cv') }}" 
                            class="group relative inline-flex items-center justify-center px-8 py-3 
                                    text-base font-medium text-[#774C0C] border-2 border-[#774C0C] 
                                    rounded-lg overflow-hidden transition-all duration-300">
                                <span class="relative z-10 flex items-center">
                                    Download CV
                                    <svg class="w-5 h-5 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                                            d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                                    </svg>
                                </span>
                                <div class="absolute inset-0 bg-[#774C0C]/10 transform scale-x-0 origin-left 
                                            transition-transform group-hover:scale-x-100"></div>
                            </a>
                        </div>

                        <!-- Social Media Links -->
                        <div class="flex items-center space-x-6 pt-8">
                            <p class="text-sm uppercase tracking-widest text-gray-600 font-montserrat font-medium 
                            flex items-center space-x-3 animate-fade-in-up">
                                <span class="w-8 h-px bg-[#774C0C]/50"></span>
                                <span>Find Me On</span>
                            </p>
                            
                            <!-- Twitter/X Link -->
                            <a href="{{ $personalInfo['twitter_url'] ?? 'https://x.com/joytotheworlzZ?t=ENlFNA-7QjPR5k1zUckRHg&s=09' }}" 
                                class="text-gray-600 hover:text-[#774C0C] transition-colors duration-300"
                                target="_blank"
                                rel="noopener noreferrer">
                                <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                                    <path d="M8.29 20.251c7.547 0 11.675-6.253 11.675-11.675 0-.178 0-.355-.012-.53A8.348 8.348 0 0022 5.92a8.19 8.19 0 01-2.357.646 4.118 4.118 0 001.804-2.27 8.224 8.224 0 01-2.605.996 4.107 4.107 0 00-6.993 3.743 11.65 11.65 0 01-8.457-4.287 4.106 4.106 0 001.27 5.477A4.072 4.072 0 012.8 9.713v.052a4.105 4.105 0 003.292 4.022 4.095 4.095 0 01-1.853.07 4.108 4.108 0 003.834 2.85A8.233 8.233 0 012 18.407a11.616 11.616 0 006.29 1.84"/>
                                </svg>
                            </a>
                            
                            <!-- Instagram Link -->
                            <a href="{{ $personalInfo['instagram_url'] ?? 'https://www.instagram.com/joytothewoorldd/' }}" 
                                class="text-gray-600 hover:text-[#774C0C] transition-colors duration-300"
                                target="_blank"
                                rel="noopener noreferrer">
                                <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                                    <path fill-rule="evenodd" d="M12.315 2c2.43 0 2.784.013 3.808.06 1.064.049 1.791.218 2.427.465a4.902 4.902 0 011.772 1.153 4.902 4.902 0 011.153 1.772c.247.636.416 1.363.465 2.427.048 1.067.06 1.407.06 4.123v.08c0 2.643-.012 2.987-.06 4.043-.049 1.064-.218 1.791-.465 2.427a4.902 4.902 0 01-1.153 1.772 4.902 4.902 0 01-1.772 1.153c-.636.247-1.363.416-2.427.465-1.067.048-1.407.06-4.123.06h-.08c-2.643 0-2.987-.012-4.043-.06-1.064-.049-1.791-.218-2.427-.465a4.902 4.902 0 01-1.772-1.153 4.902 4.902 0 01-1.153-1.772c-.247-.636-.416-1.363-.465-2.427-.047-1.024-.06-1.379-.06-3.808v-.63c0-2.43.013-2.784.06-3.808.049-1.064.218-1.791.465-2.427a4.902 4.902 0 011.153-1.772A4.902 4.902 0 015.45 2.525c.636-.247 1.363-.416 2.427-.465C8.901 2.013 9.256 2 11.685 2h.63zm-.081 1.802h-.468c-2.456 0-2.784.011-3.807.058-.975.045-1.504.207-1.857.344-.467.182-.8.398-1.15.748-.35.35-.566.683-.748 1.15-.137.353-.3.882-.344 1.857-.047 1.023-.058 1.351-.058 3.807v.468c0 2.456.011 2.784.058 3.807.045.975.207 1.504.344 1.857.182.466.399.8.748 1.15.35.35.683.566 1.15.748.353.137.882.3 1.857.344 1.054.048 1.37.058 4.041.058h.08c2.597 0 2.917-.01 3.96-.058.976-.045 1.505-.207 1.858-.344.466-.182.8-.398 1.15-.748.35-.35.566-.683.748-1.15.137-.353.3-.882.344-1.857.048-1.055.058-1.37.058-4.041v-.08c0-2.597-.01-2.917-.058-3.96-.045-.976-.207-1.505-.344-1.858a3.097 3.097 0 00-.748-1.15 3.098 3.098 0 00-1.15-.748c-.353-.137-.882-.3-1.857-.344-1.023-.047-1.351-.058-3.807-.058zM12 6.865a5.135 5.135 0 110 10.27 5.135 5.135 0 010-10.27zm0 1.802a3.333 3.333 0 100 6.666 3.333 3.333 0 000-6.666zm5.338-3.205a1.2 1.2 0 110 2.4 1.2 1.2 0 010-2.4z" clip-rule="evenodd"/>
                                </svg>
                            </a>
                            
                            <!-- GitHub Link -->
                            <a href="{{ $personalInfo['github_url'] ?? 'https://github.com/joyreyesdimaculangan' }}" 
                                class="text-gray-600 hover:text-[#774C0C] transition-colors duration-300"
                                target="_blank"
                                rel="noopener noreferrer">
                                <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                                    <path fill-rule="evenodd" d="M12 2C6.477 2 2 6.484 2 12.017c0 4.425 2.865 8.18 6.839 9.504.5.092.682-.217.682-.483 0-.237-.008-.868-.013-1.703-2.782.605-3.369-1.343-3.369-1.343-.454-1.158-1.11-1.466-1.11-1.466-.908-.62.069-.608.069-.608 1.003.07 1.531 1.032 1.531 1.032.892 1.53 2.341 1.088 2.91.832.092-.647.35-1.088.636-1.338-2.22-.253-4.555-1.113-4.555-4.951 0-1.093.39-1.988 1.029-2.688-.103-.253-.446-1.272.098-2.65 0 0 .84-.27 2.75 1.026A9.564 9.564 0 0112 6.844c.85.004 1.705.115 2.504.337 1.909-1.296 2.747-1.027 2.747-1.027.546 1.379.202 2.398.1 2.651.64.7 1.028 1.595 1.028 2.688 0 3.848-2.339 4.695-4.566 4.943.359.309.678.92.678 1.855 0 1.338-.012 2.419-.012 2.747 0 .268.18.58.688.482A10.019 10.019 0 0022 12.017C22 6.484 17.522 2 12 2z" clip-rule="evenodd"/>
                                </svg>
                            </a>
                            
                            <!-- LinkedIn Link -->
                            <a href="{{ $personalInfo['linkedin_url'] ?? 'https://www.linkedin.com/in/joy-dimaculangan/' }}" 
                                class="text-gray-600 hover:text-[#774C0C] transition-colors duration-300"
                                target="_blank"
                                rel="noopener noreferrer">
                                <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                                    <path fill-rule="evenodd" d="M19 0h-14c-2.761 0-5 2.239-5 5v14c0 2.761 2.239 5 5 5h14c2.762 0 5-2.239 5-5v-14c0-2.761-2.238-5-5-5zm-11 19h-3v-11h3v11zm-1.5-12.268c-.966 0-1.75-.79-1.75-1.764s.784-1.764 1.75-1.764 1.75.79 1.75 1.764-.783 1.764-1.75 1.764zm13.5 12.268h-3v-5.604c0-3.368-4-3.113-4 0v5.604h-3v-11h3v1.765c1.396-2.586 7-2.777 7 2.476v6.759z" clip-rule="evenodd"/>
                                </svg>
                            </a>
                        </div>
                    </div>
                </div>
            </div>


            <!-- Right Photo Container -->
            <div class="relative w-[400px] h-[500px] animate-fade-in-up delay-300">
                <!-- Photo Frame -->
                <img src="{{ isset($personalInfo['profile_image']) ? asset('storage/' . $personalInfo['profile_image']) : asset('images/my-photo.png').'?v='.time() }}" 
                    alt="{{ $personalInfo['name'] ?? 'Joy R. Dimaculangan' }}" 
                    class="w-full h-full object-cover object-center scale-105"
                />
            </div>
        </div>
    </div>
</section>
@endsection