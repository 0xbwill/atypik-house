<x-app-layout>
    <div class="py-12">
        <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
            <h1 class="text-4xl font-bold text-left">Création d'un logement</h1>
            <p class="mt-2 text-gray-600">Veuillez fournir les informations concernant votre logement.</p>

            <div class="bg-white p-6 rounded-lg">
                @if ($errors->any())
                    <div class="mb-4 p-4 bg-red-100 text-red-800 rounded-lg">
                        <ul class="list-disc list-inside">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form action="{{ route('mes-logements.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf

                    <div class="grid grid-cols-1 gap-6 sm:grid-cols-6">
                        <!-- Champs existants -->
                        <div class="sm:col-span-4">
                            <label for="title" class="block text-sm font-medium text-gray-700">
                                Titre <span class="text-red-500">*</span>
                            </label>
                            <div class="mt-2">
                                <input id="title" name="title" type="text" autocomplete="title"
                                       class="block w-full px-3 py-2 text-gray-700 bg-gray-50 border border-gray-300 rounded-md shadow-sm focus:ring-2 focus:ring-vert focus:border-vert"
                                       value="{{ old('title') }}" required>
                            </div>
                        </div>

                        <div class="col-span-full">
                            <label for="image" class="block text-sm font-medium text-gray-700">
                                Image principale <span class="text-red-500">*</span>
                            </label>
                            <div class="mt-2">
                                <input id="image" name="image" type="file" accept="image/*" required
                                       class="block w-full text-sm text-gray-700 border border-gray-300 rounded-md cursor-pointer bg-gray-50 focus:outline-none focus:ring-2 focus:ring-vert focus:border-vert">
                            </div>
                        </div>

                         <!-- Champ pour les images secondaires -->
                         <div class="col-span-full">
                            <label for="images" class="block text-sm font-medium text-gray-700">
                                Images secondaires
                            </label>
                            <div class="mt-2">
                                <input id="images" name="images[]" type="file" accept="image/*" multiple
                                       class="block w-full text-sm text-gray-700 border border-gray-300 rounded-md cursor-pointer bg-gray-50 focus:outline-none focus:ring-2 focus:ring-vert focus:border-vert">
                            </div>
                            <p class="mt-2 text-sm text-gray-600">Vous pouvez sélectionner plusieurs images pour votre logement.</p>
                        </div>

                        <div class="col-span-full">
                            <label for="short_description" class="block text-sm font-medium text-gray-700">
                                Description courte <span class="text-red-500">*</span>
                            </label>
                            <div class="mt-2">
                                <textarea id="short_description" name="short_description" rows="3"
                                          class="block w-full px-3 py-2 text-gray-700 bg-gray-50 border border-gray-300 rounded-md shadow-sm focus:ring-2 focus:ring-vert focus:border-vert">{{ old('short_description') }}</textarea>
                            </div>
                            <p class="mt-2 text-sm text-gray-600">Écrivez une brève description de votre logement.</p>
                        </div>

                        <div class="col-span-full">
                            <label for="description" class="block text-sm font-medium text-gray-700">
                                Description détaillée <span class="text-red-500">*</span>
                            </label>
                            <div class="mt-2">
                                <textarea id="description" name="description" rows="5"
                                          class="block w-full px-3 py-2 text-gray-700 bg-gray-50 border border-gray-300 rounded-md shadow-sm focus:ring-2 focus:ring-vert focus:border-vert">{{ old('description') }}</textarea>
                            </div>
                        </div>

                        <div class="sm:col-span-3">
                            <label for="price" class="block text-sm font-medium text-gray-700">
                                Prix par nuit <span class="text-red-500">*</span>
                            </label>
                            <div class="mt-2">
                                <input id="price" name="price" type="number" autocomplete="price"
                                       class="block w-full px-3 py-2 text-gray-700 bg-gray-50 border border-gray-300 rounded-md shadow-sm focus:ring-2 focus:ring-vert focus:border-vert"
                                       value="{{ old('price') }}" required>
                            </div>
                        </div>

                        <div class="sm:col-span-3">
                            <label for="capacity" class="block text-sm font-medium text-gray-700">
                                Capacité d'accueil (personnes) <span class="text-red-500">*</span>
                            </label>
                            <div class="mt-2">
                                <input id="capacity" name="capacity" type="number" autocomplete="capacity"
                                       class="block w-full px-3 py-2 text-gray-700 bg-gray-50 border border-gray-300 rounded-md shadow-sm focus:ring-2 focus:ring-vert focus:border-vert"
                                       value="{{ old('capacity') }}" required>
                            </div>
                        </div>

                        <div class="sm:col-span-3">
                            <label for="bedrooms" class="block text-sm font-medium text-gray-700">
                                Nombre de chambres <span class="text-red-500">*</span>
                            </label>
                            <div class="mt-2">
                                <input id="bedrooms" name="bedrooms" type="number" autocomplete="bedrooms"
                                       class="block w-full px-3 py-2 text-gray-700 bg-gray-50 border border-gray-300 rounded-md shadow-sm focus:ring-2 focus:ring-vert focus:border-vert"
                                       value="{{ old('bedrooms') }}" required>
                            </div>
                        </div>

                        <div class="sm:col-span-3">
                            <label for="bathrooms" class="block text-sm font-medium text-gray-700">
                                Nombre de salles de bain <span class="text-red-500">*</span>
                            </label>
                            <div class="mt-2">
                                <input id="bathrooms" name="bathrooms" type="number" autocomplete="bathrooms"
                                       class="block w-full px-3 py-2 text-gray-700 bg-gray-50 border border-gray-300 rounded-md shadow-sm focus:ring-2 focus:ring-vert focus:border-vert"
                                       value="{{ old('bathrooms') }}" required>
                            </div>
                        </div>

                        <div class="col-span-full">
                            <label for="category_id" class="block text-sm font-medium text-gray-700">
                                Catégorie <span class="text-red-500">*</span>
                            </label>
                            <div class="mt-2">
                                <select id="category_id" name="category_id"
                                        class="block w-full px-3 py-2 text-gray-700 bg-gray-50 border border-gray-300 rounded-md shadow-sm focus:ring-2 focus:ring-vert focus:border-vert" required>
                                    <option value="">Sélectionner une catégorie</option>
                                    @foreach ($categories as $category)
                                        <option value="{{ $category->id }}">{{ $category->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <!-- Nouveaux champs -->
                        <div class="sm:col-span-3">
                            <label for="pet_allowed" class="block text-sm font-medium text-gray-700">
                                Animaux autorisés
                            </label>
                            <div class="mt-2">
                                <select id="pet_allowed" name="pet_allowed"
                                        class="block w-full px-3 py-2 text-gray-700 bg-gray-50 border border-gray-300 rounded-md shadow-sm focus:ring-2 focus:ring-vert focus:border-vert">
                                    <option value="">Sélectionner une option</option>
                                    <option value="yes" {{ old('pet_allowed') == 'yes' ? 'selected' : '' }}>Oui</option>
                                    <option value="no" {{ old('pet_allowed') == 'no' ? 'selected' : '' }}>Non</option>
                                </select>
                            </div>
                        </div>

                        <div class="sm:col-span-3">
                            <label for="smoker_allowed" class="block text-sm font-medium text-gray-700">
                                Fumeurs autorisés
                            </label>
                            <div class="mt-2">
                                <select id="smoker_allowed" name="smoker_allowed"
                                        class="block w-full px-3 py-2 text-gray-700 bg-gray-50 border border-gray-300 rounded-md shadow-sm focus:ring-2 focus:ring-vert focus:border-vert">
                                    <option value="">Sélectionner une option</option>
                                    <option value="yes" {{ old('smoker_allowed') == 'yes' ? 'selected' : '' }}>Oui</option>
                                    <option value="no" {{ old('smoker_allowed') == 'no' ? 'selected' : '' }}>Non</option>
                                </select>
                            </div>
                        </div>

                        <div class="sm:col-span-3">
                            <label for="city" class="block text-sm font-medium text-gray-700">
                                Ville
                            </label>
                            <div class="mt-2">
                                <input id="city" name="city" type="text" autocomplete="city"
                                       class="block w-full px-3 py-2 text-gray-700 bg-gray-50 border border-gray-300 rounded-md shadow-sm focus:ring-2 focus:ring-vert focus:border-vert"
                                       value="{{ old('city') }}">
                            </div>
                        </div>

                        <div class="sm:col-span-3">
                            <label for="street" class="block text-sm font-medium text-gray-700">
                                Rue
                            </label>
                            <div class="mt-2">
                                <input id="street" name="street" type="text" autocomplete="street"
                                       class="block w-full px-3 py-2 text-gray-700 bg-gray-50 border border-gray-300 rounded-md shadow-sm focus:ring-2 focus:ring-vert focus:border-vert"
                                       value="{{ old('street') }}">
                            </div>
                        </div>

                        <div class="sm:col-span-3">
                            <label for="country" class="block text-sm font-medium text-gray-700">
                                Pays
                            </label>
                            <div class="mt-2">
                                <input id="country" name="country" type="text" autocomplete="country"
                                       class="block w-full px-3 py-2 text-gray-700 bg-gray-50 border border-gray-300 rounded-md shadow-sm focus:ring-2 focus:ring-vert focus:border-vert"
                                       value="{{ old('country') }}">
                            </div>
                        </div>

                        <div class="sm:col-span-3">
                            <label for="postal_code" class="block text-sm font-medium text-gray-700">
                                Code postal
                            </label>
                            <div class="mt-2">
                                <input id="postal_code" name="postal_code" type="text" autocomplete="postal_code"
                                       class="block w-full px-3 py-2 text-gray-700 bg-gray-50 border border-gray-300 rounded-md shadow-sm focus:ring-2 focus:ring-vert focus:border-vert"
                                       value="{{ old('postal_code') }}">
                            </div>
                        </div>
                    </div>

                    <div class="mt-6 flex items-center gap-x-6">
                        <button type="submit" role="button" aria-label="enregistrer"
                                class="px-4 py-2 bg-vert text-white font-semibold rounded-md shadow hover:bg-vert_hover focus:outline-none focus:ring-2 focus:ring-vert focus:ring-offset-2">Enregistrer</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
