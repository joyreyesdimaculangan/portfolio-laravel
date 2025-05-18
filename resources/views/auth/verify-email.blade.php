@extends('layouts.guest')

@section('content')
<div class="text-center mb-8">
    <h2 class="mt-6 text-3xl font-bold text-[#774C0C] font-montserrat tracking-wide">
        {{ __('Verify Email') }}
    </h2>
    <p class="mt-2 text-sm text-gray-600">
        {{ __('One more step to complete your registration.') }}
    </p>
</div>

<div class="mb-6 text-sm text-gray-600">
    {{ __('Thanks for signing up! Before getting started, could you verify your email address by clicking on the link we just emailed to you? If you didn\'t receive the email, we will gladly send you another.') }}
</div>

@if (session('status') == 'verification-link-sent')
    <div class="mb-6 p-4 bg-green-50 border border-green-100 rounded-lg">
        <p class="font-medium text-sm text-green-600">
            {{ __('A new verification link has been sent to the email address you provided during registration.') }}
        </p>
    </div>
@endif

<div class="mt-6 flex flex-col sm:flex-row items-center justify-between gap-4">
    <form method="POST" action="{{ route('verification.send') }}" class="w-full sm:w-auto">
        @csrf
        <button type="submit" class="group relative w-full sm:w-auto flex justify-center py-2.5 px-4 border border-transparent rounded-lg text-white bg-[#774C0C] hover:bg-amber-800 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-[#774C0C] shadow-sm text-sm font-semibold transition duration-300 ease-in-out">
            <span class="flex items-center">
                {{ __('Resend Verification Email') }}
            </span>
        </button>
    </form>

    <form method="POST" action="{{ route('logout') }}" class="w-full sm:w-auto">
        @csrf
        <button type="submit" class="w-full sm:w-auto text-sm text-gray-600 hover:text-[#774C0C] font-medium transition duration-300 py-2.5 px-4 rounded-lg border border-gray-200 hover:border-[#774C0C]/20 hover:bg-amber-50 flex justify-center items-center">
            <svg class="h-5 w-5 mr-2" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
            </svg>
            {{ __('Log Out') }}
        </button>
    </form>
</div>

<div class="mt-8 border-t border-gray-200 pt-6">
    <p class="text-sm text-gray-500 text-center">
        {{ __('Need assistance? Contact our support at') }} 
        <a href="mailto:support@example.com" class="text-[#774C0C] hover:text-amber-800 font-medium">
            support@example.com
        </a>
    </p>
</div>
@endsection
