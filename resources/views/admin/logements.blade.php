<x-app-layout>
    <div class="py-12 node-type-admin-listing-logements">
        <div class="max-w-full mx-auto sm:px-6 lg:px-8">
            @if (session('success'))
                <div class="flex items-center justify-between p-4 mb-4 text-white bg-green-500 rounded-lg shadow-md">
                    <div>{{ session('success') }}</div>
                    <button type="button" class="text-2xl leading-none"
                        onclick="this.parentElement.style.display='none'"role="button"
                        aria-label="enregistrer">&times;</button>
                </div>
            @endif
            <div class="flex items-center justify-between mb-8">
                <h1 class="text-4xl font-bold">Liste des logements</h1>
                <a href="{{ route('admin.logement.create') }}" wire:navigate aria-label="ajouter"
                    class="inline-block px-4 py-2 font-normal text-white transition-all bg-blue-500 rounded hover:bg-blue-700">
                    Ajouter un logement
                </a>
            </div>
            <div class="grid grid-cols-1 gap-4 md:grid-cols-3 lg:grid-cols-4">
                @foreach ($logements as $logement)
                    <div class="overflow-hidden bg-white rounded-lg shadow-md">
                        <img class="object-cover object-center w-full h-48"
                            src="{{ asset('storage/logements-default/' . $logement->id . '/' . 'main.jpg') }}"
                            alt="{{ $logement->titre }}">
                        <div class="p-4">
                            <h3 class="text-lg font-semibold">{{ $logement->title }}</h3>
                            <p class="text-sm text-gray-600">{{ $logement->adresse }}</p>
                            <p class="text-sm text-gray-600">{{ $logement->ville }}</p>
                            <p class="text-sm text-gray-600">{{ $logement->type }}</p>
                            <p class="text-sm text-gray-600" id="description">{{ $logement->description }}</p>
                            <div class="mt-4">
                                <a href="{{ route('logement.index', $logement->id) }}" wire:navigate aria-label="voir"
                                    class="px-3 py-2 mr-3 font-medium text-white bg-blue-500 rounded hover:bg-blue-700">
                                    Voir
                                </a>
                                <a href="{{ route('admin.logement.edit', $logement->id) }}" wire:navigate aria-label="modifier"
                                    class="px-3 py-2 mr-3 font-medium text-white bg-green-500 rounded hover:bg-green-700">
                                    Modifier
                                </a>

                                <form action="{{ route('admin.logements.destroy', $logement->id) }}" method="POST"
                                    class="inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit"
                                        class="px-3 py-2 font-medium text-white bg-red-600 rounded hover:bg-red-700"
                                        onclick="return confirm('Are you sure?')"role="button"
                                        aria-label="enregistrer">Supprimer</button>
                                </form>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>

        <style lang="scss">
            .node-type-admin-listing-logements {
                #description {
                    overflow: hidden;
                    text-overflow: ellipsis;
                    display: -webkit-box;
                    -webkit-line-clamp: 2;
                    /* number of lines to show */
                    line-clamp: 2;
                    -webkit-box-orient: vertical;
                }
            }
        </style>
</x-app-layout>
