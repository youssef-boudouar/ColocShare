<x-app-layout>
    <x-slot name="title">Dépenses — ClocShare</x-slot>

    {{-- Header --}}
    <div class="flex items-center justify-between mb-8">
        <div>
            <h1 class="text-2xl font-bold text-gray-900">Dépenses</h1>
            <p class="text-gray-500 text-sm mt-1">
                Toutes les dépenses de {{ $colocation->name ?? 'votre colocation' }}.
            </p>
        </div>
        <a href="#add-expense-modal"
           class="inline-flex items-center gap-2 px-4 py-2.5 bg-emerald-500 hover:bg-emerald-600 text-white font-semibold text-sm rounded-xl transition-colors">
            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
            </svg>
            Ajouter une dépense
        </a>
    </div>

    {{-- Summary bar --}}
    @if(isset($expenses) && $expenses->isNotEmpty())
    <div class="grid grid-cols-1 sm:grid-cols-3 gap-4 mb-6">
        <div class="bg-white border border-gray-200 rounded-xl p-4">
            <p class="text-xs font-medium text-gray-500 uppercase tracking-wider mb-1">Total ce mois</p>
            <p class="text-xl font-bold text-gray-900">
                {{ number_format($expenses->where('date', '>=', now()->startOfMonth())->sum('amount'), 2, ',', ' ') }} €
            </p>
        </div>
        <div class="bg-white border border-gray-200 rounded-xl p-4">
            <p class="text-xs font-medium text-gray-500 uppercase tracking-wider mb-1">Total général</p>
            <p class="text-xl font-bold text-emerald-600">
                {{ number_format($expenses->sum('amount'), 2, ',', ' ') }} €
            </p>
        </div>
        <div class="bg-white border border-gray-200 rounded-xl p-4">
            <p class="text-xs font-medium text-gray-500 uppercase tracking-wider mb-1">Nombre de dépenses</p>
            <p class="text-xl font-bold text-gray-900">{{ $expenses->count() }}</p>
        </div>
    </div>
    @endif

    {{-- Expenses table --}}
    <div class="bg-white border border-gray-200 rounded-2xl overflow-hidden">

        @if(!isset($expenses) || $expenses->isEmpty())
        {{-- Empty state --}}
        <div class="p-16 text-center">
            <div class="w-14 h-14 bg-gray-100 rounded-2xl flex items-center justify-center mx-auto mb-4">
                <svg class="w-7 h-7 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.75" d="M9 14l6-6m-5.5.5h.01m4.99 5h.01M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16l3.5-2 3.5 2 3.5-2 3.5 2z"/>
                </svg>
            </div>
            <p class="text-sm font-semibold text-gray-700 mb-1">Aucune dépense enregistrée</p>
            <p class="text-xs text-gray-400 mb-5">Commencez par ajouter votre première dépense.</p>
            <a href="#add-expense-modal"
               class="inline-flex items-center gap-2 px-4 py-2.5 bg-emerald-500 hover:bg-emerald-600 text-white font-semibold text-sm rounded-xl transition-colors">
                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                </svg>
                Ajouter une dépense
            </a>
        </div>

        @else
        {{-- Table --}}
        <div class="overflow-x-auto">
            <table class="w-full">
                <thead>
                    <tr class="border-b border-gray-100 bg-gray-50">
                        <th class="text-left px-6 py-3.5 text-xs font-semibold text-gray-500 uppercase tracking-wider">Date</th>
                        <th class="text-left px-6 py-3.5 text-xs font-semibold text-gray-500 uppercase tracking-wider">Catégorie</th>
                        <th class="text-left px-6 py-3.5 text-xs font-semibold text-gray-500 uppercase tracking-wider">Titre</th>
                        <th class="text-left px-6 py-3.5 text-xs font-semibold text-gray-500 uppercase tracking-wider">Payé par</th>
                        <th class="text-right px-6 py-3.5 text-xs font-semibold text-gray-500 uppercase tracking-wider">Montant</th>
                        <th class="px-6 py-3.5"></th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-50">
                    @foreach($expenses->sortByDesc('date') as $expense)
                    <tr class="hover:bg-gray-50 transition-colors stagger-item">
                        <td class="px-6 py-4 text-sm text-gray-500 whitespace-nowrap">
                            {{ $expense->date->format('d/m/Y') }}
                        </td>
                        <td class="px-6 py-4 text-sm">
                            <span class="inline-flex items-center gap-1.5 text-gray-500">
                                <span class="w-2 h-2 rounded-full bg-emerald-400 inline-block flex-shrink-0"></span>
                                {{ $expense->category->name ?? 'Sans catégorie' }}
                            </span>
                        </td>
                        <td class="px-6 py-4 text-sm font-medium text-gray-900">{{ $expense->title }}</td>
                        <td class="px-6 py-4">
                            <div class="flex items-center gap-2">
                                <x-avatar :name="$expense->user->name ?? 'U'" size="xs"/>
                                <span class="text-sm text-gray-500">
                                    {{ $expense->user->id === Auth::id() ? 'Moi' : ($expense->user->name ?? '—') }}
                                </span>
                            </div>
                        </td>
                        <td class="px-6 py-4 text-right whitespace-nowrap">
                            <span class="text-sm font-semibold text-emerald-600">
                                {{ number_format($expense->amount, 2, ',', ' ') }} €
                            </span>
                        </td>
                        <td class="px-6 py-4 text-right">
                            @if($expense->user_id === Auth::id())
                            <form method="POST" action="#"
                                  onsubmit="return confirm('Supprimer cette dépense ?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-red-400 hover:text-red-600 p-1 transition-colors" title="Supprimer">
                                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                    </svg>
                                </button>
                            </form>
                            @endif
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        @endif

    </div>

    {{-- Add expense modal --}}
    <x-modal id="add-expense-modal" title="Nouvelle dépense">
        <form method="POST" action="#" class="space-y-4">
            @csrf

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1.5">Titre <span class="text-red-500">*</span></label>
                <input type="text" name="title" value="{{ old('title') }}" required
                       class="block w-full rounded-xl border border-gray-300 px-4 py-2.5 text-sm outline-none focus:border-emerald-500 focus:ring-2 focus:ring-emerald-500/20 transition-all"
                       placeholder="Ex : Loyer, Courses, Électricité…">
                @error('title')
                <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
                @enderror
            </div>

            <div class="grid grid-cols-2 gap-3">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1.5">Montant (€) <span class="text-red-500">*</span></label>
                    <input type="number" name="amount" value="{{ old('amount') }}" required step="0.01" min="0.01"
                           class="block w-full rounded-xl border border-gray-300 px-4 py-2.5 text-sm outline-none focus:border-emerald-500 focus:ring-2 focus:ring-emerald-500/20 transition-all"
                           placeholder="0,00">
                    @error('amount')
                    <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
                    @enderror
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1.5">Date <span class="text-red-500">*</span></label>
                    <input type="date" name="date" value="{{ old('date', date('Y-m-d')) }}" required
                           class="block w-full rounded-xl border border-gray-300 px-4 py-2.5 text-sm outline-none focus:border-emerald-500 focus:ring-2 focus:ring-emerald-500/20 transition-all">
                    @error('date')
                    <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1.5">Catégorie</label>
                <select name="category_id"
                        class="block w-full rounded-xl border border-gray-300 px-4 py-2.5 text-sm outline-none focus:border-emerald-500 focus:ring-2 focus:ring-emerald-500/20 transition-all bg-white">
                    <option value="">Sans catégorie</option>
                    @foreach($categories ?? [] as $category)
                    <option value="{{ $category->id }}" {{ old('category_id') == $category->id ? 'selected' : '' }}>
                        {{ $category->name }}
                    </option>
                    @endforeach
                </select>
            </div>

            <button type="submit"
                    class="w-full px-4 py-2.5 bg-emerald-500 hover:bg-emerald-600 text-white font-semibold text-sm rounded-xl transition-colors">
                Enregistrer la dépense
            </button>
        </form>
    </x-modal>

</x-app-layout>
