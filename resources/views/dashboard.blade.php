<x-app-layout>
    <x-slot name="title">Tableau de bord — ClocShare</x-slot>

    {{-- Hero --}}
    <div class="mb-12 text-center">
        <h1 class="text-3xl font-bold text-gray-900 mb-2">
            Bienvenue sur ColocShare, {{ Auth::user()->name }} 👋
        </h1>
        <p class="text-gray-500 text-sm">Gérez vos dépenses en colocation simplement et sans prise de tête.</p>
    </div>

    {{-- How it works --}}
    <div class="mb-10">
        <div class="flex items-center gap-4 mb-6">
            <h2 class="text-sm font-bold text-gray-900 uppercase tracking-wider whitespace-nowrap">Comment ça marche</h2>
            <div class="flex-1 h-px bg-gray-200"></div>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">

            {{-- Step 1 --}}
            <div class="bg-white border border-gray-200 rounded-2xl p-6 text-center hover:shadow-sm transition-shadow stagger-1">
                <div class="w-12 h-12 bg-emerald-50 rounded-2xl flex items-center justify-center mx-auto mb-4">
                    <svg class="w-6 h-6 text-emerald-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.75" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/>
                    </svg>
                </div>
                <div class="w-6 h-6 rounded-full bg-emerald-100 text-emerald-700 text-xs font-bold flex items-center justify-center mx-auto mb-3">1</div>
                <h3 class="font-semibold text-gray-900 mb-2">Créez votre colocation</h3>
                <p class="text-xs text-gray-500 leading-relaxed">Donnez un nom à votre espace partagé et configurez-le en une minute.</p>
            </div>

            {{-- Step 2 --}}
            <div class="bg-white border border-gray-200 rounded-2xl p-6 text-center hover:shadow-sm transition-shadow stagger-2">
                <div class="w-12 h-12 bg-emerald-50 rounded-2xl flex items-center justify-center mx-auto mb-4">
                    <svg class="w-6 h-6 text-emerald-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.75" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                    </svg>
                </div>
                <div class="w-6 h-6 rounded-full bg-emerald-100 text-emerald-700 text-xs font-bold flex items-center justify-center mx-auto mb-3">2</div>
                <h3 class="font-semibold text-gray-900 mb-2">Invitez vos colocataires</h3>
                <p class="text-xs text-gray-500 leading-relaxed">Envoyez une invitation par e-mail. Chacun rejoint votre espace en un clic.</p>
            </div>

            {{-- Step 3 --}}
            <div class="bg-white border border-gray-200 rounded-2xl p-6 text-center hover:shadow-sm transition-shadow stagger-3">
                <div class="w-12 h-12 bg-emerald-50 rounded-2xl flex items-center justify-center mx-auto mb-4">
                    <svg class="w-6 h-6 text-emerald-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.75" d="M9 14l6-6m-5.5.5h.01m4.99 5h.01M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16l3.5-2 3.5 2 3.5-2 3.5 2z"/>
                    </svg>
                </div>
                <div class="w-6 h-6 rounded-full bg-emerald-100 text-emerald-700 text-xs font-bold flex items-center justify-center mx-auto mb-3">3</div>
                <h3 class="font-semibold text-gray-900 mb-2">Partagez les dépenses</h3>
                <p class="text-xs text-gray-500 leading-relaxed">Enregistrez chaque dépense, consultez les soldes et soldez les comptes facilement.</p>
            </div>

        </div>
    </div>

    {{-- CTA --}}
    <div class="text-center">
        <a href="{{ route('colocations.index') }}"
           class="inline-flex items-center gap-2 px-6 py-3 bg-emerald-500 hover:bg-emerald-600 text-white font-semibold text-sm rounded-xl transition-colors">
            Voir mes colocations
            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6"/>
            </svg>
        </a>
    </div>

</x-app-layout>
