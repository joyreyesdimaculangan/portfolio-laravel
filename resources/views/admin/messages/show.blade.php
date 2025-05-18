@extends('layouts.admin')

@section('title', 'Message Details')

@section('content')
<div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <x-admin.card>
            <div class="flex justify-between items-center mb-6">
                <h1 class="text-2xl font-semibold" @themeColor('text')>Message Detail</h1>
                <div class="flex space-x-2">
                    <x-admin.button-primary href="mailto:{{ $message->email }}?subject=Re: {{ $message->subject }}">
                        Reply by Email
                    </x-admin.button-primary>
                    <x-admin.button-secondary href="{{ route('admin.messages.index') }}">
                        Back to Messages
                    </x-admin.button-secondary>
                </div>
            </div>
            
            @if(session('success'))
                <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
                    {{ session('success') }}
                </div>
            @endif
            
            <div class="bg-gray-50 p-6 rounded-lg shadow">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <h2 class="text-lg font-semibold mb-4" @themeColor('text')>Sender Information</h2>
                        
                        <div class="mb-4">
                            <label class="block text-sm font-medium mb-1" @themeColor('text-light')>Name</label>
                            <div class="font-semibold" @themeColor('text')>{{ $message->name }}</div>
                        </div>
                        
                        <div class="mb-4">
                            <label class="block text-sm font-medium mb-1" @themeColor('text-light')>Email</label>
                            <div @themeColor('text')>
                                <a href="mailto:{{ $message->email }}" class="hover:underline" style="color: var(--color-primary, #774C0C);">{{ $message->email }}</a>
                            </div>
                        </div>
                        
                        <div class="mb-4">
                            <label class="block text-sm font-medium mb-1" @themeColor('text-light')>Phone</label>
                            <div @themeColor('text')>{{ $message->phone ?? 'Not provided' }}</div>
                        </div>
                    </div>
                    
                    <div>
                        <h2 class="text-lg font-semibold mb-4" @themeColor('text')>Message Details</h2>
                        
                        <div class="mb-4">
                            <label class="block text-sm font-medium mb-1" @themeColor('text-light')>Subject</label>
                            <div @themeColor('text')>{{ $message->subject ?: 'No Subject' }}</div>
                        </div>
                        
                        <div class="mb-4">
                            <label class="block text-sm font-medium mb-1" @themeColor('text-light')>Received</label>
                            <div @themeColor('text')>{{ $message->created_at->format('M d, Y h:i A') }}</div>
                        </div>
                        
                        <div class="mb-4">
                            <label class="block text-sm font-medium mb-1" @themeColor('text-light')>Status</label>
                            <div>
                                @if(!$message->read)
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                                        Unread
                                    </span>
                                @elseif($message->replied)
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium" style="color: var(--color-primary, #774C0C); background-color: var(--color-primary-50, #fef3c7);">
                                        Replied
                                    </span>
                                @else
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-gray-100 text-gray-800">
                                        Read
                                    </span>
                                @endif
                            </div>
                        </div>
                        
                        <div class="mt-8">
                            <div class="flex items-center">
                                <div class="flex-shrink-0">
                                    <div class="rounded-full p-2" style="background-color: var(--color-primary-50, #fef3c7);">
                                        <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg" style="color: var(--color-primary, #774C0C);">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                                        </svg>
                                    </div>
                                </div>
                                <div class="ml-3">
                                    <h3 class="text-sm font-medium" @themeColor('text')>Contact Status</h3>
                                    <p class="text-sm" @themeColor('text-light')>
                                        @if($message->replied)
                                            You've responded to this inquiry.
                                        @elseif($message->read)
                                            This message has been read but not replied to.
                                        @else
                                            This message is new and needs attention.
                                        @endif
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="mt-6">
                    <h2 class="text-lg font-semibold mb-2" @themeColor('text')>Message Content</h2>
                    <div class="prose max-w-none border rounded-lg p-4 bg-white" @themeColor('text')>
                        {!! nl2br(e($message->message)) !!}
                    </div>
                </div>
            </div>
            
            <div class="mt-6 flex justify-between">
                <div class="flex space-x-2">
                    @if(!$message->read)
                        <form action="{{ route('admin.messages.mark-as-read', $message) }}" method="POST">
                            @csrf
                            @method('PATCH')
                            <button type="submit" class="px-4 py-2 rounded-md bg-green-100 text-green-700 hover:bg-green-200">
                                Mark as Read
                            </button>
                        </form>
                    @endif
                    
                    @if(!$message->replied)
                        <form action="{{ route('admin.messages.mark-as-replied', $message) }}" method="POST">
                            @csrf
                            @method('PATCH')
                            <button type="submit" class="px-4 py-2 rounded-md" style="color: var(--color-primary, #774C0C); background-color: var(--color-primary-50, #fef3c7); hover:opacity-90">
                                Mark as Replied
                            </button>
                        </form>
                    @endif
                </div>
                
                <form action="{{ route('admin.messages.destroy', $message) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this message?')">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="px-4 py-2 bg-red-100 text-red-700 hover:bg-red-200 rounded-md">
                        Delete Message
                    </button>
                </form>
            </div>
        </x-admin.card>
    </div>
</div>
@endsection