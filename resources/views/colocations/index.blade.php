<x-app-layout>
    <x-slot name="title">Mes Colocations — ClocShare</x-slot>

    {{-- Page header --}}
    <div class="mb-8">
        <h1 class="text-2xl font-bold text-gray-900">Mes Colocations</h1>
        <p class="text-sm text-gray-500 mt-1">Gérez votre colocation active et consultez votre historique.</p>
    </div>

    {{-- ===== SECTION 1 — COLOCATION ACTIVE ===== --}}
    @isset($active)
    <div class="bg-white border border-gray-100 rounded-2xl shadow-sm hover:shadow-md transition-all duration-300 p-6 mb-10 animate-fade-in-up">
        <div class="flex items-start justify-between gap-6">

            {{-- Left: name + description + badge --}}
            <div class="flex-1 min-w-0">
                <div class="flex items-center gap-3 flex-wrap mb-2">
                    <h2 class="text-2xl font-bold text-gray-900 truncate">{{ $active->name }}</h2>
                    <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-semibold bg-emerald-500 text-white">
                        <span class="w-1.5 h-1.5 rounded-full bg-white/70"></span>Active
                    </span>
                </div>
                @if($active->description)
                <p class="text-sm text-gray-500 leading-relaxed">{{ $active->description }}</p>
                @else
                <p class="text-sm text-gray-400 italic">Aucune description.</p>
                @endif

                {{-- Member count --}}
                <div class="flex items-center gap-2 mt-4">
                    <div class="flex -space-x-2">
                        @foreach($active->users->take(4) as $member)
                        <div class="w-7 h-7 rounded-full bg-emerald-100 border-2 border-white flex items-center justify-center text-emerald-700 text-xs font-bold flex-shrink-0">
                            {{ strtoupper(substr($member->name, 0, 1)) }}
                        </div>
                        @endforeach
                    </div>
                    <span class="text-sm text-gray-500">
                        {{ $active->users->count() }} membre{{ $active->users->count() > 1 ? 's' : '' }}
                    </span>
                </div>
            </div>

            {{-- Right: CTA --}}
            <div class="flex-shrink-0 flex flex-col items-end gap-3">
                <a href="{{ route('colocations.show', $active) }}"
                   class="inline-flex items-center gap-2 px-5 py-2.5 bg-emerald-500 hover:bg-emerald-600 text-white font-semibold text-sm rounded-xl transition-colors whitespace-nowrap">
                    Voir la colocation
                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6"/>
                    </svg>
                </a>
                <a href="{{ route('colocations.edit', $active) }}"
                   class="inline-flex items-center gap-1.5 text-xs text-gray-400 hover:text-gray-600 transition-colors">
                    <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                    </svg>
                    Modifier
                </a>
            </div>
        </div>
    </div>

    @else
    {{-- ===== EMPTY STATE — no active colocation ===== --}}
    <div class="bg-white border border-gray-100 rounded-2xl shadow-sm p-12 mb-10 text-center animate-fade-in-up">
        <div class="w-16 h-16 bg-gray-100 rounded-2xl flex items-center justify-center mx-auto mb-5">
            <svg class="w-8 h-8 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/>
            </svg>
        </div>
        <h2 class="text-lg font-bold text-gray-900 mb-2">Aucune colocation active</h2>
        <p class="text-sm text-gray-500 max-w-sm mx-auto mb-8 leading-relaxed">
            Vous n'appartenez à aucune colocation pour le moment. Créez la vôtre ou rejoignez celle d'un colocataire.
        </p>
        <div class="flex items-center justify-center">
            <a href="{{ route('colocations.create') }}"
               class="inline-flex items-center gap-2 px-5 py-2.5 bg-emerald-500 hover:bg-emerald-600 text-white font-semibold text-sm rounded-xl transition-colors">
                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                </svg>
                Créer une colocation
            </a>
        </div>
    </div>
    @endisset

    {{-- ===== SECTION 2 — HISTORIQUE ===== --}}
    @isset($past)
    <div>
        <div class="flex items-center gap-4 mb-4">
            <h2 class="text-sm font-bold text-gray-900 whitespace-nowrap">Historique</h2>
            <div class="flex-1 h-px bg-gray-200"></div>
        </div>

        @if($past->count() > 0)
        <div class="space-y-3">
            @foreach($past as $i => $coloc)
            @php
                $stagger = 'stagger-' . min($i + 1, 4);
                $cancelledAt = $coloc->cancelled_at ?? $coloc->updated_at;
            @endphp
            <div class="bg-white border border-gray-100 rounded-xl shadow-sm border-l-4 border-l-red-200 pl-4 pr-5 py-4 flex items-center justify-between gap-4 hover:shadow-md transition-all duration-300 {{ $stagger }}">
                <div class="min-w-0">
                    <p class="text-sm font-semibold text-gray-900 truncate">{{ $coloc->name }}</p>
                    @if($cancelledAt)
                    <p class="text-xs text-gray-400 mt-0.5">
                        Annulée le {{ \Carbon\Carbon::parse($cancelledAt)->locale('fr')->isoFormat('D MMMM YYYY') }}
                    </p>
                    @endif
                </div>
                <span class="inline-flex items-center gap-1.5 px-2.5 py-0.5 rounded-full text-xs font-semibold bg-red-100 text-red-600 border border-red-200 flex-shrink-0">
                    <span class="w-1.5 h-1.5 rounded-full bg-red-400"></span>Annulée
                </span>
            </div>
            @endforeach
        </div>
        @else
        <p class="text-sm text-gray-400">Aucune colocation passée.</p>
        @endif
    </div>
    @endisset

</x-app-layout>
