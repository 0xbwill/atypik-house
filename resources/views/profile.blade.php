<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold leading-tight">
            {{ __('Profile') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="mx-auto space-y-6 max-w-7xl sm:px-6 lg:px-8">
            <div class="p-6 bg-white shadow sm:p-8 sm:rounded-lg">
                <div class="max-w-xl mx-auto">
                    @auth
                        <div class="mb-6">
                            <img src="{{ Auth::user()->profile_photo_path ? asset('storage/' . Auth::user()->profile_photo_path) : 'https://via.placeholder.com/150' }}"
                                class="w-48 h-48 rounded-full mx-auto border-4 border-gray-200 shadow-lg" alt="Profile Photo">
                        </div>

                        <form action="{{ route('profile.updatePhoto') }}" method="POST" enctype="multipart/form-data"
                            class="text-center mb-6">
                            @csrf
                            <input type="file" name="photo" class="mb-4">
                            <button type="submit"
                                class="bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded transition-colors" role="button" aria-label="sauveagarder">Sauvegarder</button>
                        </form>
                    @endauth
                </div>
            </div>

            <div class="p-6 bg-white shadow sm:p-8 sm:rounded-lg">
                <div class="max-w-xl mx-auto mb-6">
                    <livewire:profile.update-profile-information-form />
                </div>
            </div>

            <div class="p-6 bg-white shadow sm:p-8 sm:rounded-lg">

                <div class="max-w-xl mx-auto mb-6">
                    <livewire:profile.update-password-form />
                </div>
            </div>

            <div class="p-6 bg-white shadow sm:p-8 sm:rounded-lg">
                <div class="max-w-xl mx-auto mb-6">
                    <livewire:profile.delete-user-form />
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
