<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>ColocShare — La gestion de colocation simplifiée</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="antialiased">

<section class="relative min-h-screen flex flex-col"
         style="background: url('https://images.unsplash.com/photo-1502672260266-1c1ef2d93688?w=1920&q=80') center/cover no-repeat;">
    <div class="absolute inset-0 bg-gray-900/70"></div>

    {{-- Navbar --}}
    <nav class="relative z-10 flex items-center justify-between px-6 lg:px-16 py-6">
        <div class="flex items-center gap-2">
            <span class="w-2.5 h-2.5 rounded-full bg-emerald-400"></span>
            <span class="text-xl font-bold text-white tracking-tight">ColocShare</span>
        </div>
        <div class="flex items-center gap-3">
            <a href="{{ route('login') }}"
               class="px-5 py-2.5 text-sm font-semibold bg-white/10 backdrop-blur-sm border border-white/20 text-white rounded-xl hover:bg-white/20 transition-colors">
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
            <div class="inline-flex items-center gap-2 px-3.5 py-1.5 rounded-full bg-emerald-500/20 border border-emerald-400/30 text-emerald-300 text-xs font-semibold mb-8 animate-fade-in-up backdrop-blur-sm">
                <span class="w-1.5 h-1.5 rounded-full bg-emerald-400 inline-block"></span>
                Gestion de colocation simplifiée
            </div>
            <h1 class="text-5xl lg:text-7xl font-extrabold text-white leading-tight tracking-tight mb-6 animate-fade-in-up">
                ColocShare
            </h1>
            <p class="text-xl text-white/70 leading-relaxed mb-10 max-w-xl mx-auto stagger-1">
                La gestion de colocation simplifiée. Partagez les frais, suivez les soldes et réglez vos comptes facilement.
            </p>
            <div class="flex flex-col sm:flex-row items-center justify-center gap-4 stagger-2">
                <a href="{{ route('login') }}"
                   class="px-8 py-4 bg-white text-gray-900 font-semibold rounded-xl hover:bg-gray-100 transition-colors text-sm w-full sm:w-auto">
                    Se connecter
                </a>
                <a href="{{ route('register') }}"
                   class="px-8 py-4 bg-emerald-500 text-white font-semibold rounded-xl hover:bg-emerald-600 transition-colors text-sm w-full sm:w-auto">
                    S'inscrire
                </a>
            </div>
        </div>
    </div>
</section>

</body>
</html>
