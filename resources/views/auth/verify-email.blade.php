<x-guest-layout>
    <div class="mb-8">
        <h2 class="text-2xl font-bold text-gray-900">Vérifiez votre email</h2>
        <p class="text-gray-500 text-sm mt-1">Un lien de vérification vous a été envoyé par email.</p>
    </div>

    @if(session('status') == 'verification-link-sent')
    <div class="mb-5 px-4 py-3 rounded-xl bg-emerald-50 border border-emerald-200 text-emerald-700 text-sm">
        Un nouveau lien de vérification a été envoyé à votre adresse email.
    </div>
    @endif

    <p class="text-sm text-gray-500 mb-6 leading-relaxed">
        Avant de continuer, veuillez vérifier votre adresse email en cliquant sur le lien que nous venons de vous envoyer.
        Si vous n'avez pas reçu l'email, nous pouvons vous en envoyer un autre.
    </p>

    <div class="space-y-3">
        <form method="POST" action="{{ route('verification.send') }}">
            @csrf
            <button type="submit" class="w-full flex items-center justify-center px-4 py-2.5 bg-emerald-500 hover:bg-emerald-600 text-white font-semibold text-sm rounded-xl transition-colors">
                Renvoyer l'email de vérification
            </button>
        </form>

        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button type="submit" class="w-full flex items-center justify-center px-4 py-2.5 bg-white border border-gray-300 text-gray-700 font-semibold text-sm rounded-xl hover:bg-gray-50 transition-colors">
                Se déconnecter
            </button>
        </form>
    </div>
</x-guest-layout>
