@props(['id', 'title'])

<div id="{{ $id }}" class="modal">
    {{-- Backdrop (click to close) --}}
    <a href="#" class="absolute inset-0" aria-label="Fermer"></a>
    {{-- Modal box --}}
    <div class="relative z-10 bg-white rounded-2xl shadow-xl w-full max-w-lg p-6 max-h-[90vh] overflow-y-auto">
        <div class="flex items-center justify-between mb-5">
            <h3 class="text-lg font-semibold text-gray-900">{{ $title }}</h3>
            <a href="#" class="p-1.5 rounded-lg hover:bg-gray-100 text-gray-400 hover:text-gray-600 transition-colors">
                <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                </svg>
            </a>
        </div>
        {{ $slot }}
    </div>
</div>
