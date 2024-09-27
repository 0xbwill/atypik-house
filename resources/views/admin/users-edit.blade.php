<x-app-layout>
    <div class="container px-4 mx-auto">
        <div class="max-w-2xl mx-auto sm:px-6 lg:px-8">
            <h1 class="my-12 text-4xl font-bold text-center">Modification de l'utilisateur</h1>

            <form action="{{ route('admin.users.update', $user->id) }}" method="POST" enctype="multipart/form-data"
                class="w-full">
                @csrf
                @method('PUT')

                <div class="mb-4">
                    <label for="name" class="block mb-2 font-bold text-gray-700">Prénom:</label>
                    <input type="text"
                        class="w-full px-3 py-2 leading-tight text-gray-700 border rounded appearance-none focus:outline-none focus:shadow-outline"
                        id="name" name="name" value="{{ $user->name }}">
                </div>

                <div class="mb-4">
                    <label for="email" class="block mb-2 font-bold text-gray-700">Email:</label>
                    <input type="email"
                        class="w-full px-3 py-2 leading-tight text-gray-700 border rounded appearance-none focus:outline-none focus:shadow-outline"
                        id="email" name="email" value="{{ $user->email }}">
                </div>

                <div class="mb-4">
                    <label for="profile_photo_path" class="block mb-2 font-bold text-gray-700">Photo de profil :</label>
                    @if ($user->profile_photo_path)
                        <div class="flex mb-4">
                            <img src="{{ asset('storage/' . $user->profile_photo_path) }}" alt="Profile Photo"
                                class="object-cover w-32 h-32 rounded-xl">
                            <button type="button"
                                onclick="document.getElementById('delete-profile-photo-form').submit();"
                                class="ml-2 text-red-500 hover:text-red-700"role="button"
                                aria-label="enregistrer">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                                    xmlns="http://www.w3.org/2000/svg">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M6 18L18 6M6 6l12 12"></path>
                                </svg>
                            </button>
                        </div>
                    @endif
                    <input type="file"
                        class="w-full px-3 py-2 leading-tight text-gray-700 border rounded appearance-none focus:outline-none focus:shadow-outline"
                        id="profile_photo_path" name="profile_photo_path">
                </div>

                <div class="mb-4">
                    <label for="role" class="block mb-2 font-bold text-gray-700">Rôle:</label>
                    <select id="role" name="role"
                        class="w-full px-3 py-2 leading-tight text-gray-700 border rounded appearance-none focus:outline-none focus:shadow-outline">
                        @foreach ($roles as $role)
                            <option value="{{ $role->name }}"
                                {{ $userRole && $userRole->name == $role->name ? 'selected' : '' }}>
                                {{ $role->name }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="flex items-center justify-between">
                    <button
                        class="px-4 py-2 mt-4 font-bold text-white transition-all bg-blue-500 rounded hover:bg-blue-700 focus:outline-none focus:shadow-outline"
                        type="submit" role="button"
                        aria-label="enregistrer">Mettre à jour</button>
                </div>
            </form>

            <!-- Formulaire de suppression de la photo de profil -->
            <form id="delete-profile-photo-form" action="{{ route('admin.users.deleteProfilePhoto', $user->id) }}"
                method="POST" style="display: none;">
                @csrf
                @method('DELETE')
            </form>
        </div>
    </div>
</x-app-layout>
