<!-- resources/views/livewire/become-host.blade.php -->
<div class="px-4">
    <h1 class="mb-4 text-4xl font-bold text-center">Devenir Hôte</h1>
    <p class="text-center mb-4 mx-auto max-w-4xl">Vous souhaitez devenir hôte sur notre plateforme ? Remplissez simplement le
        formulaire ci-dessous. Nos
        administrateurs examineront attentivement votre dossier pour s'assurer que vous respectez tous les critères
        nécessaires pour rejoindre notre communauté d'hôtes. Nous vous contacterons une fois la vérification
        terminée
        pour vous informer de la décision.</p>
    <p class="mb-12 text-center">Merci de votre intérêt et de votre patience pendant ce processus.</p>
    
    <div class="max-w-3xl mx-auto">
        @if (session()->has('status'))
            @if ($alertType == 'error')
                <div class="p-4 mb-4 text-sm text-red-700 bg-red-100 rounded-lg" role="alert">
                    {{ session('status') }}
                </div>
            @else
                <div class="p-4 mb-4 text-sm text-green-700 bg-green-100 rounded-lg" role="alert">
                    {{ session('status') }}
                </div>
            @endif
        @endif

        <form wire:submit.prevent="submit" class="space-y-6">
            <div class="grid grid-cols-1 gap-6 sm:grid-cols-2">
                <div>
                    <label for="name" class="block text-sm font-medium text-gray-700">Nom</label>
                    <input type="text" id="name" wire:model="name"
                        class="block w-full mt-1 border-gray-300 rounded-md shadow-sm"
                        placeholder="Veuillez saisir votre nom">
                    @error('name')
                        <span class="text-red-500">{{ $message }}</span>
                    @enderror
                </div>
                <div>
                    <label for="email" class="block text-sm font-medium text-gray-700">Email</label>
                    <input type="email" id="email" wire:model="email"
                        class="block w-full mt-1 border-gray-300 rounded-md shadow-sm"
                        placeholder="Veuillez saisir votre email">
                    @error('email')
                        <span class="text-red-500">{{ $message }}</span>
                    @enderror
                </div>
            </div>
            <div>
                <label for="message" class="block text-sm font-medium text-gray-700">Message</label>
                <textarea id="message" wire:model="message" rows="4"
                    class="block w-full mt-1 border-gray-300 rounded-md shadow-sm"
                    placeholder="Veuillez indiquer votre message"></textarea>
                @error('message')
                    <span class="text-red-500">{{ $message }}</span>
                @enderror
            </div>
            <div class="text-center">
                <button type="submit" class="px-4 py-2 mb-12 text-white bg-green-600 rounded-md hover:bg-green-700" role="button"
                aria-label="Soumettre ma
                    demande">Soumettre ma
                    demande</button>
            </div>
        </form>
    </div>
</div>
