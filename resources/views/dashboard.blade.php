<x-app-layout>
    <x-slot name="title">Tableau de bord — ColocShare</x-slot>

    @php
        $active = auth()->user()->colocations()->where('status', 'active')->wherePivotNull('left_at')->first();
        $memberCount = $active?->users()->wherePivotNull('left_at')->count();
    @endphp

    {{-- ===== SECTION 1 — HERO ===== --}}
    <div class="relative overflow-hidden rounded-3xl bg-emerald-600 mb-20 animate-fade-in-up" style="background: linear-gradient(135deg, #10B981 0%, #059669 40%, #0D9488 100%);">
        {{-- Geometric pattern overlay --}}
        <div class="absolute inset-0 hero-pattern pointer-events-none"></div>

        {{-- Subtle decorative shapes — pushed to corners, away from text --}}
        <div class="absolute -top-16 -right-16 w-64 h-64 bg-white/10 rounded-full pointer-events-none"></div>
        <div class="absolute -bottom-24 -left-24 w-72 h-72 bg-white/[0.06] rounded-full pointer-events-none"></div>

        <div class="relative z-10 px-8 sm:px-12 py-14 sm:py-20">
            <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between gap-10">
                {{-- Left — text content (60%) --}}
                <div class="lg:w-[58%]">
                    <div class="inline-flex items-center gap-2 px-3.5 py-1.5 rounded-full bg-white/20 text-white text-xs font-semibold mb-6 backdrop-blur-sm">
                        <span class="text-sm">✨</span>
                        Votre espace collaboratif
                    </div>
                    <h1 class="text-4xl lg:text-5xl font-extrabold text-white mb-5 leading-tight tracking-tight">
                        Bienvenue, {{ auth()->user()->name }}
                    </h1>
                    <p class="text-emerald-100 text-lg leading-relaxed mb-8 max-w-lg">
                        Simplifiez la gestion de vos dépenses partagées entre colocataires.
                    </p>

                    @if($active)
                    <a href="{{ route('colocations.show', $active) }}"
                       class="inline-flex items-center gap-2 px-7 py-3.5 bg-white text-emerald-700 font-semibold text-sm rounded-xl hover:bg-gray-50 transition-colors shadow-lg shadow-black/10">
                        Accéder à ma colocation
                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6"/></svg>
                    </a>
                    @else
                    <a href="{{ route('colocations.create') }}"
                       class="inline-flex items-center gap-2 px-7 py-3.5 bg-white text-emerald-700 font-semibold text-sm rounded-xl hover:bg-gray-50 transition-colors shadow-lg shadow-black/10">
                        Créer ma colocation
                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6"/></svg>
                    </a>
                    @endif
                    <p class="text-emerald-200 text-xs mt-4 tracking-wide">Gratuit &bull; Simple &bull; Sécurisé</p>
                </div>

                {{-- Right — floating preview card (40%) --}}
                <div class="lg:w-[38%] stagger-2">
                    <div class="bg-white rounded-2xl shadow-2xl p-6 transform rotate-2 hover:rotate-0 transition-transform duration-500 relative z-10">
                        <div class="flex items-center gap-3 mb-5">
                            <div class="w-8 h-8 rounded-lg bg-emerald-50 flex items-center justify-center">
                                <svg class="w-4 h-4 text-emerald-600" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/></svg>
                            </div>
                            <span class="text-sm font-bold text-gray-900">Ma Colocation</span>
                        </div>
                        <div class="space-y-3 mb-5">
                            <div class="flex items-center justify-between">
                                <span class="text-xs text-gray-400">Membres</span>
                                <span class="text-sm font-semibold text-gray-900">3</span>
                            </div>
                            <div class="flex items-center justify-between">
                                <span class="text-xs text-gray-400">Total dépenses</span>
                                <span class="text-sm font-semibold text-gray-900">1 240,00 DH</span>
                            </div>
                            <div class="flex items-center justify-between">
                                <span class="text-xs text-gray-400">Mon solde</span>
                                <span class="text-sm font-semibold text-emerald-600">+120,00 DH</span>
                            </div>
                        </div>
                        {{-- Mini bar chart --}}
                        <div class="flex items-end gap-2 h-12">
                            <div class="flex-1 bg-emerald-100 rounded-t-md" style="height: 40%"></div>
                            <div class="flex-1 bg-emerald-300 rounded-t-md" style="height: 75%"></div>
                            <div class="flex-1 bg-emerald-500 rounded-t-md" style="height: 100%"></div>
                            <div class="flex-1 bg-emerald-400 rounded-t-md" style="height: 60%"></div>
                            <div class="flex-1 bg-teal-300 rounded-t-md" style="height: 85%"></div>
                            <div class="flex-1 bg-teal-500 rounded-t-md" style="height: 50%"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- ===== SECTION 2 — COMMENT ÇA MARCHE ===== --}}
    <div class="mb-20">
        <div class="text-center mb-12">
            <h2 class="text-3xl font-bold text-gray-900 mb-3">Comment ça marche ?</h2>
            <p class="text-gray-500">Trois étapes simples pour commencer</p>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-3 gap-8 relative">
            {{-- Dotted connector line (desktop only) --}}
            <div class="hidden sm:block absolute top-20 left-[20%] right-[20%] border-t-2 border-dashed border-gray-200 z-0"></div>

            {{-- Step 1 --}}
            <div class="relative z-10 bg-white border border-gray-100 rounded-2xl shadow-sm p-8 text-center hover:shadow-lg hover:-translate-y-1 transition-all duration-300 stagger-1 group">
                <div class="text-5xl font-black text-emerald-100 mb-2 select-none">01</div>
                <div class="w-14 h-14 bg-emerald-50 rounded-2xl flex items-center justify-center mx-auto mb-5 group-hover:bg-emerald-100 transition-colors">
                    <svg class="w-7 h-7 text-emerald-600" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/></svg>
                </div>
                <h3 class="text-lg font-bold text-gray-900 mb-2">Créez votre espace</h3>
                <p class="text-sm text-gray-500 leading-relaxed">Configurez votre colocation et personnalisez vos catégories de dépenses.</p>
            </div>

            {{-- Step 2 --}}
            <div class="relative z-10 bg-white border border-gray-100 rounded-2xl shadow-sm p-8 text-center hover:shadow-lg hover:-translate-y-1 transition-all duration-300 stagger-2 group">
                <div class="text-5xl font-black text-emerald-100 mb-2 select-none">02</div>
                <div class="w-14 h-14 bg-emerald-50 rounded-2xl flex items-center justify-center mx-auto mb-5 group-hover:bg-emerald-100 transition-colors">
                    <svg class="w-7 h-7 text-emerald-600" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/></svg>
                </div>
                <h3 class="text-lg font-bold text-gray-900 mb-2">Invitez vos colocataires</h3>
                <p class="text-sm text-gray-500 leading-relaxed">Envoyez des invitations par email. Vos colocataires rejoignent en un clic.</p>
            </div>

            {{-- Step 3 --}}
            <div class="relative z-10 bg-white border border-gray-100 rounded-2xl shadow-sm p-8 text-center hover:shadow-lg hover:-translate-y-1 transition-all duration-300 stagger-3 group">
                <div class="text-5xl font-black text-emerald-100 mb-2 select-none">03</div>
                <div class="w-14 h-14 bg-emerald-50 rounded-2xl flex items-center justify-center mx-auto mb-5 group-hover:bg-emerald-100 transition-colors">
                    <svg class="w-7 h-7 text-emerald-600" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/></svg>
                </div>
                <h3 class="text-lg font-bold text-gray-900 mb-2">Suivez les dépenses</h3>
                <p class="text-sm text-gray-500 leading-relaxed">Ajoutez vos dépenses, les soldes se calculent automatiquement.</p>
            </div>
        </div>
    </div>

    {{-- ===== SECTION 3 — FEATURES GRID ===== --}}
    <div class="mb-20">
        <div class="text-center mb-12">
            <h2 class="text-3xl font-bold text-gray-900 mb-3">Tout ce dont vous avez besoin</h2>
            <p class="text-gray-500">Une plateforme complète pour simplifier la vie en colocation</p>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
            {{-- Feature 1: Sécurisé --}}
            <div class="bg-white border border-gray-100 rounded-2xl shadow-sm p-6 hover:shadow-md hover:scale-[1.02] transition-all duration-300 stagger-1">
                <div class="w-11 h-11 bg-emerald-50 rounded-xl flex items-center justify-center mb-4">
                    <svg class="w-5.5 h-5.5 text-emerald-600" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/></svg>
                </div>
                <h3 class="font-bold text-gray-900 mb-1">Sécurisé</h3>
                <p class="text-sm text-gray-500 leading-relaxed">Protection de vos données personnelles</p>
            </div>

            {{-- Feature 2: Calcul automatique --}}
            <div class="bg-white border border-gray-100 rounded-2xl shadow-sm p-6 hover:shadow-md hover:scale-[1.02] transition-all duration-300 stagger-2">
                <div class="w-11 h-11 bg-blue-50 rounded-xl flex items-center justify-center mb-4">
                    <svg class="w-5.5 h-5.5 text-blue-600" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 7h6m0 10v-3m-3 3h.01M9 17h.01M9 14h.01M12 14h.01M15 11h.01M12 11h.01M9 11h.01M7 21h10a2 2 0 002-2V5a2 2 0 00-2-2H7a2 2 0 00-2 2v14a2 2 0 002 2z"/></svg>
                </div>
                <h3 class="font-bold text-gray-900 mb-1">Calcul automatique</h3>
                <p class="text-sm text-gray-500 leading-relaxed">Les soldes sont mis à jour en temps réel</p>
            </div>

            {{-- Feature 3: Collaboratif --}}
            <div class="bg-white border border-gray-100 rounded-2xl shadow-sm p-6 hover:shadow-md hover:scale-[1.02] transition-all duration-300 stagger-3">
                <div class="w-11 h-11 bg-purple-50 rounded-xl flex items-center justify-center mb-4">
                    <svg class="w-5.5 h-5.5 text-purple-600" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"/></svg>
                </div>
                <h3 class="font-bold text-gray-900 mb-1">Collaboratif</h3>
                <p class="text-sm text-gray-500 leading-relaxed">Invitez jusqu'à 10 colocataires</p>
            </div>

            {{-- Feature 4: Catégories --}}
            <div class="bg-white border border-gray-100 rounded-2xl shadow-sm p-6 hover:shadow-md hover:scale-[1.02] transition-all duration-300 stagger-4">
                <div class="w-11 h-11 bg-amber-50 rounded-xl flex items-center justify-center mb-4">
                    <svg class="w-5.5 h-5.5 text-amber-600" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A2 2 0 013 12V7a4 4 0 014-4z"/></svg>
                </div>
                <h3 class="font-bold text-gray-900 mb-1">Catégories</h3>
                <p class="text-sm text-gray-500 leading-relaxed">Organisez vos dépenses intelligemment</p>
            </div>

            {{-- Feature 5: Historique --}}
            <div class="bg-white border border-gray-100 rounded-2xl shadow-sm p-6 hover:shadow-md hover:scale-[1.02] transition-all duration-300 stagger-5">
                <div class="w-11 h-11 bg-rose-50 rounded-xl flex items-center justify-center mb-4">
                    <svg class="w-5.5 h-5.5 text-rose-600" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                </div>
                <h3 class="font-bold text-gray-900 mb-1">Historique</h3>
                <p class="text-sm text-gray-500 leading-relaxed">Retrouvez chaque dépense et règlement</p>
            </div>

            {{-- Feature 6: Notifications --}}
            <div class="bg-white border border-gray-100 rounded-2xl shadow-sm p-6 hover:shadow-md hover:scale-[1.02] transition-all duration-300 stagger-6">
                <div class="w-11 h-11 bg-sky-50 rounded-xl flex items-center justify-center mb-4">
                    <svg class="w-5.5 h-5.5 text-sky-600" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"/></svg>
                </div>
                <h3 class="font-bold text-gray-900 mb-1">Notifications</h3>
                <p class="text-sm text-gray-500 leading-relaxed">Restez informé par email</p>
            </div>
        </div>
    </div>

    {{-- ===== SECTION 4 — SOCIAL PROOF / STATS BAR ===== --}}
    <div class="bg-gray-50 rounded-3xl px-8 py-12 mb-20">
        <div class="grid grid-cols-1 sm:grid-cols-3 gap-8 text-center">
            <div class="stagger-1">
                <p class="text-3xl font-bold text-emerald-600 mb-1">500+</p>
                <p class="text-sm text-gray-500">Utilisateurs actifs</p>
            </div>
            <div class="stagger-2">
                <p class="text-3xl font-bold text-emerald-600 mb-1">1 200+</p>
                <p class="text-sm text-gray-500">Dépenses gérées</p>
            </div>
            <div class="stagger-3">
                <p class="text-3xl font-bold text-emerald-600 mb-1">98%</p>
                <p class="text-sm text-gray-500">Satisfaction</p>
            </div>
        </div>
    </div>

    {{-- ===== SECTION 5 — CTA BOTTOM ===== --}}
    <div class="bg-emerald-50 rounded-3xl px-8 py-16 mb-20 text-center">
        <h2 class="text-2xl sm:text-3xl font-bold text-gray-900 mb-3">Prêt à simplifier vos comptes ?</h2>
        <p class="text-gray-500 mb-8 max-w-md mx-auto">Rejoignez ColocShare gratuitement et commencez à gérer vos dépenses partagées.</p>
        @if($active)
        <a href="{{ route('colocations.show', $active) }}"
           class="inline-flex items-center gap-2 px-8 py-3.5 bg-emerald-500 hover:bg-emerald-600 text-white font-semibold text-sm rounded-xl transition-colors shadow-lg shadow-emerald-500/25">
            Commencer maintenant
            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6"/></svg>
        </a>
        @else
        <a href="{{ route('colocations.create') }}"
           class="inline-flex items-center gap-2 px-8 py-3.5 bg-emerald-500 hover:bg-emerald-600 text-white font-semibold text-sm rounded-xl transition-colors shadow-lg shadow-emerald-500/25">
            Commencer maintenant
            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6"/></svg>
        </a>
        @endif
    </div>

</x-app-layout>

{{-- ===== SECTION 6 — FOOTER ===== --}}
<footer class="bg-gray-900">
    <div class="max-w-6xl mx-auto px-4 sm:px-6 py-10">
        <div class="flex flex-col sm:flex-row items-center justify-between gap-4">
            <div class="flex items-center gap-4">
                <div class="flex items-center gap-2">
                    <span class="w-2 h-2 rounded-full bg-emerald-400"></span>
                    <span class="text-sm font-bold text-white">ColocShare</span>
                </div>
                <span class="hidden sm:inline text-gray-600">|</span>
                <div class="flex items-center gap-4 text-sm text-gray-400">
                    <a href="{{ route('dashboard') }}" class="hover:text-gray-300 transition-colors">Accueil</a>
                    <a href="{{ route('colocations.index') }}" class="hover:text-gray-300 transition-colors">Mes Colocations</a>
                </div>
            </div>
            <p class="text-sm text-gray-500">&copy; 2026 ColocShare &mdash; Projet réalisé avec Laravel</p>
        </div>
    </div>
</footer>
