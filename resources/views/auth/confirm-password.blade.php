<x-guest-layout>
    <div class="mb-8">
        <h2 class="text-2xl font-bold text-gray-900">Zone sécurisée</h2>
        <p class="text-gray-500 text-sm mt-1">Confirmez votre mot de passe pour accéder à cette section.</p>
    </div>

    <form method="POST" action="{{ route('password.confirm') }}" class="space-y-4">
        @csrf

        <div>
            <label for="password" class="block text-sm font-medium text-gray-700 mb-1.5">Mot de passe</label>
            <input type="password" name="password" id="password" required autocomplete="current-password"
                   class="block w-full rounded-xl border {{ $errors->has('password') ? 'border-red-400' : 'border-gray-300' }} px-4 py-2.5 text-sm text-gray-900 outline-none focus:border-emerald-500 focus:ring-2 focus:ring-emerald-500/20 transition-all">
            @error('password')
            <p class="mt-1.5 text-xs text-red-500">{{ $message }}</p>
            @enderror
        </div>

        <button type="submit" class="w-full flex items-center justify-center px-4 py-2.5 bg-emerald-500 hover:bg-emerald-600 text-white font-semibold text-sm rounded-xl transition-colors">
            Confirmer
        </button>
    </form>
</x-guest-layout>
