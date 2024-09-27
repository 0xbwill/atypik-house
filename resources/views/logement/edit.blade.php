<x-app-layout>
    <div class="py-12">
        <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
            {{-- Session alert --}}
            @if ($errors->any())
                <div class="mb-4 p-4 bg-red-100 text-red-800 rounded-lg">
                    <ul class="list-disc list-inside">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <div class="bg-white p-6 rounded-lg space-y-12">
                <div class="border-b border-gray-300 pb-12">
                    <h1 class="text-3xl font-bold">Modifier Logement: {{ $logement->title }}</h1>
                    <p class="mt-2 text-gray-600">Mettre à jour les informations de votre logement.</p>

                    <form action="{{ route('mes-logements.update', $logement->id) }}" method="POST"
                        enctype="multipart/form-data" class="mt-6">
                        @csrf
                        @method('PUT')

                        <div class="grid grid-cols-1 gap-6 sm:grid-cols-6">
                            <!-- Champ Titre -->
                            <div class="sm:col-span-4">
                                <label for="title" class="block text-sm font-medium text-gray-700">Titre</label>
                                <div class="mt-2">
                                    <input id="title" name="title" type="text" autocomplete="title"
                                        class="block w-full px-3 py-2 text-gray-700 bg-gray-50 border border-gray-300 rounded-md shadow-sm focus:ring-2 focus:ring-vert focus:border-vert"
                                        value="{{ old('title', $logement->title) }}" required>
                                </div>
                            </div>

                            <!-- Champ Image -->
                            <div class="col-span-full">
                                <label for="image" class="block text-sm font-medium text-gray-700">Image
                                    principale</label>
                                <div class="mt-2">
                                    <img class="left-0 mb-4 w-80 h-auto" id="image_preview"
                                        src="{{ $logement->image_url ? asset('storage/' . $logement->image_url) : 'https://placehold.co/1200x800' }}">
                                    <input id="image" name="image" type="file" accept="image/*"
                                        onchange="previewImage(event)"
                                        class="block w-full p-4 text-sm text-gray-700 border border-gray-300 rounded-md cursor-pointer bg-gray-50 focus:outline-none focus:ring-2 focus:ring-vert focus:border-vert">
                                </div>
                            </div>

                            <div class="col-span-full">
                                <label for="image" class="block text-sm font-medium text-gray-700">Image
                                    secondaires</label>
                                <input type="file" name="images[]" id="images" multiple
                                    class="mt-4 block w-full p-2 border border-gray-300 rounded-md">
                                @error('images')
                                    <span class="text-red-500">{{ $message }}</span>
                                @enderror

                            </div>

                            <!-- Champ Description courte -->
                            <div class="col-span-full">
                                <label for="short_description"
                                    class="block text-sm font-medium text-gray-700">Description courte</label>
                                <div class="mt-2">
                                    <textarea id="short_description" name="short_description" rows="3"
                                        class="block w-full px-3 py-2 text-gray-700 bg-gray-50 border border-gray-300 rounded-md shadow-sm focus:ring-2 focus:ring-vert focus:border-vert">{{ old('short_description', $logement->short_description) }}</textarea>
                                </div>
                                <p class="mt-2 text-sm text-gray-600">Écrivez une brève description de votre logement.
                                </p>
                            </div>

                            <!-- Champ Description -->
                            <div class="col-span-full">
                                <label for="description"
                                    class="block text-sm font-medium text-gray-700">Description</label>
                                <div class="mt-2">
                                    <textarea id="description" name="description" rows="5"
                                        class="block w-full px-3 py-2 text-gray-700 bg-gray-50 border border-gray-300 rounded-md shadow-sm focus:ring-2 focus:ring-vert focus:border-vert">{{ old('description', $logement->description) }}</textarea>
                                </div>
                            </div>

                            <!-- Champ Prix -->
                            <div class="sm:col-span-3">
                                <label for="price" class="block text-sm font-medium text-gray-700">Prix</label>
                                <div class="mt-2">
                                    <input id="price" name="price" type="number" autocomplete="price"
                                        class="block w-full px-3 py-2 text-gray-700 bg-gray-50 border border-gray-300 rounded-md shadow-sm focus:ring-2 focus:ring-vert focus:border-vert"
                                        value="{{ old('price', $logement->price) }}">
                                </div>
                            </div>

                            <!-- Champ Capacité -->
                            <div class="sm:col-span-3">
                                <label for="capacity" class="block text-sm font-medium text-gray-700">Capacité</label>
                                <div class="mt-2">
                                    <input id="capacity" name="capacity" type="number" autocomplete="capacity"
                                        class="block w-full px-3 py-2 text-gray-700 bg-gray-50 border border-gray-300 rounded-md shadow-sm focus:ring-2 focus:ring-vert focus:border-vert"
                                        value="{{ old('capacity', $logement->capacity) }}">
                                </div>
                            </div>

                            <!-- Champ Chambres -->
                            <div class="sm:col-span-3">
                                <label for="bedrooms" class="block text-sm font-medium text-gray-700">Chambres</label>
                                <div class="mt-2">
                                    <input id="bedrooms" name="bedrooms" type="number" autocomplete="bedrooms"
                                        class="block w-full px-3 py-2 text-gray-700 bg-gray-50 border border-gray-300 rounded-md shadow-sm focus:ring-2 focus:ring-vert focus:border-vert"
                                        value="{{ old('bedrooms', $logement->bedrooms) }}">
                                </div>
                            </div>

                            <!-- Champ Salles de bain -->
                            <div class="sm:col-span-3">
                                <label for="bathrooms" class="block text-sm font-medium text-gray-700">Salles de
                                    bain</label>
                                <div class="mt-2">
                                    <input id="bathrooms" name="bathrooms" type="number" autocomplete="bathrooms"
                                        class="block w-full px-3 py-2 text-gray-700 bg-gray-50 border border-gray-300 rounded-md shadow-sm focus:ring-2 focus:ring-vert focus:border-vert"
                                        value="{{ old('bathrooms', $logement->bathrooms) }}">
                                </div>
                            </div>

                            <!-- Champ Publié -->
                            <div class="sm:col-span-3">
                                <label for="published" class="block text-sm font-medium text-gray-700">Publié</label>
                                <div class="mt-2">
                                    <input id="published" name="published" type="checkbox"
                                        class="block w-6 h-6 text-vert border-gray-300 rounded shadow-sm focus:ring-2 focus:ring-vert focus:border-vert"
                                        {{ old('published', $logement->published) ? 'checked' : '' }}>
                                </div>
                            </div>

                            <!-- Champ Catégorie -->
                            {{-- <div class="col-span-full">
                                <label for="category_id"
                                    class="block text-sm font-medium text-gray-700">Catégorie</label>
                                <div class="mt-2">
                                    <select id="category_id" name="category_id"
                                        class="block w-full px-3 py-2 text-gray-700 bg-gray-50 border border-gray-300 rounded-md shadow-sm focus:ring-2 focus:ring-vert focus:border-vert"
                                        required>
                                        <option value="">Sélectionner une catégorie</option>
                                        @foreach ($categories as $category)
                                            <option value="{{ $category->id }}"
                                                {{ $logement->category_id == $category->id ? 'selected' : '' }}>
                                                {{ $category->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div> --}}

                            <!-- Champ Équipements -->
                            <div class="col-span-full">
                                <label for="equipements"
                                    class="block text-sm font-medium text-gray-700">Équipements</label>
                                <div class="mt-2">
                                    <select id="equipements" name="equipements[]" multiple class="w-full">
                                        @foreach ($availableEquipements as $equipement)
                                            <option value="{{ $equipement->id }}"
                                                {{ $logement->equipements->contains($equipement->id) ? 'selected' : '' }}>
                                                {{ $equipement->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <!-- Champs Adresse -->
                            <div class="sm:col-span-3">
                                <label for="city" class="block text-sm font-medium text-gray-700">Ville</label>
                                <div class="mt-2">
                                    <input id="city" name="city" type="text" autocomplete="city"
                                        class="block w-full px-3 py-2 text-gray-700 bg-gray-50 border border-gray-300 rounded-md shadow-sm focus:ring-2 focus:ring-vert focus:border-vert"
                                        value="{{ old('city', $logement->city) }}">
                                </div>
                            </div>

                            <div class="sm:col-span-3">
                                <label for="street" class="block text-sm font-medium text-gray-700">Rue</label>
                                <div class="mt-2">
                                    <input id="street" name="street" type="text" autocomplete="street"
                                        class="block w-full px-3 py-2 text-gray-700 bg-gray-50 border border-gray-300 rounded-md shadow-sm focus:ring-2 focus:ring-vert focus:border-vert"
                                        value="{{ old('street', $logement->street) }}">
                                </div>
                            </div>

                            <div class="sm:col-span-3">
                                <label for="country" class="block text-sm font-medium text-gray-700">Pays</label>
                                <div class="mt-2">
                                    <input id="country" name="country" type="text" autocomplete="country"
                                        class="block w-full px-3 py-2 text-gray-700 bg-gray-50 border border-gray-300 rounded-md shadow-sm focus:ring-2 focus:ring-vert focus:border-vert"
                                        value="{{ old('country', $logement->country) }}">
                                </div>
                            </div>



                            <div class="sm:col-span-3">
                                <label for="postal_code" class="block text-sm font-medium text-gray-700">Code
                                    postal</label>
                                <div class="mt-2">
                                    <input id="postal_code" name="postal_code" type="text"
                                        autocomplete="postal_code"
                                        class="block w-full px-3 py-2 text-gray-700 bg-gray-50 border border-gray-300 rounded-md shadow-sm focus:ring-2 focus:ring-vert focus:border-vert"
                                        value="{{ old('postal_code', $logement->postal_code) }}">
                                </div>
                            </div>
                        </div>

                        <div class="mt-6 flex items-center gap-x-6">
                            <button type="submit" role="button" aria-label="filtre"
                                class="px-4 py-2 bg-vert text-white font-semibold rounded-md shadow hover:bg-vert_hover focus:outline-none focus:ring-2 focus:ring-vert focus:ring-offset-2">Enregistrer</button>
                        </div>
                    </form>

                    <div class="col-span-full mt-12">
                        <label for="images" class="block text-md font-medium text-gray-700 mb-2">Gestion des images
                            secondaires</label>
                        <div class="grid grid-cols-1 gap-4 sm:grid-cols-2 lg:grid-cols-3">
                            @foreach ($logement->images as $image)
                                <div class="relative rounded-lg overflow-hidden shadow-md bg-white">
                                    <img src="{{ asset('storage/' . $image->url) }}" alt="Image secondaire"
                                        class="w-full h-48 object-cover">
                                    <form action="{{ route('logement.image.delete', $image->id) }}" method="POST"
                                        class="absolute inset-0 flex justify-end items-start p-2">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" role="button" aria-label="delete"
                                            class="text-red-600 hover:text-red-800 bg-white bg-opacity-70 rounded-full p-1 transition ease-in-out duration-150">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6" fill="none"
                                                viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M6 18L18 6M6 6l12 12" />
                                            </svg>
                                        </button>
                                    </form>
                                </div>
                            @endforeach
                        </div>
                    </div>

                </div>

            </div>
        </div>
    </div>

    <div class="mx-auto mt-12 max-w-7xl sm:px-6 lg:px-8">
        <h1 class="mb-12 text-4xl font-bold text-center">Gestion des créneaux</h1>
        @livewire('manage-dates', ['logement' => $logement])
    </div>
    </div>
</x-app-layout>

<script type="text/javascript">
    function previewImage(event) {
        var reader = new FileReader();
        reader.onload = function() {
            var output = document.getElementById('image_preview');
            output.src = reader.result;
        };
        reader.readAsDataURL(event.target.files[0]);
    }
</script>
