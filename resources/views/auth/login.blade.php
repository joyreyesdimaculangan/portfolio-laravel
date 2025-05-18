@extends('layouts.guest')

@section('content')
<div class="text-center mb-8">
    <h2 class="mt-6 text-3xl font-bold text-[#774C0C] font-montserrat tracking-wide">
        Welcome Back
    </h2>
    <p class="mt-2 text-sm text-gray-600">
        {{ __('Please sign in to access your account.') }}
    </p>
</div>

<form method="POST" action="{{ route('login') }}" class="space-y-6">
    @csrf

    <!-- Email Address -->
    <div>
        <label for="email" class="block text-sm font-medium text-gray-700">Email</label>
        <div class="mt-1 relative">
            <input id="email" type="email" name="email" placeholder="Enter your email" value="{{ old('email') }}" required autofocus autocomplete="username" 
                   class="block w-full pl-10 pr-3 py-2.5 border border-gray-300 rounded-lg shadow-sm focus:border-[#774C0C] focus:ring focus:ring-[#774C0C]/20 focus:ring-opacity-50" />
        </div>
        @error('email')
            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
        @enderror
    </div>

    <!-- Password -->
    <div class="mt-4">
        <div class="flex items-center justify-between">
            <label for="password" class="block text-sm font-medium text-gray-700">Password</label>
            <!-- @if (Route::has('password.request'))
                <a class="text-xs font-medium text-[#774C0C] hover:text-amber-800 transition duration-300" href="{{ route('password.request') }}">
                    {{ __('Forgot password?') }}
                </a>
            @endif --->
        </div>
        <div class="mt-1 relative">
            <input id="password" type="password" name="password" placeholder="Enter password" required autocomplete="current-password"
                   class="block w-full pl-10 pr-3 py-2.5 border border-gray-300 rounded-lg shadow-sm focus:border-[#774C0C] focus:ring focus:ring-[#774C0C]/20 focus:ring-opacity-50" />
        </div>
        @error('password')
            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
        @enderror
    </div>

    <!-- Remember Me -->
    <!-- <div class="block mt-4">
        <label for="remember_me" class="inline-flex items-center">
            <input id="remember_me" type="checkbox" name="remember" class="rounded border-gray-300 text-[#774C0C] shadow-sm focus:border-[#774C0C] focus:ring focus:ring-[#774C0C]/20 focus:ring-opacity-50">
            <span class="ml-2 text-sm text-gray-600">{{ __('Remember me') }}</span>
        </label>
    </div> -->

    <div class="mt-6">
        <button type="submit" class="group relative w-full flex justify-center py-2.5 px-4 border border-transparent rounded-lg text-white bg-[#774C0C] hover:bg-amber-800 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-[#774C0C] shadow-sm text-sm font-semibold transition duration-300 ease-in-out">
            <span class="absolute left-0 inset-y-0 flex items-center pl-3">
                
            </span>
            {{ __('Sign in') }}
        </button>
    </div>
    
    <div class="mt-6 flex justify-center">
        <div class="text-sm">
            <span class="text-gray-600">Don't have an account?</span>
            <a href="{{ route('register') }}" class="font-medium text-[#774C0C] hover:text-amber-800 ml-2 transition duration-300">
                Register now
            </a>
        </div>
    </div>
</form>
@endsection
