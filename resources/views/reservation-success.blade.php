<x-app-layout>
    <div class="max-w-3xl mx-auto py-12">
        <div class="bg-white p-8 rounded-lg">
            @if($lastReservation)
                <h1 class="text-3xl font-medium text-green-500 mb-12 text-center">Votre réservation est confirmée.</h1>
                <p class="text-lg text-gray-700 mb-4">{{ session('success') }}</p>

                <!-- Récapitulatif de la réservation -->
                <div class="bg-gray-100 p-6 rounded-lg shadow-md mb-6">
                    <h2 class="text-2xl font-semibold mb-4">Récapitulatif de votre dernière réservation</h2>
                    <div class="mb-2">
                        <span class="font-semibold">Logement :</span> {{ $lastReservation->logement->title }}
                    </div>
                    <div class="mb-2">
                        <span class="font-semibold">Description :</span> {{ $lastReservation->logement->short_description }}
                    </div>
                    <div class="mb-2">
                        <span class="font-semibold">Adresse :</span> {{ $lastReservation->logement->street }}, {{ $lastReservation->logement->city }}, {{ $lastReservation->logement->country }} - {{ $lastReservation->logement->postal_code }}
                    </div>
                    <div class="mb-2">
                        <span class="font-semibold">Dates de séjour :</span> du {{ $lastReservation->startDate->format('d/m/Y') }} au {{ $lastReservation->endDate->format('d/m/Y') }}
                    </div>
                    <div class="mb-2">
                        <span class="font-semibold">Nombre de nuits :</span> {{ $lastReservation->nights }}
                    </div>
                    <div class="mb-2">
                        <span class="font-semibold">Prix par nuit :</span> {{ number_format($lastReservation->logement->price, 2) }} €
                    </div>
                    <div class="mb-2">
                        <span class="font-semibold">Prix total :</span> {{ number_format($lastReservation->totalAmount, 2) }} €
                    </div>
                </div>

                <a href="{{ route('mes-reservations.index') }}" class="block w-full bg-blue-500 text-white py-2 px-4 rounded-lg hover:bg-blue-600 focus:outline-none focus:bg-blue-600 text-center">Voir mes réservations</a>
            @else
                <h1 class="text-3xl font-medium text-red-500 mb-12 text-center">Aucune réservation trouvée</h1>
                <p class="text-lg text-gray-700 mb-4">Vous n'avez encore effectué aucune réservation.</p>
                <a href="{{ route('home.index') }}" class="block w-full bg-blue-500 text-white py-2 px-4 rounded-lg hover:bg-blue-600 focus:outline-none focus:bg-blue-600 text-center">Retour à l'accueil</a>
            @endif
        </div>
    </div>
</x-app-layout>
