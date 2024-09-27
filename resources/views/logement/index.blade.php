<x-app-layout>
    <div class="lg:py-12 md:py-0">
        <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
            <div class="overflow-hidden bg-white shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white">
                    <div class="grid items-center grid-cols-1 gap-6 md:grid-cols-2">
                        <div>
                            <span class="font-bold text-vert">{{ $logement->city }}</span>
                            <h1 class="mt-2 text-5xl font-bold text-bleu">{{ $logement->title }}</h1>
                            {{-- category logement --}}
                            <p class="mt-4 text-lg text-noir">
                                {{ $logement->short_description }}
                            </p>

                            @if (isset(Auth::user()->id) && Auth::user()->id == $logement->user_id)
                            <a href="{{ route('mes-logements.edit', $logement->id) }}">
                                <button class="px-4 py-2 mt-4 text-white rounded-md bg-vert focus:outline-none"
                                    role="button" aria-label="gerer">
                                    Gérer
                                </button>
                            </a>
                            @endif

                            @if ($logement->published == true)
                            <button id="bookButton" role="button" aria-label="reserever"
                                class="px-4 py-2 mt-4 text-white rounded-md bg-vert focus:outline-none">
                                <i class="mr-2 fas fa-calendar-alt"></i> Réserver
                            </button>
                            @endif

                            <div id="calendarContainer" class="hidden mt-4">
                                <input type="text" id="calendar" placeholder="Sélectionner une date"
                                    class="w-full p-2 border border-gray-300 rounded-md shadow-sm">
                                <form id="reservationForm" action="{{ route('logement.reserver', $logement->id) }}"
                                    method="POST" class="mt-4">
                                    @csrf
                                    <input type="hidden" name="start_date" id="start_date">
                                    <input type="hidden" name="end_date" id="end_date">
                                    <button type="submit" role="button" aria-label="confirmer"
                                        class="px-4 py-2 text-white rounded-md bg-bleu focus:outline-none">Confirmer
                                        la réservation</button>
                                </form>
                            </div>
                        </div>
                        <div class="relative aspect-w-3 aspect-h-2">
                            <img src="{{ $logement->public_url ? $logement->image_url : ($logement->image_url ? asset('storage/' . $logement->image_url) : 'https://placehold.co/600x600') }}"
                                alt="{{ $logement->title }}" class="object-cover rounded-lg aspect-square">
                            <!-- Price Tag in Absolute Position -->
                            <div
                                class="absolute left-3 top-3 px-5 py-3 text-lg font-bold text-black bg-white rounded-lg w-fit h-fit">
                                {{ $logement->price }}€/nuit
                            </div>
                        </div>
                    </div>

                    <!-- Afficher les coordonnées du propriétaire -->
                    <div class="mt-6">
                        <h2 class="text-3xl font-bold text-gray-700">Propriétaire</h2>
                        <div class="flex items-center mt-4">
                            <a href="{{ route('profile.show', ['slug' => $logement->user->slug]) }}">
                                <img src="{{ $logement->user->profile_photo_path ? asset('storage/' . $logement->user->profile_photo_path) : asset('storage/profile_photos/default.svg') }}"
                                    alt="Propriétaire" class="w-16 h-16 rounded-full">
                            </a>
                            <div class="ml-4">
                                <a href="{{ route('profile.show', ['slug' => $logement->user->slug]) }}"
                                    class="text-lg font-semibold text-bleu hover:underline">{{ $logement->user->name }}</a>
                                <p class="text-gray-600">
                                    <a href="mailto:{{ $logement->user->email }}"
                                        class="text-gray-600 hover:underline">
                                        <i class="fas fa-envelope"></i> <!-- Icône de mail -->
                                        {{ $logement->user->email }}
                                    </a>
                                </p>
                                @if ($logement->user->phone)
                                <p class="text-gray-600">
                                    <a href="tel:{{ $logement->user->phone }}"
                                        class="text-gray-600 hover:underline">
                                        <i class="fas fa-phone"></i> <!-- Icône de téléphone -->
                                        {{ $logement->user->phone }}
                                    </a>
                                </p>
                                @endif
                            </div>
                        </div>
                    </div>

                    <!-- Galerie d'images supplémentaires -->
                    <div class="relative my-36">
                        @if (count($logement->images) > 0)

                        <h2 class="my-12 text-3xl font-bold text-center text-gray-700">Aperçu du logement</h2>
                        <div class="relative annexes-slider">
                            @foreach ($logement->images as $image)
                            @php
                            // Vérifier si l'URL de l'image est externe ou locale
                            $isExternal = preg_match('/^(http|https):\/\//', $image->url);
                            @endphp
                            <div class="slider-item">
                                <img src="{{ $isExternal ? $image->url : asset('storage/' . $image->url) }}"
                                    alt="Image supplémentaire" class="object-cover rounded-lg">
                            </div>
                            @endforeach
                        </div>
                        @endif
                    </div>

                    <h2 class="text-3xl font-bold text-center text-gray-700">Le logement en détail</h2>
                    <div class="container mx-auto mt-6">
                        <!-- Premier étage -->
                        <div class="flex flex-col gap-6 lg:flex-row">


                            <!-- Équipements Section -->
                            <div class="w-full border-2 border-gray-100 rounded-lg lg:w-2/3">
                                <div class="p-6 bg-gray-100 rounded-t-lg">
                                    <h3 class="text-2xl font-bold text-gray-900">Équipements</h3>
                                    <p class="mt-1 text-lg text-gray-700">Ce logement comprend les équipements suivants
                                        :</p>
                                </div>
                                <div class="p-6">
                                    @if ($logement->equipements->isEmpty())
                                    <!-- Message si aucun équipement n'est disponible -->
                                    <div
                                        class="flex items-center justify-center p-4 bg-white border border-gray-200 rounded-lg shadow-sm">
                                        <p class="text-center text-gray-600">Aucun équipement disponible pour ce
                                            logement.</p>
                                    </div>
                                    @else
                                    <!-- Liste des équipements -->
                                    <div
                                        class="grid grid-cols-1 gap-4 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-3">
                                        @foreach ($logement->equipements as $equipement)
                                        <div
                                            class="flex items-center p-4 space-x-4 bg-white border border-gray-200 rounded-lg shadow-sm">
                                            <i class="text-2xl text-green-500 fas fa-check-circle"></i>
                                            <span
                                                class="text-base font-medium text-gray-800">{{ $equipement->name }}</span>
                                        </div>
                                        @endforeach
                                    </div>
                                    @endif
                                </div>
                            </div>


                            <!-- Note moyenne -->
                            <div class="w-full bg-white rounded-lg lg:w-1/3">
                                <div
                                    class="flex flex-col items-center justify-center h-full p-6 align-middle bg-gray-100 rounded-t-lg d-flex">
                                    <h3 class="mb-2 text-5xl font-bold text-gray-900">
                                        {{ $averageRating ? number_format($averageRating, 2) : 'Aucun avis' }}
                                        <i class="ml-1 text-4xl text-yellow-500 fas fa-star"></i>
                                    </h3>
                                    <p class="text-center text-gray-800">
                                        Note moyenne des <b class="text-gray-900">{{ $countAvis }}</b> avis reçus.
                                    </p>
                                </div>
                            </div>

                        </div>

                        <!-- Description Section -->
                        <div class="flex-1 w-full mt-12">
                            <div class="p-4 bg-white rounded-lg">
                                <p class="text-lg text-gray-800">
                                    {{ $logement->description }}
                                </p>
                            </div>
                        </div>


                        <!-- Second étage -->
                        <div class="mt-6">
                            <div class="p-4 bg-white rounded-lg">
                                <ul class="grid gap-4 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4">
                                    <li
                                        class="flex flex-col items-center p-4 space-y-2 text-center border border-gray-200 rounded-lg bg-gray-50">
                                        <i class="text-2xl text-gray-700 fas fa-home"></i>
                                        <span class="text-sm font-bold">Catégorie</span>
                                        <span class="text-gray-800">{{ $logement->category->name }}</span>
                                    </li>
                                    <li
                                        class="flex flex-col items-center p-4 space-y-2 text-center border border-gray-200 rounded-lg bg-gray-50">
                                        <i class="text-2xl text-gray-700 fas fa-euro-sign"></i>
                                        <span class="text-sm font-bold">Prix par nuit</span>
                                        <span class="text-gray-800">{{ $logement->price }}</span>
                                    </li>
                                    <li
                                        class="flex flex-col items-center p-4 space-y-2 text-center border border-gray-200 rounded-lg bg-gray-50">
                                        <i class="text-2xl text-gray-700 fas fa-users"></i>
                                        <span class="text-sm font-bold">Capacité</span>
                                        <span class="text-gray-800">{{ $logement->capacity }}</span>
                                    </li>
                                    <li
                                        class="flex flex-col items-center p-4 space-y-2 text-center border border-gray-200 rounded-lg bg-gray-50">
                                        <i class="text-2xl text-gray-700 fas fa-bed"></i>
                                        <span class="text-sm font-bold">Chambre(s)</span>
                                        <span class="text-gray-800">{{ $logement->bedrooms }}</span>
                                    </li>
                                    <li
                                        class="flex flex-col items-center p-4 space-y-2 text-center border border-gray-200 rounded-lg bg-gray-50">
                                        <i class="text-2xl text-gray-700 fas fa-bath"></i>
                                        <span class="text-sm font-bold">Salle(s) de bain</span>
                                        <span class="text-gray-800">{{ $logement->bathrooms }}</span>
                                    </li>
                                    <li
                                        class="flex flex-col items-center p-4 space-y-2 text-center border border-gray-200 rounded-lg bg-gray-50">
                                        <i class="text-2xl text-gray-700 fas fa-paw"></i>
                                        <span class="text-sm font-bold">Animaux autorisés</span>
                                        <span
                                            class="text-gray-800">{{ $logement->pet_allowed == 1 ? 'Oui' : 'Non' }}</span>
                                    </li>
                                    <li
                                        class="flex flex-col items-center p-4 space-y-2 text-center border border-gray-200 rounded-lg bg-gray-50">
                                        <i class="text-2xl text-gray-700 fas fa-smoking"></i>
                                        <span class="text-sm font-bold">Fumeurs autorisés</span>
                                        <span
                                            class="text-gray-800">{{ $logement->smoker_allowed == 1 ? 'Oui' : 'Non' }}</span>
                                    </li>
                                    </li>
                                    <li
                                        class="flex flex-col items-center p-4 space-y-2 text-center border border-gray-200 rounded-lg bg-gray-50">
                                        <i class="text-2xl text-gray-700 fas fa-city"></i>
                                        <span class="text-sm font-bold">Ville</span>
                                        <span class="text-gray-800">{{ $logement->city ?? 'Non renseigné' }}</span>
                                    </li>
                                    <li
                                        class="flex flex-col items-center p-4 space-y-2 text-center border border-gray-200 rounded-lg bg-gray-50">
                                        <i class="text-2xl text-gray-700 fas fa-flag"></i>
                                        <span class="text-sm font-bold">Pays</span>
                                        <span class="text-gray-800">{{ $logement->country ?? 'Non renseigné' }}</span>
                                    </li>
                                    <li
                                        class="flex flex-col items-center p-4 space-y-2 text-center border border-gray-200 rounded-lg bg-gray-50">
                                        <i class="text-2xl text-gray-700 fas fa-map-marker-alt"></i>
                                        <span class="text-sm font-bold">Rue</span>
                                        <span class="text-gray-800">{{ $logement->street ?? 'Non renseigné' }}</span>
                                    </li>
                                    <li
                                        class="flex flex-col items-center p-4 space-y-2 text-center border border-gray-200 rounded-lg bg-gray-50">
                                        <i class="text-2xl text-gray-700 fas fa-envelope"></i>
                                        <span class="text-sm font-bold">Code postal</span>
                                        <span
                                            class="text-gray-800">{{ $logement->postal_code ?? 'Non renseigné' }}</span>
                                    </li>

                                </ul>
                            </div>

                        </div>
                    </div>



                    <div class="py-12 mx-auto bg-white rounded-lg" id="avis-slider">
                        @if (count($avisDuLogement) > 0)
                        <h2 class="mb-12 text-3xl font-bold text-center text-bleu">Avis</h2>
                        <div class="space-y-6 avis-slider">
                            @foreach ($avisDuLogement as $avis)
                            <div
                                class="flex flex-col p-8 space-y-4 bg-white rounded-lg avis-card max-w-xl border-gray-100 border-2 h-full">
                                <div class="flex items-center space-x-4">
                                    <a href="{{ route('profile.show', ['slug' => $avis->user->slug]) }}"
                                        class="hover:underline" aria-label="profile">
                                        <img src="{{ $avis->user->profile_photo_path ? asset('storage/' . $avis->user->profile_photo_path) : 'https://via.placeholder.com/150' }}"
                                            alt="User image" class="w-24 h-24 rounded-full object-cover">
                                    </a>
                                    <div>
                                        <p class="text-sm text-gray-500">Utilisateur vérifié</p>
                                        <a href="{{ route('profile.show', ['slug' => $avis->user->slug]) }}"
                                            aria-label="profile" class="hover:underline">
                                            <h4 class="font-bold text-lg">{{ $avis->user->name }}</h4>
                                        </a>
                                        <p class="text-sm text-gray-500"><small>Posté le
                                                {{ $avis->updated_at->format('d/m/Y') ?? $avis->created_at->format('d/m/Y') }}</small>
                                        </p>
                                    </div>
                                </div>
                                <p class="font-bold text-gray-700 line-clamp-2">{{ $avis->logement->title }}
                                </p>
                                <!-- Limiter à 2 lignes -->
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
                                        <p class="text-gray-700 font-bold"><i
                                                class="fa-solid fa-moon mr-2"></i><span
                                                class="font-normal">{{ $avis->interval }}
                                                {{ $avis->interval == 1 ? 'nuit' : 'nuits' }}</span> </p>
                                    </div>
                                </div>
                                <p class="text-gray-600 line-clamp-4">{{ $avis->comment }}</p>
                                <!-- Limiter à 4 lignes -->

                            </div>
                            @endforeach
                        </div>
                        @endif
                    </div>


                    <div class="py-12 mx-auto overflow-hidden bg-white rounded-lg logementsSimilaires"
                        id="avis-slider">
                        @if (count($logementsSimilaires) > 0)
                        <h2 class="mb-12 text-3xl font-bold text-center text-bleu">Logements similaires</h2>
                        <div class="max-w-full mx-auto sm:px-6 lg:px-8">
                            <div class="grid grid-cols-1 gap-8 sm:grid-cols-2 lg:grid-cols-3">
                                @if (isset($logementsSimilaires))
                                @foreach ($logementsSimilaires as $logementSimilaire)
                                <div>
                                    <div class="p-4 bg-white rounded-lg text-noir">
                                        <div class="relative aspect-w-1 aspect-h-1">
                                            <img src="{{ $logementSimilaire->public_url ? $logementSimilaire->image_url : ($logementSimilaire->image_url ? asset('storage/' . $logementSimilaire->image_url) : asset('storage/profile_photos/default.svg')) }}"
                                                alt="{{ $logementSimilaire->title }}"
                                                class="object-cover rounded-lg aspect-square">
                                            <div
                                                class="absolute right-0 px-3 py-2 text-sm font-bold text-black bg-white rounded top-2 left-2 h-fit w-fit">
                                                {{ $logementSimilaire->price }}€/nuit
                                            </div>
                                        </div>
                                        <div class="mt-4">
                                            <div class="flex justify-between">
                                                <h3 class="w-2/3 text-lg font-bold text-noir">
                                                    {{ $logementSimilaire->title }}
                                                </h3>
                                                <div class="flex items-base h-fit">
                                                    <p class="w-auto text-noir">
                                                        @if ($logementSimilaire->averageRating)
                                                        {{ number_format($logementSimilaire->averageRating, 1) }}
                                                        /
                                                        5
                                                        <i class="fas fa-star h-fit"></i>
                                                        @else
                                                        Aucun avis
                                                        @endif
                                                    </p>
                                                </div>
                                            </div>
                                            <p>{{ $logementSimilaire->short_description }}</p>
                                            <p><i
                                                    class="mr-2 fa-solid fa-user"></i>{{ $logementSimilaire->capacity }}
                                                {{ $logementSimilaire->capacity == 1 ? 'personne' : 'personnes' }}
                                            </p>
                                            <p><i
                                                    class="mr-2 fa-solid fa-bed"></i>{{ $logementSimilaire->bedrooms }}
                                                {{ $logementSimilaire->bedrooms == 1 ? 'chambre' : 'chambres' }}
                                            </p>
                                            <p><i
                                                    class="mr-2 fa-solid fa-bath"></i>{{ $logementSimilaire->bathrooms }}
                                                {{ $logementSimilaire->bathrooms == 1 ? 'salle de bains' : 'salles de bains' }}
                                            </p>
                                            <a href="/logement/{{ $logementSimilaire->slug }}"
                                                wire:navigate
                                                class="inline-block px-4 py-2 mt-4 font-semibold text-white transition-all rounded bg-vert hover:bg-green-700">
                                                Découvrir
                                            </a>
                                        </div>
                                    </div>
                                </div>
                                @endforeach
                                @endif
                            </div>
                        </div>
                        @endif
                    </div>


                </div>
            </div>
        </div>
    </div>
</x-app-layout>

<script type="text/javascript">
    $(document).ready(function() {
        $('.annexes-slider').slick({
            slidesToShow: 3,
            slidesToScroll: 1,
            speed: 300,
            infinite: false,
            arrows: false,
            dots: true,
            responsive: [{
                    breakpoint: 1024,
                    settings: {
                        slidesToShow: 2,
                        slidesToScroll: 1,
                        infinite: true,
                        dots: true
                    }
                },
                {
                    breakpoint: 600,
                    settings: {
                        slidesToShow: 1,
                        slidesToScroll: 1
                    }
                }
            ]
        });
    });

    // Debut gestion calendrier réservation
    document.getElementById('bookButton').addEventListener('click', function() {
        document.getElementById('calendarContainer').classList.toggle('hidden');

        // Récupérer les dates disponibles et réservées depuis le serveur
        const datesDuLogement = @json($datesDuLogement);
        const datesReservees = @json($datesReservees);
        let enabledDates = [];

        // Ajouter les dates de disponibilité au tableau de dates activées
        datesDuLogement.forEach(item => {
            let start = new Date(item.debut_dispo);
            let end = new Date(item.fin_dispo);

            // Ajouter chaque jour du début à la fin à enabledDates
            for (let d = start; d <= end; d.setDate(d.getDate() + 1)) {
                enabledDates.push(d.toISOString().split('T')[0]);
            }
        });

        // Retirer les réservations du tableau de dates activées
        datesReservees.forEach(item => {
            let start = new Date(item.debut_dispo);
            let end = new Date(item.fin_dispo);

            // Retirer chaque jour du début à la fin de enabledDates
            for (let d = start; d <= end; d.setDate(d.getDate() + 1)) {
                let dateString = d.toISOString().split('T')[0];
                let index = enabledDates.indexOf(dateString);
                if (index > -1) {
                    enabledDates.splice(index, 1);
                }
            }
        });

        flatpickr('#calendar', {
            mode: 'range',
            minDate: 'today',
            dateFormat: 'd/m/Y',
            locale: 'fr',
            enable: [
                function(date) {
                    let dateString = date.toISOString().split('T')[0];
                    return enabledDates.includes(
                        dateString); // Activer la date si elle est dans enabledDates
                }
            ],
            onClose: function(selectedDates, dateStr, instance) {
                if (selectedDates.length === 2) {
                    const dateDebut = new Date(selectedDates[0]);
                    const dateFin = new Date(selectedDates[1]);
                    document.getElementById('start_date').value = dateDebut.getFullYear() + '-' + (
                            dateDebut.getMonth() + 1).toString().padStart(2, '0') + '-' + dateDebut
                        .getDate().toString().padStart(2, '0');
                    document.getElementById('end_date').value = dateFin.getFullYear() + '-' + (
                            dateFin.getMonth() + 1).toString().padStart(2, '0') + '-' + dateFin
                        .getDate().toString().padStart(2, '0');
                }
            }
        });
    });
</script>