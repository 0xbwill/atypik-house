<x-app-layout>

    <!-- Texte d'intro -->
    <div class="lg:py-12 md:py-0">
        <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
            <div class="overflow-hidden bg-white shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <div class="grid items-center grid-cols-1 gap-6 md:grid-cols-2">
                        <div>
                            <span class="font-bold text-vert">NOUS DÉCOUVRIR</span>
                            <h1 class="mt-2 text-5xl font-bold text-bleu">Vivez l'expérience
                            </h1>
                            <h2 class="text-bleu text-5xl font-bold">ATYPIKHOUSE</h2>
                            <p class="mt-4 text-lg text-noir">
                                Découvrez AtypikHouse, votre portail pour des séjours uniques dans des habitats
                                insolites. De cabanes perchées à des yourtes confortables, plongez au cœur de la nature
                                pour une escapade inoubliable.

                            </p>
                            <a href="{{ route('logements.index') }}" aria-label="decouvrir"
                                class="block w-fit px-4 py-3 mt-6 text-white transition-all rounded-xl bg-vert hover:bg-green-700"
                                wire:navigate>
                                Découvrir nos logements
                            </a>
                        </div>
                        <div>
                            <img src="{{ asset('images/pexels-daniele-la-rosa-messina-1626789-24602126.png') }}"
                                alt="Auvergne-Rhône-Alpes" class="object-cover w-full h-auto rounded-lg shadow-lg"
                                loading="lazy" width="600" height="400">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <!-- caroussel -->
    <div class="py-12">
        <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
            <h3 class="mt-8 mb-4 text-4xl font-bold text-center text-bleu">Nos logements les mieux notés</h3>
            <div class="bg-white shadow-sm sm:rounded-lg">
                <div class="relative p-6">
                    <div class="carousel best-logements">
                        @foreach ($logements as $logement)
                            <div>
                                <div class="relative p-4 bg-white rounded-lg">
                                    <div class="relative aspect-w-1 aspect-h-1">
                                        <img src="{{ $logement->public_url ? $logement->image_url : ($logement->image_url ? asset('storage/' . $logement->image_url) : 'https://placehold.co/600x600') }}"
                                            alt="{{ $logement->title }}" class="object-cover rounded-lg aspect-square">

                                        <div class="absolute right-0 px-3 py-2 text-sm font-bold text-black bg-white rounded h-fit w-fit left-2 top-2">
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
                                            {{ $logement->bathrooms == 1 ? 'salle de bains' : 'salles de bains' }}</p>
                                        <a href="/logement/{{ $logement->slug }}" wire:navigate.hover
                                            aria-label="decouvrir"
                                            class="inline-block px-4 py-2 mt-4 font-semibold text-white transition-all rounded bg-vert hover:bg-green-700">
                                            Découvrir
                                        </a>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>

                    <button type="button" class="slick-prev" role="button" aria-label="enregistrer"><i
                            class="fas fa-chevron-left"></i></button>
                    <button type="button" class="slick-next" role="button" aria-label="enregistrer"><i
                            class="fas fa-chevron-right"></i></button>
                </div>
            </div>
        </div>
    </div>

    <!-- Pourquoi nous -->
    <div class="py-12">
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8"> <!-- Ajout de px-4 pour les marges sur mobile -->
            <h2 class="mb-12 text-4xl font-bold text-center text-bleu">Pourquoi nous ?</h2>
            <div class="grid grid-cols-1 gap-6 md:grid-cols-2 lg:grid-cols-4">
                <div class="rounded-lg shadow-md">
                    <div class="p-6 bg-gray-100 rounded-t-lg">
                        <li class="flex items-center">
                            <h3 class="text-4xl font-bold text-noir">{{ $totalLogements }}</h3>
                            <i class="mb-2 ml-2 text-3xl text-gray-700 fas fa-home"></i>
                        </li>
                        <p class="text-2xl font-semibold text-noir">logements</p>
                        <p class="text-xl font-semibold text-vert">disponibles</p>
                    </div>
                    <p class="px-6 pt-2 pb-6 mt-4 text-noir">Découvrez une vaste gamme de logements uniques, allant des
                        cabanes dans les arbres aux maisons flottantes. Trouvez l'endroit parfait pour une expérience
                        inoubliable.</p>
                </div>
                <div class="rounded-lg shadow-md">
                    <div class="p-6 bg-gray-100 rounded-t-lg">
                        <li class="flex items-center">
                            <h3 class="text-4xl font-bold text-noir">{{ $totalUsersWithHostRole }}</h3>
                            <i class="text-3xl ml-2 text-gray-700 fas fa-users"></i>
                        </li>
                        <p class="text-2xl font-semibold text-noir">hôtes</p>
                        <p class="text-xl font-semibold text-vert">enregistrés</p>
                    </div>
                    <p class="px-6 pt-2 pb-6 mt-4 text-noir">Rejoignez une communauté dynamique d’hôtes passionnés,
                        prêts à partager leur espace et leurs conseils pour une expérience locale authentique.</p>
                </div>
                <div class="rounded-lg shadow-md">
                    <div class="p-6 bg-gray-100 rounded-t-lg">
                        <li class="flex items-center">
                            <h3 class="text-4xl font-bold text-noir">{{ $totalAvis }}</h3>
                            <i class="ml-3 text-3xl text-gray-700 fas fa-comment-dots"></i>
                        </li>
                        <p class="text-2xl font-semibold text-noir">avis</p>
                        <p class="text-xl font-semibold text-vert">au total</p>
                    </div>
                    <p class="px-6 pt-2 pb-6 mt-4 text-noir">Les avis de nos utilisateurs reflètent la qualité
                        exceptionnelle des séjours offerts. Lisez les témoignages pour vous faire une idée de
                        l'expérience qui vous attend.</p>
                </div>
                <div class="rounded-lg shadow-md">
                    <div class="p-6 bg-gray-100 rounded-t-lg">
                        <li class="flex items-center">
                            <h3 class="text-4xl font-bold text-noir">
                                {{ $averageRating ? number_format($averageRating, 2) : 'Aucun avis' }}
                            </h3>
                            <i class="ml-1 text-3xl text-yellow-500 fas fa-star"></i>
                        </li>
                        <p class="text-2xl font-semibold text-noir">moyenne</p>
                        <p class="text-xl font-semibold text-vert">des avis</p>
                    </div>
                    <p class="px-6 pt-2 pb-6 mt-4 text-noir">Nos utilisateurs apprécient la qualité de service et des
                        logements proposés, comme en témoigne notre excellente note moyenne. Réservez en toute
                        confiance.</p>
                </div>
            </div>
        </div>
    </div>




    <!-- Avis -->
    <div class="py-12 mx-auto bg-white rounded-lg" id="avis-slider">
        <h2 class="mb-12 text-3xl font-bold text-center text-bleu">Ils parlent pour nous</h2>
        <div class="avis-slider space-y-6 mb-12"> <!-- Ajouter une marge inférieure -->
            @foreach ($filteredAvis as $avis)
                <div class="flex flex-col p-8 space-y-4 bg-white rounded-lg avis-card max-w-xl border-gray-100 border-2 h-full">
                    <div class="flex items-center space-x-4">
                        <a href="{{ route('profile.show', ['slug' => $avis->user->slug]) }}" class="hover:underline" aria-label="profile">
                            <img src="{{ $avis->user->profile_photo_path ? asset('storage/' . $avis->user->profile_photo_path) : 'https://via.placeholder.com/150' }}"
                                 alt="User image" class="w-24 h-24 rounded-full object-cover">
                        </a>
                        <div>
                            <p class="text-sm text-gray-500">Utilisateur vérifié</p>
                            <a href="{{ route('profile.show', ['slug' => $avis->user->slug]) }}" aria-label="profile" class="hover:underline">
                                <h4 class="font-bold text-lg">{{ $avis->user->name }}</h4>
                            </a>
                            <p class="text-sm text-gray-500"><small>Posté le {{ $avis->updated_at->format('d/m/Y') ?? $avis->created_at->format('d/m/Y') }}</small></p>
                        </div>
                    </div>
                    <a href="{{ route('logement.index', ['slug' => $avis->logement->slug]) }}" class="font-bold text-gray-700 hover:underline line-clamp-2">
                        {{ $avis->logement->title }}
                    </a>
                    <p style="margin-top: 4px !important">{{ $avis->logement->city }}</p>
                    <div class="flex justify-between items-center border-t pt-4">
                        <div class="flex items-center">
                            <p class="text-gray-700 font-bold mr-2">Note :</p>
                            <div class="text-yellow-500 flex items-center">
                                @for ($i = 0; $i < $avis->rating; $i++)
                                    <i class="fas fa-star"></i>
                                @endfor
                                @for ($i = $avis->rating; $i < 5; $i++)
                                    <i class="far fa-star"></i>
                                @endfor
                            </div>
                        </div>
                        <div>
                            <p class="text-gray-700 font-bold"><i class="fa-solid fa-moon mr-2"></i><span class="font-normal">{{ $avis->interval }} {{ $avis->interval == 1 ? 'nuit' : 'nuits' }}</span></p>
                        </div>
                    </div>
                    <p class="text-gray-600 line-clamp-4">{{ $avis->comment }}</p>
                </div>
            @endforeach
        </div>
    </div>
    
</x-app-layout>


<style>
    /* Limite le texte à 2 lignes */
    .line-clamp-2 {
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
        overflow: hidden;
        text-overflow: ellipsis;
    }

    /* Limite le texte à 4 lignes */
    .line-clamp-4 {
        display: -webkit-box;
        -webkit-line-clamp: 4;
        -webkit-box-orient: vertical;
        overflow: hidden;
        text-overflow: ellipsis;
    }

    /* Uniformiser la hauteur des cartes */
    .avis-slider {
        display: flex;
        flex-wrap: wrap;
    }

    .avis-card {
        flex: 1 1 30%;
        /* Permet l'ajustement flexible des cartes */
        min-height: 350px;
        /* Définir une hauteur minimale pour uniformiser la hauteur */
        max-height: 100%;
        /* Empêche les cartes de dépasser une certaine hauteur */
    }
</style>
