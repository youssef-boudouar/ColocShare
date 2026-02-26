<x-app-layout>
    <x-slot name="title">Tableau de bord — ClocShare</x-slot>

    {{-- Header --}}
    <div class="flex items-start justify-between mb-8">
        <div>
            <h1 class="text-2xl font-bold text-gray-900">Bonjour, {{ Auth::user()->name }} 👋</h1>
            <p class="text-gray-500 text-sm mt-1">{{ now()->locale('fr')->isoFormat('dddd D MMMM YYYY') }}</p>
        </div>
    </div>

    @isset($colocation)
    {{-- ===== HAS COLOCATION ===== --}}

    {{-- Stats row --}}
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 mb-8">
        <x-stat-card
            :value="$stats['total_expenses'] ?? '0,00 €'"
            label="Dépenses ce mois"
            icon='<svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.75" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>'
        />
        <x-stat-card
            :value="$stats['balance'] ?? '+0,00 €'"
            label="Mon solde"
            icon='<svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.75" d="M3 6l3 1m0 0l-3 9a5.002 5.002 0 006.001 0M6 7l3 9M6 7l6-2m6 2l3-1m-3 1l-3 9a5.002 5.002 0 006.001 0M18 7l3 9m-3-9l-6-2m0-2v2m0 16V5m0 16H9m3 0h3"/></svg>'
        />
        <x-stat-card
            :value="$colocation->users->count()"
            label="Membres"
            icon='<svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.75" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"/></svg>'
        />
        <x-stat-card
            :value="$stats['pending_debt'] ?? '0,00 €'"
            label="À régler"
            icon='<svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.75" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>'
        />
    </div>

    {{-- Quick actions --}}
    <div class="flex flex-wrap gap-3 mb-8">
        <a href="#" class="inline-flex items-center gap-2 px-4 py-2.5 bg-emerald-500 hover:bg-emerald-600 text-white font-semibold text-sm rounded-xl transition-colors">
            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
            Ajouter une dépense
        </a>
        <a href="{{ route('colocations.show', $colocation) }}" class="inline-flex items-center gap-2 px-4 py-2.5 bg-white border border-gray-300 text-gray-700 font-semibold text-sm rounded-xl hover:bg-gray-50 transition-colors">
            Voir ma colocation
        </a>
    </div>

    {{-- Recent expenses --}}
    <div class="bg-white border border-gray-200 rounded-2xl overflow-hidden">
        <div class="flex items-center justify-between px-6 py-4 border-b border-gray-100">
            <h2 class="font-semibold text-gray-900">Dernières dépenses</h2>
            <a href="#" class="text-sm text-emerald-600 hover:text-emerald-700 font-medium">Voir tout →</a>
        </div>
        <div class="overflow-x-auto">
            <table class="w-full">
                <thead>
                    <tr class="border-b border-gray-100">
                        <th class="text-left px-6 py-3 text-xs font-semibold text-gray-500 uppercase tracking-wider">Catégorie</th>
                        <th class="text-left px-6 py-3 text-xs font-semibold text-gray-500 uppercase tracking-wider">Titre</th>
                        <th class="text-left px-6 py-3 text-xs font-semibold text-gray-500 uppercase tracking-wider">Payé par</th>
                        <th class="text-right px-6 py-3 text-xs font-semibold text-gray-500 uppercase tracking-wider">Montant</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-50">
                    @forelse($colocation->expenses->sortByDesc('created_at')->take(5) as $expense)
                    <tr class="hover:bg-gray-50 transition-colors stagger-item">
                        <td class="px-6 py-4 text-sm">
                            <span class="inline-flex items-center gap-2 text-gray-500">
                                <span class="w-2 h-2 rounded-full bg-emerald-400 inline-block"></span>
                                {{ $expense->category->name ?? 'Autre' }}
                            </span>
                        </td>
                        <td class="px-6 py-4 text-sm font-medium text-gray-900">{{ $expense->title }}</td>
                        <td class="px-6 py-4">
                            <div class="flex items-center gap-2">
                                <x-avatar :name="$expense->user->name ?? 'U'" size="xs"/>
                                <span class="text-sm text-gray-500">{{ $expense->user->name ?? '—' }}</span>
                            </div>
                        </td>
                        <td class="px-6 py-4 text-right">
                            <span class="text-sm font-semibold text-emerald-600">{{ number_format($expense->amount, 2, ',', ' ') }} €</span>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="4" class="px-6 py-12 text-center text-sm text-gray-400">
                            Aucune dépense enregistrée pour l'instant
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    @else
    {{-- ===== NO COLOCATION — empty state ===== --}}

    <div class="max-w-lg mx-auto text-center">

        {{-- Hero card --}}
        <div class="bg-white rounded-2xl border border-gray-200 shadow-sm overflow-hidden mb-6 animate-fade-in-up">
            <img src="https://images.unsplash.com/photo-1600585154340-be6161a56a0c?w=800"
                 alt="Appartement en colocation"
                 class="w-full h-52 object-cover">
            <div class="p-8">
                <h2 class="text-2xl font-bold text-gray-900 mb-2">Démarrez votre colocation</h2>
                <p class="text-gray-500 leading-relaxed text-sm">
                    Créez votre espace partagé ou rejoignez celui de vos colocataires pour gérer vos dépenses ensemble.
                </p>
            </div>
        </div>

        {{-- Action cards --}}
        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 mb-10">
            <a href="{{ route('colocations.create') }}"
               class="stagger-item bg-white border border-gray-200 rounded-xl p-5 text-left hover:shadow-md hover:-translate-y-0.5 transition-all duration-300 block">
                <div class="w-10 h-10 bg-emerald-50 rounded-xl flex items-center justify-center text-emerald-600 mb-3">
                    <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                    </svg>
                </div>
                <h3 class="font-semibold text-gray-900 mb-1">Créer une colocation</h3>
                <p class="text-xs text-gray-500 mb-3">Configurez votre espace partagé en quelques secondes.</p>
                <span class="text-emerald-600 text-xs font-semibold inline-flex items-center gap-1">
                    Commencer
                    <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6"/></svg>
                </span>
            </a>

            <a href="#join-modal"
               class="stagger-item bg-white border border-gray-200 rounded-xl p-5 text-left hover:shadow-md hover:-translate-y-0.5 transition-all duration-300 block">
                <div class="w-10 h-10 bg-indigo-50 rounded-xl flex items-center justify-center text-indigo-600 mb-3">
                    <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.828 10.172a4 4 0 00-5.656 0l-4 4a4 4 0 105.656 5.656l1.102-1.101m-.758-4.899a4 4 0 005.656 0l4-4a4 4 0 00-5.656-5.656l-1.1 1.1"/>
                    </svg>
                </div>
                <h3 class="font-semibold text-gray-900 mb-1">Rejoindre via invitation</h3>
                <p class="text-xs text-gray-500 mb-3">Entrez le code reçu par email pour rejoindre.</p>
                <span class="text-indigo-600 text-xs font-semibold inline-flex items-center gap-1">
                    Rejoindre
                    <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6"/></svg>
                </span>
            </a>
        </div>

        {{-- How it works --}}
        <div class="stagger-item">
            <div class="flex items-center gap-4 mb-5">
                <h3 class="text-sm font-bold text-gray-900 whitespace-nowrap">Comment ça marche ?</h3>
                <div class="flex-1 h-px bg-gray-200"></div>
            </div>
            <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                @php
                $steps = [
                    ['n' => '1', 'title' => 'Créez votre colocation', 'desc' => 'Donnez un nom à votre espace et configurez-le en une minute.'],
                    ['n' => '2', 'title' => 'Invitez vos colocataires', 'desc' => 'Envoyez une invitation par email. Chacun rejoint facilement.'],
                    ['n' => '3', 'title' => 'Gérez les dépenses', 'desc' => 'Enregistrez, consultez les soldes et réglez les comptes.'],
                ];
                @endphp
                @foreach($steps as $step)
                <div class="bg-gray-50 rounded-xl p-5 text-center border border-gray-200 hover:bg-white hover:shadow-sm transition-all duration-300">
                    <div class="w-8 h-8 rounded-full bg-emerald-100 text-emerald-700 text-sm font-bold flex items-center justify-center mx-auto mb-3">{{ $step['n'] }}</div>
                    <h4 class="font-semibold text-gray-900 text-sm mb-1">{{ $step['title'] }}</h4>
                    <p class="text-xs text-gray-500 leading-relaxed">{{ $step['desc'] }}</p>
                </div>
                @endforeach
            </div>
        </div>
    </div>

    {{-- Join modal --}}
    <x-modal id="join-modal" title="Rejoindre une colocation">
        <form method="POST" action="#" class="space-y-4">
            @csrf
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1.5">Token d'invitation</label>
                <input type="text" name="token"
                       class="block w-full rounded-xl border border-gray-300 px-4 py-2.5 text-sm outline-none focus:border-emerald-500 focus:ring-2 focus:ring-emerald-500/20 transition-all"
                       placeholder="Collez le token d'invitation reçu par email...">
            </div>
            <button type="submit" class="w-full px-4 py-2.5 bg-emerald-500 hover:bg-emerald-600 text-white font-semibold text-sm rounded-xl transition-colors">
                Rejoindre la colocation
            </button>
        </form>
    </x-modal>

    @endisset

</x-app-layout>
