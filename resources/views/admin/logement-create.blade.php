<x-app-layout>
    <div class="py-12">
        <div class="max-w-full mx-auto sm:px-6 lg:px-8">
            <h1 class="mb-12 text-4xl font-bold text-center">Création d'un logement</h1>

            <div class="px-8 pt-6 pb-8 mb-4 bg-white rounded shadow-md">
                @if ($errors->any())
                    <div class="mb-4">
                        <ul class="text-sm text-red-600 list-disc list-inside">
                            @foreach ($errors->all() as $error)
                                <span>{{ $error }}</span>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form action="{{ route('admin.logement.store.logement') }}" method="POST" enctype="multipart/form-data">
                    @csrf

                    <div class="mb-4">
                        <label class="block mb-2 text-sm font-bold text-gray-700" for="title">Titre</label>
                        <input
                            class="w-full px-3 py-2 leading-tight text-gray-700 border rounded shadow appearance-none focus:outline-none focus:shadow-outline"
                            id="title" type="text" name="title" value="{{ old('title') }}" required>
                    </div>

                    <div class="mb-4">
                        <label class="block mb-2 text-sm font-bold text-gray-700" for="image">Image
                            principale</label>
                        <input type="file" name="image" id="image" accept="image/*" required>
                    </div>

                    <div class="mb-4">
                        <label class="block mb-2 text-sm font-bold text-gray-700" for="short_description">Description
                            courte</label>
                        <textarea
                            class="w-full px-3 py-2 leading-tight text-gray-700 border rounded shadow appearance-none focus:outline-none focus:shadow-outline"
                            id="short_description" name="short_description"
                            required>{{ old('short_description') }}</textarea>
                    </div>

                    <div class="mb-4">
                        <label class="block mb-2 text-sm font-bold text-gray-700" for="description">Description</label>
                        <textarea
                            class="w-full px-3 py-2 leading-tight text-gray-700 border rounded shadow appearance-none focus:outline-none focus:shadow-outline"
                            id="description" name="description" required>{{ old('description') }}</textarea>
                    </div>

                    <div class="grid grid-cols-2 gap-4 mb-4">
                        <div>
                            <label class="block mb-2 text-sm font-bold text-gray-700" for="price">Prix</label>
                            <input
                                class="w-full px-3 py-2 leading-tight text-gray-700 border rounded shadow appearance-none focus:outline-none focus:shadow-outline"
                                id="price" type="number" name="price" value="{{ old('price') }}" required>
                        </div>

                        <div>
                            <label class="block mb-2 text-sm font-bold text-gray-700" for="capacity">Capacité</label>
                            <input
                                class="w-full px-3 py-2 leading-tight text-gray-700 border rounded shadow appearance-none focus:outline-none focus:shadow-outline"
                                id="capacity" type="number" name="capacity" value="{{ old('capacity') }}" required>
                        </div>

                        <div>
                            <label class="block mb-2 text-sm font-bold text-gray-700" for="bedrooms">Chambres</label>
                            <input
                                class="w-full px-3 py-2 leading-tight text-gray-700 border rounded shadow appearance-none focus:outline-none focus:shadow-outline"
                                id="bedrooms" type="number" name="bedrooms" value="{{ old('bedrooms') }}" required>
                        </div>

                        <div>
                            <label class="block mb-2 text-sm font-bold text-gray-700" for="bathrooms">Salles de
                                bain</label>
                            <input
                                class="w-full px-3 py-2 leading-tight text-gray-700 border rounded shadow appearance-none focus:outline-none focus:shadow-outline"
                                id="bathrooms" type="number" name="bathrooms" value="{{ old('bathrooms') }}" required>
                        </div>
                    </div>

                    

                    <div class="flex items-center justify-between">
                        <button
                            class="px-4 py-2 font-bold text-white bg-blue-500 rounded hover:bg-blue-700 focus:outline-none focus:shadow-outline"
                            type="submit"
                            role="button"
                            aria-label="enregistrer"
                            >
                            Enregistrer
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>