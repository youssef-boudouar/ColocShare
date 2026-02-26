<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'ClocShare') }}</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="antialiased bg-white">

<div class="min-h-screen flex">

    {{-- Left panel — image + branding (desktop only) --}}
    <div class="hidden lg:flex lg:w-1/2 relative items-end justify-start p-12 flex-col"
         style="background: url('https://images.unsplash.com/photo-1502672260266-1c1ef2d93688?w=1920&q=80') center/cover no-repeat;">
        <div class="absolute inset-0 bg-gray-900/75"></div>
        <div class="relative z-10 w-full max-w-md mr-auto">
            <a href="/" class="inline-block text-2xl font-bold text-white mb-12 tracking-tight">ClocShare</a>
            <h1 class="text-4xl font-bold text-white leading-tight mb-4">
                Gérez vos dépenses<br>de colocation
                <span class="text-emerald-400"> intelligemment</span>
            </h1>
            <p class="text-gray-300 text-base leading-relaxed mb-10">
                Partagez les frais, suivez les dettes et réglez les comptes facilement avec vos colocataires.
            </p>
            <div class="space-y-3">
                @foreach(['Suivi des dépenses en temps réel', 'Calcul automatique des soldes', 'Règlements simplifiés entre membres', 'Invitez vos colocataires par email'] as $f)
                <div class="flex items-center gap-3">
                    <div class="w-5 h-5 rounded-full bg-emerald-500/25 border border-emerald-500/40 flex items-center justify-center flex-shrink-0">
                        <svg class="w-2.5 h-2.5 text-emerald-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"/>
                        </svg>
                    </div>
                    <span class="text-gray-300 text-sm">{{ $f }}</span>
                </div>
                @endforeach
            </div>
        </div>
    </div>

    {{-- Right panel — auth form --}}
    <div class="w-full lg:w-1/2 flex items-center justify-center p-6 sm:p-12 bg-white">
        <div class="w-full max-w-sm animate-fade-in-up">
            {{-- Mobile logo --}}
            <div class="flex items-center justify-center mb-8 lg:hidden">
                <a href="/" class="text-xl font-bold text-gray-900">ClocShare</a>
            </div>
            {{ $slot }}
        </div>
    </div>

</div>

</body>
</html>
