<nav class="py-4 shadow-xl bg-white/95 sticky top-0 z-50 backdrop-blur-sm">
    <div class="max-w-8xl flex flex-wrap items-center justify-between mx-auto px-4 md:px-8">
        {{-- Logo and Brand Name --}}
        <a href="{{ route('home') }}" class="flex items-center space-x-6 rtl:space-x-reverse transition-all duration-300 hover:scale-105">
            <img src="{{ asset('images/my-logo.png') }}" 
                class="h-12 hover:rotate-6 transition-transform duration-300" 
                alt="Logo" />
                <span class="hidden md:block self-center text-sm font-semibold whitespace-nowrap text-black hover:text-[#774C0C] 
                transition-colors duration-300 font-merriweather tracking-wide">
                    sharing positive energy with a smile
                </span>
        </a>

        {{-- Mobile Menu Button --}}
        <button data-collapse-toggle="navbar-default" 
                type="button" 
                class="inline-flex items-center p-4 w-16 h-16 justify-center text-sm text-black 
                       rounded-lg md:hidden hover:bg-gray-100 focus:outline-none focus:ring-2 
                       focus:ring-blue-500 transition-all duration-300" 
                aria-controls="navbar-default" 
                aria-expanded="false">
            <span class="sr-only">Open main menu</span>
            <svg class="w-6 h-6" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 17 14">
                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M1 1h15M1 7h15M1 13h15"/>
            </svg>
        </button>

        <div class="hidden w-full md:block md:w-auto" id="navbar-default">
            <ul class="font-medium text-lg flex flex-col p-4 md:p-0 mt-4 
                    rounded-lg md:flex-row md:items-center md:space-x-12 rtl:space-x-reverse md:mt-0">
                {{-- Main Navigation Links --}}
                @foreach(['home' => 'Home', 'about' => 'About', 'projects' => 'Projects', 'contact' => 'Contact'] as $route => $label)
                    <li>
                        <a href="{{ route($route) }}" 
                        class="block py-2 px-3 relative transition-all duration-300 ease-in-out text-black
                                {{ request()->routeIs($route) 
                                    ? 'text-[#774C0C] font-bold after:absolute after:bottom-0 
                                    after:left-0 after:w-full after:h-0.5 after:bg-[#774C0C] 
                                    after:transition-transform after:duration-300 after:transform 
                                    after:opacity-100' 
                                    : 'hover:text-[#774C0C]' }}"
                        aria-current="{{ request()->routeIs($route) ? 'page' : 'false' }}">
                            {{ $label }}
                        </a>
                    </li>
                @endforeach
        
                {{-- Authentication Links --}}
                @auth
                    <li class="relative group md:ml-auto">
                        <button id="userDropdownBtn" type="button" class="flex items-center px-3 py-2 md:py-1.5 rounded-full bg-amber-50 hover:bg-amber-100 text-[#774C0C] transition-all duration-300 border border-amber-200 hover:border-amber-300 shadow-sm">
                            {{-- User Name --}}
                            <span class="truncate max-w-[80px] md:max-w-[120px] lg:max-w-none font-medium">{{ Auth::user()->name }}</span>
                            {{-- Dropdown Arrow --}}
                            <svg class="w-4 h-4 ml-2 flex-shrink-0 transition-transform duration-300 group-hover:rotate-180" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                            </svg>
                        </button>
                        
                        <div id="userDropdownMenu" class="absolute right-0 mt-2 w-64 bg-white rounded-xl shadow-xl py-2 z-50 hidden border border-gray-100 overflow-hidden transform transition-all duration-200 origin-top-right ease-out">
                            {{-- User Header --}}
                            <div class="px-4 py-3 border-b border-gray-100 bg-gray-50">
                                <p class="text-xs text-gray-500">Signed in as</p>
                                <p class="text-sm font-medium text-gray-900 truncate">{{ Auth::user()->email }}</p>
                            </div>
                            
                            {{-- Menu Items with Icons --}}
                            <div class="py-1">
                                <a href="{{ route('admin.dashboard') }}" class="flex items-center px-4 py-2.5 text-sm text-gray-700 hover:bg-amber-50 hover:text-[#774C0C] group">
                                    <svg class="w-5 h-5 mr-3 text-gray-400 group-hover:text-[#774C0C]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path>
                                    </svg>
                                    Dashboard
                                </a>
                            </div>
                            
                            {{-- Logout --}}
                            <div class="py-1 border-t border-gray-100">
                                <form method="POST" action="{{ route('logout') }}">
                                    @csrf
                                    <button type="submit" class="flex w-full items-center px-4 py-2.5 text-sm text-red-600 hover:bg-red-50 group">
                                        <svg class="w-5 h-5 mr-3 text-red-400 group-hover:text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path>
                                        </svg>
                                        Log Out
                                    </button>
                                </form>
                            </div>
                        </div>
                    </li>
                @else
                    <li class="relative group md:ml-auto flex items-center space-x-3">
                        {{-- Login Button --}}
                        <a href="{{ route('login') }}" class="flex items-center px-4 py-2 text-sm font-medium text-[#774C0C] hover:text-white hover:bg-[#774C0C] transition-all duration-300 border border-[#774C0C] rounded-md">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h7a3 3 0 013 3v1"></path>
                            </svg>
                            Login
                        </a>
                        
                        @if (Route::has('register'))
                            {{-- Register Button --}}
                            <a href="{{ route('register') }}" class="flex items-center px-4 py-2 text-sm font-medium rounded-md bg-[#774C0C] text-white hover:bg-amber-800 transition-all duration-300 shadow-sm">
                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z"></path>
                                </svg>
                                Register
                            </a>
                        @endif
                    </li>
                @endauth
            </ul>
        </div>
    </div>
</nav>


<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Improved dropdown functionality using pure Tailwind classes
        const userDropdownBtn = document.getElementById('userDropdownBtn');
        const userDropdownMenu = document.getElementById('userDropdownMenu');
        
        if (userDropdownBtn && userDropdownMenu) {
            let userDropdownTimeout;
            
            // Toggle function with Tailwind-only classes
            const toggleUserDropdown = (show) => {
                if (show) {
                    // Make visible first
                    userDropdownMenu.classList.remove('hidden');
                    
                    // Force browser to recognize the element is visible before animating
                    setTimeout(() => {
                        userDropdownMenu.classList.remove('opacity-0', 'scale-95'); 
                        userDropdownMenu.classList.add('opacity-100', 'scale-100');
                    }, 5);
                } else {
                    userDropdownMenu.classList.remove('opacity-100', 'scale-100');
                    userDropdownMenu.classList.add('opacity-0', 'scale-95');
                    
                    setTimeout(() => {
                        userDropdownMenu.classList.add('hidden');
                    }, 200);
                }
            };
            
            // Initially add Tailwind classes that aren't in the HTML
            // We'll do this with JavaScript to avoid having to modify the blade template
            userDropdownMenu.classList.add('transition-all', 'duration-200', 'ease-out', 
                                           'opacity-0', 'scale-95');
            
            // Show/hide on click with animation
            userDropdownBtn.addEventListener('click', function(e) {
                e.preventDefault();
                e.stopPropagation();
                
                const isHidden = userDropdownMenu.classList.contains('hidden');
                toggleUserDropdown(isHidden);
            });
            
            // Remaining event listeners unchanged
            userDropdownBtn.parentElement.addEventListener('mouseenter', function() {
                if (window.innerWidth >= 768) {
                    clearTimeout(userDropdownTimeout);
                    toggleUserDropdown(true);
                }
            });
            
            userDropdownBtn.parentElement.addEventListener('mouseleave', function() {
                if (window.innerWidth >= 768) {
                    userDropdownTimeout = setTimeout(() => {
                        if (!isMouseOverElement(userDropdownMenu)) {
                            toggleUserDropdown(false);
                        }
                    }, 300);
                }
            });
            
            userDropdownMenu.addEventListener('mouseenter', function() {
                if (window.innerWidth >= 768) {
                    clearTimeout(userDropdownTimeout);
                }
            });
            
            userDropdownMenu.addEventListener('mouseleave', function() {
                if (window.innerWidth >= 768) {
                    userDropdownTimeout = setTimeout(() => {
                        toggleUserDropdown(false);
                    }, 300);
                }
            });
            
            document.addEventListener('click', function(e) {
                if (!userDropdownBtn.contains(e.target) && 
                    !userDropdownMenu.contains(e.target) &&
                    !userDropdownMenu.classList.contains('hidden')) {
                    toggleUserDropdown(false);
                }
            });
            
            document.addEventListener('keydown', function(e) {
                if (e.key === 'Escape' && 
                    !userDropdownMenu.classList.contains('hidden')) {
                    toggleUserDropdown(false);
                }
            });
        }
        
        function isMouseOverElement(element) {
            if (!element) return false;
            
            try {
                const rect = element.getBoundingClientRect();
                const mouseX = event ? event.clientX : 0;
                const mouseY = event ? event.clientY : 0;
                
                return (
                    mouseX >= rect.left &&
                    mouseX <= rect.right &&
                    mouseY >= rect.top &&
                    mouseY <= rect.bottom
                );
            } catch (error) {
                return false;
            }
        }
    });
</script>