<div class="min-h-screen">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

        <!-- Affichage des demandes d'hôte -->
        @if ($hostRequests->isEmpty())
            <div class="p-4 bg-gray-200 dark:bg-gray-700 text-gray-800 dark:text-gray-300 rounded-lg shadow-md mt-6">
                <p class="text-gray-800 dark:text-white">Aucune demande d'hôte en attente.</p>
            </div>
        @else
            <div class="grid grid-cols-1 gap-6 md:grid-cols-2 lg:grid-cols-3">
                @foreach ($hostRequests as $request)
                    <div
                        class="overflow-hidden bg-white dark:bg-gray-800 rounded-lg shadow-lg dark:shadow-gray-700">
                        <div class="flex p-6">
                            <!-- Image de Profil ou Avatar -->
                            <div class="flex-shrink-0 w-16 h-16 mr-4">
                                <img src="https://www.gravatar.com/avatar/{{ md5(strtolower(trim($request->email))) }}?d=mp"
                                    alt="{{ $request->name }}"
                                    class="object-cover w-full h-full rounded-full border-2 border-gray-300 dark:border-gray-600">
                            </div>
                            <div class="flex-grow ml-4">
                                <!-- Informations de la demande -->
                                <h3 class="text-lg font-semibold text-gray-800 dark:text-white">{{ $request->name }}</h3>
                                <p class="text-sm text-gray-600 dark:text-white">{{ $request->email }}</p>
                                <p class="text-sm text-gray-600 dark:text-gray-400 mt-2">{{ Str::limit($request->message, 100) }}</p>
                                <div class="mt-4 flex space-x-2">
                                    <!-- Boutons d'action -->
                                    <button wire:click="accept({{ $request->id }})"
                                        class="px-4 py-2 text-sm font-medium text-white bg-green-600 rounded-lg hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-green-500 transition duration-200 dark:bg-green-700 dark:hover:bg-green-800 dark:focus:ring-green-400" role="button"
                                        aria-label="enregistrer">
                                        Accepter
                                    </button>
                                    <button wire:click="reject({{ $request->id }})"
                                        class="px-4 py-2 text-sm font-medium text-white bg-red-600 rounded-lg hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-red-500 transition duration-200 dark:bg-red-700 dark:hover:bg-red-800 dark:focus:ring-red-400"
                                        role="button"
                                        aria-label="enregistrer">
                                        Refuser
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        @endif

        <!-- Message de succès -->
        @if (session()->has('success'))
            <div class="mt-6 p-4 bg-green-50 dark:bg-green-900 text-green-800 dark:text-green-100 rounded-lg shadow-md">
                {{ session('success') }}
            </div>
        @endif
    </div>
</div>
