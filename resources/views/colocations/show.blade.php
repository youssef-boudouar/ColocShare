<x-app-layout>
    <x-slot name="title">{{ $colocation->name }} — ClocShare</x-slot>

    @php
        $pivot = $colocation->users->firstWhere('id', Auth::id())?->pivot;
        $isOwner = $pivot && $pivot->role === 'owner';
    @endphp

    {{-- ===== HEADER ===== --}}
    <div class="mb-8">
        <div class="flex items-start justify-between gap-4 mb-4">
            <div class="flex-1 min-w-0">
                <div class="flex items-center gap-3 flex-wrap mb-1">
                    <h1 class="text-2xl font-bold text-gray-900 truncate">{{ $colocation->name }}</h1>
                    @if($colocation->status === 'active')
                    <span class="inline-flex items-center gap-1 px-2.5 py-1 rounded-full text-xs font-semibold bg-emerald-50 text-emerald-700 border border-emerald-200">
                        <span class="w-1.5 h-1.5 rounded-full bg-emerald-500 inline-block"></span>
                        Active
                    </span>
                    @else
                    <span class="inline-flex items-center gap-1 px-2.5 py-1 rounded-full text-xs font-semibold bg-gray-100 text-gray-500 border border-gray-200">
                        <span class="w-1.5 h-1.5 rounded-full bg-gray-400 inline-block"></span>
                        {{ ucfirst($colocation->status) }}
                    </span>
                    @endif
                </div>
                @if($colocation->description)
                <p class="text-gray-500 text-sm">{{ $colocation->description }}</p>
                @endif
            </div>

            {{-- Owner / member actions --}}
            <div class="flex items-center gap-2 flex-shrink-0">
                @if($isOwner)
                <a href="{{ route('colocations.edit', $colocation) }}"
                   class="inline-flex items-center gap-2 px-4 py-2 bg-white border border-gray-300 text-gray-700 font-semibold text-sm rounded-xl hover:bg-gray-50 transition-colors">
                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                    </svg>
                    Modifier
                </a>
                <form method="POST" action="{{ route('colocations.cancel', $colocation) }}"
                      onsubmit="return confirm('Annuler cette colocation ?')">
                    @csrf
                    <button type="submit"
                            class="inline-flex items-center gap-2 px-4 py-2 bg-red-50 border border-red-200 text-red-600 font-semibold text-sm rounded-xl hover:bg-red-100 transition-colors">
                        Annuler
                    </button>
                </form>
                @else
                <form method="POST" action="{{ route('colocations.leave', $colocation) }}"
                      onsubmit="return confirm('Quitter cette colocation ?')">
                    @csrf
                    <button type="submit"
                            class="inline-flex items-center gap-2 px-4 py-2 bg-red-50 border border-red-200 text-red-600 font-semibold text-sm rounded-xl hover:bg-red-100 transition-colors">
                        Quitter
                    </button>
                </form>
                @endif
            </div>
        </div>

        {{-- Invite token section (owner only) --}}
        @if($isOwner)
        <div class="bg-emerald-50 border border-emerald-100 rounded-2xl p-5">
            <div class="flex items-center gap-2 mb-3">
                <svg class="w-4 h-4 text-emerald-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.828 10.172a4 4 0 00-5.656 0l-4 4a4 4 0 105.656 5.656l1.102-1.101m-.758-4.899a4 4 0 005.656 0l4-4a4 4 0 00-5.656-5.656l-1.1 1.1"/>
                </svg>
                <p class="text-sm font-semibold text-emerald-800">Inviter un colocataire</p>
            </div>
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                {{-- Token display --}}
                <div>
                    <label class="block text-xs font-medium text-emerald-700 mb-1.5">Token d'invitation</label>
                    <input type="text" readonly value="{{ $colocation->invite_token }}"
                           class="block w-full rounded-xl border border-emerald-200 bg-white px-3 py-2 text-sm text-gray-700 outline-none select-all font-mono">
                </div>
                {{-- Email invite --}}
                <div>
                    <label class="block text-xs font-medium text-emerald-700 mb-1.5">Inviter par email</label>
                    <form method="POST" action="#" class="flex gap-2">
                        @csrf
                        <input type="email" name="email"
                               class="flex-1 block rounded-xl border border-emerald-200 bg-white px-3 py-2 text-sm text-gray-700 placeholder-gray-400 outline-none focus:border-emerald-500 focus:ring-2 focus:ring-emerald-500/20 transition-all"
                               placeholder="colocataire@email.fr">
                        <button type="submit"
                                class="px-4 py-2 bg-emerald-500 hover:bg-emerald-600 text-white font-semibold text-sm rounded-xl transition-colors whitespace-nowrap">
                            Envoyer
                        </button>
                    </form>
                </div>
            </div>
        </div>
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
        <div class="tab-nav flex overflow-x-auto border-b border-gray-200 px-2">
            <label for="tab-membres" class="tab-label label-membres">Membres</label>
            <label for="tab-depenses" class="tab-label label-depenses">Dépenses</label>
            <label for="tab-soldes" class="tab-label label-soldes">Soldes</label>
            <label for="tab-reglements" class="tab-label label-reglements">Règlements</label>
            @if($isOwner)
            <label for="tab-categories" class="tab-label label-categories">Catégories</label>
            @endif
        </div>

        {{-- Tab panels --}}
        <div class="tab-panels p-6">

            {{-- ===== MEMBRES ===== --}}
            <div class="tab-panel panel-membres">
                <div class="space-y-1">
                    @forelse($colocation->users as $member)
                    <div class="flex items-center justify-between py-3.5 px-2 border-b border-gray-50 last:border-0 stagger-item rounded-xl hover:bg-gray-50 transition-colors">
                        <div class="flex items-center gap-3">
                            <x-avatar :name="$member->name" size="sm"/>
                            <div>
                                <p class="text-sm font-semibold text-gray-900">
                                    {{ $member->name }}
                                    @if($member->id === Auth::id())
                                    <span class="text-xs text-gray-400 font-normal">(moi)</span>
                                    @endif
                                </p>
                                <p class="text-xs text-gray-400">{{ $member->email }}</p>
                            </div>
                        </div>
                        <div class="flex items-center gap-2">
                            <x-badge :variant="$member->pivot->role === 'owner' ? 'owner' : 'member'">
                                {{ $member->pivot->role === 'owner' ? 'Propriétaire' : 'Membre' }}
                            </x-badge>
                            @if($isOwner && $member->id !== Auth::id())
                            <form method="POST"
                                  action="{{ route('colocations.removeMember', [$colocation, $member->id]) }}"
                                  onsubmit="return confirm('Retirer ce membre ?')">
                                @csrf
                                <button type="submit"
                                        class="text-gray-300 hover:text-red-500 p-1 transition-colors" title="Retirer">
                                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                                    </svg>
                                </button>
                            </form>
                            @endif
                        </div>
                    </div>
                    @empty
                    <div class="text-center py-12">
                        <p class="text-sm text-gray-400">Aucun membre.</p>
                    </div>
                    @endforelse
                </div>
            </div>

            {{-- ===== DÉPENSES ===== --}}
            <div class="tab-panel panel-depenses">
                <div class="flex items-center justify-between mb-5">
                    <p class="text-sm font-semibold text-gray-700">
                        {{ $colocation->expenses->count() }} dépense(s)
                        &nbsp;·&nbsp;
                        <span class="text-emerald-600 font-bold">{{ number_format($colocation->expenses->sum('amount'), 2, ',', ' ') }} €</span>
                    </p>
                    <a href="#modal-add-expense"
                       class="inline-flex items-center gap-1.5 px-3.5 py-2 bg-emerald-500 hover:bg-emerald-600 text-white font-semibold text-sm rounded-xl transition-colors">
                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                        </svg>
                        Ajouter
                    </a>
                </div>
                @if($colocation->expenses->isEmpty())
                <div class="text-center py-14">
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
                                <th class="text-left px-6 py-3.5 text-xs font-semibold text-gray-500 uppercase tracking-wider">Catégorie</th>
                                <th class="text-left px-6 py-3.5 text-xs font-semibold text-gray-500 uppercase tracking-wider">Titre</th>
                                <th class="text-left px-6 py-3.5 text-xs font-semibold text-gray-500 uppercase tracking-wider">Payé par</th>
                                <th class="text-right px-6 py-3.5 text-xs font-semibold text-gray-500 uppercase tracking-wider">Montant</th>
                                <th class="text-right px-6 py-3.5 text-xs font-semibold text-gray-500 uppercase tracking-wider">Date</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-50">
                            @foreach($colocation->expenses->sortByDesc('date') as $expense)
                            <tr class="hover:bg-gray-50 transition-colors stagger-item">
                                <td class="px-6 py-4 text-sm">
                                    <span class="inline-flex items-center gap-2 text-gray-500">
                                        <span class="w-2 h-2 rounded-full bg-emerald-400 inline-block flex-shrink-0"></span>
                                        {{ $expense->category->name ?? 'Sans catégorie' }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 text-sm font-semibold text-gray-900">{{ $expense->title }}</td>
                                <td class="px-6 py-4">
                                    <div class="flex items-center gap-2">
                                        <x-avatar :name="$expense->user->name ?? 'U'" size="xs"/>
                                        <span class="text-sm text-gray-500">{{ $expense->user->name ?? '—' }}</span>
                                    </div>
                                </td>
                                <td class="px-6 py-4 text-right">
                                    <span class="text-sm font-bold text-emerald-600">
                                        {{ number_format($expense->amount, 2, ',', ' ') }} €
                                    </span>
                                </td>
                                <td class="px-6 py-4 text-right text-sm text-gray-400 whitespace-nowrap">
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
                @php
                    $memberCount = $colocation->users->count();
                    $totalExpenses = $colocation->expenses->sum('amount');
                    $sharePerMember = $memberCount > 0 ? $totalExpenses / $memberCount : 0;
                    $memberBalances = $colocation->users->map(function($u) use ($colocation, $sharePerMember) {
                        $paid = $colocation->expenses->where('user_id', $u->id)->sum('amount');
                        return ['member' => $u, 'balance' => round($paid - $sharePerMember, 2), 'paid' => $paid];
                    });
                @endphp

                @if($colocation->expenses->isEmpty())
                <div class="text-center py-14">
                    <div class="w-12 h-12 bg-gray-100 rounded-xl flex items-center justify-center mx-auto mb-3">
                        <svg class="w-6 h-6 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.75" d="M3 6l3 1m0 0l-3 9a5.002 5.002 0 006.001 0M6 7l3 9M6 7l6-2m6 2l3-1m-3 1l-3 9a5.002 5.002 0 006.001 0M18 7l3 9m-3-9l-6-2m0-2v2m0 16V5m0 16H9m3 0h3"/>
                        </svg>
                    </div>
                    <p class="text-sm font-semibold text-gray-700 mb-1">Aucune dépense à répartir</p>
                    <p class="text-xs text-gray-400">Enregistrez des dépenses pour voir les soldes.</p>
                </div>
                @else
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 mb-6">
                    @foreach($memberBalances as $b)
                    @php $balance = $b['balance']; $member = $b['member']; @endphp
                    <div class="flex items-center gap-4 p-4 bg-gray-50 rounded-2xl border border-gray-100 stagger-item hover:shadow-sm transition-shadow">
                        <x-avatar :name="$member->name" size="md"/>
                        <div class="flex-1 min-w-0">
                            <p class="text-sm font-semibold text-gray-900 truncate">
                                {{ $member->name }}
                                @if($member->id === Auth::id()) <span class="text-xs text-gray-400 font-normal">(moi)</span> @endif
                            </p>
                            <p class="text-xs text-gray-400 mt-0.5">
                                A payé {{ number_format($b['paid'], 2, ',', ' ') }} €
                                · part : {{ number_format($sharePerMember, 2, ',', ' ') }} €
                            </p>
                        </div>
                        <div class="text-right flex-shrink-0">
                            <p class="text-lg font-bold {{ $balance >= 0 ? 'text-emerald-600' : 'text-red-500' }}">
                                {{ $balance >= 0 ? '+' : '' }}{{ number_format($balance, 2, ',', ' ') }} €
                            </p>
                            <p class="text-xs {{ $balance >= 0 ? 'text-emerald-500' : 'text-red-400' }} font-medium">
                                {{ $balance > 0 ? 'à recevoir' : ($balance < 0 ? 'à payer' : 'équilibré') }}
                            </p>
                        </div>
                    </div>
                    @endforeach
                </div>
                <p class="text-xs text-gray-400 text-center">
                    Répartition égale de {{ number_format($sharePerMember, 2, ',', ' ') }} € / membre
                    sur un total de {{ number_format($totalExpenses, 2, ',', ' ') }} €
                </p>
                @endif
            </div>

            {{-- ===== RÈGLEMENTS ===== --}}
            <div class="tab-panel panel-reglements">
                @php $settlements = $colocation->expenses->flatMap(fn($e) => $e->relationLoaded('settlements') ? $e->settlements : collect())->sortByDesc('paid_at'); @endphp
                <div class="flex items-center justify-between mb-5">
                    <p class="text-sm font-semibold text-gray-700">
                        {{ $settlements->count() }} règlement(s)
                    </p>
                    <a href="#modal-add-settlement"
                       class="inline-flex items-center gap-1.5 px-3.5 py-2 bg-emerald-500 hover:bg-emerald-600 text-white font-semibold text-sm rounded-xl transition-colors">
                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                        </svg>
                        Ajouter
                    </a>
                </div>
                @if($settlements->isEmpty())
                <div class="text-center py-14">
                    <div class="w-12 h-12 bg-gray-100 rounded-xl flex items-center justify-center mx-auto mb-3">
                        <svg class="w-6 h-6 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.75" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                    </div>
                    <p class="text-sm font-semibold text-gray-700 mb-1">Aucun règlement enregistré</p>
                    <p class="text-xs text-gray-400">Les remboursements apparaîtront ici.</p>
                </div>
                @else
                <div class="overflow-x-auto -mx-6">
                    <table class="w-full">
                        <thead>
                            <tr class="border-b border-gray-100 bg-gray-50/50">
                                <th class="text-left px-6 py-3.5 text-xs font-semibold text-gray-500 uppercase tracking-wider">Date</th>
                                <th class="text-left px-6 py-3.5 text-xs font-semibold text-gray-500 uppercase tracking-wider">Membre</th>
                                <th class="text-left px-6 py-3.5 text-xs font-semibold text-gray-500 uppercase tracking-wider">Dépense</th>
                                <th class="text-right px-6 py-3.5 text-xs font-semibold text-gray-500 uppercase tracking-wider">Montant</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-50">
                            @foreach($settlements as $settlement)
                            <tr class="hover:bg-gray-50 transition-colors stagger-item">
                                <td class="px-6 py-4 text-sm text-gray-500 whitespace-nowrap">
                                    {{ $settlement->paid_at->format('d/m/Y') }}
                                </td>
                                <td class="px-6 py-4">
                                    <div class="flex items-center gap-2">
                                        <x-avatar :name="$settlement->user->name ?? 'U'" size="xs"/>
                                        <span class="text-sm text-gray-700">{{ $settlement->user->name ?? '—' }}</span>
                                    </div>
                                </td>
                                <td class="px-6 py-4 text-sm text-gray-500">
                                    {{ $settlement->expense->title ?? '—' }}
                                </td>
                                <td class="px-6 py-4 text-right">
                                    <span class="text-sm font-bold text-emerald-600">
                                        {{ number_format($settlement->amount, 2, ',', ' ') }} €
                                    </span>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                @endif
            </div>

            {{-- ===== CATÉGORIES (owner only) ===== --}}
            @if($isOwner)
            <div class="tab-panel panel-categories">
                {{-- Add category form --}}
                <form method="POST" action="#" class="flex gap-3 mb-6">
                    @csrf
                    <input type="text" name="name" required
                           class="flex-1 block rounded-xl border border-gray-300 px-4 py-2.5 text-sm text-gray-900 placeholder-gray-400 outline-none focus:border-emerald-500 focus:ring-2 focus:ring-emerald-500/20 transition-all"
                           placeholder="Nom de la catégorie — ex: Loyer, Courses…">
                    <button type="submit"
                            class="inline-flex items-center gap-2 px-5 py-2.5 bg-emerald-500 hover:bg-emerald-600 text-white font-semibold text-sm rounded-xl transition-colors whitespace-nowrap">
                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                        </svg>
                        Ajouter
                    </button>
                </form>

                @if($colocation->categories->isEmpty())
                <div class="text-center py-10">
                    <div class="w-12 h-12 bg-gray-100 rounded-xl flex items-center justify-center mx-auto mb-3">
                        <svg class="w-6 h-6 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.75" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"/>
                        </svg>
                    </div>
                    <p class="text-sm text-gray-400">Aucune catégorie. Créez-en une ci-dessus.</p>
                </div>
                @else
                <div class="space-y-2">
                    @foreach($colocation->categories as $category)
                    <div class="flex items-center justify-between px-4 py-3 bg-gray-50 rounded-xl border border-gray-100 hover:border-gray-200 transition-colors stagger-item">
                        <div class="flex items-center gap-3">
                            <div class="w-8 h-8 bg-emerald-100 rounded-lg flex items-center justify-center text-emerald-600">
                                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.75" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"/>
                                </svg>
                            </div>
                            <div>
                                <p class="text-sm font-semibold text-gray-900">{{ $category->name }}</p>
                                <p class="text-xs text-gray-400">{{ $category->expenses_count ?? 0 }} dépense(s)</p>
                            </div>
                        </div>
                        <form method="POST" action="#"
                              onsubmit="return confirm('Supprimer « {{ $category->name }} » ?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit"
                                    class="text-gray-300 hover:text-red-500 p-1.5 transition-colors rounded-lg hover:bg-red-50"
                                    title="Supprimer">
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

    {{-- ===== MODAL: Ajouter une dépense ===== --}}
    <div id="modal-add-expense" class="modal">
        <div class="bg-white rounded-2xl shadow-xl w-full max-w-md p-6">
            <div class="flex items-center justify-between mb-5">
                <h3 class="text-base font-bold text-gray-900">Nouvelle dépense</h3>
                <a href="#" class="text-gray-400 hover:text-gray-600 transition-colors p-1">
                    <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                    </svg>
                </a>
            </div>
            <form method="POST" action="#" class="space-y-4">
                @csrf
                <div>
                    <label class="block text-xs font-semibold text-gray-600 mb-1.5">Titre</label>
                    <input type="text" name="title" required
                           class="block w-full rounded-xl border border-gray-300 px-4 py-2.5 text-sm text-gray-900 placeholder-gray-400 outline-none focus:border-emerald-500 focus:ring-2 focus:ring-emerald-500/20 transition-all"
                           placeholder="Ex: Loyer de mars">
                </div>
                <div class="grid grid-cols-2 gap-3">
                    <div>
                        <label class="block text-xs font-semibold text-gray-600 mb-1.5">Montant (€)</label>
                        <input type="number" name="amount" step="0.01" min="0.01" required
                               class="block w-full rounded-xl border border-gray-300 px-4 py-2.5 text-sm text-gray-900 placeholder-gray-400 outline-none focus:border-emerald-500 focus:ring-2 focus:ring-emerald-500/20 transition-all"
                               placeholder="0,00">
                    </div>
                    <div>
                        <label class="block text-xs font-semibold text-gray-600 mb-1.5">Date</label>
                        <input type="date" name="date" required value="{{ date('Y-m-d') }}"
                               class="block w-full rounded-xl border border-gray-300 px-4 py-2.5 text-sm text-gray-900 outline-none focus:border-emerald-500 focus:ring-2 focus:ring-emerald-500/20 transition-all">
                    </div>
                </div>
                <div>
                    <label class="block text-xs font-semibold text-gray-600 mb-1.5">Catégorie</label>
                    <select name="category_id"
                            class="block w-full rounded-xl border border-gray-300 px-4 py-2.5 text-sm text-gray-900 outline-none focus:border-emerald-500 focus:ring-2 focus:ring-emerald-500/20 transition-all bg-white">
                        <option value="">Sans catégorie</option>
                        @foreach($colocation->categories as $cat)
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

    {{-- ===== MODAL: Ajouter un règlement ===== --}}
    <div id="modal-add-settlement" class="modal">
        <div class="bg-white rounded-2xl shadow-xl w-full max-w-md p-6">
            <div class="flex items-center justify-between mb-5">
                <h3 class="text-base font-bold text-gray-900">Nouveau règlement</h3>
                <a href="#" class="text-gray-400 hover:text-gray-600 transition-colors p-1">
                    <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                    </svg>
                </a>
            </div>
            <form method="POST" action="#" class="space-y-4">
                @csrf
                <div>
                    <label class="block text-xs font-semibold text-gray-600 mb-1.5">Dépense concernée</label>
                    <select name="expense_id" required
                            class="block w-full rounded-xl border border-gray-300 px-4 py-2.5 text-sm text-gray-900 outline-none focus:border-emerald-500 focus:ring-2 focus:ring-emerald-500/20 transition-all bg-white">
                        <option value="">— Choisir une dépense —</option>
                        @foreach($colocation->expenses as $exp)
                        <option value="{{ $exp->id }}">{{ $exp->title }} ({{ number_format($exp->amount, 2, ',', ' ') }} €)</option>
                        @endforeach
                    </select>
                </div>
                <div class="grid grid-cols-2 gap-3">
                    <div>
                        <label class="block text-xs font-semibold text-gray-600 mb-1.5">Montant réglé (€)</label>
                        <input type="number" name="amount" step="0.01" min="0.01" required
                               class="block w-full rounded-xl border border-gray-300 px-4 py-2.5 text-sm text-gray-900 placeholder-gray-400 outline-none focus:border-emerald-500 focus:ring-2 focus:ring-emerald-500/20 transition-all"
                               placeholder="0,00">
                    </div>
                    <div>
                        <label class="block text-xs font-semibold text-gray-600 mb-1.5">Date du règlement</label>
                        <input type="date" name="paid_at" required value="{{ date('Y-m-d') }}"
                               class="block w-full rounded-xl border border-gray-300 px-4 py-2.5 text-sm text-gray-900 outline-none focus:border-emerald-500 focus:ring-2 focus:ring-emerald-500/20 transition-all">
                    </div>
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
