<x-app-layout>
    <x-slot name="title">Administration — ClocShare</x-slot>

    {{-- Header --}}
    <div class="mb-8">
        <h1 class="text-2xl font-bold text-gray-900">Administration</h1>
        <p class="text-gray-500 text-sm mt-1">Vue d'ensemble de la plateforme ClocShare.</p>
    </div>

    {{-- Stats --}}
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 mb-8">
        <x-stat-card
            :value="$stats['users_count'] ?? 0"
            label="Utilisateurs"
            icon='<svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.75" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"/></svg>'
        />
        <x-stat-card
            :value="$stats['colocations_count'] ?? 0"
            label="Colocations actives"
            icon='<svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.75" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/></svg>'
        />
        <x-stat-card
            :value="$stats['expenses_count'] ?? 0"
            label="Dépenses totales"
            icon='<svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.75" d="M9 14l6-6m-5.5.5h.01m4.99 5h.01M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16l3.5-2 3.5 2 3.5-2 3.5 2z"/></svg>'
        />
        <x-stat-card
            :value="isset($stats['total_amount']) ? number_format($stats['total_amount'], 2, ',', ' ') . ' DH' : '0,00 DH'"
            label="Volume financier"
            icon='<svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.75" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>'
        />
    </div>

    {{-- Banned users alert (only shown when there are banned users) --}}
    @if(($stats['banned_count'] ?? 0) > 0)
    <div class="flex items-center gap-3 bg-red-50 border border-red-200 rounded-2xl px-5 py-4 mb-6">
        <svg class="w-5 h-5 text-red-500 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.75" d="M18.364 18.364A9 9 0 005.636 5.636m12.728 12.728A9 9 0 015.636 5.636m12.728 12.728L5.636 5.636"/>
        </svg>
        <p class="text-sm font-semibold text-red-700">
            {{ $stats['banned_count'] }} utilisateur(s) banni(s) sur la plateforme.
        </p>
    </div>
    @endif

    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">

        {{-- Recent users --}}
        <div class="bg-white border border-gray-200 rounded-2xl overflow-hidden">
            <div class="flex items-center justify-between px-6 py-4 border-b border-gray-100">
                <h2 class="font-semibold text-gray-900">Utilisateurs récents</h2>
                <span class="text-xs text-gray-400">{{ $stats['users_count'] ?? 0 }} au total</span>
            </div>

            @if(!isset($users) || $users->isEmpty())
            <div class="p-10 text-center">
                <p class="text-sm text-gray-400">Aucun utilisateur.</p>
            </div>
            @else
            <div class="divide-y divide-gray-50">
                @foreach($users->take(8) as $user)
                <div class="flex items-center gap-3 px-6 py-3.5 stagger-item">
                    <x-avatar :name="$user->name" size="sm"/>
                    <div class="flex-1 min-w-0">
                        <div class="flex items-center gap-2 flex-wrap">
                            <p class="text-sm font-medium text-gray-900 truncate">{{ $user->name }}</p>
                            @if($user->is_admin)
                            <x-badge variant="info">Admin</x-badge>
                            @endif
                            @if($user->is_banned)
                            <x-badge variant="danger">Banni</x-badge>
                            @endif
                        </div>
                        <p class="text-xs text-gray-400 truncate">{{ $user->email }}</p>
                    </div>
                    <div class="flex items-center gap-2 flex-shrink-0">
                        <span class="text-xs text-gray-400 whitespace-nowrap hidden sm:inline">
                            {{ $user->created_at->diffForHumans() }}
                        </span>
                        @if(!$user->is_admin)
                        @if($user->is_banned)
                        <form method="POST" action="#" class="inline">
                            @csrf
                            @method('PATCH')
                            <button type="submit" title="Débannir"
                                    class="inline-flex items-center gap-1 text-xs font-semibold text-emerald-600 hover:text-emerald-700 px-2.5 py-1.5 rounded-lg hover:bg-emerald-50 transition-colors border border-emerald-200">
                                <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                </svg>
                                Débannir
                            </button>
                        </form>
                        @else
                        <form method="POST" action="#" class="inline"
                              onsubmit="return confirm('Bannir {{ addslashes($user->name) }} ?')">
                            @csrf
                            @method('PATCH')
                            <button type="submit" title="Bannir"
                                    class="inline-flex items-center gap-1 text-xs font-semibold text-red-500 hover:text-red-600 px-2.5 py-1.5 rounded-lg hover:bg-red-50 transition-colors border border-red-200">
                                <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18.364 18.364A9 9 0 005.636 5.636m12.728 12.728A9 9 0 015.636 5.636m12.728 12.728L5.636 5.636"/>
                                </svg>
                                Bannir
                            </button>
                        </form>
                        @endif
                        @endif
                    </div>
                </div>
                @endforeach
            </div>
            @endif
        </div>

        {{-- Active colocations --}}
        <div class="bg-white border border-gray-200 rounded-2xl overflow-hidden">
            <div class="flex items-center justify-between px-6 py-4 border-b border-gray-100">
                <h2 class="font-semibold text-gray-900">Colocations actives</h2>
                <span class="text-xs text-gray-400">{{ $stats['colocations_count'] ?? 0 }} au total</span>
            </div>

            @if(!isset($colocations) || $colocations->isEmpty())
            <div class="p-10 text-center">
                <p class="text-sm text-gray-400">Aucune colocation.</p>
            </div>
            @else
            <div class="divide-y divide-gray-50">
                @foreach($colocations->take(8) as $colocation)
                <div class="flex items-center gap-3 px-6 py-3.5 stagger-item">
                    <div class="w-8 h-8 bg-emerald-50 rounded-lg flex items-center justify-center text-emerald-600 flex-shrink-0">
                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.75" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/>
                        </svg>
                    </div>
                    <div class="flex-1 min-w-0">
                        <p class="text-sm font-medium text-gray-900 truncate">{{ $colocation->name }}</p>
                        <p class="text-xs text-gray-400">
                            {{ $colocation->users_count ?? $colocation->users->count() }} membre(s)
                            · {{ $colocation->expenses_count ?? $colocation->expenses->count() }} dépense(s)
                        </p>
                    </div>
                    <x-badge variant="success">Actif</x-badge>
                </div>
                @endforeach
            </div>
            @endif
        </div>

    </div>

</x-app-layout>
