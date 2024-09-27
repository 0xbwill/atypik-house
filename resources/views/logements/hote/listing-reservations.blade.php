<x-app-layout>
    <div class="py-12">
        <div class="max-w-full mx-auto sm:px-6 lg:px-8">
            <h1 class="mb-2 text-3xl font-bold">
                Liste des réservations pour votre logement
            </h1>
            <a class="w-fit block mb-6" href="{{ route('logement.index', $logement->slug) }}">
                <h3 class="mb-4 text-2xl font-bold">
                    <i class="fa-solid fa-arrow-right mr-2"></i>{{ $logement->title }}
                </h3>
            </a>

            <!-- Accordéon pour chaque mois -->
            <div class="my-5" x-data="{ openSection: '' }">
                @php
                    $currentMonth = \Carbon\Carbon::now()->format('Y-m'); // Format '2024-09'
                @endphp

                @foreach ($reservationsByMonth as $month => $reservations)
                    <div class="mb-4 border rounded-lg">
                        <h2 @click="openSection = openSection === '{{ $month }}' ? '' : '{{ $month }}'"
                            class="flex items-center justify-between p-4 mb-0 text-2xl font-bold cursor-pointer">
                            <div class="flex items-left">

                                <p>
                                    {{ \Carbon\Carbon::parse($month)->translatedFormat('F Y') }}

                                </p>
                                @if (\Carbon\Carbon::parse($month)->format('Y-m') === $currentMonth)
                                    <span
                                        class="ml-4 px-3 py-1 text-sm font-semibold text-white bg-green-500 rounded-xl">
                                        Mois en cours
                                    </span>
                                @endif
                            </div>
                            <svg :class="{ 'rotate-180': openSection === '{{ $month }}' }"
                                class="w-5 h-5 transition-transform" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M19 9l-7 7-7-7"></path>
                            </svg>
                        </h2>
                        <div x-show="openSection === '{{ $month }}'" class="px-4 pb-4">
                            @if ($reservations->isEmpty())
                                <div class="p-4 overflow-hidden bg-white rounded-lg">
                                    <p>Aucune réservation pour ce mois.</p>
                                </div>
                            @else
                                @foreach ($reservations as $reservation)
                                    <div class="mb-4 p-4 border rounded-lg shadow-sm bg-white">
                                        <div class="flex flex-col md:flex-row">
                                            <!-- Informations sur la réservation -->
                                            <div class="flex-1 mb-4 md:mb-0">
                                                <h3 class="text-xl font-semibold text-gray-700">
                                                    Réservation du {{ $reservation->debut_resa }} au
                                                    {{ $reservation->fin_resa }}
                                                </h3>
                                                <p class="text-gray-600">
                                                    Nombre de nuits : <span
                                                        class="font-semibold">{{ $reservation->nights }}</span>
                                                </p>
                                                <p class="text-gray-600">
                                                    Prix total : <span
                                                        class="font-semibold">{{ $reservation->totalPrice }} €</span>
                                                </p>
                                            </div>

                                            <!-- Informations sur le réservateur -->
                                            <div class="flex-1 border-l pl-4">
                                                <h3 class="text-xl font-semibold text-gray-700">
                                                    Détails du client
                                                </h3>
                                                <p class="text-gray-600">
                                                    Nom : <span
                                                        class="font-semibold">{{ $reservation->user->name }}</span>
                                                </p>
                                                <p class="text-gray-600">
                                                    Email : <span
                                                        class="font-semibold">{{ $reservation->user->email }}</span>
                                                </p>
                                                <p class="text-gray-600">
                                                    Téléphone : <span
                                                        class="font-semibold">{{ $reservation->user->phone ?? 'Non disponible' }}</span>
                                                </p>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            @endif
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
</x-app-layout>
