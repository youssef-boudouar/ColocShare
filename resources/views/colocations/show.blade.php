<x-app-layout>
    <x-slot name="title">{{ $colocation->name }} — ColocShare</x-slot>

    @php
        $pivot = $members->firstWhere('id', Auth::id())?->pivot;
        $isOwner = $pivot && $pivot->role === 'owner';
    @endphp

    {{-- ===== HEADER ===== --}}
    <div class="mb-6">
        <div class="flex items-start justify-between gap-4">
            <div class="min-w-0">
                <div class="flex items-center gap-2.5 flex-wrap mb-1">
                    <h1 class="text-2xl font-bold text-gray-900 truncate">{{ $colocation->name }}</h1>
                    @if($colocation->status === 'active')
                    <span class="inline-flex items-center gap-1.5 px-2.5 py-0.5 rounded-full text-xs font-semibold bg-emerald-50 text-emerald-700 border border-emerald-200">
                        <span class="w-1.5 h-1.5 rounded-full bg-emerald-500"></span>Active
                    </span>
                    @else
                    <span class="inline-flex items-center gap-1.5 px-2.5 py-0.5 rounded-full text-xs font-semibold bg-gray-100 text-gray-500 border border-gray-200">
                        <span class="w-1.5 h-1.5 rounded-full bg-gray-400"></span>{{ ucfirst($colocation->status) }}
                    </span>
                    @endif
                </div>
                @if($colocation->description)
                <p class="text-sm text-gray-500 mt-0.5">{{ $colocation->description }}</p>
                @endif
            </div>

            @if($isOwner)
            <div class="flex items-center gap-2 flex-shrink-0">
                <a href="{{ route('colocations.edit', $colocation) }}"
                   class="inline-flex items-center gap-2 px-4 py-2 bg-white border border-gray-200 text-gray-700 font-medium text-sm rounded-xl hover:bg-gray-50 transition-colors">
                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                    </svg>
                    Modifier
                </a>
                <form method="POST" action="{{ route('colocations.cancel', $colocation) }}"
                      onsubmit="return confirm('Annuler cette colocation ?')">
                    @csrf
                    @method('PATCH')
                    <button type="submit"
                            class="inline-flex items-center gap-2 px-4 py-2 bg-white border border-red-200 text-red-500 font-medium text-sm rounded-xl hover:bg-red-50 transition-colors">
                        Annuler la coloc
                    </button>
                </form>
            </div>
            @endif
        </div>

        {{-- Invite bar (owner only) --}}
        @if($isOwner)
        <div class="mt-4">
            @if(session('success'))
            <div class="mb-3 px-4 py-2.5 bg-emerald-50 border border-emerald-200 text-emerald-700 text-sm rounded-xl">
                {{ session('success') }}
            </div>
            @endif
            @if(session('error'))
            <div class="mb-3 px-4 py-2.5 bg-red-50 border border-red-200 text-red-700 text-sm rounded-xl">
                {{ session('error') }}
            </div>
            @endif
            <div class="flex items-center gap-3 bg-gray-50 border border-gray-200 rounded-xl px-4 py-3">
                <svg class="w-4 h-4 text-gray-400 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z"/>
                </svg>
                <span class="text-sm text-gray-500 flex-shrink-0">Inviter par e-mail</span>
                <form method="POST" action="{{ route('invitations.send', $colocation) }}" class="flex flex-1 gap-2 max-w-sm">
                    @csrf
                    <input type="email" name="email"
                           class="flex-1 rounded-lg border border-gray-300 bg-white px-3 py-1.5 text-sm text-gray-900 placeholder-gray-400 outline-none focus:border-emerald-500 focus:ring-2 focus:ring-emerald-500/20 transition-all"
                           placeholder="email@exemple.fr">
                    <button type="submit"
                            class="px-3.5 py-1.5 bg-emerald-500 hover:bg-emerald-600 text-white font-semibold text-sm rounded-lg transition-colors whitespace-nowrap">
                        Envoyer
                    </button>
                </form>
            </div>
        </div>
        @else
            @if(session('success'))
            <div class="mt-4 px-4 py-2.5 bg-emerald-50 border border-emerald-200 text-emerald-700 text-sm rounded-xl">
                {{ session('success') }}
            </div>
            @endif
            @if(session('error'))
            <div class="mt-4 px-4 py-2.5 bg-red-50 border border-red-200 text-red-700 text-sm rounded-xl">
                {{ session('error') }}
            </div>
            @endif
        @endif
    </div>

    {{-- ===== CSS RADIO TABS ===== --}}
    <div class="bg-white border border-gray-200 rounded-2xl overflow-hidden">
        <input type="radio" name="coloc-tab" id="tab-membres" class="tab-radio" checked>
        <input type="radio" name="coloc-tab" id="tab-depenses" class="tab-radio">
        <input type="radio" name="coloc-tab" id="tab-soldes" class="tab-radio">
        <input type="radio" name="coloc-tab" id="tab-reglements" class="tab-radio">
        @if($isOwner)
        <input type="radio" name="coloc-tab" id="tab-categories" class="tab-radio">
        @endif

        {{-- Tab nav --}}
        <div class="tab-nav flex overflow-x-auto border-b border-gray-200 px-4">
            <label for="tab-membres"    class="tab-label label-membres">Membres</label>
            <label for="tab-depenses"   class="tab-label label-depenses">Dépenses</label>
            <label for="tab-soldes"     class="tab-label label-soldes">Soldes</label>
            <label for="tab-reglements" class="tab-label label-reglements">Règlements</label>
            @if($isOwner)
            <label for="tab-categories" class="tab-label label-categories">Catégories</label>
            @endif
        </div>

        {{-- Tab panels --}}
        <div class="tab-panels p-6">

            {{-- ===== MEMBRES ===== --}}
            <div class="tab-panel panel-membres">
                @forelse($members as $member)
                <div class="flex items-center justify-between py-3 px-3 rounded-xl hover:bg-gray-50 transition-colors stagger-item {{ !$loop->last ? 'border-b border-gray-50' : '' }}">
                    <div class="flex items-center gap-3">
                        <x-avatar :name="$member->name" size="sm"/>
                        <div>
                            <p class="text-sm font-semibold text-gray-900">
                                {{ $member->name }}
                                @if($member->id === Auth::id())
                                <span class="text-xs font-normal text-gray-400">(moi)</span>
                                @endif
                            </p>
                            <p class="text-xs text-gray-400">{{ $member->email }}</p>
                        </div>
                    </div>
                    <x-badge :variant="$member->pivot->role === 'owner' ? 'owner' : 'member'">
                        {{ $member->pivot->role === 'owner' ? 'Propriétaire' : 'Membre' }}
                    </x-badge>
                </div>
                @empty
                <div class="py-12 text-center">
                    <p class="text-sm text-gray-400">Aucun membre.</p>
                </div>
                @endforelse
            </div>

            {{-- ===== DÉPENSES ===== --}}
            <div class="tab-panel panel-depenses">
                <div class="flex items-center justify-between mb-5">
                    <div>
                        <span class="text-sm font-semibold text-gray-900">{{ $expenses->count() }} dépense(s)</span>
                        <span class="text-sm text-gray-400 mx-1.5">·</span>
                        <span class="text-sm font-bold text-emerald-600">{{ number_format($total, 2, ',', ' ') }} DH</span>
                    </div>
                    <a href="#modal-add-expense"
                       class="inline-flex items-center gap-1.5 px-3.5 py-2 bg-emerald-500 hover:bg-emerald-600 text-white font-semibold text-sm rounded-xl transition-colors">
                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                        </svg>
                        Nouvelle dépense
                    </a>
                </div>

                @if($expenses->isEmpty())
                <div class="py-14 text-center">
                    <div class="w-12 h-12 bg-gray-100 rounded-xl flex items-center justify-center mx-auto mb-3">
                        <svg class="w-6 h-6 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.75" d="M9 14l6-6m-5.5.5h.01m4.99 5h.01M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16l3.5-2 3.5 2 3.5-2 3.5 2z"/>
                        </svg>
                    </div>
                    <p class="text-sm font-semibold text-gray-700 mb-1">Aucune dépense enregistrée</p>
                    <p class="text-xs text-gray-400">Ajoutez votre première dépense pour commencer.</p>
                </div>
                @else
                <div class="overflow-x-auto -mx-6">
                    <table class="w-full">
                        <thead>
                            <tr class="border-b border-gray-100 bg-gray-50/50">
                                <th class="text-left px-6 py-3 text-xs font-semibold text-gray-400 uppercase tracking-wider">Titre</th>
                                <th class="text-left px-6 py-3 text-xs font-semibold text-gray-400 uppercase tracking-wider">Catégorie</th>
                                <th class="text-left px-6 py-3 text-xs font-semibold text-gray-400 uppercase tracking-wider">Payé par</th>
                                <th class="text-right px-6 py-3 text-xs font-semibold text-gray-400 uppercase tracking-wider">Montant</th>
                                <th class="text-right px-6 py-3 text-xs font-semibold text-gray-400 uppercase tracking-wider">Date</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($expenses->sortByDesc('date') as $expense)
                            <tr class="border-b border-gray-50 hover:bg-gray-50/50 transition-colors stagger-item">
                                <td class="px-6 py-3.5 text-sm font-semibold text-gray-900">{{ $expense->title }}</td>
                                <td class="px-6 py-3.5 text-sm text-gray-500">
                                    <span class="inline-flex items-center gap-1.5">
                                        <span class="w-1.5 h-1.5 rounded-full bg-emerald-400 flex-shrink-0"></span>
                                        {{ $expense->category->name ?? 'Sans catégorie' }}
                                    </span>
                                </td>
                                <td class="px-6 py-3.5">
                                    <div class="flex items-center gap-2">
                                        <x-avatar :name="$expense->user->name ?? 'U'" size="xs"/>
                                        <span class="text-sm text-gray-600">{{ $expense->user->name ?? '—' }}</span>
                                    </div>
                                </td>
                                <td class="px-6 py-3.5 text-right">
                                    <span class="text-sm font-bold text-emerald-600">{{ number_format($expense->amount, 2, ',', ' ') }} DH</span>
                                </td>
                                <td class="px-6 py-3.5 text-right text-sm text-gray-400 whitespace-nowrap">
                                    {{ $expense->date->format('d/m/Y') }}
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                @endif
            </div>

            {{-- ===== SOLDES ===== --}}
            <div class="tab-panel panel-soldes">
                @if($expenses->isEmpty())
                <div class="py-14 text-center">
                    <div class="w-12 h-12 bg-gray-100 rounded-xl flex items-center justify-center mx-auto mb-3">
                        <svg class="w-6 h-6 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.75" d="M3 6l3 1m0 0l-3 9a5.002 5.002 0 006.001 0M6 7l3 9M6 7l6-2m6 2l3-1m-3 1l-3 9a5.002 5.002 0 006.001 0M18 7l3 9m-3-9l-6-2m0-2v2m0 16V5m0 16H9m3 0h3"/>
                        </svg>
                    </div>
                    <p class="text-sm font-semibold text-gray-700 mb-1">Aucune dépense à répartir</p>
                    <p class="text-xs text-gray-400">Enregistrez des dépenses pour voir les soldes.</p>
                </div>
                @else
                {{-- Summary --}}
                <div class="flex items-center gap-4 mb-5 p-4 bg-gray-50 rounded-2xl border border-gray-100">
                    <div class="flex-1 text-center">
                        <p class="text-xs font-semibold text-gray-400 uppercase tracking-wider">Total</p>
                        <p class="text-lg font-bold text-gray-900 mt-0.5">{{ number_format($total, 2, ',', ' ') }} DH</p>
                    </div>
                    <div class="w-px h-10 bg-gray-200"></div>
                    <div class="flex-1 text-center">
                        <p class="text-xs font-semibold text-gray-400 uppercase tracking-wider">Part par personne</p>
                        <p class="text-lg font-bold text-emerald-600 mt-0.5">{{ number_format($fairShare, 2, ',', ' ') }} DH</p>
                    </div>
                </div>

                {{-- Balance table --}}
                <div class="overflow-x-auto -mx-6">
                    <table class="w-full">
                        <thead>
                            <tr class="border-b border-gray-100 bg-gray-50/50">
                                <th class="text-left px-6 py-3 text-xs font-semibold text-gray-400 uppercase tracking-wider">Membre</th>
                                <th class="text-right px-6 py-3 text-xs font-semibold text-gray-400 uppercase tracking-wider">Payé</th>
                                <th class="text-right px-6 py-3 text-xs font-semibold text-gray-400 uppercase tracking-wider">Solde</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($balances as $b)
                            <tr class="border-b border-gray-50 hover:bg-gray-50/50 transition-colors stagger-item">
                                <td class="px-6 py-3.5">
                                    <div class="flex items-center gap-2">
                                        <x-avatar :name="$b['user']->name" size="xs"/>
                                        <span class="text-sm font-semibold text-gray-900">
                                            {{ $b['user']->name }}
                                            @if($b['user']->id === Auth::id())
                                            <span class="text-xs font-normal text-gray-400">(moi)</span>
                                            @endif
                                        </span>
                                    </div>
                                </td>
                                <td class="px-6 py-3.5 text-right text-sm text-gray-600">
                                    {{ number_format($b['paid'], 2, ',', ' ') }} DH
                                </td>
                                <td class="px-6 py-3.5 text-right">
                                    <span class="text-sm font-bold {{ $b['balance'] > 0 ? 'text-emerald-600' : ($b['balance'] < 0 ? 'text-red-500' : 'text-gray-400') }}">
                                        {{ $b['balance'] > 0 ? '+' : '' }}{{ number_format($b['balance'], 2, ',', ' ') }} DH
                                    </span>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                @endif
            </div>

            {{-- ===== RÈGLEMENTS ===== --}}
            <div class="tab-panel panel-reglements">
                {{-- Form: enregistrer un règlement --}}
                <div class="bg-gray-50 border border-gray-100 rounded-2xl p-5 mb-6">
                    <h3 class="text-sm font-bold text-gray-900 mb-4">Enregistrer un règlement</h3>
                    <form method="POST" action="{{ route('settlements.store', $colocation) }}" class="flex flex-wrap items-end gap-3">
                        @csrf
                        <div class="flex-1 min-w-[140px]">
                            <label class="block text-xs font-semibold text-gray-600 mb-1.5">De</label>
                            <div class="block w-full rounded-xl border border-gray-300 bg-gray-100 px-4 py-2.5 text-sm text-gray-500">
                                {{ Auth::user()->name }}
                            </div>
                        </div>
                        <div class="flex-1 min-w-[140px]">
                            <label class="block text-xs font-semibold text-gray-600 mb-1.5">À</label>
                            <select name="receiver_id" required
                                    class="block w-full rounded-xl border border-gray-300 px-4 py-2.5 text-sm text-gray-900 outline-none focus:border-emerald-500 focus:ring-2 focus:ring-emerald-500/20 transition-all bg-white">
                                <option value="">— Choisir —</option>
                                @foreach($members as $member)
                                    @if($member->id !== Auth::id())
                                    <option value="{{ $member->id }}">{{ $member->name }}</option>
                                    @endif
                                @endforeach
                            </select>
                        </div>
                        <div class="w-32">
                            <label class="block text-xs font-semibold text-gray-600 mb-1.5">Montant (DH)</label>
                            <input type="number" name="amount" step="0.01" min="0.01" required
                                   class="block w-full rounded-xl border border-gray-300 px-4 py-2.5 text-sm text-gray-900 placeholder-gray-400 outline-none focus:border-emerald-500 focus:ring-2 focus:ring-emerald-500/20 transition-all"
                                   placeholder="0.00">
                        </div>
                        <button type="submit"
                                class="inline-flex items-center gap-1.5 px-5 py-2.5 bg-emerald-500 hover:bg-emerald-600 text-white font-semibold text-sm rounded-xl transition-colors whitespace-nowrap">
                            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                            </svg>
                            Enregistrer
                        </button>
                    </form>
                </div>

                {{-- Liste des règlements --}}
                <div class="flex items-center justify-between mb-4">
                    <span class="text-sm font-semibold text-gray-900">{{ $settlements->count() }} règlement(s)</span>
                </div>

                @if($settlements->isEmpty())
                <div class="py-14 text-center">
                    <div class="w-12 h-12 bg-gray-100 rounded-xl flex items-center justify-center mx-auto mb-3">
                        <svg class="w-6 h-6 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.75" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                    </div>
                    <p class="text-sm font-semibold text-gray-700 mb-1">Aucun règlement pour le moment</p>
                    <p class="text-xs text-gray-400">Les remboursements apparaîtront ici.</p>
                </div>
                @else
                <div class="space-y-3">
                    @foreach($settlements as $settlement)
                    <div class="flex items-center justify-between px-4 py-3.5 bg-white border border-gray-100 rounded-2xl hover:border-gray-200 transition-colors stagger-item">
                        <div class="flex items-center gap-3 min-w-0">
                            <div class="w-9 h-9 bg-emerald-50 rounded-xl flex items-center justify-center flex-shrink-0">
                                <svg class="w-4.5 h-4.5 text-emerald-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z"/>
                                </svg>
                            </div>
                            <div class="min-w-0">
                                <p class="text-sm font-semibold text-gray-900 truncate">
                                    {{ $settlement->payer->name }} a payé
                                    <span class="text-emerald-600">{{ number_format($settlement->amount, 2, ',', ' ') }} DH</span>
                                    à {{ $settlement->receiver->name }}
                                </p>
                                <p class="text-xs text-gray-400 mt-0.5">Le {{ $settlement->paid_at->translatedFormat('d F Y') }}</p>
                            </div>
                        </div>
                        <form method="POST" action="{{ route('settlements.destroy', $settlement) }}"
                              onsubmit="return confirm('Supprimer ce règlement ?')" class="flex-shrink-0 ml-3">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="text-xs text-red-400 hover:text-red-600 font-medium transition-colors">
                                Supprimer
                            </button>
                        </form>
                    </div>
                    @endforeach
                </div>
                @endif
            </div>

            {{-- ===== CATÉGORIES (owner only) ===== --}}
            @if($isOwner)
            <div class="tab-panel panel-categories">
                <form method="POST" action="{{ route('categories.store', $colocation) }}" class="flex gap-3 mb-6">
                    @csrf
                    <input type="text" name="name" required
                           class="flex-1 rounded-xl border border-gray-300 px-4 py-2.5 text-sm text-gray-900 placeholder-gray-400 outline-none focus:border-emerald-500 focus:ring-2 focus:ring-emerald-500/20 transition-all"
                           placeholder="Nom de la catégorie — ex: Loyer, Courses…">
                    <button type="submit"
                            class="inline-flex items-center gap-2 px-5 py-2.5 bg-emerald-500 hover:bg-emerald-600 text-white font-semibold text-sm rounded-xl transition-colors whitespace-nowrap">
                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                        </svg>
                        Ajouter
                    </button>
                </form>

                @if($categories->isEmpty())
                <div class="py-10 text-center">
                    <div class="w-12 h-12 bg-gray-100 rounded-xl flex items-center justify-center mx-auto mb-3">
                        <svg class="w-6 h-6 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.75" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"/>
                        </svg>
                    </div>
                    <p class="text-sm text-gray-400">Aucune catégorie. Créez-en une ci-dessus.</p>
                </div>
                @else
                <div class="space-y-2">
                    @foreach($categories as $category)
                    <div class="flex items-center justify-between px-4 py-3 bg-gray-50 rounded-xl border border-gray-100 hover:border-gray-200 transition-colors stagger-item">
                        <div class="flex items-center gap-3">
                            <div class="w-8 h-8 bg-emerald-100 rounded-lg flex items-center justify-center text-emerald-600">
                                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.75" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"/>
                                </svg>
                            </div>
                            <p class="text-sm font-semibold text-gray-900">{{ $category->name }}</p>
                        </div>
                        <form method="POST" action="{{ route('categories.destroy', $category) }}"
                              onsubmit="return confirm('Supprimer « {{ $category->name }} » ?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" title="Supprimer"
                                    class="p-1.5 text-gray-300 hover:text-red-500 hover:bg-red-50 rounded-lg transition-colors">
                                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                </svg>
                            </button>
                        </form>
                    </div>
                    @endforeach
                </div>
                @endif
            </div>
            @endif

        </div>
    </div>

    {{-- ===== MODAL: Nouvelle dépense ===== --}}
    <div id="modal-add-expense" class="modal">
        <div class="bg-white rounded-2xl shadow-xl w-full max-w-md p-6">
            <div class="flex items-center justify-between mb-5">
                <h3 class="text-base font-bold text-gray-900">Nouvelle dépense</h3>
                <a href="#" class="text-gray-400 hover:text-gray-600 transition-colors p-1 rounded-lg hover:bg-gray-100">
                    <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                    </svg>
                </a>
            </div>
            <form method="POST" action="{{ route('expenses.store', $colocation) }}" class="space-y-4">
                @csrf
                <div>
                    <label class="block text-xs font-semibold text-gray-600 mb-1.5">Titre</label>
                    <input type="text" name="title" required
                           class="block w-full rounded-xl border border-gray-300 px-4 py-2.5 text-sm text-gray-900 placeholder-gray-400 outline-none focus:border-emerald-500 focus:ring-2 focus:ring-emerald-500/20 transition-all"
                           placeholder="Ex: Loyer de mars">
                </div>
                <div class="grid grid-cols-2 gap-3">
                    <div>
                        <label class="block text-xs font-semibold text-gray-600 mb-1.5">Montant (DH)</label>
                        <input type="number" name="amount" step="0.01" min="0.01" required
                               class="block w-full rounded-xl border border-gray-300 px-4 py-2.5 text-sm text-gray-900 placeholder-gray-400 outline-none focus:border-emerald-500 focus:ring-2 focus:ring-emerald-500/20 transition-all"
                               placeholder="0.00">
                    </div>
                    <div>
                        <label class="block text-xs font-semibold text-gray-600 mb-1.5">Date</label>
                        <input type="date" name="date" required value="{{ date('Y-m-d') }}"
                               class="block w-full rounded-xl border border-gray-300 px-4 py-2.5 text-sm text-gray-900 outline-none focus:border-emerald-500 focus:ring-2 focus:ring-emerald-500/20 transition-all">
                    </div>
                </div>
                <div>
                    <label class="block text-xs font-semibold text-gray-600 mb-1.5">Catégorie <span class="font-normal text-gray-400">(optionnel)</span></label>
                    <select name="category_id"
                            class="block w-full rounded-xl border border-gray-300 px-4 py-2.5 text-sm text-gray-900 outline-none focus:border-emerald-500 focus:ring-2 focus:ring-emerald-500/20 transition-all bg-white">
                        <option value="">Sans catégorie</option>
                        @foreach($categories as $cat)
                        <option value="{{ $cat->id }}">{{ $cat->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="flex gap-3 pt-1">
                    <a href="#" class="flex-1 text-center px-4 py-2.5 bg-gray-100 hover:bg-gray-200 text-gray-700 font-semibold text-sm rounded-xl transition-colors">
                        Annuler
                    </a>
                    <button type="submit"
                            class="flex-1 px-4 py-2.5 bg-emerald-500 hover:bg-emerald-600 text-white font-semibold text-sm rounded-xl transition-colors">
                        Enregistrer
                    </button>
                </div>
            </form>
        </div>
    </div>

</x-app-layout>
