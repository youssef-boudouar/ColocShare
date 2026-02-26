@props(['name', 'size' => 'md'])

@php
$sizes = [
    'xs' => 'w-5 h-5 text-[0.5rem]',
    'sm' => 'w-7 h-7 text-xs',
    'md' => 'w-9 h-9 text-sm',
    'lg' => 'w-11 h-11 text-base',
];
$cls = $sizes[$size] ?? $sizes['md'];

$colors = [
    'A'=>'bg-red-100 text-red-700',    'B'=>'bg-orange-100 text-orange-700',
    'C'=>'bg-amber-100 text-amber-700', 'D'=>'bg-yellow-100 text-yellow-700',
    'E'=>'bg-lime-100 text-lime-700',   'F'=>'bg-green-100 text-green-700',
    'G'=>'bg-emerald-100 text-emerald-700', 'H'=>'bg-teal-100 text-teal-700',
    'I'=>'bg-cyan-100 text-cyan-700',   'J'=>'bg-sky-100 text-sky-700',
    'K'=>'bg-blue-100 text-blue-700',   'L'=>'bg-indigo-100 text-indigo-700',
    'M'=>'bg-violet-100 text-violet-700', 'N'=>'bg-purple-100 text-purple-700',
    'O'=>'bg-fuchsia-100 text-fuchsia-700','P'=>'bg-pink-100 text-pink-700',
    'Q'=>'bg-rose-100 text-rose-700',   'R'=>'bg-red-100 text-red-700',
    'S'=>'bg-orange-100 text-orange-700','T'=>'bg-amber-100 text-amber-700',
    'U'=>'bg-emerald-100 text-emerald-700','V'=>'bg-teal-100 text-teal-700',
    'W'=>'bg-sky-100 text-sky-700',     'X'=>'bg-blue-100 text-blue-700',
    'Y'=>'bg-indigo-100 text-indigo-700','Z'=>'bg-purple-100 text-purple-700',
];
$initial = strtoupper(substr($name ?? '?', 0, 1));
$color = $colors[$initial] ?? 'bg-gray-100 text-gray-700';
@endphp

<div class="rounded-full flex items-center justify-center font-semibold flex-shrink-0 {{ $cls }} {{ $color }}">
    {{ $initial }}
</div>
