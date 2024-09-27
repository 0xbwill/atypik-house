<x-app-layout>
    <div class="py-12">
        <div class="max-w-full mx-auto sm:px-6 lg:px-8">
            <h1 class="mb-12 text-4xl font-bold text-center">Modification du logement</h1>
            {{-- session alert --}}
            @if ($errors->any())
                <div class="mb-4">
                    <ul class="text-sm text-red-600 list-disc list-inside">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <div class="px-8 pt-6 pb-8 mb-4 bg-white rounded shadow-md">
                <form action="{{ route('admin.logement.update', $logement->id) }}" method="POST"
                    enctype="multipart/form-data">
                    @csrf
                    @method('PUT')

                    <div class="mb-4">
                        <label class="block mb-2 text-sm font-bold text-gray-700" for="title">Titre</label>
                        <input
                            class="w-full px-3 py-2 leading-tight text-gray-700 border rounded shadow appearance-none focus:outline-none focus:shadow-outline"
                            id="title" type="text" name="title" value="{{ old('title', $logement->title) }}"
                            required>
                    </div>

                    <div class="mb-4">
                        <label class="block mb-2 text-sm font-bold text-gray-700" for="image">Image
                            principale</label>
                        <img id="image_preview"
                            src="{{ asset('storage/logements-default/' . $logement->id . '/main.jpg') }}"
                            alt="Aperçu de l'image principale" class="w-48 h-48 mb-4">
                        <input type="file" name="image" id="image" accept="image/*"
                            onchange="previewImage(event)">
                    </div>

                    <div class="mb-4">
                        <label class="block mb-2 text-sm font-bold text-gray-700" for="short_description">Description
                            courte</label>
                        <textarea
                            class="w-full px-3 py-2 leading-tight text-gray-700 border rounded shadow appearance-none focus:outline-none focus:shadow-outline"
                            id="short_description" name="short_description">{{ old('short_description', $logement->short_description) }}</textarea>
                    </div>

                    <div class="mb-4">
                        <label class="block mb-2 text-sm font-bold text-gray-700" for="description">Description</label>
                        <textarea
                            class="w-full px-3 py-2 leading-tight text-gray-700 border rounded shadow appearance-none focus:outline-none focus:shadow-outline"
                            id="description" name="description">{{ old('description', $logement->description) }}</textarea>
                    </div>

                    <div class="grid grid-cols-2 gap-4 mb-4">
                        <div>
                            <label class="block mb-2 text-sm font-bold text-gray-700" for="price">Prix</label>
                            <input
                                class="w-full px-3 py-2 leading-tight text-gray-700 border rounded shadow appearance-none focus:outline-none focus:shadow-outline"
                                id="price" type="number" name="price"
                                value="{{ old('price', $logement->price) }}">
                        </div>

                        <div>
                            <label class="block mb-2 text-sm font-bold text-gray-700" for="capacity">Capacité</label>
                            <input
                                class="w-full px-3 py-2 leading-tight text-gray-700 border rounded shadow appearance-none focus:outline-none focus:shadow-outline"
                                id="capacity" type="number" name="capacity"
                                value="{{ old('capacity', $logement->capacity) }}">
                        </div>

                        <div>
                            <label class="block mb-2 text-sm font-bold text-gray-700" for="bedrooms">Chambres</label>
                            <input
                                class="w-full px-3 py-2 leading-tight text-gray-700 border rounded shadow appearance-none focus:outline-none focus:shadow-outline"
                                id="bedrooms" type="number" name="bedrooms"
                                value="{{ old('bedrooms', $logement->bedrooms) }}">
                        </div>

                        <div>
                            <label class="block mb-2 text-sm font-bold text-gray-700" for="bathrooms">Salles de
                                bain</label>
                            <input
                                class="w-full px-3 py-2 leading-tight text-gray-700 border rounded shadow appearance-none focus:outline-none focus:shadow-outline"
                                id="bathrooms" type="number" name="bathrooms"
                                value="{{ old('bathrooms', $logement->bathrooms) }}">
                        </div>
                        <div>
                            {{-- pet allowed --}}
                            <label class="block mb-2 text-sm font-bold text-gray-700" for="pet_allowed">Animaux
                                autorisés</label>
                            <select
                                class="w-full px-3 py-2 leading-tight text-gray-700 border rounded shadow appearance-none focus:outline-none focus:shadow-outline"
                                id="pet_allowed" name="pet_allowed">
                                <option value="1"
                                    {{ old('pet_allowed', $logement->pet_allowed) == 1 ? 'selected' : '' }}>
                                    Oui</option>
                                <option value="0"
                                    {{ old('pet_allowed', $logement->pet_allowed) == 0 ? 'selected' : '' }}>
                                    Non</option>
                            </select>
                        </div>
                        {{-- smoker allowed --}}
                        <div>
                            <label class="block mb-2 text-sm font-bold text-gray-700" for="smoker_allowed">Fumeurs
                                autorisés</label>
                            <select
                                class="w-full px-3 py-2 leading-tight text-gray-700 border rounded shadow appearance-none focus:outline-none focus:shadow-outline"
                                id="smoker_allowed" name="smoker_allowed">
                                <option value="1"
                                    {{ old('smoker_allowed', $logement->smoker_allowed) == 1 ? 'selected' : '' }}>
                                    Oui</option>
                                <option value="0"
                                    {{ old('smoker_allowed', $logement->smoker_allowed) == 0 ? 'selected' : '' }}>
                                    Non</option>
                            </select>
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
        <div class="max-w-full mx-auto mt-12 sm:px-6 lg:px-8">
            <h1 class="mb-12 text-4xl font-bold text-center">Gestion des créneaux</h1>

            @livewire('manage-dates', ['logement' => $logement])
        </div>
    </div>
</x-app-layout>

<script>
    function previewImage(event) {
        var reader = new FileReader();
        reader.onload = function() {
            var output = document.getElementById('image_preview');
            output.src = reader.result;
        };
        reader.readAsDataURL(event.target.files[0]);
    }
</script>
