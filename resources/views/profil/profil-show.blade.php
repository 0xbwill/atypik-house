<x-app-layout>
    <div class="container max-w-4xl px-4 py-8 mx-auto">
        <div class="p-6 bg-white sm:rounded-lg">
            <div class="flex flex-col sm:flex-row items-center sm:space-x-4 space-y-4 sm:space-y-0">
                <img class="w-24 h-24 rounded-full"
                    src="{{ $user->profile_photo_path ? asset('storage/' . $user->profile_photo_path) : 'https://via.placeholder.com/150' }}"
                    alt="{{ $user->name }}">
                <div class="text-center sm:text-left">
                    <h1 class="text-2xl font-bold">{{ $user->name }}</h1>
                    @if ($user->hasRole('hôte'))
                        <p>
                            <i class="fas fa-envelope mr-1"></i> <!-- Icône de mail -->
                            <a href="mailto:{{ $user->email }}"
                                class="text-gray-600 hover:underline">{{ $user->email }}</a>
                        </p>
                        @if ($user->phone)
                            <!-- Vérifie si l'utilisateur a un téléphone et est un hôte -->
                            <p>
                                <i class="fas fa-phone mr-1"></i> <!-- Icône de téléphone -->
                                <a href="tel:{{ $user->phone }}"
                                    class="text-gray-600 hover:underline">{{ $user->phone }}</a>
                            </p>
                        @endif
                    @endif
                </div>
            </div>

            @if ($user->logements->count())
                <div class="mt-12">
                    <h2 class="mb-4 text-3xl font-semibold">Informations sur l'hôte</h2>
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                        <!-- Nombre de logements -->
                        <div class="rounded-lg shadow-md">
                            <div class="p-6 bg-gray-100 rounded-t-lg">
                                <h3 class="text-3xl font-bold text-noir">{{ $user->logements->count() }}
                                    <i class="w-4 h-4 mb-2 ml-2 text-2xl text-gray-700 fas fa-home"></i>
                                </h3>
                                <p class="text-2xl font-semibold text-noir">{{ $user->logements->count() === 1 ? 'logement' : 'logements' }}</p>
                                <p class="text-xl font-semibold text-vert">{{ $user->logements->count() === 1 ? 'disponible' : 'disponibles' }}</p>
                            </div>
                            <p class="px-6 pt-2 pb-6 mt-4 text-noir">Nombre total de logements en location.</p>
                        </div>

                        <!-- Nombre d'avis -->
                        <div class="rounded-lg shadow-md">
                            <div class="p-6 bg-gray-100 rounded-t-lg">
                                <h3 class="text-3xl font-bold text-noir">{{ $totalAvis }}
                                    <i class="w-4 h-4 ml-3 text-2xl text-gray-700 fas fa-comment-dots"></i>
                                </h3>
                                <p class="text-2xl font-semibold text-noir">avis</p>
                                <p class="text-xl font-semibold text-vert">{{ $totalAvis === 1 ? 'reçu' : 'reçus' }}</p>
                            </div>
                            <p class="px-6 pt-2 pb-6 mt-4 text-noir">Nombre total d'avis pour les logements.</p>
                        </div>

                        <!-- Note moyenne -->
                        <div class="rounded-lg shadow-md">
                            <div class="p-6 bg-gray-100 rounded-t-lg">
                                <h3 class="text-3xl font-bold text-noir">{{ number_format($averageRating, 2) }}
                                    <i class="w-4 h-4 ml-1 text-2xl text-yellow-500 fas fa-star"></i>
                                </h3>
                                <p class="text-2xl font-semibold text-noir">note moyenne</p>
                                <p class="text-xl font-semibold text-vert">sur 5</p>
                            </div>
                            <p class="px-6 pt-2 pb-6 mt-4 text-noir">Note moyenne des avis reçus.</p>
                        </div>
                    </div>
                </div>

                <div class="mt-12">
                    <h2 class="mb-4 text-3xl font-semibold">Liste des logements</h2>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        @foreach ($user->logements as $logement)
                            <div class="overflow-hidden bg-gray-100 rounded-lg shadow">
                                <img class="object-cover w-full h-48"
                                    src="{{ $logement->public_url ? $logement->image_url : ($logement->image_url ? asset('storage/' . $logement->image_url) : asset('storage/profile_photos/default.svg')) }}"
                                    alt="{{ $logement->title }}">
                                <div class="p-6">
                                    <h3 class="mb-2 text-lg font-bold text-bleu">{{ $logement->title }}</h3>
                                    <p class="mb-4 text-gray-700">{{ $logement->short_description }}</p>
                                    <ul class="mb-4 space-y-2">
                                        <li class="flex items-center">
                                            <i class="w-4 h-4 mr-2 text-gray-700 fas fa-map-marker-alt"></i>
                                            <span>{{ $logement->city }}</span>
                                        </li>
                                        <li class="flex items-center">
                                            <i class="w-4 h-4 mr-2 text-gray-700 fas fa-dollar-sign"></i>
                                            <span>{{ $logement->price }}€ par nuit</span>
                                        </li>
                                        <li class="flex items-center">
                                            <i class="w-4 h-4 mr-2 text-gray-700 fas fa-users"></i>
                                            <span>{{ $logement->capacity }} personnes</span>
                                        </li>
                                        <li class="flex items-center">
                                            <i class="w-4 h-4 mr-2 text-gray-700 fas fa-bed"></i>
                                            <span>{{ $logement->bedrooms }} chambres</span>
                                        </li>
                                    </ul>
                                    <a href="{{ route('logement.index', $logement->slug) }}"
                                        class="block px-4 py-2 text-white transition-all duration-300 rounded-md bg-vert hover:bg-green-700 text-center">
                                        Voir le logement
                                    </a>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            @elseif ($userAvis && $userAvis->count())
                <!-- Afficher les informations sur les avis postés -->
                <div class="mt-12">
                    <h2 class="mb-4 text-3xl font-semibold">Informations sur vos avis</h2>
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                        <!-- Nombre d'avis postés -->
                        <div class="rounded-lg shadow-md">
                            <div class="p-6 bg-gray-100 rounded-t-lg">
                                <h3 class="text-3xl font-bold text-noir">{{ $totalUserAvis }}
                                    <i class="w-4 h-4 ml-3 text-2xl text-gray-700 fas fa-comment-dots"></i>
                                </h3>
                                <p class="text-2xl font-semibold text-noir">avis</p>
                                <p class="text-xl font-semibold text-vert">postés</p>
                            </div>
                            <p class="px-6 pt-2 pb-6 mt-4 text-noir">Nombre total d'avis postés.</p>
                        </div>

                        <!-- Note moyenne des avis postés -->
                        <div class="rounded-lg shadow-md">
                            <div class="p-6 bg-gray-100 rounded-t-lg">
                                <h3 class="text-3xl font-bold text-noir">{{ number_format($averageUserRating, 2) }}
                                    <i class="w-4 h-4 ml-1 text-2xl text-yellow-500 fas fa-star"></i>
                                </h3>
                                <p class="text-2xl font-semibold text-noir">note moyenne</p>
                                <p class="text-xl font-semibold text-vert">sur 5</p>
                            </div>
                            <p class="px-6 pt-2 pb-6 mt-4 text-noir">Note moyenne des avis laissés.</p>
                        </div>
                    </div>
                </div>

                <!-- Afficher la liste des avis de l'utilisateur -->
                <div class="mt-12">
                    <h2 class="mb-4 text-3xl font-semibold">Avis postés</h2>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        @foreach ($userAvis as $avis)
                            <div class="overflow-hidden bg-gray-100 rounded-lg shadow">
                                
                                <div class="p-6">
                                    <a href="{{ route('logement.index', $avis->logement->slug) }}" wire:navigate>
                                    <h3 class="mb-2 text-lg font-bold text-bleu">{{ $avis->logement->title }}</h3></a>
                                    <p class="mb-4 text-gray-700">{{ $avis->comment }}</p>
                                    <p class="mb-4 text-gray-700">Note : {{ $avis->rating }} / 5</p>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            @else
                <p class="mt-6">Cet utilisateur n'a pas de logements en location ni d'avis.</p>
            @endif
        </div>
    </div>
</x-app-layout>
