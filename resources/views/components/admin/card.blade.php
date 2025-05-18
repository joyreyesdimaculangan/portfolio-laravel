@props(['title' => null])

<div {{ $attributes->merge(['class' => 'bg-white overflow-hidden shadow-md rounded-lg']) }}>
    @if($title)
        <div class="border-b border-gray-200 px-6 py-4 flex justify-between items-center">
            <h3 class="text-lg font-medium" style="color: var(--color-text);">{{ $title }}</h3>
            @if(isset($titleRight))
                <div>{{ $titleRight }}</div>
            @endif
        </div>
    @endif
    <div class="p-6">
        {{ $slot }}
    </div>
</div>