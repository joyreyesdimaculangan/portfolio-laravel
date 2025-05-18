@extends('layouts.guest')

@section('content')
<div class="text-center mb-8">
    <h2 class="mt-6 text-3xl font-bold text-[#774C0C] font-montserrat tracking-wide">
        Create Account
    </h2>
    <p class="mt-2 text-sm text-gray-600">
        {{ __('Sign up to get started with your new account.') }}
    </p>
</div>

<form method="POST" action="{{ route('register') }}" class="space-y-6">
    @csrf

    <!-- Name -->
    <div>
        <label for="name" class="block text-sm font-medium text-gray-700">{{ __('Name') }}</label>
        <div class="mt-1 relative">
            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none"></div>
            <input id="name" type="text" name="name" placeholder="Enter your full name" value="{{ old('name') }}" required autofocus autocomplete="name"
                   class="block w-full pl-10 pr-3 py-2.5 border border-gray-300 rounded-lg shadow-sm focus:border-[#774C0C] focus:ring focus:ring-[#774C0C]/20 focus:ring-opacity-50" />
        </div>
        @error('name')
            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
        @enderror
    </div>

    <!-- Email Address -->
    <div class="mt-4">
        <label for="email" class="block text-sm font-medium text-gray-700">{{ __('Email') }}</label>
        <div class="mt-1 relative">
            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none"></div>
            <input id="email" type="email" name="email" placeholder="Enter your email address" value="{{ old('email') }}" required autocomplete="username"
                   class="block w-full pl-10 pr-3 py-2.5 border border-gray-300 rounded-lg shadow-sm focus:border-[#774C0C] focus:ring focus:ring-[#774C0C]/20 focus:ring-opacity-50" />
        </div>
        @error('email')
            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
        @enderror
    </div>

    <!-- Password -->
    <div class="mt-4">
        <label for="password" class="block text-sm font-medium text-gray-700">{{ __('Password') }}</label>
        <div class="mt-1 relative">
            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none"></div>
            <input id="password" type="password" name="password" placeholder="Create a secure password" required autocomplete="new-password"
                   class="block w-full pl-10 pr-3 py-2.5 border border-gray-300 rounded-lg shadow-sm focus:border-[#774C0C] focus:ring focus:ring-[#774C0C]/20 focus:ring-opacity-50" />
        </div>
        @error('password')
            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
        @enderror
    </div>

    <!-- Confirm Password -->
    <div class="mt-4">
        <label for="password_confirmation" class="block text-sm font-medium text-gray-700">{{ __('Confirm Password') }}</label>
        <div class="mt-1 relative">
            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none"></div>
            <input id="password_confirmation" type="password" name="password_confirmation" placeholder="Confirm your password" required autocomplete="new-password"
                   class="block w-full pl-10 pr-3 py-2.5 border border-gray-300 rounded-lg shadow-sm focus:border-[#774C0C] focus:ring focus:ring-[#774C0C]/20 focus:ring-opacity-50" />
        </div>
        @error('password_confirmation')
            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
        @enderror
    </div>

    <div class="mt-6">
        <button type="submit" class="group relative w-full flex justify-center py-2.5 px-4 border border-transparent rounded-lg text-white bg-[#774C0C] hover:bg-amber-800 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-[#774C0C] shadow-sm text-sm font-semibold transition duration-300 ease-in-out">
            <span class="absolute left-0 inset-y-0 flex items-center pl-3"></span>
            {{ __('Register') }}
        </button>
    </div>
    
    <div class="mt-6 flex justify-center">
        <div class="text-sm">
            <span class="text-gray-600">Already have an account?</span>
            <a href="{{ route('login') }}" class="font-medium text-[#774C0C] hover:text-amber-800 ml-2 transition duration-300">
                Login instead
            </a>
        </div>
    </div>
</form>
@endsection
