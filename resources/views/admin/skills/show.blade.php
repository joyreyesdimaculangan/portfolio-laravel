@extends('layouts.admin')

@section('title', 'Skill Details')

@section('content')
<div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <x-admin.card>
            <div class="flex justify-between items-center mb-6">
                <h1 class="text-2xl font-semibold" @themeColor('text')>Skill Details</h1>
                <div class="flex space-x-2">
                    <x-admin.button-primary href="{{ route('admin.skills.edit', $skill) }}">
                        Edit Skill
                    </x-admin.button-primary>
                    <x-admin.button-secondary href="{{ route('admin.skills.index') }}">
                        Back to Skills
                    </x-admin.button-secondary>
                </div>
            </div>

            <div class="bg-gray-50 p-6 rounded-lg shadow">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <h2 class="text-lg font-semibold mb-4" @themeColor('text')>Skill Information</h2>
                        
                        <div class="mb-4">
                            <label class="block text-sm font-medium mb-1" @themeColor('text-light')>Name</label>
                            <div class="font-semibold" @themeColor('text')>{{ $skill->name }}</div>
                        </div>
                        
                        <div class="mb-4">
                            <label class="block text-sm font-medium mb-1" @themeColor('text-light')>Category</label>
                            <div @themeColor('text')>{{ $skill->category ?? 'Not categorized' }}</div>
                        </div>

                        <div class="mb-4">
                            <label class="block text-sm font-medium mb-1" @themeColor('text-light')>Order</label>
                            <div @themeColor('text')>{{ $skill->order }}</div>
                        </div>
                    </div>
                    
                    <div>
                        <h2 class="text-lg font-semibold mb-4" @themeColor('text')>Proficiency</h2>
                        
                        <div class="mb-4">
                            <div class="w-full bg-gray-200 rounded-full h-4 mb-1">
                                <div class="h-4 rounded-full" 
                                     style="width: {{ $skill->proficiency }}%; background-color: var(--color-primary, #774C0C);">
                                </div>
                            </div>
                            <div class="text-right text-sm" @themeColor('text-light')>{{ $skill->proficiency }}%</div>
                        </div>
                    </div>
                </div>
            </div>
        </x-admin.card>
    </div>
</div>
@endsection