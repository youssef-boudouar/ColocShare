<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ $title ?? 'ClocShare' }}</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-white text-gray-900 antialiased">

{{-- ===== NAVBAR ===== --}}
<header class="sticky top-0 z-40 bg-white border-b border-gray-200">

    {{-- Mobile menu checkbox (must be first child of header to be a sibling of the mobile panel) --}}
    <input type="checkbox" id="menu-toggle" class="sr-only peer">

    {{-- Navbar row --}}
    <div class="max-w-5xl mx-auto px-4 sm:px-6">
        <div class="flex items-center justify-between h-16 gap-6">

            {{-- Logo --}}
            <a href="{{ route('dashboard') }}" class="text-lg font-bold text-gray-900 tracking-tight flex-shrink-0 select-none">
                ClocShare
            </a>

            {{-- Center nav (desktop only) --}}
            @php
                $activeColocation = auth()->user()?->colocations()->where('status','active')->first();
            @endphp
            <nav class="hidden md:flex items-center gap-7 flex-1 justify-center">
                <x-nav-link href="{{ route('dashboard') }}" :active="request()->routeIs('dashboard')">
                    Tableau de bord
                </x-nav-link>
                <x-nav-link href="{{ $activeColocation ? route('colocations.show', $activeColocation) : route('colocations.create') }}" :active="request()->routeIs('colocations.*')">
                    Ma Colocation
                </x-nav-link>
                <x-nav-link href="#" :active="false">Dépenses</x-nav-link>
                <x-nav-link href="#" :active="false">Soldes</x-nav-link>
                <x-nav-link href="#" :active="false">Règlements</x-nav-link>
                @if(auth()->user()->is_admin)
                <x-nav-link href="#" :active="request()->routeIs('admin.*')" class="text-amber-600">
                    Administration
                </x-nav-link>
                @endif
            </nav>

            {{-- Right side --}}
            <div class="flex items-center gap-2 flex-shrink-0">

                {{-- User dropdown (<details> CSS-only, desktop) --}}
                <details class="relative hidden md:block">
                    <summary class="flex items-center gap-2 px-2 py-1.5 rounded-lg hover:bg-gray-50 transition-colors cursor-pointer select-none outline-none">
                        <div class="w-8 h-8 rounded-full bg-emerald-100 flex items-center justify-center text-emerald-700 text-sm font-semibold flex-shrink-0">
                            {{ strtoupper(substr(Auth::user()->name ?? 'U', 0, 1)) }}
                        </div>
                        <span class="text-sm font-medium text-gray-700 max-w-[120px] truncate">{{ Auth::user()->name ?? '' }}</span>
                        <svg class="w-3.5 h-3.5 text-gray-400 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                        </svg>
                    </summary>
                    <div class="absolute right-0 top-full mt-2 w-56 bg-white border border-gray-200 rounded-xl shadow-lg py-1.5 z-50">
                        <div class="px-4 py-2.5 border-b border-gray-100 mb-1">
                            <p class="text-xs font-semibold text-gray-900 truncate">{{ Auth::user()->name ?? '' }}</p>
                            <p class="text-xs text-gray-400 truncate mt-0.5">{{ Auth::user()->email ?? '' }}</p>
                        </div>
                        <a href="{{ route('profile.edit') }}" class="flex items-center gap-2.5 px-4 py-2 text-sm text-gray-700 hover:bg-gray-50 transition-colors">
                            <svg class="w-4 h-4 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                            </svg>
                            Mon profil
                        </a>
                        <div class="h-px bg-gray-100 my-1 mx-3"></div>
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit" class="w-full flex items-center gap-2.5 px-4 py-2 text-sm text-red-600 hover:bg-red-50 transition-colors">
                                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/>
                                </svg>
                                Se déconnecter
                            </button>
                        </form>
                    </div>
                </details>

                {{-- Hamburger label (mobile) --}}
                <label for="menu-toggle" class="md:hidden p-2 rounded-lg hover:bg-gray-100 cursor-pointer transition-colors">
                    <svg class="w-5 h-5 text-gray-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/>
                    </svg>
                </label>
            </div>
        </div>
    </div>

    {{-- Mobile menu panel (peer-checked:block when checkbox checked) --}}
    <div class="hidden peer-checked:block md:!hidden border-t border-gray-100">
        <div class="max-w-5xl mx-auto px-4 sm:px-6 py-3 space-y-0.5">
            <a href="{{ route('dashboard') }}" class="block px-3 py-2.5 text-sm font-medium rounded-xl {{ request()->routeIs('dashboard') ? 'bg-emerald-50 text-emerald-700' : 'text-gray-600 hover:bg-gray-50' }}">Tableau de bord</a>
            <a href="{{ $activeColocation ? route('colocations.show', $activeColocation) : route('colocations.create') }}" class="block px-3 py-2.5 text-sm font-medium rounded-xl {{ request()->routeIs('colocations.*') ? 'bg-emerald-50 text-emerald-700' : 'text-gray-600 hover:bg-gray-50' }}">Ma Colocation</a>
            <a href="#" class="block px-3 py-2.5 text-sm font-medium rounded-xl text-gray-600 hover:bg-gray-50">Dépenses</a>
            <a href="#" class="block px-3 py-2.5 text-sm font-medium rounded-xl text-gray-600 hover:bg-gray-50">Soldes</a>
            <a href="#" class="block px-3 py-2.5 text-sm font-medium rounded-xl text-gray-600 hover:bg-gray-50">Règlements</a>
            @if(auth()->user()->is_admin)
            <a href="#" class="block px-3 py-2.5 text-sm font-medium rounded-xl text-amber-600 hover:bg-amber-50">Administration</a>
            @endif
            <div class="h-px bg-gray-100 my-2"></div>
            <a href="{{ route('profile.edit') }}" class="block px-3 py-2.5 text-sm font-medium rounded-xl text-gray-600 hover:bg-gray-50">Mon profil</a>
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="w-full text-left px-3 py-2.5 text-sm font-medium rounded-xl text-red-600 hover:bg-red-50">Se déconnecter</button>
            </form>
        </div>
    </div>

</header>

{{-- Flash messages --}}
@if(session('success'))
<div class="fixed top-20 right-4 z-50 max-w-sm animate-fade-in-up">
    <div class="bg-emerald-50 border border-emerald-200 text-emerald-800 text-sm px-4 py-3 rounded-xl shadow-md flex items-center gap-2.5">
        <svg class="w-4 h-4 text-emerald-500 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
        </svg>
        {{ session('success') }}
    </div>
</div>
@endif
@if(session('error'))
<div class="fixed top-20 right-4 z-50 max-w-sm animate-fade-in-up">
    <div class="bg-red-50 border border-red-200 text-red-800 text-sm px-4 py-3 rounded-xl shadow-md flex items-center gap-2.5">
        <svg class="w-4 h-4 text-red-500 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
        </svg>
        {{ session('error') }}
    </div>
</div>
@endif

{{-- Main content --}}
<main class="max-w-5xl mx-auto px-4 sm:px-6 py-10 animate-fade-in-up">
    {{ $slot }}
</main>

</body>
</html>
