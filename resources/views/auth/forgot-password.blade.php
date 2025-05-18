@extends('layouts.guest')

@section('content')
<div class="text-center mb-8">
    <h2 class="mt-6 text-3xl font-bold text-[#774C0C] font-montserrat tracking-wide">
        {{ __('Forgot Password') }}
    </h2>
    <p class="mt-2 text-sm text-gray-600">
        {{ __('Enter your email address and we will send you a password reset link.') }}
    </p>
</div>

<!-- Session Status -->
@if (session('status'))
    <div class="mb-6 p-4 bg-green-50 border border-green-100 rounded-lg">
        <p class="font-medium text-sm text-green-600">
            {{ session('status') }}
        </p>
    </div>
@endif

<form method="POST" action="{{ route('password.email') }}" class="space-y-6">
    @csrf

    <!-- Email Address -->
    <div>
        <label for="email" class="block text-sm font-medium text-gray-700">{{ __('Email') }}</label>
        <div class="mt-1 relative">
            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none"></div>
            <input id="email" type="email" name="email" placeholder="Enter your email address" value="{{ old('email') }}" required autofocus
                   class="block w-full pl-10 pr-3 py-2.5 border border-gray-300 rounded-lg shadow-sm focus:border-[#774C0C] focus:ring focus:ring-[#774C0C]/20 focus:ring-opacity-50" />
        </div>
        @error('email')
            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
        @enderror
    </div>

    <div class="mt-6">
        <button type="submit" class="group relative w-full flex justify-center py-2.5 px-4 border border-transparent rounded-lg text-white bg-[#774C0C] hover:bg-amber-800 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-[#774C0C] shadow-sm text-sm font-semibold transition duration-300 ease-in-out">
            <span class="absolute left-0 inset-y-0 flex items-center pl-3"></span>
            {{ __('Email Password Reset Link') }}
        </button>
    </div>
    
    <div class="mt-6 flex justify-center">
        <div class="text-sm">
            <span class="text-gray-600">Remember your password?</span>
            <a href="{{ route('login') }}" class="font-medium text-[#774C0C] hover:text-amber-800 ml-2 transition duration-300">
                Back to login
            </a>
        </div>
    </div>
</form>
@endsection
