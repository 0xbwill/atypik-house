<x-app-layout>
    <div class="py-12">
        <div class="max-w-full mx-auto sm:px-6 lg:px-8">
            <div class="flex items-start justify-between">
                <h1 class="mb-12 text-4xl font-bold text-center">Gestion des hôtes</h1>
                <a href="{{ route('admin.host-requests.index') }}" aria-label="demandes"
                    class="px-3 py-2 mr-2 text-base font-medium text-white bg-blue-500 rounded hover:bg-blue-700">
                    Voir les demandes</a>
            </div>

            <div class="grid grid-cols-1 gap-4 md:grid-cols-2 lg:grid-cols-3">
                @foreach ($users as $user)
                    <div class="overflow-hidden bg-white rounded-lg shadow-md">
                        <div class="flex p-2">
                            @if ($user->profile_photo_path)
                                <div class="flex-shrink-0 w-24 h-24">
                                    <img class="object-cover w-full h-full rounded-lg"
                                        src="{{ asset('storage/' . $user->profile_photo_path) }}"
                                        alt="{{ $user->name }}">
                                </div>
                            @endif
                            <div class="flex-grow p-2">
                                <h3 class="text-base font-semibold">{{ $user->name }}</h3>
                                <p class="text-xs text-gray-600">{{ $user->email }}</p>
                                <p class="text-xs text-gray-600">{{ $user->role }}</p>
                                <div class="mt-2">
                                    <a href="{{ route('admin.users.edit', $user->id) }}" aria-label="modifier"
                                        class="px-2 py-1 mr-2 text-sm font-medium text-white bg-blue-500 rounded hover:bg-blue-700">
                                        Modifier
                                    </a>
                                    <button onclick="toggleLogements({{ $user->id }})"
                                        class="px-2 py-1 text-sm font-medium text-white bg-green-500 rounded hover:bg-green-700" role="button" aria-label="voir logements">
                                        Voir les logements
                                    </button>
                                </div>
                            </div>
                        </div>
                        <div id="logements-{{ $user->id }}" class="hidden p-2 bg-gray-100">
                            @if ($user->logements->isEmpty())
                                <p class="text-gray-500">Aucun logement pour cet hôte.</p>
                            @else
                                @foreach ($user->logements as $logement)
                                    <div class="mb-2">
                                        <strong class="text-sm">{{ $logement->title }}</strong>
                                        <span class="block text-xs">{{ $logement->short_description }}</span>
                                        <span class="block text-xs">Prix : {{ $logement->price }} €</span>
                                        <span class="block text-xs">Capacité : {{ $logement->capacity }}</span>
                                        <a class="px-2 py-1 mt-1 text-xs text-white bg-blue-500 rounded hover:bg-blue-700"
                                            href="{{ route('logement.index', $logement->id) }}">Voir le
                                            logement</a>
                                    </div>
                                @endforeach
                            @endif
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
    <script>
        function toggleLogements(userId) {
            var element = document.getElementById('logements-' + userId);
            element.classList.toggle('hidden');
        }
    </script>
</x-app-layout>
