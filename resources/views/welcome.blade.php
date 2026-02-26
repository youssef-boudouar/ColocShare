<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>ClocShare — Gérez vos dépenses de colocation</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="antialiased">

{{-- ===== HERO ===== --}}
<section class="relative min-h-screen flex flex-col"
         style="background-image: url('https://images.unsplash.com/photo-1522708323590-d24dbb6b0267?w=1920&q=80'); background-size: cover; background-position: center;">
    <div class="absolute inset-0" style="background: linear-gradient(to bottom, rgba(0,0,0,0.72) 0%, rgba(0,0,0,0.42) 100%);"></div>

    {{-- Navbar --}}
    <nav class="relative z-10 flex items-center justify-between px-6 lg:px-16 py-6">
        <span class="text-2xl font-bold text-white tracking-tight select-none">ClocShare</span>
        <div class="flex items-center gap-3">
            <a href="{{ route('login') }}"
               class="px-5 py-2.5 text-sm font-semibold bg-white text-gray-900 rounded-xl hover:bg-gray-100 transition-colors">
                Se connecter
            </a>
            <a href="{{ route('register') }}"
               class="px-5 py-2.5 bg-emerald-500 text-white text-sm font-semibold rounded-xl hover:bg-emerald-600 transition-colors">
                Créer un compte
            </a>
        </div>
    </nav>

    {{-- Hero content --}}
    <div class="relative z-10 flex-1 flex items-center justify-center px-6 py-28 text-center">
        <div class="max-w-3xl mx-auto">
            <div class="inline-flex items-center gap-2 px-3.5 py-1.5 rounded-full bg-emerald-500/20 border border-emerald-400/30 text-emerald-300 text-xs font-semibold mb-8 animate-fade-in-up">
                <span class="w-1.5 h-1.5 rounded-full bg-emerald-400 inline-block"></span>
                Gestion de colocation simplifiée
            </div>
            <h1 class="text-5xl lg:text-7xl font-bold text-white leading-tight tracking-tight mb-6 animate-fade-in-up">
                Gérez vos dépenses<br>de colocation
                <span class="text-emerald-400"> intelligemment</span>
            </h1>
            <p class="text-xl text-white/65 leading-relaxed mb-10 max-w-xl mx-auto stagger-1">
                Partagez les frais, suivez les dettes et réglez les comptes facilement avec vos colocataires.
            </p>
            <div class="flex flex-col sm:flex-row items-center justify-center gap-4 stagger-2">
                <a href="{{ route('login') }}"
                   class="px-8 py-4 bg-white text-gray-900 font-semibold rounded-xl hover:bg-gray-100 transition-colors text-sm w-full sm:w-auto">
                    Se connecter
                </a>
                <a href="{{ route('register') }}"
                   class="px-8 py-4 bg-emerald-500 text-white font-semibold rounded-xl hover:bg-emerald-600 transition-colors text-sm w-full sm:w-auto">
                    Créer un compte
                </a>
            </div>
        </div>
    </div>

    {{-- Scroll indicator --}}
    <div class="relative z-10 flex justify-center pb-8 stagger-3">
        <div class="w-6 h-10 rounded-full border-2 border-white/30 flex items-start justify-center pt-2">
            <div class="w-1 h-2 bg-white/50 rounded-full"></div>
        </div>
    </div>
</section>

{{-- ===== FEATURES ===== --}}
<section class="bg-white py-28 px-6">
    <div class="max-w-5xl mx-auto">
        <div class="text-center mb-16 animate-fade-in-up">
            <h2 class="text-4xl font-bold text-gray-900 mb-4">Tout ce dont vous avez besoin</h2>
            <p class="text-gray-500 text-lg max-w-xl mx-auto">
                Une plateforme complète et élégante pour gérer la vie en colocation
            </p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
            @php
            $features = [
                [
                    'icon' => 'M9 14l6-6m-5.5.5h.01m4.99 5h.01M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16l3.5-2 3.5 2 3.5-2 3.5 2z',
                    'title' => 'Suivi des dépenses',
                    'desc'  => 'Enregistrez toutes vos dépenses partagées avec catégories, montants et dates. Visualisez l\'historique complet à tout moment.',
                ],
                [
                    'icon' => 'M3 6l3 1m0 0l-3 9a5.002 5.002 0 006.001 0M6 7l3 9M6 7l6-2m6 2l3-1m-3 1l-3 9a5.002 5.002 0 006.001 0M18 7l3 9m-3-9l-6-2m0-2v2m0 16V5m0 16H9m3 0h3',
                    'title' => 'Calcul automatique des soldes',
                    'desc'  => 'Le calcul de qui doit combien à qui est fait automatiquement et en temps réel. Zéro calcul manuel.',
                ],
                [
                    'icon' => 'M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z',
                    'title' => 'Règlements simplifiés',
                    'desc'  => 'Marquez les dettes comme réglées en un clic et gardez un historique complet de tous les remboursements.',
                ],
            ];
            @endphp

            @foreach($features as $i => $f)
            <div class="stagger-{{ $i + 1 }} bg-white border border-gray-100 rounded-2xl p-8 hover:shadow-lg hover:-translate-y-1 transition-all duration-300 group">
                <div class="w-14 h-14 bg-emerald-50 rounded-2xl flex items-center justify-center text-emerald-600 mb-6 group-hover:bg-emerald-100 transition-colors">
                    <svg class="w-7 h-7" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.75">
                        <path stroke-linecap="round" stroke-linejoin="round" d="{{ $f['icon'] }}"/>
                    </svg>
                </div>
                <h3 class="font-bold text-gray-900 text-xl mb-3">{{ $f['title'] }}</h3>
                <p class="text-gray-500 text-sm leading-relaxed">{{ $f['desc'] }}</p>
            </div>
            @endforeach
        </div>
    </div>
</section>

{{-- ===== PARALLAX BAND ===== --}}
<section class="relative py-36 px-6 text-center"
         style="background-image: url('https://images.unsplash.com/photo-1529408632839-a54952c491e3?w=1920&q=80'); background-size: cover; background-position: center; background-attachment: fixed;">
    <div class="absolute inset-0 bg-black/60"></div>
    <div class="relative z-10 max-w-2xl mx-auto">
        <h2 class="text-4xl lg:text-5xl font-bold text-white mb-5 leading-tight">
            Rejoignez des milliers<br>de colocataires
        </h2>
        <p class="text-white/70 text-lg mb-10 max-w-md mx-auto">
            Simplifiez la gestion financière de votre colocation dès aujourd'hui. Gratuit et sans prise de tête.
        </p>
        <a href="{{ route('register') }}"
           class="inline-flex items-center gap-2 px-8 py-4 bg-emerald-500 text-white font-semibold rounded-xl hover:bg-emerald-600 transition-colors text-sm">
            Commencer gratuitement
            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6"/>
            </svg>
        </a>
    </div>
</section>

{{-- ===== FOOTER ===== --}}
<footer class="bg-gray-900 py-10 px-6">
    <div class="max-w-5xl mx-auto flex flex-col sm:flex-row items-center justify-between gap-4">
        <div>
            <span class="text-lg font-bold text-white">ClocShare</span>
            <p class="text-xs text-gray-600 mt-1">La gestion de colocation, enfin simple.</p>
        </div>
        <p class="text-sm text-gray-500">© 2026 ClocShare. Tous droits réservés.</p>
    </div>
</footer>

</body>
</html>
