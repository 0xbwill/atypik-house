<x-app-layout>
    <div class="py-12">
        <div class="max-w-full mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex flex-col sm:flex-row justify-between mb-8">
                <h1 class="text-4xl font-bold text-center mb-4 sm:mb-0">Mes logements</h1>
                <a href="{{ route('mes-logements.create') }}"
                    class="px-3 py-2 font-medium text-white bg-green-500 rounded h-fit hover:bg-green-700 text-center sm:text-left">
                    Ajouter un nouveau logement
                </a>
            </div>

            <!-- Section des logements publiés -->
            <div class="mb-8">
                <h2 class="text-2xl font-bold mb-4">Logements publiés</h2>
                @forelse ($logementsPubliés as $logement)
                    <div class="mb-4 overflow-hidden bg-white rounded-lg shadow-md">
                        <div class="flex flex-col sm:flex-row p-4">
                            @if ($logement->image_url)
                                <div class="flex-shrink-0 w-full sm:w-32 h-32 mb-4 sm:mb-0">
                                    <img class="w-full h-32 object-cover rounded-lg"
                                        src="{{ $logement->public_url ? $logement->image_url : ($logement->image_url ? asset('storage/' . $logement->image_url) : 'https://placehold.co/600x600') }}"
                                        alt="{{ $logement->title }}" class="object-cover rounded-lg aspect-square">
                                </div>
                            @else
                                <div class="flex-shrink-0 w-full sm:w-32 h-32 mb-4 sm:mb-0">
                                    <img class="object-cover w-full h-full rounded-lg" src="https://placehold.co/600x600"
                                        alt="Image par défaut">
                                </div>
                            @endif
                            <div class="flex-grow sm:ml-4">
                                <h3 class="text-lg font-semibold">{{ $logement->title }}</h3>
                                <p class="text-sm text-gray-600">{{ $logement->short_description }}</p>
                                <p class="text-sm text-gray-600">{{ $logement->price }} €</p>
                                <div class="mt-4 flex flex-col sm:flex-row sm:items-center justify-between">
                                    <div class="flex flex-col sm:flex-row">
                                        <a href="{{ route('logement.index', $logement->slug) }}" wire:navigate
                                            class="px-3 py-2 mb-2 sm:mb-0 sm:mr-3 font-medium text-white bg-green-500 rounded hover:bg-green-700 text-center sm:text-left">
                                            Voir le logement
                                        </a>
                                        <a href="{{ route('mes-logements.edit', $logement->id) }}"
                                            class="px-3 py-2 mb-2 sm:mb-0 sm:mr-3 font-medium text-white bg-blue-500 rounded hover:bg-blue-700 text-center sm:text-left">
                                            Modifier
                                        </a>
                                        <a href="{{ route('listing-reservations.index', $logement->id) }}" wire:navigate
                                            class="px-3 py-2 mb-2 sm:mb-0 sm:mr-3 font-medium text-white bg-yellow-500 rounded hover:bg-yellow-700 text-center sm:text-left">
                                            Voir les réservations
                                        </a>
                                    </div>
                                    <div class="flex flex-col sm:flex-row">
                                        <button onclick="confirmDeletion({{ $logement->id }})" role="button" aria-label="delete"
                                            class="px-3 py-2 font-medium text-white bg-red-500 rounded hover:bg-red-700 text-center sm:text-left">
                                            Supprimer
                                        </button>
                                    </div>
                                </div>

                                <!-- Formulaire de suppression -->
                                <form id="delete-logement-form-{{ $logement->id }}"
                                    action="{{ route('mes-logements.destroy', $logement->id) }}" method="POST"
                                    style="display: none;">
                                    @csrf
                                    @method('DELETE')
                                </form>
                            </div>
                        </div>
                    </div>

                @empty
                    <p>Aucun logement publié.</p>
                @endforelse
            </div>

            <!-- Section des logements non publiés -->
            <div>
                <h2 class="text-2xl font-bold mb-4">Logements non publiés</h2>
                @forelse ($logementsNonPubliés as $logement)
                    <div class="mb-4 overflow-hidden bg-white rounded-lg shadow-md">
                        <div class="flex flex-col sm:flex-row p-4">
                            @if ($logement->image_url)
                                <div class="flex-shrink-0 w-full sm:w-32 h-32 mb-4 sm:mb-0">
                                    <img class="sm:w-full h-32 object-cover rounded-lg"
                                        src="{{ $logement->public_url ? $logement->image_url : ($logement->image_url ? asset('storage/' . $logement->image_url) : 'https://placehold.co/600x600') }}"
                                        alt="{{ $logement->title }}" class="object-cover rounded-lg aspect-square">
                                </div>
                            @else
                                <div class="flex-shrink-0 w-full sm:w-32 h-32 mb-4 sm:mb-0">
                                    <img class="object-cover w-full h-full rounded-lg" src="https://placehold.co/600x600"
                                        alt="Image par défaut">
                                </div>
                            @endif
                            <div class="flex-grow sm:ml-4">
                                <h3 class="text-lg font-semibold">{{ $logement->title }}</h3>
                                <p class="text-sm text-gray-600">{{ $logement->short_description }}</p>
                                <p class="text-sm text-gray-600">{{ $logement->price }} €</p>
                                <div class="mt-4 flex flex-col sm:flex-row sm:items-center justify-between">
                                    <div class="flex flex-col sm:flex-row">
                                        <a href="{{ route('logement.index', $logement->slug) }}" wire:navigate
                                            class="px-3 py-2 mb-2 sm:mb-0 sm:mr-3 font-medium text-white bg-green-500 rounded hover:bg-green-700 text-center sm:text-left">
                                            Voir le logement
                                        </a>
                                        <a href="{{ route('mes-logements.edit', $logement->id) }}"
                                            class="px-3 py-2 mb-2 sm:mb-0 sm:mr-3 font-medium text-white bg-blue-500 rounded hover:bg-blue-700 text-center sm:text-left">
                                            Modifier
                                        </a>
                                        <a href="{{ route('listing-reservations.index', $logement->id) }}" wire:navigate
                                            class="px-3 py-2 mb-2 sm:mb-0 sm:mr-3 font-medium text-white bg-yellow-500 rounded hover:bg-yellow-700 text-center sm:text-left">
                                            Voir les réservations
                                        </a>
                                    </div>
                                    <div class="flex flex-col sm:flex-row">
                                        <button onclick="confirmDeletion({{ $logement->id }})" role="button" aria-label="delete"
                                            class="px-3 py-2 font-medium text-white bg-red-500 rounded hover:bg-red-700 text-center sm:text-left">
                                            Supprimer
                                        </button>
                                    </div>
                                </div>

                                <!-- Formulaire de suppression -->
                                <form id="delete-logement-form-{{ $logement->id }}"
                                    action="{{ route('mes-logements.destroy', $logement->id) }}" method="POST"
                                    style="display: none;">
                                    @csrf
                                    @method('DELETE')
                                </form>
                            </div>
                        </div>
                    </div>
                @empty
                    <p>Aucun logement non publié.</p>
                @endforelse
            </div>

        </div>
    </div>
</x-app-layout>

<script>
    function confirmDeletion(logementId) {
        if (confirm('Êtes-vous sûr de vouloir supprimer ce logement ? Cette action est irréversible.')) {
            document.getElementById('delete-logement-form-' + logementId).submit();
        }
    }
</script>
