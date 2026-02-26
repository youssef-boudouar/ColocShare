@props(['variant' => 'neutral'])

@php
$variants = [
    'success' => 'bg-emerald-50 text-emerald-700 border border-emerald-200',
    'warning' => 'bg-amber-50 text-amber-700 border border-amber-200',
    'danger'  => 'bg-red-50 text-red-700 border border-red-200',
    'info'    => 'bg-sky-50 text-sky-700 border border-sky-200',
    'owner'   => 'bg-violet-50 text-violet-700 border border-violet-200',
    'member'  => 'bg-gray-100 text-gray-600 border border-gray-200',
    'neutral' => 'bg-gray-100 text-gray-600 border border-gray-200',
];
$cls = $variants[$variant] ?? $variants['neutral'];
@endphp

<span class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-semibold {{ $cls }}">
    {{ $slot }}
</span>
