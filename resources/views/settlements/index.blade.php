<x-app-layout>
    <x-slot name="title">Règlements — ClocShare</x-slot>

    {{-- Header --}}
    <div class="flex items-center justify-between mb-8">
        <div>
            <h1 class="text-2xl font-bold text-gray-900">Règlements</h1>
            <p class="text-gray-500 text-sm mt-1">Historique des remboursements effectués.</p>
        </div>
        <a href="#add-settlement-modal"
           class="inline-flex items-center gap-2 px-4 py-2.5 bg-emerald-500 hover:bg-emerald-600 text-white font-semibold text-sm rounded-xl transition-colors">
            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
            </svg>
            Enregistrer un règlement
        </a>
    </div>

    {{-- Settlements list --}}
    <div class="bg-white border border-gray-200 rounded-2xl overflow-hidden">

        @if(!isset($settlements) || $settlements->isEmpty())
        {{-- Empty state --}}
        <div class="p-16 text-center">
            <div class="w-14 h-14 bg-gray-100 rounded-2xl flex items-center justify-center mx-auto mb-4">
                <svg class="w-7 h-7 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.75" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
            </div>
            <p class="text-sm font-semibold text-gray-700 mb-1">Aucun règlement enregistré</p>
            <p class="text-xs text-gray-400 mb-5">Les remboursements entre colocataires apparaîtront ici.</p>
            <a href="#add-settlement-modal"
               class="inline-flex items-center gap-2 px-4 py-2.5 bg-emerald-500 hover:bg-emerald-600 text-white font-semibold text-sm rounded-xl transition-colors">
                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                </svg>
                Enregistrer un règlement
            </a>
        </div>

        @else
        {{-- Total --}}
        <div class="px-6 py-4 border-b border-gray-100 bg-gray-50 flex items-center justify-between">
            <p class="text-sm text-gray-500">
                <span class="font-semibold text-gray-900">{{ $settlements->count() }}</span>
                règlement(s) au total
            </p>
            <p class="text-sm font-semibold text-emerald-600">
                {{ number_format($settlements->sum('amount'), 2, ',', ' ') }} DH remboursés
            </p>
        </div>

        {{-- Table --}}
        <div class="overflow-x-auto">
            <table class="w-full">
                <thead>
                    <tr class="border-b border-gray-100">
                        <th class="text-left px-6 py-3.5 text-xs font-semibold text-gray-500 uppercase tracking-wider">Date</th>
                        <th class="text-left px-6 py-3.5 text-xs font-semibold text-gray-500 uppercase tracking-wider">De</th>
                        <th class="text-left px-6 py-3.5 text-xs font-semibold text-gray-500 uppercase tracking-wider">Dépense liée</th>
                        <th class="text-right px-6 py-3.5 text-xs font-semibold text-gray-500 uppercase tracking-wider">Montant</th>
                        <th class="px-6 py-3.5"></th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-50">
                    @foreach($settlements->sortByDesc('paid_at') as $settlement)
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
                        <td class="px-6 py-4 text-right whitespace-nowrap">
                            <span class="text-sm font-semibold text-emerald-600">
                                {{ number_format($settlement->amount, 2, ',', ' ') }} DH
                            </span>
                        </td>
                        <td class="px-6 py-4 text-right">
                            <span class="inline-flex items-center gap-1 text-xs text-emerald-600 font-medium">
                                <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/>
                                </svg>
                                Réglé
                            </span>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        @endif

    </div>

    {{-- Add settlement modal --}}
    <x-modal id="add-settlement-modal" title="Enregistrer un règlement">
        <form method="POST" action="#" class="space-y-4">
            @csrf

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1.5">Dépense remboursée <span class="text-red-500">*</span></label>
                <select name="expense_id" required
                        class="block w-full rounded-xl border border-gray-300 px-4 py-2.5 text-sm outline-none focus:border-emerald-500 focus:ring-2 focus:ring-emerald-500/20 transition-all bg-white">
                    <option value="">Sélectionnez une dépense…</option>
                    @foreach($expenses ?? [] as $expense)
                    <option value="{{ $expense->id }}">
                        {{ $expense->title }} — {{ number_format($expense->amount, 2, ',', ' ') }} DH
                    </option>
                    @endforeach
                </select>
                @error('expense_id')
                <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
                @enderror
            </div>

            <div class="grid grid-cols-2 gap-3">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1.5">Montant (DH) <span class="text-red-500">*</span></label>
                    <input type="number" name="amount" value="{{ old('amount') }}" required step="0.01" min="0.01"
                           class="block w-full rounded-xl border border-gray-300 px-4 py-2.5 text-sm outline-none focus:border-emerald-500 focus:ring-2 focus:ring-emerald-500/20 transition-all"
                           placeholder="0,00">
                    @error('amount')
                    <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
                    @enderror
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1.5">Date de règlement</label>
                    <input type="date" name="paid_at" value="{{ old('paid_at', date('Y-m-d')) }}"
                           class="block w-full rounded-xl border border-gray-300 px-4 py-2.5 text-sm outline-none focus:border-emerald-500 focus:ring-2 focus:ring-emerald-500/20 transition-all">
                </div>
            </div>

            <button type="submit"
                    class="w-full px-4 py-2.5 bg-emerald-500 hover:bg-emerald-600 text-white font-semibold text-sm rounded-xl transition-colors">
                Enregistrer le règlement
            </button>
        </form>
    </x-modal>

</x-app-layout>
