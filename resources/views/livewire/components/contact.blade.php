<div class="px-4 sm:px-6 lg:px-8"> <!-- Ajout de px-4 pour les marges sur mobile -->
    <h1 class="mb-12 text-4xl font-bold text-center">Nous contacter</h1>
    <div class="max-w-3xl mx-auto">
        @if (session()->has('message'))
            <div class="p-4 mb-4 text-sm text-green-700 bg-green-100 rounded-lg" role="alert">
                {{ session('message') }}
            </div>
        @endif

        <form wire:submit.prevent="submit" class="space-y-6">
            <div class="grid grid-cols-1 gap-6 sm:grid-cols-2">
                <div>
                    <label for="nom" class="block text-sm font-medium text-gray-700">Nom</label>
                    <input type="text" id="nom" wire:model="nom"
                        class="block w-full mt-1 border-gray-300 rounded-md shadow-sm"
                        placeholder="Veuillez saisir votre nom">
                    @error('nom')
                        <span class="text-red-500">{{ $message }}</span>
                    @enderror
                </div>
                <div>
                    <label for="prenom" class="block text-sm font-medium text-gray-700">Prénom</label>
                    <input type="text" id="prenom" wire:model="prenom"
                        class="block w-full mt-1 border-gray-300 rounded-md shadow-sm"
                        placeholder="Veuillez saisir votre prénom">
                    @error('prenom')
                        <span class="text-red-500">{{ $message }}</span>
                    @enderror
                </div>
            </div>
            <div>
                <label for="telephone" class="block text-sm font-medium text-gray-700">Numéro de
                    téléphone</label>
                <input type="text" id="telephone" wire:model="telephone"
                    class="block w-full mt-1 border-gray-300 rounded-md shadow-sm"
                    placeholder="Veuillez indiquer votre numéro de téléphone">
                @error('telephone')
                    <span class="text-red-500">{{ $message }}</span>
                @enderror
            </div>
            <div>
                <label for="email" class="block text-sm font-medium text-gray-700">Email</label>
                <input type="email" id="email" wire:model="email"
                    class="block w-full mt-1 border-gray-300 rounded-md shadow-sm"
                    placeholder="Veuillez indiquer votre email">
                @error('email')
                    <span class="text-red-500">{{ $message }}</span>
                @enderror
            </div>
            <div>
                <label for="message" class="block text-sm font-medium text-gray-700">Message</label>
                <textarea id="message" wire:model="message" class="block w-full mt-1 border-gray-300 rounded-md shadow-sm"
                    placeholder="Veuillez indiquer votre message"></textarea>
                @error('message')
                    <span class="text-red-500">{{ $message }}</span>
                @enderror
            </div>
            <div class="text-center">
                <button type="submit" class="px-4 py-2 text-white bg-green-600 rounded-md" role="button"
                aria-label="Envoyer">Envoyer</button>
            </div>
        </form>
    </div>
</div>
