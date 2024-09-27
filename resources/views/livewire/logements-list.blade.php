<div x-data="{ showFilters: false }" class="logementsAll">
    <h1 class="mt-8 mb-8 text-4xl font-extrabold text-center text-bleu">Tous nos Logements</h1>

    <!-- Bouton pour afficher/masquer le formulaire de filtres -->
    <div class="flex justify-center mb-12">
        <button @click="showFilters = !showFilters"
            class="inline-block px-6 py-3 mt-4 font-semibold text-white bg-vert transition-all rounded-lg shadow-lg hover:bg-green-700 focus:outline-none focus:ring-4 focus:ring-green-300"
            role="button" aria-label="filtre">
            <span x-show="!showFilters" class="transition duration-300 ease-in-out">Afficher Filtre</span>
            <span x-show="showFilters" class="transition duration-300 ease-in-out">Masquer Filtre</span>
        </button>
    </div>

    <!-- Formulaire de filtres -->
    <div class="mb-8 max-w-screen-lg mx-auto px-4 transition duration-500 ease-in-out" x-show="showFilters" x-cloak>
        <form wire:submit.prevent="applyFilters" class="grid grid-cols-1 gap-6">
            <div class="grid grid-cols-1 gap-6 md:grid-cols-2 lg:grid-cols-4">
                <!-- Catégorie -->
                <div>
                    <label for="category" class="block text-sm font-medium text-gray-700">Catégorie</label>
                    <select id="category" wire:model="category"
                        class="block w-full mt-1 p-2 border border-gray-300 rounded-lg shadow-sm focus:ring-2 focus:ring-bleu focus:border-bleu">
                        <option value="">Toutes les catégories</option>
                        @foreach ($categories as $category)
                            <option value="{{ $category->name }}">{{ $category->name }}</option>
                        @endforeach
                    </select>
                </div>

                <!-- Prix minimum -->
                <div>
                    <label for="priceMin" class="block text-sm font-medium text-gray-700">Prix minimum</label>
                    <input type="number" id="priceMin" wire:model.debounce.300ms="priceMin"
                        class="block w-full mt-1 p-2 border border-gray-300 rounded-lg shadow-sm focus:ring-2 focus:ring-bleu focus:border-bleu"
                        placeholder="Saisir un montant" step="1" min="0">
                </div>

                <!-- Prix maximum -->
                <div>
                    <label for="priceMax" class="block text-sm font-medium text-gray-700">Prix maximum</label>
                    <input type="number" id="priceMax" wire:model.debounce.300ms="priceMax"
                        class="block w-full mt-1 p-2 border border-gray-300 rounded-lg shadow-sm focus:ring-2 focus:ring-bleu focus:border-bleu"
                        placeholder="Saisir un montant" step="1" min="0">
                </div>

                <!-- Capacité -->
                <div>
                    <label for="capacity" class="block text-sm font-medium text-gray-700">Capacité</label>
                    <input type="number" id="capacity" wire:model.debounce.300ms="capacity"
                        class="block w-full mt-1 p-2 border border-gray-300 rounded-lg shadow-sm focus:ring-2 focus:ring-bleu focus:border-bleu"
                        placeholder="Saisir un chiffre" step="1" min="0">
                </div>
            </div>

            <div class="grid grid-cols-1 gap-6 md:grid-cols-2 lg:grid-cols-4">
                <!-- Animaux acceptés -->
                <div>
                    <label for="petAllowed" class="block text-sm font-medium text-gray-700">Animaux acceptés</label>
                    <select id="petAllowed" wire:model="petAllowed"
                        class="block w-full mt-1 p-2 border border-gray-300 rounded-lg shadow-sm focus:ring-2 focus:ring-bleu focus:border-bleu">
                        <option value="">Choisir une option</option>
                        <option value="1">Oui</option>
                        <option value="0">Non</option>
                    </select>
                </div>

                <!-- Chambres -->
                <div>
                    <label for="bedrooms" class="block text-sm font-medium text-gray-700">Nombre de chambres</label>
                    <input type="number" id="bedrooms" wire:model.debounce.300ms="bedrooms"
                        class="block w-full mt-1 p-2 border border-gray-300 rounded-lg shadow-sm focus:ring-2 focus:ring-bleu focus:border-bleu"
                        placeholder="Saisir un chiffre" step="1" min="0">
                </div>

                <!-- Salles de bain -->
                <div>
                    <label for="bathrooms" class="block text-sm font-medium text-gray-700">Nombre de salles de
                        bain</label>
                    <input type="number" id="bathrooms" wire:model.debounce.300ms="bathrooms"
                        class="block w-full mt-1 p-2 border border-gray-300 rounded-lg shadow-sm focus:ring-2 focus:ring-bleu focus:border-bleu"
                        placeholder="Saisir un chiffre" step="1" min="0">
                </div>

            </div>

            <div class="flex space-x-4 justify-center mb-8">
                <button type="button" wire:click="resetFilters"
                    class="block w-full max-w-xs px-4 py-2 font-semibold text-white transition-all rounded-lg bg-red-600 shadow-md hover:bg-red-700"
                    role="button" aria-label="enregistrer">
                    Réinitialiser
                </button>
                <button type="button" wire:click="applyFilters"
                    class="block w-full max-w-xs px-4 py-2 font-semibold text-white transition-all rounded-lg bg-vert shadow-md hover:bg-green-700"
                    role="button" aria-label="enregistrer">
                    Appliquer
                </button>
            </div>
        </form>
    </div>

    <!-- Liste des logements filtrés -->
    <div class="max-w-full mx-auto sm:px-6 lg:px-8">
        <div class="grid grid-cols-1 gap-8 sm:grid-cols-2 lg:grid-cols-3">
            @foreach ($paginatedLogements as $logement)
                <div>
                    <div class="p-4 bg-white rounded-lg text-noir">
                        <div class="relative aspect-w-1 aspect-h-1">
                            <img src="{{ $logement->public_url ? $logement->image_url : ($logement->image_url ? asset('storage/' . $logement->image_url) : 'https://placehold.co/600x600') }}"
                                alt="{{ $logement->title }}" class="object-cover rounded-lg aspect-square">

                            <div
                                class="absolute right-0 px-3 py-2 text-sm font-bold text-black bg-white rounded h-fit w-fit left-2 top-2">
                                {{ $logement->price }}€/nuit
                            </div>
                        </div>
                        <div class="mt-4">
                            <div class="flex justify-between">
                                <h3 class="w-2/3 text-lg font-bold text-noir">{{ $logement->title }}</h3>
                                <div class="flex items-base h-fit">
                                    <p class="w-auto text-noir">
                                        @if ($logement->average_rating)
                                            {{ number_format($logement->average_rating, 1) }} / 5
                                            <i class="fas fa-star h-fit"></i>
                                        @else
                                            Aucun avis
                                        @endif
                                    </p>
                                </div>
                            </div>
                            <p>{{ $logement->short_description }}</p>
                            <p><i class="mr-2 fa-solid fa-user"></i>{{ $logement->capacity }}
                                {{ $logement->capacity == 1 ? 'personne' : 'personnes' }}</p>
                            <p><i class="mr-2 fa-solid fa-bed"></i>{{ $logement->bedrooms }}
                                {{ $logement->bedrooms == 1 ? 'chambre' : 'chambres' }}</p>
                            <p><i class="mr-2 fa-solid fa-bath"></i>{{ $logement->bathrooms }}
                                {{ $logement->bathrooms == 1 ? 'salle de bains' : 'salles de bains' }}
                            </p>
                            <a href="/logement/{{ $logement->slug }}" wire:navigate aria-label="decouvrir"
                                class="inline-block px-4 py-2 mt-4 font-semibold text-white transition-all rounded-lg bg-vert shadow-md hover:bg-green-700">
                                Découvrir
                            </a>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        <!-- Liens de pagination -->
        <div id="paginated-logements" class="mt-8">
            {{ $paginatedLogements->links(data: ['scrollTo' => '#paginated-logements']) }}
        </div>
    </div>
</div>
