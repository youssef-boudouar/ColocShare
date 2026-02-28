<x-app-layout>
    <x-slot name="title">Mes Colocations — ColocShare</x-slot>

    {{-- Page header --}}
    <div class="mb-8 animate-fade-in-up">
        <h1 class="text-2xl font-bold text-gray-900">Mes Colocations</h1>
        <p class="text-sm text-gray-500 mt-1">Gérez votre colocation active et consultez votre historique.</p>
    </div>

    {{-- ===== ACTIVE COLOCATION ===== --}}
    @if($active)
    @php
        $memberCount = $active->users()->wherePivotNull('left_at')->count();
        $expenseCount = $active->expenses()->count();
        $totalAmount = $active->expenses()->sum('amount');
    @endphp
    <div class="bg-white border border-gray-100 rounded-2xl shadow-sm hover:shadow-md transition-all duration-300 mb-10 animate-fade-in-up overflow-hidden">
        {{-- Gradient left accent --}}
        <div class="flex">
            <div class="w-1.5 bg-gradient-to-b from-emerald-400 to-emerald-600 flex-shrink-0 rounded-l-2xl"></div>
            <div class="flex-1 p-6 sm:p-8">
                <div class="flex flex-col sm:flex-row sm:items-start sm:justify-between gap-5 mb-6">
                    {{-- Left: name + badge + description --}}
                    <div class="min-w-0 flex-1">
                        <div class="flex items-center gap-3 flex-wrap mb-2">
                            <h2 class="text-xl font-bold text-gray-900 truncate">{{ $active->name }}</h2>
                            <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-semibold bg-emerald-50 text-emerald-700 border border-emerald-200">
                                <span class="w-1.5 h-1.5 rounded-full bg-emerald-500 animate-pulse"></span>
                                Active
                            </span>
                        </div>
                        @if($active->description)
                        <p class="text-sm text-gray-500 leading-relaxed">{{ $active->description }}</p>
                        @else
                        <p class="text-sm text-gray-400 italic">Aucune description.</p>
                        @endif
                    </div>

                    {{-- Right: CTA --}}
                    <a href="{{ route('colocations.show', $active) }}"
                       class="inline-flex items-center gap-2 px-5 py-2.5 bg-emerald-500 hover:bg-emerald-600 text-white font-semibold text-sm rounded-xl transition-colors whitespace-nowrap flex-shrink-0">
                        Gérer
                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6"/></svg>
                    </a>
                </div>

                {{-- Stats row --}}
                <div class="flex flex-wrap items-center gap-6 pt-5 border-t border-gray-100">
                    <div class="flex items-center gap-2 text-sm text-gray-500">
                        <svg class="w-4 h-4 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                        <span>{{ $memberCount }} membre{{ $memberCount > 1 ? 's' : '' }}</span>
                    </div>
                    <div class="flex items-center gap-2 text-sm text-gray-500">
                        <svg class="w-4 h-4 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 14l6-6m-5.5.5h.01m4.99 5h.01M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16l3.5-2 3.5 2 3.5-2 3.5 2z"/></svg>
                        <span>{{ $expenseCount }} dépense{{ $expenseCount > 1 ? 's' : '' }}</span>
                    </div>
                    <div class="flex items-center gap-2 text-sm text-gray-500">
                        <svg class="w-4 h-4 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1"/></svg>
                        <span class="font-semibold text-gray-900">{{ number_format($totalAmount, 2, ',', ' ') }} DH</span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @else
    {{-- ===== EMPTY STATE ===== --}}
    <div class="bg-white border border-gray-100 rounded-2xl shadow-sm p-12 sm:p-16 mb-10 text-center animate-fade-in-up">
        {{-- SVG illustration: house with people --}}
        <div class="mx-auto mb-8 w-32 h-32">
            <svg viewBox="0 0 128 128" fill="none" class="w-full h-full">
                {{-- House body --}}
                <rect x="30" y="58" width="68" height="50" rx="4" fill="#F0FDF4" stroke="#10B981" stroke-width="2"/>
                {{-- Roof --}}
                <path d="M24 62L64 30L104 62" stroke="#10B981" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" fill="none"/>
                {{-- Door --}}
                <rect x="54" y="80" width="20" height="28" rx="3" fill="#D1FAE5" stroke="#10B981" stroke-width="1.5"/>
                <circle cx="70" cy="95" r="1.5" fill="#10B981"/>
                {{-- Window left --}}
                <rect x="36" y="68" width="14" height="12" rx="2" fill="#D1FAE5" stroke="#10B981" stroke-width="1.5"/>
                <line x1="43" y1="68" x2="43" y2="80" stroke="#10B981" stroke-width="1"/>
                <line x1="36" y1="74" x2="50" y2="74" stroke="#10B981" stroke-width="1"/>
                {{-- Window right --}}
                <rect x="78" y="68" width="14" height="12" rx="2" fill="#D1FAE5" stroke="#10B981" stroke-width="1.5"/>
                <line x1="85" y1="68" x2="85" y2="80" stroke="#10B981" stroke-width="1"/>
                <line x1="78" y1="74" x2="92" y2="74" stroke="#10B981" stroke-width="1"/>
                {{-- Person 1 --}}
                <circle cx="20" cy="90" r="6" fill="#D1FAE5" stroke="#10B981" stroke-width="1.5"/>
                <path d="M12 108a8 8 0 0116 0" stroke="#10B981" stroke-width="1.5" fill="#F0FDF4"/>
                {{-- Person 2 --}}
                <circle cx="108" cy="90" r="6" fill="#D1FAE5" stroke="#10B981" stroke-width="1.5"/>
                <path d="M100 108a8 8 0 0116 0" stroke="#10B981" stroke-width="1.5" fill="#F0FDF4"/>
            </svg>
        </div>
        <h2 class="text-2xl font-bold text-gray-900 mb-3">Aucune colocation active</h2>
        <p class="text-sm text-gray-500 max-w-sm mx-auto mb-8 leading-relaxed">
            Créez votre première colocation pour commencer à partager vos dépenses.
        </p>
        <a href="{{ route('colocations.create') }}"
           class="inline-flex items-center gap-2 px-6 py-3 bg-emerald-500 hover:bg-emerald-600 text-white font-semibold text-sm rounded-xl transition-colors shadow-sm">
            Créer une colocation
            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6"/></svg>
        </a>
        <p class="text-xs text-gray-400 mt-4">Ou attendez une invitation par email d'un colocataire</p>
    </div>
    @endif

    {{-- ===== HISTORIQUE ===== --}}
    <div class="{{ $active ? 'stagger-2' : 'stagger-1' }}">
        <div class="flex items-center gap-4">
            <h2 class="text-xl font-bold text-gray-900 whitespace-nowrap">Historique</h2>
            <div class="flex-1 h-px bg-gradient-to-r from-gray-200 to-transparent"></div>
        </div>
        <p class="text-sm text-gray-400 mb-6">Vos anciennes colocations</p>

        @if($past->count() > 0)
        <div class="space-y-4">
            @foreach($past as $coloc)
            <div class="bg-white rounded-2xl shadow-sm hover:shadow-md hover:-translate-y-0.5 transition-all duration-300 p-6 stagger-{{ $loop->iteration }}">
                <div class="flex items-center gap-5">
                    {{-- Gradient accent bar --}}
                    <div class="w-1.5 self-stretch rounded-full bg-gradient-to-b from-gray-300 to-gray-200 flex-shrink-0"></div>

                    {{-- Main content --}}
                    <div class="min-w-0 flex-1">
                        <div class="flex items-center gap-3 flex-wrap mb-2">
                            <p class="text-lg font-semibold text-gray-900 truncate">{{ $coloc->name }}</p>
                            <span class="inline-flex items-center gap-1 bg-gray-100 text-gray-500 text-xs font-semibold px-3 py-1 rounded-full">
                                <span class="w-1.5 h-1.5 rounded-full bg-gray-400"></span>
                                Terminée
                            </span>
                        </div>
                        <div class="flex items-center gap-1.5 text-sm text-gray-400">
                            <svg class="w-3.5 h-3.5 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                            <span>Terminée le {{ $coloc->cancelled_at ? $coloc->cancelled_at->translatedFormat('d F Y') : $coloc->updated_at->translatedFormat('d F Y') }}</span>
                        </div>
                    </div>

                    {{-- Archive icon --}}
                    <div class="bg-gray-50 rounded-full p-3 flex-shrink-0">
                        <svg class="w-5 h-5 text-gray-300" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M5 8h14M5 8a2 2 0 110-4h14a2 2 0 110 4M5 8v10a2 2 0 002 2h10a2 2 0 002-2V8m-9 4h4"/></svg>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
        @else
        <p class="text-sm text-gray-400">Aucune colocation passée.</p>
        @endif
    </div>

</x-app-layout>
