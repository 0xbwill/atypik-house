<footer class="py-8 text-black bg-gray-100">
    <div class="container px-4 mx-auto">
        <!-- Wrapper avec un design en grid pour mobile et flex pour desktop -->
        <div class="flex flex-wrap justify-between lg:flex-nowrap lg:space-x-10">
            
            <!-- Logo et liens principaux -->
            <div class="w-full md:w-1/2 lg:w-1/5 mb-6 lg:mb-0">
                <a class="logo" href="{{ route('home.index') }}" wire:navigate aria-label="home">
                    <img class="w-48 mb-4" src="{{ url('/images/logo full.png') }}" alt="Logo">
                </a>
                <nav class="space-y-2">
                    <a class="block text-gray-400" href="{{ route('home.index') }}" wire:navigate aria-label="home">
                        Accueil
                    </a>
                    <a class="block text-gray-400" href="{{ route('logements.index') }}" wire:navigate
                        aria-label="logements">
                        Nos logements
                    </a>
                    <a class="block text-gray-400" href="{{ route('about.show') }}" wire:navigate aria-label="logements">
                        A propos
                    </a>
                    <a class="block text-gray-400" href="{{ route('contact') }}" wire:navigate aria-label="contact">
                        Contact
                    </a>
                </nav>
            </div>

            <!-- Liens utilisateurs -->
            <div class="w-full md:w-1/2 lg:w-1/5 mb-6 lg:mb-0">
                <h3 class="mb-4 text-lg font-semibold">Utilisateur</h3>
                @auth
                    <nav class="space-y-2">
                        @php
                            $user = Auth::user();
                            $isAdmin = $user->hasRole('admin');
                            $isHost = $user->hasRole('hôte');
                            $isUser = $user->hasRole('user');
                        @endphp

                        @if ($isAdmin)
                            <a class="block text-gray-400" href="{{ url('/admin') }}" aria-label="admin">
                                Administration
                            </a>
                        @endif

                        @if ($isAdmin || $isHost)
                            <a class="block text-gray-400" href="{{ route('devenir-hote') }}" wire:navigate
                                aria-label="devenir-hote">
                                Devenir hôte
                            </a>
                        @endif

                        @if ($isAdmin || $isHost)
                            <a class="block text-gray-400" href="{{ route('mes-logements.index') }}" wire:navigate
                                aria-label="mes-logements">
                                Mes logements
                            </a>
                        @endif

                        <a class="block text-gray-400" href="{{ route('profile.show', ['slug' => Auth::user()->slug]) }}"
                            wire:navigate aria-label="profile">
                            Mon profil
                        </a>

                        <a class="block text-gray-400" href="{{ route('profile') }}" wire:navigate aria-label="profile">
                            Paramètres
                        </a>

                        <button wire:click="logout" class="block w-full text-left text-gray-400" role="button"
                            aria-label="deconnecter">
                            Se déconnecter
                        </button>
                    </nav>
                @endauth

                @guest
                    <nav class="space-y-2">
                        <a class="block text-gray-400" href="{{ route('login') }}" wire:navigate aria-label="login">
                            Se connecter
                        </a>
                        <a class="block text-gray-400" href="{{ route('register') }}" wire:navigate aria-label="register">
                            S'inscrire
                        </a>
                    </nav>
                @endguest
            </div>

            <!-- Informations de contact -->
            <div class="w-full md:w-1/2 lg:w-1/5 mb-6 lg:mb-0">
                <h3 class="mb-4 text-lg font-semibold">Contactez-nous</h3>
                <div class="space-y-2">
                    <p class="text-gray-400">10 Rue de la Liberté, 60350</p>
                    <p class="text-gray-400">Pierrefonds, France</p>
                    <a class="text-gray-400" href="mailto:contact@atypikhouse.site">contact@atypikhouse.site</a>
                    <a class="text-gray-400" href="tel:0123456789">01 23 45 67 89</a>
                </div>
            </div>

            <!-- Légal -->
            <div class="w-full md:w-1/2 lg:w-1/5 mb-6 lg:mb-0">
                <h3 class="mb-4 text-lg font-semibold">Légal</h3>
                <div class="space-y-2">
                    <a class="block text-gray-400" href="{{ route('legal') }}#cgv" aria-label="cgv">
                        Conditions générales de vente
                    </a>
                    <a class="block text-gray-400" href="{{ route('legal') }}#cgu" aria-label="cgu">
                        Conditions générales d'utilisation
                    </a>
                    <a class="block text-gray-400" href="{{ route('legal') }}#mentions-legales" aria-label="legales">
                        Mentions légales
                    </a>
                    <a class="block text-gray-400" href="{{ route('legal') }}#rgpd" aria-label="rgpd">
                        RGPD
                    </a>
                </div>
            </div>

            <!-- Newsletter -->
            <div class="w-full md:w-1/2 lg:w-1/5 mb-6 lg:mb-0">
                <h3 class="mb-4 text-lg font-semibold">Newsletter</h3>
                <div class="space-y-2">
                    <button class="btn" onclick="my_modal_3.showModal()">S'abonner à la newsletter</button>
                </div>
            </div>
        </div>

        <!-- Réseaux sociaux -->
        <div class="flex justify-center mt-8 space-x-6">
            <a target="_blank" href="https://www.facebook.com/profile.php?id=61562194624915" aria-label="facebook"
                class="text-gray-400"><i class="fab fa-facebook-f"></i></a>
            <a target="_blank" href="https://www.instagram.com/_atypikhouse_/" aria-label="instagram"
                class="text-gray-400"><i class="fab fa-instagram"></i></a>
        </div>

        <!-- Copyright -->
        <div class="mt-8 text-center text-gray-500">
            &copy; 2024 AtypikHouse. Tous droits réservés.
            <h2 class="font-semibold">Ce projet est une simulation étudiante, il ne permet ni de réaliser de véritables
                achats ni d'effectuer des réservations réelles.</h2>
        </div>
    </div>
</footer>
