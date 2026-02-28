<x-guest-layout>
    <div class="mb-8">
        <h2 class="text-2xl font-bold text-gray-900">Créer un compte</h2>
        <p class="text-gray-500 text-sm mt-1">Rejoignez ColocShare et gérez vos dépenses</p>
    </div>

    <form method="POST" action="{{ route('register') }}" class="space-y-4">
        @csrf

        <div>
            <label for="name" class="block text-sm font-medium text-gray-700 mb-1.5">Nom complet</label>
            <input type="text" name="name" id="name" value="{{ old('name') }}" required autofocus autocomplete="name"
                   class="block w-full rounded-xl border {{ $errors->has('name') ? 'border-red-400' : 'border-gray-300' }} px-4 py-2.5 text-sm text-gray-900 placeholder-gray-400 outline-none focus:border-emerald-500 focus:ring-2 focus:ring-emerald-500/20 transition-all"
                   placeholder="Jean Dupont">
            @error('name')
            <p class="mt-1.5 text-xs text-red-500">{{ $message }}</p>
            @enderror
        </div>

        <div>
            <label for="email" class="block text-sm font-medium text-gray-700 mb-1.5">Adresse email</label>
            <input type="email" name="email" id="email" value="{{ old('email') }}" required autocomplete="username"
                   class="block w-full rounded-xl border {{ $errors->has('email') ? 'border-red-400' : 'border-gray-300' }} px-4 py-2.5 text-sm text-gray-900 placeholder-gray-400 outline-none focus:border-emerald-500 focus:ring-2 focus:ring-emerald-500/20 transition-all"
                   placeholder="vous@exemple.fr">
            @error('email')
            <p class="mt-1.5 text-xs text-red-500">{{ $message }}</p>
            @enderror
        </div>

        <div>
            <label for="password" class="block text-sm font-medium text-gray-700 mb-1.5">Mot de passe</label>
            <input type="password" name="password" id="password" required autocomplete="new-password"
                   class="block w-full rounded-xl border {{ $errors->has('password') ? 'border-red-400' : 'border-gray-300' }} px-4 py-2.5 text-sm text-gray-900 outline-none focus:border-emerald-500 focus:ring-2 focus:ring-emerald-500/20 transition-all">
            @error('password')
            <p class="mt-1.5 text-xs text-red-500">{{ $message }}</p>
            @enderror
        </div>

        <div>
            <label for="password_confirmation" class="block text-sm font-medium text-gray-700 mb-1.5">Confirmer le mot de passe</label>
            <input type="password" name="password_confirmation" id="password_confirmation" required autocomplete="new-password"
                   class="block w-full rounded-xl border {{ $errors->has('password_confirmation') ? 'border-red-400' : 'border-gray-300' }} px-4 py-2.5 text-sm text-gray-900 outline-none focus:border-emerald-500 focus:ring-2 focus:ring-emerald-500/20 transition-all">
            @error('password_confirmation')
            <p class="mt-1.5 text-xs text-red-500">{{ $message }}</p>
            @enderror
        </div>

        <button type="submit" class="w-full flex items-center justify-center px-4 py-2.5 bg-gradient-to-r from-emerald-500 to-teal-600 hover:from-emerald-600 hover:to-teal-700 text-white font-semibold text-sm rounded-xl transition-all mt-2 shadow-sm">
            Créer mon compte
        </button>
    </form>

    <p class="mt-6 text-center text-sm text-gray-500">
        Déjà un compte ?
        <a href="{{ route('login') }}" class="text-emerald-600 font-semibold hover:text-emerald-700 ml-1">Connectez-vous</a>
    </p>
</x-guest-layout>
