<?php

use App\Livewire\Actions\Logout;
use Livewire\Volt\Component;

new class extends Component {
    /**
     * Log the current user out of the application.
     */
    public function logout(Logout $logout): void
    {
        $logout();

        $this->redirect('/', navigate: true);
    }
};
?>

<nav>
    <div class="flex items-center justify-between p-6 pt-8">
        <a class="logo" href="{{ route('home.index') }}" wire:navigate aria-label="home">
            <img class="w-48" src="{{ url('/images/logo full.png') }}" alt="">
        </a>
        <div class="items-center justify-around hidden px-6 py-4 space-x-8 lg:flex border-slate rounded-3xl h-fit">
            <a class="block" href="{{ route('home.index') }}" wire:navigate aria-label="home">
                <h3 class="text-1xl">Accueil</h3>
            </a>
            <a class="block" href="{{ route('logements.index') }}" wire:navigate aria-label="logements">
                <h3 class="text-1xl">Nos logements</h3>
            </a>


            <a class="block" href="{{ route('about.show') }}" wire:navigate aria-label="about">
                <h3 class="text-1xl">À propos</h3>
            </a>

            <div>
                <i class="fa-solid fa-magnifying-glass" id="search-icon"></i>

                <div class="search-overlay" id="search-overlay">
                    <div class="search-container ais-InstantSearch">
                        <div id="searchbox"></div>
                        <div id="hits"></div>
                    </div>
                </div>
            </div>
        </div>
        <div class="items-center hidden space-x-4 lg:flex">
            <!-- Settings Dropdown -->
            <div class="sm:flex sm:items-center sm:ms-6">
                @auth
                    <x-dropdown align="right" width="48">
                        <x-slot name="trigger">
                            <button role="button" aria-label="filtre"
                                class="inline-flex items-center px-3 py-2 text-sm font-medium leading-4 transition duration-150 ease-in-out bg-white border border-transparent rounded-md text-noir focus:outline-none">
                                <div><i class="fa-solid fa-user"></i></div>

                                <div class="ms-1">
                                    <svg class="w-4 h-4 fill-current" xmlns="http://www.w3.org/2000/svg"
                                        viewBox="0 0 20 20">
                                        <path fill-rule="evenodd"
                                            d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"
                                            clip-rule="evenodd" />
                                    </svg>
                                </div>
                            </button>
                        </x-slot>

                        @php
                            $user = Auth::user();
                            $isAdmin = $user->hasRole('admin');
                            $isHost = $user->hasRole('hôte');
                            $isUser = $user->hasRole('user');
                        @endphp

                        <x-slot name="content">
                            @if ($isAdmin)
                                <x-dropdown-link :href="url('/admin')" aria-label="admin">
                                    {{ __('Administration') }}
                                </x-dropdown-link>
                            @endif

                            @auth
                                @if ($isAdmin || !$isHost)
                                    <x-dropdown-link :href="route('devenir-hote')" wire:navigate aria-label="devenir-hote">
                                        {{ __('Devenir hôte') }}
                                    </x-dropdown-link>
                                @endif



                                @if ($isAdmin || $isHost)
                                    <x-dropdown-link :href="route('mes-logements.index')" wire:navigate aria-label="mes-logements">
                                        {{ __('Mes logements') }}
                                    </x-dropdown-link>
                                @endif

                                <x-dropdown-link :href="route('mes-reservations.index')" aria-label="mes-reservations">
                                    {{ __('Mes réservations') }}
                                </x-dropdown-link>
                            @endauth

                            <x-dropdown-link :href="route('profile.show', ['slug' => Auth::user()->slug])" wire:navigate aria-label="profile">
                                {{ __('Mon profil') }}
                            </x-dropdown-link>

                            <x-dropdown-link :href="route('profile')" wire:navigate aria-label="profile">
                                {{ __('Paramètres') }}
                            </x-dropdown-link>
                            <x-dropdown-link :href="route('contact')" wire:navigate aria-label="contact">
                                {{ __('Nous contacter') }}
                            </x-dropdown-link>

                            <!-- Authentication -->
                            <button wire:click="logout" class="w-full text-start" role="button" aria-label="filtre">
                                <x-dropdown-link>
                                    {{ __('Se déconnecter') }}
                                </x-dropdown-link>
                            </button>
                        </x-slot>

                    </x-dropdown>
                @endauth

                @guest
                    <a class="block mr-3" href="{{ route('devenir-hote-guide') }}" wire:navigate aria-label="Guide pour devenir hôte">
                        <h3 class="text-1xl">Devenir hôte</h3>
                    </a>
                    <div class="flex flex-col w-full sm:w-auto sm:flex-row p-4">
                        <a href="{{ route('login') }}" wire:navigate aria-label="login"
                            class="mr-4 no-hover-underline text-white flex flex-row items-center justify-center w-full px-5 py-2 text-sm font-medium bg-vert leading-6 capitalize duration-100 transform rounded-sm shadow cursor-pointer">
                            {{ __('Connexion') }}
                        </a>
                        <a href="{{ route('register') }}" wire:navigate aria-label="register"
                            class="no-hover-underline flex flex-row items-center justify-center w-full px-5 py-2 text-sm font-medium border-vert border-2 text-vert leading-6 capitalize duration-100 transform rounded-sm cursor-pointer">
                            {{ __('S\'inscrire') }}
                        </a>
                    </div>
                @endguest

            </div>

        </div>

        <!-- Mobile menu button -->
        <div class="lg:hidden">
            <button id="mobile-menu-button" role="button" aria-label="filtre"
                class="text-gray-500 hover:text-gray-700 focus:outline-none focus:text-gray-700">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                    xmlns="http://www.w3.org/2000/svg">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16m-7 6h7">
                    </path>
                </svg>
            </button>
        </div>
    </div>

    <!-- Mobile menu -->
    <div id="mobile-menu"
        class="fixed inset-0 z-50 hidden bg-white bg-opacity-95 flex flex-col items-center justify-center space-y-6 text-lg">
        <button id="close-mobile-menu" role="button" aria-label="filtre"
            class="absolute top-6 right-6 text-gray-500 hover:text-gray-700 focus:outline-none">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                xmlns="http://www.w3.org/2000/svg">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
            </svg>
        </button>
        <a class="block" href="{{ route('home.index') }}" wire:navigate aria-label="accueil">
            <h3 class="text-2xl">Accueil</h3>
        </a>
        <a class="block" href="{{ route('logements.index') }}" wire:navigate aria-label="logements">
            <h3 class="text-2xl">Nos logements</h3>
        </a>
        <a class="block" href="{{ route('about.show') }}" wire:navigate aria-label="about">
            <h3 class="text-2xl">À propos</h3>
        </a>
        @auth
            @if ($isAdmin)
                <a href="{{ url('/admin') }}" class="text-2xl" aria-label="admin">{{ __('Administration') }}</a>
                <a href="{{ route('devenir-hote') }}" wire:navigate aria-label="devenir-hote"
                    class="text-2xl">{{ __('Devenir hôte') }}</a>
            @endif
            <a href="{{ route('profile.show', ['slug' => Auth::user()->slug]) }}" wire:navigate aria-label="profile"
                class="text-2xl">{{ __('Mon profil') }}</a>
            @if ($isAdmin || $isHost)
                <a href="{{ route('mes-logements.index') }}" wire:navigate aria-label="mes-logements"
                    class="text-2xl">{{ __('Mes logements') }}</a>
            @endif
            <a href="{{ route('mes-reservations.index') }}" aria-label="mes-resrevations"
                class="text-2xl">{{ __('Mes réservations') }}</a>
            <a href="{{ route('profile') }}" wire:navigate aria-label="parametres"
                class="text-2xl">{{ __('Paramètres') }}</a>
            <a href="{{ route('contact') }}" wire:navigate aria-label="nous-contacter"
                class="text-2xl">{{ __('Nous contacter') }}</a>
            <button wire:click="logout" class="text-2xl" role="button"
                aria-label="filtre">{{ __('Se déconnecter') }}</button>
        @endauth
        @guest
            <a href="{{ route('devenir-hote-guide') }}" wire:navigate aria-label="Guide pour devenir hôte">
                <h3 class="text-2xl">Devenir hôte</h3>
            </a>
            <a href="{{ route('login') }}" wire:navigate aria-label="connexion"
                class="text-2xl">{{ __('Connexion') }}</a>
            <a href="{{ route('register') }}" wire:navigate aria-label="inscription"
                class="text-2xl">{{ __('S\'inscrire') }}</a>
        @endguest
    </div>

    <style lang="scss">
        .search-overlay {
            visibility: hidden;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.7);
            z-index: 1000;
            opacity: 0;
            transition: opacity 0.5s ease-in-out, visibility 0.5s ease-in-out;
        }

        .search-overlay.visible {
            visibility: visible;
            opacity: 1;
        }

        #search-icon:hover {
            cursor: pointer;
        }

        .search-container {
            position: absolute;
            top: 20%;
            left: 50%;
            transform: translate(-50%, -50%);
            z-index: 1001;
            width: 80%;
            background: white;
            padding: 20px;
            border-radius: 8px;
            opacity: 0;
            transition: opacity 0.5s ease-in-out, transform 0.5s ease-in-out;
        }

        .search-container.visible {
            opacity: 1;
            transform: translate(-50%, 0);
        }

        #mobile-menu-button {
            cursor: pointer;
        }

        #mobile-menu {
            display: none;
        }

        #mobile-menu.show {
            display: flex;
        }
    </style>

    <script>
        document.getElementById('mobile-menu-button').addEventListener('click', function() {
            var menu = document.getElementById('mobile-menu');
            menu.classList.toggle('hidden');
            menu.classList.toggle('show');
        });

        document.getElementById('close-mobile-menu').addEventListener('click', function() {
            var menu = document.getElementById('mobile-menu');
            menu.classList.add('hidden');
            menu.classList.remove('show');
        });

        document.getElementById('search-icon').addEventListener('click', function() {
            var overlay = document.getElementById('search-overlay');
            overlay.classList.toggle('visible');
        });
    </script>
</nav>
