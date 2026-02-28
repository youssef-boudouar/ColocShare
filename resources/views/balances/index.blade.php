<x-app-layout>
    <x-slot name="title">Soldes — ClocShare</x-slot>

    {{-- Header --}}
    <div class="mb-8">
        <h1 class="text-2xl font-bold text-gray-900">Soldes</h1>
        <p class="text-gray-500 text-sm mt-1">
            Qui doit quoi à qui dans {{ $colocation->name ?? 'votre colocation' }}.
        </p>
    </div>

    @if(!isset($balances) || empty($balances))
    {{-- Empty state --}}
    <div class="bg-white border border-gray-200 rounded-2xl p-16 text-center">
        <div class="w-14 h-14 bg-gray-100 rounded-2xl flex items-center justify-center mx-auto mb-4">
            <svg class="w-7 h-7 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.75" d="M3 6l3 1m0 0l-3 9a5.002 5.002 0 006.001 0M6 7l3 9M6 7l6-2m6 2l3-1m-3 1l-3 9a5.002 5.002 0 006.001 0M18 7l3 9m-3-9l-6-2m0-2v2m0 16V5m0 16H9m3 0h3"/>
            </svg>
        </div>
        <p class="text-sm font-semibold text-gray-700 mb-1">Aucun solde à afficher</p>
        <p class="text-xs text-gray-400">Enregistrez des dépenses pour voir les soldes calculés automatiquement.</p>
    </div>

    @else

    {{-- Balance cards per member --}}
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4 mb-8">
        @foreach($balances as $b)
        @php $balance = $b['balance']; $member = $b['member']; @endphp
        <div class="bg-white border border-gray-200 rounded-2xl p-5 stagger-item">
            <div class="flex items-center gap-3 mb-4">
                <x-avatar :name="$member->name" size="md"/>
                <div class="min-w-0">
                    <p class="text-sm font-semibold text-gray-900 truncate">
                        {{ $member->name }}
                        @if($member->id === Auth::id()) <span class="text-xs text-gray-400 font-normal">(moi)</span> @endif
                    </p>
                    <p class="text-xs text-gray-400 truncate">{{ $member->email }}</p>
                </div>
            </div>
            <div class="flex items-baseline gap-1 mb-1">
                <span class="text-2xl font-bold {{ $balance >= 0 ? 'text-emerald-600' : 'text-red-500' }}">
                    {{ $balance >= 0 ? '+' : '' }}{{ number_format($balance, 2, ',', ' ') }} DH
                </span>
            </div>
            @if($balance > 0)
            <p class="text-xs text-emerald-600 font-medium">
                <span class="inline-block w-1.5 h-1.5 rounded-full bg-emerald-400 mr-1"></span>
                A avancé de l'argent
            </p>
            @elseif($balance < 0)
            <p class="text-xs text-red-500 font-medium">
                <span class="inline-block w-1.5 h-1.5 rounded-full bg-red-400 mr-1"></span>
                Doit de l'argent
            </p>
            @else
            <p class="text-xs text-gray-400">
                <span class="inline-block w-1.5 h-1.5 rounded-full bg-gray-300 mr-1"></span>
                À l'équilibre
            </p>
            @endif
        </div>
        @endforeach
    </div>

    {{-- Debts breakdown --}}
    @if(isset($debts) && !empty($debts))
    <div class="bg-white border border-gray-200 rounded-2xl overflow-hidden">
        <div class="px-6 py-4 border-b border-gray-100">
            <h2 class="font-semibold text-gray-900">Remboursements suggérés</h2>
            <p class="text-xs text-gray-400 mt-0.5">Pour équilibrer les comptes avec le moins de transactions possible.</p>
        </div>
        <div class="divide-y divide-gray-50">
            @foreach($debts as $debt)
            <div class="flex items-center gap-4 px-6 py-4 stagger-item">
                <div class="flex items-center gap-2 flex-1 min-w-0">
                    <x-avatar :name="$debt['from']->name" size="xs"/>
                    <span class="text-sm font-medium text-gray-900 truncate">{{ $debt['from']->name }}</span>
                </div>
                <div class="flex items-center gap-2 flex-shrink-0">
                    <svg class="w-4 h-4 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6"/>
                    </svg>
                    <span class="text-sm font-bold text-emerald-600">{{ number_format($debt['amount'], 2, ',', ' ') }} DH</span>
                    <svg class="w-4 h-4 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6"/>
                    </svg>
                </div>
                <div class="flex items-center gap-2 flex-1 min-w-0 justify-end">
                    <span class="text-sm font-medium text-gray-900 truncate">{{ $debt['to']->name }}</span>
                    <x-avatar :name="$debt['to']->name" size="xs"/>
                </div>
            </div>
            @endforeach
        </div>
    </div>
    @endif

    @endif

</x-app-layout>
