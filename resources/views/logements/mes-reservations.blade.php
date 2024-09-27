<x-app-layout>
    <div class="py-12">
        <div class="max-w-full mx-auto sm:px-6 lg:px-8">
            <div class="flex justify-between">
                <h1 class="mb-12 text-4xl font-bold text-center">Mes réservations</h1>
            </div>
            <div class="my  -5" x-data="{ openSection: '', showModal: false, selectedReservationId: null }">
                <!-- Réservations en cours -->
                <div class="mb-4 border rounded-lg">
                    <h2 @click="openSection = openSection === 'current' ? '' : 'current'"
                        class="flex items-center justify-between p-4 mb-0 text-2xl font-bold cursor-pointer">
                        <p>En cours <i class="fas fa-sync-alt text-blue-500"></i></p>
                        <svg :class="{ 'rotate-180': openSection === 'current' }" class="w-5 h-5 transition-transform"
                            fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7">
                            </path>
                        </svg>
                    </h2>
                    <div x-show="openSection === 'current'" class="px-4 pb-4">
                        @if ($currentReservations->isEmpty())
                            <div class="p-4 overflow-hidden bg-white rounded-lg">
                                <p>Vous n'avez aucune réservation en cours pour le moment.</p>
                            </div>
                        @else
                            <div class="grid grid-cols-1 gap-4 md:grid-cols-2 lg:grid-cols-3">
                                @foreach ($currentReservations as $reservation)
                                    <div class="overflow-hidden bg-white rounded-lg shadow-md">
                                        <img src="{{ $reservation->logement->public_url ? $reservation->logement->image_url : ($reservation->logement->image_url ? asset('storage/' . $reservation->logement->image_url) : 'https://placehold.co/600x600') }}"
                                            alt="{{ $reservation->logement->title }}" class="object-cover w-full h-48">
                                        <div class="p-6">
                                            <h2 class="text-2xl font-bold">
                                                <a href="/logement/{{ $reservation->logement->slug }}"
                                                    wire:navigate>{{ $reservation->logement->title }}</a>
                                            </h2>
                                            <p class="mt-2 text-lg font-semibold">
                                                {{ $reservation->nights }} nuits réservées
                                                <span class="text-sm font-normal"> ({{ $reservation->totalPrice }}
                                                    €)</span>
                                            </p>
                                            <span class="text-sm text-blue-500 font-normal">
                                                ({{ 'Du ' . $reservation->resa_debut . ' au ' . $reservation->resa_fin }})
                                            </span>
                                            <p class="mt-2 text-sm text-gray-600">{{ $reservation->logement->city }},
                                                {{ $reservation->logement->country }}</p>
                                            <p class="mt-2 text-sm font-medium">
                                                <span
                                                    class="inline-block px-2 py-1 text-xs font-semibold rounded-lg 
                                                        {{ $reservation->payment_status == 'paid' ? 'bg-green-200 text-green-800' : ($reservation->payment_status == 'pending' ? 'bg-yellow-200 text-yellow-800' : 'bg-red-200 text-red-800') }}">

                                                    @if ($reservation->payment_status == 'paid')
                                                        Payée <span>#{{ $reservation->id }}</span>
                                                    @elseif ($reservation->payment_status == 'pending')
                                                        En attente
                                                    @elseif ($reservation->payment_status == 'canceled')
                                                        Annulée
                                                    @else
                                                        Inconnu
                                                    @endif
                                                </span>
                                            </p>

                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        @endif
                    </div>
                </div>

                <!-- Réservations à venir -->
                <div class="mb-4 border rounded-lg">
                    <h2 @click="openSection = openSection === 'upcoming' ? '' : 'upcoming'"
                        class="flex items-center justify-between p-4 mb-0 text-2xl font-bold cursor-pointer">
                        <p>A venir <i class="fas fa-hourglass-half text-yellow-800"></i></p>
                        <svg :class="{ 'rotate-180': openSection === 'upcoming' }" class="w-5 h-5 transition-transform"
                            fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7">
                            </path>
                        </svg>
                    </h2>
                    <div x-show="openSection === 'upcoming'" class="px-4 pb-4">
                        @if ($upcomingReservations->isEmpty())
                            <div class="p-4 overflow-hidden bg-white rounded-lg">
                                <p>Vous n'avez aucune réservation à venir pour le moment.</p>
                            </div>
                        @else
                            <div class="grid grid-cols-1 gap-4 md:grid-cols-2 lg:grid-cols-3">
                                @foreach ($upcomingReservations as $reservation)
                                    <div class="relative overflow-hidden bg-white rounded-lg shadow-md">
                                        <!-- Vérification si c'est la première réservation -->
                                        @if ($reservation->is($upcomingReservations->first()))
                                            <span
                                                class="absolute top-2 left-2 px-2 py-1 text-xs font-medium text-white bg-blue-600 rounded-lg z-10">
                                                Ma prochaine réservation
                                            </span>
                                        @endif
                                        <img src="{{ $reservation->logement->public_url ? $reservation->logement->image_url : ($reservation->logement->image_url ? asset('storage/' . $reservation->logement->image_url) : 'https://placehold.co/600x600') }}"
                                            alt="{{ $reservation->logement->title }}" class="object-cover w-full h-48">
                                        <div class="p-6">
                                            <h2 class="text-2xl font-bold">
                                                <a href="/logement/{{ $reservation->logement->slug }}"
                                                    wire:navigate>{{ $reservation->logement->title }}</a>
                                            </h2>
                                            <p class="mt-2 text-lg font-semibold">
                                                {{ $reservation->nights }} nuits réservées
                                                <span class="text-sm font-normal"> ({{ $reservation->totalPrice }}
                                                    €)</span>
                                            </p>
                                            <span class="text-sm text-blue-500 font-normal">
                                                ({{ 'Du ' . $reservation->resa_debut . ' au ' . $reservation->resa_fin }})
                                            </span>
                                            <p class="mt-2 text-sm text-gray-600">{{ $reservation->logement->city }},
                                                {{ $reservation->logement->country }}</p>
                                            <p class="mt-2 text-sm font-medium">
                                                <span
                                                    class="inline-block px-2 py-1 text-xs font-semibold rounded-lg 
                                                        {{ $reservation->payment_status == 'paid' ? 'bg-green-200 text-green-800' : ($reservation->payment_status == 'pending' ? 'bg-yellow-200 text-yellow-800' : 'bg-red-200 text-red-800') }}">

                                                    @if ($reservation->payment_status == 'paid')
                                                        Payée
                                                    @elseif ($reservation->payment_status == 'pending')
                                                        En attente
                                                    @elseif ($reservation->payment_status == 'canceled')
                                                        Annulée
                                                    @else
                                                        Inconnu
                                                    @endif
                                                </span>
                                                <span
                                                    class="inline-block px-2 py-1 text-xs font-semibold rounded-lg bg-green-200 text-green-800">#{{ $reservation->id }}</span>
                                            </p>

                                            @php
                                                $reservationStartDate = \Carbon\Carbon::createFromFormat(
                                                    'd/m/Y',
                                                    $reservation->resa_debut,
                                                );
                                                $daysDifference = $reservationStartDate->diffInDays(now());
                                            @endphp


                                            @if ($daysDifference >= 7)
                                                <button
                                                    @click="showModal = true; selectedReservationId = {{ $reservation->id }}"
                                                    class="mt-4 bg-red-500 text-white p-2 rounded-lg" role="button"
                                                    aria-label="annuler">Annuler la
                                                    réservation
                                                </button>
                                            @else
                                                <p class="mt-4 text-red-500">L'annulation n'est plus possible car la
                                                    date de début est dans moins de 7 jours.</p>
                                            @endif
                                        </div>
                                    </div>
                                @endforeach

                            </div>
                        @endif
                    </div>
                </div>
                <!-- Modal de confirmation -->
                <div x-show="showModal" class="fixed inset-0 z-50 flex items-center justify-center">
                    <div class="fixed inset-0 bg-gray-800 bg-opacity-95"></div>
                    <div class="bg-white rounded-lg shadow-xl p-6 relative z-50 md:w-1/4">
                        <h2 class="text-xl font-bold mb-4">Confirmation d'annulation</h2>
                        <div class="mb-4 text-sm text-blue-500 rounded-lg flex items-center" role="alert">
                            <i class="fas fa-info-circle mr-2"></i>
                            <p>Conformément à nos CGV, vous pouvez annuler votre réservation au moins 7 jours avant la
                                date prévue pour un remboursement intégral. Sinon, contactez-nous par mail pour toute
                                demande de remboursement.</p>
                        </div>
                        <p>Êtes-vous sûr de vouloir annuler cette réservation ?</p>
                        <div class="mt-4">
                            <button @click="showModal = false" role="button" aria-label="annuler"
                                class="bg-gray-500 text-white px-4 py-2 rounded-lg mr-2">Annuler</button>
                            <form :action="'{{ url('reservations') }}/' + selectedReservationId + '/cancel'"
                                method="POST" class="inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" role="button" aria-label="confirmer"
                                    class="bg-red-500 text-white px-4 py-2 rounded-lg">Confirmer</button>
                            </form>
                        </div>
                    </div>
                </div>
                <!-- Réservations passées -->
                <div class="mb-4 border rounded-lg">
                    <h2 @click="openSection = openSection === 'past' ? '' : 'past'"
                        class="flex items-center justify-between p-4 mb-0 text-2xl font-bold cursor-pointer">
                        <p>Passées <i class="fas fa-check text-green-800"></i></p>
                        <svg :class="{ 'rotate-180': openSection === 'past' }" class="w-5 h-5 transition-transform"
                            fill="none" stroke="currentColor" viewBox="0 0 24 24"
                            xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7">
                            </path>
                        </svg>
                    </h2>
                    <div x-show="openSection === 'past'" class="px-4 pb-4">
                        @if ($pastReservations->isEmpty())
                            <div class="p-4 overflow-hidden bg-white rounded-lg">
                                <p>Vous n'avez aucune réservation passée pour le moment.</p>
                            </div>
                        @else
                            <div class="grid grid-cols-1 gap-4 md:grid-cols-2 lg:grid-cols-3">
                                @foreach ($pastReservations as $reservation)
                                    <div class="overflow-hidden bg-white rounded-lg shadow-md">
                                        <img src="{{ $reservation->logement->public_url ? $reservation->logement->image_url : ($reservation->logement->image_url ? asset('storage/' . $reservation->logement->image_url) : 'https://placehold.co/600x600') }}"
                                            alt="{{ $reservation->logement->title }}"
                                            class="object-cover w-full h-48">
                                        <div class="p-6">
                                            <h2 class="text-2xl font-bold">
                                                <a href="/logement/{{ $reservation->logement->slug }}"
                                                    wire:navigate>{{ $reservation->logement->title }}</a>
                                            </h2>
                                            <p class="mt-2 text-lg font-semibold">
                                                {{ $reservation->nights }} nuits réservées
                                                <span class="text-sm font-normal"> ({{ $reservation->totalPrice }}
                                                    €)</span>
                                            </p>
                                            <span class="text-sm text-blue-500 font-normal">
                                                ({{ 'Du ' . $reservation->resa_debut . ' au ' . $reservation->resa_fin }})
                                            </span>
                                            <p class="mt-2 text-sm text-gray-600">{{ $reservation->logement->city }},
                                                {{ $reservation->logement->country }}</p>
                                            <p class="mt-2 text-sm font-medium">
                                                <span
                                                    class="inline-block px-2 py-1 text-xs font-semibold rounded-lg 
                                                        {{ $reservation->payment_status == 'paid' ? 'bg-green-200 text-green-800' : ($reservation->payment_status == 'pending' ? 'bg-yellow-200 text-yellow-800' : 'bg-red-200 text-red-800') }}">

                                                    @if ($reservation->payment_status == 'paid')
                                                        Payée
                                                    @elseif ($reservation->payment_status == 'pending')
                                                        En attente
                                                    @elseif ($reservation->payment_status == 'canceled')
                                                        Annulée
                                                    @else
                                                        Inconnu
                                                    @endif
                                                </span>
                                                <span
                                                    class="inline-block px-2 py-1 text-xs font-semibold rounded-lg bg-green-200 text-green-800">#{{ $reservation->id }}</span>

                                            </p>

                                            <div class="mt-4 border-t pt-4">
                                                <details class="collapse collapse-plus bg-base-200">
                                                    <summary class="collapse-title text-lg font-medium">
                                                        {{ $reservation->avis->first() ? 'Voir l\'avis' : 'Ajouter un avis' }}
                                                    </summary>
                                                    <div class="collapse-content mt-4">
                                                        @if ($reservation->avis->first())
                                                            <!-- Affichage de l'avis existant -->
                                                            <p class="font-bold">Ma note</p>
                                                            <div class="flex items-center text-yellow-500">
                                                                @for ($i = 0; $i < $reservation->avis->first()->rating; $i++)
                                                                    <i class="fas fa-star"></i>
                                                                @endfor
                                                                @for ($i = $reservation->avis->first()->rating; $i < 5; $i++)
                                                                    <i class="far fa-star"></i>
                                                                @endfor
                                                            </div>
                                                            <p class="font-bold mt-4">Mon commentaire</p>
                                                            <p class="p-2 border rounded-md bg-gray-100">
                                                                {{ $reservation->avis->first()->comment }}
                                                            </p>
                                                        @else
                                                            <!-- Formulaire d'ajout de commentaire et de note -->
                                                            <form action="{{ route('avis.storeAvis') }}"
                                                                method="POST" class="mt-4" data-rating-form>
                                                                @csrf
                                                                @method('POST')
                                                                <input type="hidden" name="reservation_id"
                                                                    value="{{ $reservation->id }}">
                                                                <div class="mb-3">
                                                                    <label for="comment"
                                                                        class="form-label">Commentaire</label>
                                                                    <textarea class="w-full p-2 border rounded-md form-control" id="comment" name="comment" rows="3"></textarea>
                                                                </div>

                                                                {{-- Étoiles cliquables pour la note --}}
                                                                <div class="flex items-center mt-4 text-yellow-500">
                                                                    <span class="star cursor-pointer"
                                                                        data-value="1"><i
                                                                            class="fas fa-star"></i></span>
                                                                    <span class="star cursor-pointer"
                                                                        data-value="2"><i
                                                                            class="fas fa-star"></i></span>
                                                                    <span class="star cursor-pointer"
                                                                        data-value="3"><i
                                                                            class="fas fa-star"></i></span>
                                                                    <span class="star cursor-pointer"
                                                                        data-value="4"><i
                                                                            class="fas fa-star"></i></span>
                                                                    <span class="star cursor-pointer"
                                                                        data-value="5"><i
                                                                            class="fas fa-star"></i></span>
                                                                </div>

                                                                <!-- Champ caché pour la note -->
                                                                <input type="hidden" name="rating" id="rating"
                                                                    value="1">


                                                                <button type="submit" role="button"
                                                                    aria-label="ajouter"
                                                                    class="p-2 mt-4 text-white bg-blue-500 rounded-lg">Ajouter</button>
                                                            </form>
                                                        @endif
                                                    </div>
                                                </details>
                                            </div>
                                            <!-- Fin de l'accordéon pour les commentaires/avis -->

                                        </div>
                                    </div>
                                @endforeach

                            </div>
                        @endif
                    </div>
                </div>
                <!-- Réservations annulées -->
                <div class="mb-4 border rounded-lg">
                    <h2 @click="openSection = openSection === 'cancelled' ? '' : 'cancelled'"
                        class="flex items-center justify-between p-4 mb-0 text-2xl font-bold cursor-pointer">
                        <p>Annulées <i class="fas fa-times text-red-800"></i></p>
                        <svg :class="{ 'rotate-180': openSection === 'cancelled' }"
                            class="w-5 h-5 transition-transform" fill="none" stroke="currentColor"
                            viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7">
                            </path>
                        </svg>
                    </h2>
                    <div x-show="openSection === 'cancelled'" class="px-4 pb-4">
                        @if ($cancelledReservations->isEmpty())
                            <div class="p-4 overflow-hidden bg-white rounded-lg">
                                <p>Vous n'avez aucune réservation annulée pour le moment.</p>
                            </div>
                        @else
                            <div class="grid grid-cols-1 gap-4 md:grid-cols-2 lg:grid-cols-3">
                                @foreach ($cancelledReservations as $reservation)
                                    <div class="overflow-hidden bg-white rounded-lg shadow-md">
                                        <img src="{{ $reservation->logement->public_url ? $reservation->logement->image_url : ($reservation->logement->image_url ? asset('storage/' . $reservation->logement->image_url) : 'https://placehold.co/600x600') }}"
                                            alt="{{ $reservation->logement->title }}"
                                            class="object-cover w-full h-48">
                                        <div class="p-6">
                                            <h2 class="text-2xl font-bold">
                                                <a href="/logement/{{ $reservation->logement->slug }}"
                                                    wire:navigate>{{ $reservation->logement->title }}</a>
                                            </h2>

                                            <p class="mt-2 text-lg font-semibold">
                                                {{ $reservation->nights }} nuits réservées
                                                <span class="text-sm font-normal"> ({{ $reservation->totalPrice }}
                                                    €)</span>
                                            </p>
                                            <span class="text-sm text-blue-500 font-normal">
                                                ({{ 'Du ' . $reservation->resa_debut . ' au ' . $reservation->resa_fin }})
                                            </span>
                                            <p class="mt-2 text-sm text-gray-600">{{ $reservation->logement->city }},
                                                {{ $reservation->logement->country }}</p>
                                            <p class="mt-2 text-sm font-medium">
                                                <span
                                                    class="inline-block px-2 py-1 text-xs font-semibold rounded-lg 
                                                        {{ $reservation->payment_status == 'paid' ? 'bg-green-200 text-green-800' : ($reservation->payment_status == 'pending' ? 'bg-yellow-200 text-yellow-800' : ($reservation->payment_status == 'refunded' ? 'bg-blue-200 text-blue-700' : 'bg-red-200 text-red-800')) }}">
                                                    @if ($reservation->payment_status == 'paid')
                                                        Payée
                                                    @elseif ($reservation->payment_status == 'pending')
                                                        En attente
                                                    @elseif ($reservation->payment_status == 'canceled')
                                                        Annulée
                                                    @else
                                                        Remboursée
                                                    @endif
                                                </span>
                                                <span
                                                    class="inline-block px-2 py-1 text-xs font-semibold rounded-lg bg-blue-200 text-blue-700">#{{ $reservation->id }}</span>

                                            </p>

                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        @endif
                    </div>
                </div>
            </div>

        </div>
    </div>
</x-app-layout>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Sélectionner tous les formulaires d'avis
        const allForms = document.querySelectorAll('form[data-rating-form]');

        allForms.forEach(form => {
            const stars = form.querySelectorAll('.star');
            const ratingInput = form.querySelector('input[name="rating"]');

            if (stars.length > 0 && ratingInput) {
                initStars(form, stars, ratingInput);
            }
        });
    });

    function initStars(form, stars, ratingInput) {
        // Fonction pour mettre à jour les étoiles
        function updateStars(value) {
            stars.forEach(star => {
                if (parseInt(star.getAttribute('data-value')) <= value) {
                    star.classList.add('text-yellow-500');
                    star.classList.remove('text-gray-400');
                } else {
                    star.classList.remove('text-yellow-500');
                    star.classList.add('text-gray-400');
                }
            });
        }

        // Initialiser les étoiles avec la note par défaut (ou 1 si non défini)
        updateStars(parseInt(ratingInput.value) || 1);

        stars.forEach(star => {
            star.addEventListener('click', function() {
                const value = this.getAttribute('data-value');
                ratingInput.value = value;
                updateStars(parseInt(value));
            });
        });
    }
</script>
