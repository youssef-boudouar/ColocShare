<x-app-layout>
    <x-slot name="title">Catégories — ColocShare</x-slot>

    {{-- Header --}}
    <div class="flex items-center justify-between mb-8">
        <div>
            <h1 class="text-2xl font-bold text-gray-900">Catégories</h1>
            <p class="text-gray-500 text-sm mt-1">
                Gérez les catégories de dépenses de {{ $colocation->name ?? 'votre colocation' }}.
            </p>
        </div>
        @if($isOwner ?? false)
        <a href="#add-category-modal"
           class="inline-flex items-center gap-2 px-4 py-2.5 bg-emerald-500 hover:bg-emerald-600 text-white font-semibold text-sm rounded-xl transition-colors">
            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
            </svg>
            Nouvelle catégorie
        </a>
        @endif
    </div>

    {{-- Categories grid --}}
    @if(!isset($categories) || $categories->isEmpty())
    {{-- Empty state --}}
    <div class="bg-white border border-gray-200 rounded-2xl p-16 text-center">
        <div class="w-14 h-14 bg-gray-100 rounded-2xl flex items-center justify-center mx-auto mb-4">
            <svg class="w-7 h-7 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.75" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"/>
            </svg>
        </div>
        <p class="text-sm font-semibold text-gray-700 mb-1">Aucune catégorie créée</p>
        <p class="text-xs text-gray-400 mb-5">Créez des catégories pour organiser vos dépenses.</p>
        @if($isOwner ?? false)
        <a href="#add-category-modal"
           class="inline-flex items-center gap-2 px-4 py-2.5 bg-emerald-500 hover:bg-emerald-600 text-white font-semibold text-sm rounded-xl transition-colors">
            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
            </svg>
            Créer une catégorie
        </a>
        @endif
    </div>

    @else
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4">
        @foreach($categories as $category)
        <div class="stagger-item bg-white border border-gray-200 rounded-2xl p-5 hover:shadow-sm transition-shadow">
            <div class="flex items-start justify-between mb-4">
                <div class="w-10 h-10 bg-emerald-50 rounded-xl flex items-center justify-center text-emerald-600">
                    <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.75" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"/>
                    </svg>
                </div>
                @if($isOwner ?? false)
                <form method="POST" action="{{ route('categories.destroy', $category) }}"
                      onsubmit="return confirm('Supprimer la catégorie « {{ $category->name }} » ?')">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="text-gray-300 hover:text-red-500 transition-colors p-1" title="Supprimer">
                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                        </svg>
                    </button>
                </form>
                @endif
            </div>
            <h3 class="font-semibold text-gray-900 mb-1">{{ $category->name }}</h3>
            <p class="text-xs text-gray-400">
                {{ $category->expenses_count ?? 0 }} dépense(s)
            </p>
        </div>
        @endforeach

        {{-- Add new category shortcut (owner only) --}}
        @if($isOwner ?? false)
        <a href="#add-category-modal"
           class="stagger-item border-2 border-dashed border-gray-200 rounded-2xl p-5 flex flex-col items-center justify-center gap-2 text-gray-400 hover:border-emerald-300 hover:text-emerald-500 transition-colors min-h-[120px]">
            <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
            </svg>
            <span class="text-sm font-medium">Nouvelle catégorie</span>
        </a>
        @endif
    </div>
    @endif

    {{-- Add category modal (owner only) --}}
    @if($isOwner ?? false)
    <x-modal id="add-category-modal" title="Nouvelle catégorie">
        <form method="POST" action="{{ route('categories.store', $colocation) }}" class="space-y-4">
            @csrf

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1.5">Nom de la catégorie <span class="text-red-500">*</span></label>
                <input type="text" name="name" value="{{ old('name') }}" required autofocus
                       class="block w-full rounded-xl border border-gray-300 px-4 py-2.5 text-sm outline-none focus:border-emerald-500 focus:ring-2 focus:ring-emerald-500/20 transition-all"
                       placeholder="Ex : Loyer, Courses, Transport…">
                @error('name')
                <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
                @enderror
            </div>

            <button type="submit"
                    class="w-full px-4 py-2.5 bg-emerald-500 hover:bg-emerald-600 text-white font-semibold text-sm rounded-xl transition-colors">
                Créer la catégorie
            </button>
        </form>
    </x-modal>
    @endif

</x-app-layout>
