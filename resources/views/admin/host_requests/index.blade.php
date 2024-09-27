<x-app-layout>
    <div class="py-12">
        <div class="max-w-full mx-auto sm:px-6 lg:px-8">
            <h1 class="mb-12 text-4xl font-bold text-center">Gestion des demandes d'hôte</h1>
            <div class="grid grid-cols-1 gap-4 md:grid-cols-2 lg:grid-cols-3">
                @foreach ($hostRequests as $request)
                    <div class="overflow-hidden bg-white rounded-lg shadow-md">
                        <div class="flex p-4">
                            <div class="flex-grow">
                                <h3 class="text-base font-semibold">{{ $request->name }}</h3>
                                <p class="text-xs text-gray-600">{{ $request->email }}</p>
                                <p class="text-xs text-gray-600">{{ $request->message }}</p>
                                <div class="mt-2">
                                    <form action="{{ route('admin.host-requests.accept', $request->id) }}" method="POST" class="inline-block">
                                        @csrf
                                        <button type="submit"
                                            class="px-2 py-1 text-sm font-medium text-white bg-green-500 rounded hover:bg-green-700" role="button"
                                            aria-label="enregistrer">
                                            Accepter
                                        </button>
                                    </form>
                                    <form action="{{ route('admin.host-requests.reject', $request->id) }}" method="POST" class="inline-block">
                                        @csrf
                                        <button type="submit"
                                            class="px-2 py-1 text-sm font-medium text-white bg-red-500 rounded hover:bg-red-700" role="button"
                                            aria-label="enregistrer">
                                            Refuser
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
</x-app-layout>
