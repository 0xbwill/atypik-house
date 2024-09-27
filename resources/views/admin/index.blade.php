<x-app-layout>
    <div class="py-12">
        <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
            <h1 class="text-4xl font-bold text-center">Administration</h1>
            <div class="grid grid-cols-1 gap-6 mt-8 sm:grid-cols-2 md:grid-cols-3">
                <a href="{{ route('admin.users') }}" wire:navigate aria-label="utilisateurs"
                    class="block p-6 bg-gray-100 rounded-lg shadow-md transition duration-300 ease-in-out hover:bg-gray-200">
                    <h2 class="mb-2 text-xl font-semibold">Utilisateurs</h2>
                    <p class="text-gray-600">Gestion des utilisateurs et leurs rôles.</p>
                </a>
                <a href="{{ route('admin.logements.index') }}" wire:navigate aria-label="logements"
                    class="block p-6 bg-gray-100 rounded-lg shadow-md transition duration-300 ease-in-out hover:bg-gray-200">
                    <h2 class="mb-2 text-xl font-semibold">Logements</h2>
                    <p class="text-gray-600">Gestion des logements</p>
                </a>

                <a href="{{ route('admin.hotes.index') }}" wire:navigate aria-label="hotes"
                    class="block p-6 bg-gray-100 rounded-lg shadow-md transition duration-300 ease-in-out hover:bg-gray-200">
                    <h2 class="mb-2 text-xl font-semibold">Hôtes</h2>
                    <p class="text-gray-600">Gestion des hôtes et des demandes.</p>
                </a>

                <a href="{{ route('about.edit') }}" wire:navigate aria-label="about"
                    class="block p-6 bg-gray-100 rounded-lg shadow-md transition duration-300 ease-in-out hover:bg-gray-200">
                    <h2 class="mb-2 text-xl font-semibold">A propos</h2>
                    <p class="text-gray-600">Administration de la page à propos.</p>
                </a>

                <a href="{{ route('admin.equipements.index') }}" wire:navigate aria-label="equipements"
                    class="block p-6 bg-gray-100 rounded-lg shadow-md transition duration-300 ease-in-out hover:bg-gray-200">
                    <h2 class="mb-2 text-xl font-semibold">Équipements</h2>
                    <p class="text-gray-600">Gestion des équipements.</p>
                </a>

            </div>

        </div>
        <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">

            <h1 class="mt-12 text-4xl font-bold text-center">TODO</h1>
            <div class="grid grid-cols-1 gap-6 mt-8 sm:grid-cols-2 md:grid-cols-3">
                <a href="{{ route('admin.index') }}" wire:navigate aria-label="reservations"
                    class="block p-6 bg-gray-100 rounded-lg shadow-md transition duration-300 ease-in-out hover:bg-gray-200">
                    <h2 class="mb-2 text-xl font-semibold">Réservations</h2>
                    <p class="text-gray-600">Gestion des réservations</p>
                </a>
                <a href="{{ route('admin.index') }}" wire:navigate aria-label="rapports"
                    class="block p-6 bg-gray-100 rounded-lg shadow-md transition duration-300 ease-in-out hover:bg-gray-200">
                    <h2 class="mb-2 text-xl font-semibold">Rapports</h2>
                    <p class="text-gray-600">Visualiser les rapports d'activité.</p>
                </a>
            </div>
        </div>
    </div>
    <script></script>


    <style lang="scss">

    </style>
</x-app-layout>
