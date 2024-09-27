<div class="hero mt-8 mb-4 w-full">
    <div
        class="hero-content flex flex-col lg:flex-row-reverse items-center lg:items-start max-w-3xl mx-auto px-5 py-3 bg-white rounded-lg">
        <div class="text-center lg:text-left">
            <h2 class="text-4xl font-bold text-gray-900 mb-6">Restez informé !</h2>
            <p class="text-lg text-gray-700 mb-6">
                Abonnez-vous à notre newsletter pour les dernières mises à jour et offres exclusives. Soyez toujours au
                courant de nos nouveautés !
            </p>
            <form wire:submit.prevent="submit"
                class="w-full flex space-y-4 bg-white p-4 rounded-lg border border-gray-200">
                <input type="email" wire:model="email" placeholder="Votre email"
                    class="input input-bordered w-2/3 mr-4 border-gray-300 rounded-md shadow-sm focus:border-gray-500 focus:ring focus:ring-gray-200 focus:ring-opacity-50"
                    required>
                <button type="submit"
                    class="btn btn-primary border-0 w-1/3 mt-0 bg-gray-800 text-white rounded-md py-2 px-4 shadow-md hover:bg-gray-900 transition-colors duration-300">
                    S'abonner
                </button>
            </form>

            <div class="mt-10 text-center">
                @error('email')
                <span class="text-red-500 mt-2 block">{{ $message }}</span>
                @enderror

                @if (session()->has('message'))
                <span class="text-green-500 mt-2 block">{{ session('message') }}</span>
                @endif
            </div>
        </div>
    </div>
    <style lang="scss">
        button[type="submit"] {
            margin-top: 0 !important;
        }
    </style>
</div>