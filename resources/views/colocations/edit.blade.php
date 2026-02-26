<x-app-layout>
    <x-slot name="title">Modifier la colocation — ClocShare</x-slot>

    <div class="max-w-lg mx-auto">
        <div class="mb-8">
            <h1 class="text-2xl font-bold text-gray-900">Modifier la colocation</h1>
            <p class="text-gray-500 text-sm mt-1">Mettez à jour les informations de votre colocation.</p>
        </div>

        <div class="bg-white border border-gray-200 rounded-2xl p-6">
            <form method="POST" action="{{ route('colocations.update', $colocation) }}" class="space-y-5">
                @csrf
                @method('PATCH')

                <div>
                    <label for="name" class="block text-sm font-medium text-gray-700 mb-1.5">Nom de la colocation</label>
                    <input type="text" name="name" id="name" value="{{ old('name', $colocation->name) }}" required autofocus
                           class="block w-full rounded-xl border {{ $errors->has('name') ? 'border-red-400' : 'border-gray-300' }} px-4 py-2.5 text-sm text-gray-900 placeholder-gray-400 outline-none focus:border-emerald-500 focus:ring-2 focus:ring-emerald-500/20 transition-all">
                    @error('name')
                    <p class="mt-1.5 text-xs text-red-500">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="description" class="block text-sm font-medium text-gray-700 mb-1.5">
                        Description <span class="text-gray-400 font-normal">(optionnel)</span>
                    </label>
                    <textarea name="description" id="description" rows="3"
                              class="block w-full rounded-xl border {{ $errors->has('description') ? 'border-red-400' : 'border-gray-300' }} px-4 py-2.5 text-sm text-gray-900 placeholder-gray-400 outline-none focus:border-emerald-500 focus:ring-2 focus:ring-emerald-500/20 transition-all resize-none"
                              placeholder="Décrivez votre colocation…">{{ old('description', $colocation->description) }}</textarea>
                    @error('description')
                    <p class="mt-1.5 text-xs text-red-500">{{ $message }}</p>
                    @enderror
                </div>

                <div class="flex items-center gap-3 pt-2">
                    <button type="submit" class="flex-1 flex items-center justify-center px-4 py-2.5 bg-emerald-500 hover:bg-emerald-600 text-white font-semibold text-sm rounded-xl transition-colors">
                        Enregistrer les modifications
                    </button>
                    <a href="{{ route('colocations.show', $colocation) }}" class="px-4 py-2.5 bg-white border border-gray-300 text-gray-700 font-semibold text-sm rounded-xl hover:bg-gray-50 transition-colors">
                        Annuler
                    </a>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>
