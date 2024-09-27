<div>
    <div class="mx-auto mt-8 max-w-6xl">
        @if (session()->has('message'))
            <div class="p-4 my-4 text-white bg-green-500 rounded shadow">
                {{ session('message') }}
            </div>
        @endif

        <!-- Formulaire pour ajouter un équipement à une catégorie -->
        <div class="p-4 mb-6 rounded-lg border border-gray-200 dark:border-gray-700">
            <form wire:submit.prevent="addEquipementToCategory" class="space-y-4">
                <div>
                    <label for="selectedEquipementId" class="block text-sm font-medium text-gray-700 dark:text-white ">Équipement</label>
                    <select wire:model="selectedEquipementId" id="selectedEquipementId"
                        class="block mt-2 w-full rounded-md border-gray-300 dark:border-gray-700 shadow-sm dark:text-white dark:bg-gray-800">
                        <option value="">Sélectionner un équipement</option>
                        @foreach ($allEquipements as $equipement)
                            <option value="{{ $equipement->id }}">{{ $equipement->name }}</option>
                        @endforeach
                    </select>
                    @error('selectedEquipementId')
                        <span class="text-red-500">{{ $message }}</span>
                    @enderror
                </div>
                <div>
                    <label for="categoryToAddEquipement" class="block text-sm font-medium dark:text-white text-gray-700">Catégorie</label>
                    <select wire:model="categoryToAddEquipement" id="categoryToAddEquipement"
                        class="block mt-1 w-full rounded-md border-gray-300 dark:border-gray-700 shadow-sm dark:bg-gray-800">
                        <option value="">Sélectionner une catégorie</option>
                        @foreach ($categories as $category)
                            <option value="{{ $category->id }}">{{ $category->name }}</option>
                        @endforeach
                    </select>
                    @error('categoryToAddEquipement')
                        <span class="text-red-500">{{ $message }}</span>
                    @enderror
                </div>
                <div>
                    <button type="submit" class="bg-blue-500 px-4 py-2 text-white rounded" role="button" aria-label="Ajouter">Ajouter</button>
                </div>
            </form>
        </div>

        <!-- Formulaire de modification d'un équipement -->
        @if ($selectedEquipementId)
            <div class="p-4 mb-6 rounded-lg border border-gray-200 dark:border-gray-700">
                <form wire:submit.prevent="updateEquipement" class="space-y-4">
                    <div>
                        <label for="equipementName" class="block text-sm font-medium text-gray-700 dark:text-white">Nom de l'équipement</label>
                        <input type="text" id="equipementName" wire:model="equipementName"
                               class="block mt-2 w-full rounded-md border-gray-300 dark:border-gray-700 shadow-sm dark:bg-gray-800">
                        @error('equipementName')
                        <span class="text-red-500">{{ $message }}</span>
                        @enderror
                    </div>
                    <div>
                        <label for="categoryToEdit" class="block text-sm font-medium text-gray-700 dark:text-white">Catégorie</label>
                        <select wire:model="categoryToEdit" id="categoryToEdit"
                                class="block mt-1 w-full rounded-md border-gray-300 dark:border-gray-700 shadow-sm dark:bg-gray-800">
                            <option value="">Sélectionner une catégorie</option>
                            @foreach ($categories as $category)
                                <option value="{{ $category->id }}">{{ $category->name }}</option>
                            @endforeach
                        </select>
                        @error('categoryToEdit')
                        <span class="text-red-500">{{ $message }}</span>
                        @enderror
                    </div>
                    <div>
                        <button type="submit" class="bg-green-500 px-4 py-2 text-white rounded" role="button" aria-label="Mettre à jour">Mettre à jour</button>
                    </div>
                </form>
            </div>
        @endif

        <!-- Affichage des catégories et équipements -->
        @foreach ($categories as $category)
            <div class="rounded-lg border border-gray-200 dark:border-gray-700" style="margin-top: 1.25rem">
                <div class="flex justify-between items-center p-4 bg-gray-100 dark:bg-gray-800 rounded-lg">
                    <h2 class="text-2xl">{{ $category->name }}</h2>
                    <button class="text-blue-500" wire:click="$toggle('showEquipements.{{ $category->id }}')" role="button" aria-label="Voir les équipements">
                        Voir les équipements
                    </button>
                </div>
                @if ($showEquipements[$category->id] ?? false)
                    <div>
                        @if ($category->equipements->isEmpty())
                            <p class="p-4">Aucun équipement disponible pour cette catégorie.</p>
                        @else
                            <table class="w-full border-collapse">
                                <thead>
                                    <tr class="bg-gray-200 dark:bg-gray-700">
                                        <th class="p-2 border-gray-700">Nom</th>
                                        <th class="p-2 border-gray-700">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($category->equipements as $equipement)
                                        <tr>
                                            <td class="p-2 border border-gray-200 dark:border-gray-700 dark:bg-gray-800">
                                                {{ $equipement->name }}
                                            </td>
                                            <td class="p-2 border border-gray-200 dark:border-gray-700 dark:bg-gray-800">
                                                <button wire:click="editEquipement({{ $equipement->id }})" class="text-blue-500"
                                                    style="background: rgb(59, 130, 246); padding: 6px 1rem; border-radius: 12px; color: white;"
                                                    role="button" aria-label="Modifier">Modifier</button>

                                                <button wire:click="deleteEquipementFromCategory({{ $category->id }}, {{ $equipement->id }})"
                                                    class="text-red-500"
                                                    style="background: rgb(231, 31, 31); padding: 6px 1rem; border-radius: 12px; color: white;"
                                                    role="button" aria-label="Supprimer">Supprimer</button>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        @endif
                    </div>
                @endif
            </div>
        @endforeach
    </div>
</div>
