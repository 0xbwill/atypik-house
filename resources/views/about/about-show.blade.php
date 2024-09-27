<x-app-layout>
    <div class="container px-4 py-8 mx-auto max-w-7xl">
        @if ($about)
            <div class="lg:py-12 md:py-0">
                <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
                    <!-- Section 1 -->
                    <div class="mb-8 overflow-hidden bg-white shadow-sm sm:rounded-lg">
                        <div class="p-6">
                            <div class="grid items-center grid-cols-1 gap-6 md:grid-cols-2">
                                <div class="md:order-last">
                                    <img src="{{ asset('storage/' . $about->section1_image) }}"
                                        alt="{{ $about->section1_title }}"
                                        class="object-cover w-full h-auto rounded-lg shadow-lg">
                                </div>
                                <div class="md:order-first">
                                    <span class="font-bold text-vert">{{ $about->section1_title }}</span>
                                    <h1 class="mt-2 text-5xl font-bold text-bleu">{{ $about->section1_subtitle }}</h1>
                                    <p class="mt-4 mb-8 text-lg text-noir">
                                        {{ $about->section1_description }}
                                    </p>
                                    <a href="{{ $about->section1_button_link }}" aria-label="about"
                                        class="block w-fit px-4 py-3 mt-6 text-white transition-all rounded-xl bg-vert hover:bg-green-700">
                                        {{ $about->section1_button_text }}
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Section 2 -->
                    <div class="mb-8 overflow-hidden bg-white shadow-sm sm:rounded-lg">
                        <div class="p-6">
                            <div class="grid items-center grid-cols-1 gap-6 md:grid-cols-2">
                                <div class="md:order-first">
                                    <img src="{{ asset('storage/' . $about->section2_image) }}"
                                        alt="{{ $about->section2_title }}"
                                        class="object-cover w-full h-auto rounded-lg shadow-lg">
                                </div>
                                <div class="md:order-last">
                                    <span class="font-bold text-vert">{{ $about->section2_title }}</span>
                                    <h1 class="mt-2 text-5xl font-bold text-bleu">{{ $about->section2_subtitle }}</h1>
                                    <p class="mt-4 mb-8 text-lg text-noir">
                                        {{ $about->section2_description }}
                                    </p>
                                    <a href="{{ $about->section2_button_link }}" aria-label="link"
                                        class="block w-fit px-4 py-3 mt-6 text-white transition-all rounded-xl bg-vert hover:bg-green-700">
                                        {{ $about->section2_button_text }}
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Pourquoi nous -->
                    <div class="py-12">
                        <div class="mx-auto overflow-hidden max-w-7xl sm:px-6 lg:px-8">
                            <h2 class="mb-12 text-4xl font-bold text-center text-bleu">Pourquoi nous ?</h2>
                            <div class="grid grid-cols-1 gap-6 md:grid-cols-2 lg:grid-cols-4">
                                <div class="rounded-lg shadow-md">
                                    <div class="p-6 bg-gray-100 rounded-t-lg">
                                        <li class="flex items-center">
                                            <h3 class="text-4xl font-bold text-noir">{{ $totalLogements }}</h3>
                                            <i class="mb-2 ml-2 text-3xl text-gray-700 fas fa-home"></i>
                                        </li>
                                        <p class="text-2xl font-semibold text-noir">logements</p>
                                        <p class="text-xl font-semibold text-vert">disponibles</p>
                                    </div>
                                    <p class="px-6 pt-2 pb-6 mt-4 text-noir">Découvrez une vaste gamme de logements
                                        uniques, allant des
                                        cabanes dans les arbres aux maisons flottantes. Trouvez l'endroit parfait pour
                                        une expérience
                                        inoubliable.</p>
                                </div>
                                <div class="rounded-lg shadow-md">
                                    <div class="p-6 bg-gray-100 rounded-t-lg">
                                        <li class="flex items-center">
                                            <h3 class="text-4xl font-bold text-noir">{{ $totalUsersWithHostRole }}</h3>
                                            <i class="text-3xl ml-2 text-gray-700 fas fa-users"></i>
                                        </li>
                                        <p class="text-2xl font-semibold text-noir">hôtes</p>
                                        <p class="text-xl font-semibold text-vert">enregistrés</p>
                                    </div>
                                    <p class="px-6 pt-2 pb-6 mt-4 text-noir">Rejoignez une communauté dynamique d’hôtes
                                        passionnés,
                                        prêts à partager leur espace et leurs conseils pour une expérience locale
                                        authentique.</p>
                                </div>
                                <div class="rounded-lg shadow-md">
                                    <div class="p-6 bg-gray-100 rounded-t-lg">
                                        <li class="flex items-center">
                                            <h3 class="text-4xl font-bold text-noir">{{ $totalAvis }}</h3>
                                            <i class="ml-3 text-3xl text-gray-700 fas fa-comment-dots"></i>
                                        </li>
                                        <p class="text-2xl font-semibold text-noir">avis</p>
                                        <p class="text-xl font-semibold text-vert">au total</p>
                                    </div>
                                    <p class="px-6 pt-2 pb-6 mt-4 text-noir">Les avis de nos utilisateurs reflètent la
                                        qualité
                                        exceptionnelle des séjours offerts. Lisez les témoignages pour vous faire une
                                        idée de
                                        l'expérience qui vous attend.</p>
                                </div>
                                <div class="rounded-lg shadow-md">
                                    <div class="p-6 bg-gray-100 rounded-t-lg">
                                        <li class="flex items-center">
                                            <h3 class="text-4xl font-bold text-noir">
                                                {{ number_format($averageRating, 1) }}</h3>
                                            <i class="ml-1 text-3xl text-yellow-500 fas fa-star"></i>
                                        </li>
                                        <p class="text-2xl font-semibold text-noir">moyenne</p>
                                        <p class="text-xl font-semibold text-vert">des avis</p>
                                    </div>
                                    <p class="px-6 pt-2 pb-6 mt-4 text-noir">Nos utilisateurs apprécient la qualité de
                                        service et des
                                        logements proposés, comme en témoigne notre excellente note moyenne. Réservez en
                                        toute
                                        confiance.</p>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        @else
            <p class="text-center text-gray-500">No data available for the About page.</p>
        @endif
    </div>
</x-app-layout>
