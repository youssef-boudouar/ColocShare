@props(['title', 'description' => ''])

<div class="flex flex-col items-center justify-center py-12 text-center">
    @isset($icon)
    <div class="mb-4">{{ $icon }}</div>
    @endisset
    <h3 class="text-sm font-semibold text-gray-900 mb-1">{{ $title }}</h3>
    @if($description)
    <p class="text-sm text-gray-500 max-w-xs leading-relaxed">{{ $description }}</p>
    @endif
    @isset($action)
    <div class="mt-5">{{ $action }}</div>
    @endisset
</div>
