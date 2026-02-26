@props(['value', 'label', 'icon' => ''])

<div class="bg-white border border-gray-200 rounded-xl p-5 hover:shadow-sm transition-shadow">
    <div class="flex items-center justify-between mb-3">
        <span class="text-xs font-semibold text-gray-500 uppercase tracking-wider">{{ $label }}</span>
        @if($icon)
        <div class="w-8 h-8 bg-gray-50 rounded-lg flex items-center justify-center text-gray-400">
            {!! $icon !!}
        </div>
        @endif
    </div>
    <p class="text-2xl font-bold text-gray-900">{{ $value }}</p>
</div>
