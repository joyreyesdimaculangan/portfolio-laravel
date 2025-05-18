@props(['href' => null, 'type' => 'button'])

@if($href)
    <a href="{{ $href }}" {{ $attributes->merge(['class' => 'px-4 py-2 rounded-md hover:opacity-90 inline-flex items-center']) }} 
       style="color: var(--color-primary); background-color: var(--color-primary-50); transition-duration: var(--transition-speed);">
        {{ $slot }}
    </a>
@else
    <button type="{{ $type }}" {{ $attributes->merge(['class' => 'px-4 py-2 rounded-md hover:opacity-90 inline-flex items-center']) }} 
            style="color: var(--color-primary); background-color: var(--color-primary-50); transition-duration: var(--transition-speed);">
        {{ $slot }}
    </button>
@endif