<x-app-layout>
    <x-slot name="title">Mon profil — ClocShare</x-slot>

    <div class="max-w-lg mx-auto space-y-6">
        <div class="mb-2">
            <h1 class="text-2xl font-bold text-gray-900">Mon profil</h1>
            <p class="text-gray-500 text-sm mt-1">Gérez vos informations personnelles.</p>
        </div>

        {{-- Success flash --}}
        @if(session('status') === 'profile-updated')
        <div class="px-4 py-3 rounded-xl bg-emerald-50 border border-emerald-200 text-emerald-700 text-sm">
            Profil mis à jour avec succès.
        </div>
        @endif

        {{-- Profile form --}}
        <div class="bg-white border border-gray-200 rounded-2xl p-6">
            <h2 class="text-base font-semibold text-gray-900 mb-5">Informations personnelles</h2>

            <form method="POST" action="{{ route('profile.update') }}" class="space-y-4">
                @csrf
                @method('PATCH')

                <div>
                    <label for="name" class="block text-sm font-medium text-gray-700 mb-1.5">Nom complet</label>
                    <input type="text" name="name" id="name" value="{{ old('name', $user->name) }}" required autofocus autocomplete="name"
                           class="block w-full rounded-xl border {{ $errors->has('name') ? 'border-red-400' : 'border-gray-300' }} px-4 py-2.5 text-sm text-gray-900 placeholder-gray-400 outline-none focus:border-emerald-500 focus:ring-2 focus:ring-emerald-500/20 transition-all">
                    @error('name')
                    <p class="mt-1.5 text-xs text-red-500">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="email" class="block text-sm font-medium text-gray-700 mb-1.5">Adresse email</label>
                    <input type="email" name="email" id="email" value="{{ old('email', $user->email) }}" required autocomplete="username"
                           class="block w-full rounded-xl border {{ $errors->has('email') ? 'border-red-400' : 'border-gray-300' }} px-4 py-2.5 text-sm text-gray-900 placeholder-gray-400 outline-none focus:border-emerald-500 focus:ring-2 focus:ring-emerald-500/20 transition-all">
                    @error('email')
                    <p class="mt-1.5 text-xs text-red-500">{{ $message }}</p>
                    @enderror

                    @if($user instanceof \Illuminate\Contracts\Auth\MustVerifyEmail && ! $user->hasVerifiedEmail())
                    <p class="mt-1.5 text-xs text-amber-600">
                        Votre adresse email n'est pas vérifiée.
                        <button form="send-verification" class="underline hover:no-underline">Renvoyer l'email de vérification.</button>
                    </p>
                    @endif
                </div>

                <div class="pt-2">
                    <button type="submit" class="px-5 py-2.5 bg-emerald-500 hover:bg-emerald-600 text-white font-semibold text-sm rounded-xl transition-colors">
                        Enregistrer
                    </button>
                </div>
            </form>

            @if($user instanceof \Illuminate\Contracts\Auth\MustVerifyEmail && ! $user->hasVerifiedEmail())
            <form id="send-verification" method="POST" action="{{ route('verification.send') }}" class="hidden">
                @csrf
            </form>
            @endif
        </div>

        {{-- Change password --}}
        <div class="bg-white border border-gray-200 rounded-2xl p-6">
            <h2 class="text-base font-semibold text-gray-900 mb-5">Changer le mot de passe</h2>

            <form method="POST" action="{{ route('password.update') }}" class="space-y-4">
                @csrf
                @method('PUT')

                <div>
                    <label for="current_password" class="block text-sm font-medium text-gray-700 mb-1.5">Mot de passe actuel</label>
                    <input type="password" name="current_password" id="current_password" autocomplete="current-password"
                           class="block w-full rounded-xl border {{ $errors->updatePassword->has('current_password') ? 'border-red-400' : 'border-gray-300' }} px-4 py-2.5 text-sm text-gray-900 outline-none focus:border-emerald-500 focus:ring-2 focus:ring-emerald-500/20 transition-all">
                    @if($errors->updatePassword->has('current_password'))
                    <p class="mt-1.5 text-xs text-red-500">{{ $errors->updatePassword->first('current_password') }}</p>
                    @endif
                </div>

                <div>
                    <label for="password" class="block text-sm font-medium text-gray-700 mb-1.5">Nouveau mot de passe</label>
                    <input type="password" name="password" id="password" autocomplete="new-password"
                           class="block w-full rounded-xl border {{ $errors->updatePassword->has('password') ? 'border-red-400' : 'border-gray-300' }} px-4 py-2.5 text-sm text-gray-900 outline-none focus:border-emerald-500 focus:ring-2 focus:ring-emerald-500/20 transition-all">
                    @if($errors->updatePassword->has('password'))
                    <p class="mt-1.5 text-xs text-red-500">{{ $errors->updatePassword->first('password') }}</p>
                    @endif
                </div>

                <div>
                    <label for="password_confirmation" class="block text-sm font-medium text-gray-700 mb-1.5">Confirmer le mot de passe</label>
                    <input type="password" name="password_confirmation" id="password_confirmation" autocomplete="new-password"
                           class="block w-full rounded-xl border border-gray-300 px-4 py-2.5 text-sm text-gray-900 outline-none focus:border-emerald-500 focus:ring-2 focus:ring-emerald-500/20 transition-all">
                </div>

                <div class="pt-2">
                    @if(session('status') === 'password-updated')
                    <p class="text-xs text-emerald-600 mb-3">Mot de passe mis à jour.</p>
                    @endif
                    <button type="submit" class="px-5 py-2.5 bg-emerald-500 hover:bg-emerald-600 text-white font-semibold text-sm rounded-xl transition-colors">
                        Mettre à jour
                    </button>
                </div>
            </form>
        </div>

        {{-- Delete account --}}
        <div class="bg-white border border-red-100 rounded-2xl p-6">
            <h2 class="text-base font-semibold text-red-600 mb-2">Supprimer le compte</h2>
            <p class="text-sm text-gray-500 mb-4">
                Une fois supprimé, toutes vos données seront définitivement effacées. Cette action est irréversible.
            </p>
            <a href="#delete-account-modal" class="inline-flex items-center gap-2 px-4 py-2 bg-red-50 hover:bg-red-100 text-red-600 font-semibold text-sm rounded-xl transition-colors border border-red-200">
                Supprimer mon compte
            </a>
        </div>
    </div>

    {{-- Delete account modal (:target) --}}
    <div id="delete-account-modal" class="modal">
        <div class="bg-white rounded-2xl shadow-xl w-full max-w-md p-6 relative">
            <a href="#" class="absolute top-4 right-4 text-gray-400 hover:text-gray-600 transition-colors">
                <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
            </a>
            <h3 class="text-lg font-bold text-gray-900 mb-2">Supprimer le compte ?</h3>
            <p class="text-sm text-gray-500 mb-5">
                Confirmez votre mot de passe pour supprimer définitivement votre compte.
            </p>
            <form method="POST" action="{{ route('profile.destroy') }}" class="space-y-4">
                @csrf
                @method('DELETE')

                <div>
                    <label for="delete_password" class="block text-sm font-medium text-gray-700 mb-1.5">Mot de passe</label>
                    <input type="password" name="password" id="delete_password" required autocomplete="current-password"
                           class="block w-full rounded-xl border {{ $errors->userDeletion->has('password') ? 'border-red-400' : 'border-gray-300' }} px-4 py-2.5 text-sm text-gray-900 outline-none focus:border-emerald-500 focus:ring-2 focus:ring-emerald-500/20 transition-all">
                    @if($errors->userDeletion->has('password'))
                    <p class="mt-1.5 text-xs text-red-500">{{ $errors->userDeletion->first('password') }}</p>
                    @endif
                </div>

                <div class="flex items-center gap-3">
                    <button type="submit" class="flex-1 px-4 py-2.5 bg-red-500 hover:bg-red-600 text-white font-semibold text-sm rounded-xl transition-colors">
                        Supprimer définitivement
                    </button>
                    <a href="#" class="px-4 py-2.5 bg-white border border-gray-300 text-gray-700 font-semibold text-sm rounded-xl hover:bg-gray-50 transition-colors">
                        Annuler
                    </a>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>
