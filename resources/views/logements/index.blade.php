<x-app-layout>
    <div class="py-12 node-type-categories">
        <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
            <div class="shadow-sm sm:rounded-lg">
                <div class="relative p-6 text-noir">
                    <h2 class="my-12 text-4xl font-bold text-center text-bleu">Nos logements les mieux notés</h2>
                    <div class="best-logements">
                        @foreach ($topRatedLogements as $logement)
                            <div>
                                <div class="p-4 bg-white rounded-lg">
                                    <div class="relative aspect-w-1 aspect-h-1">
                                        <img src="{{ $logement->public_url ? $logement->image_url : ($logement->image_url ? asset('storage/' . $logement->image_url) : 'https://placehold.co/600x600') }}"
                                            alt="{{ $logement->title }}" class="object-cover rounded-lg aspect-square">

                                        <div
                                            class="absolute right-0 px-3 py-2 text-sm font-bold text-black bg-white rounded h-fit w-fit left-2 top-2">
                                            {{ $logement->price }}€/nuit
                                        </div>
                                    </div>
                                    <div class="mt-4">
                                        <div class="flex justify-between">
                                            <h3 class="w-2/3 text-lg font-bold text-noir">{{ $logement->title }}</h3>
                                            <div class="flex items-base h-fit">
                                                <p class="w-auto text-noir">
                                                <p class="w-auto text-noir">
                                                    @if ($logement->average_rating)
                                                        {{ number_format($logement->average_rating, 1) }} / 5
                                                        <i class="fas fa-star h-fit"></i>
                                                    @else
                                                        Aucun avis
                                                    @endif
                                                </p>
                                                </p>
                                            </div>
                                        </div>
                                        <p>{{ $logement->short_description }}</p>
                                        <p><i class="mr-2 fa-solid fa-user"></i>{{ $logement->capacity }}
                                            {{ $logement->capacity == 1 ? 'personne' : 'personnes' }}</p>
                                        <p><i class="mr-2 fa-solid fa-bed"></i>{{ $logement->bedrooms }}
                                            {{ $logement->bedrooms == 1 ? 'chambre' : 'chambres' }}</p>
                                        <p><i class="mr-2 fa-solid fa-bath"></i>{{ $logement->bathrooms }}
                                            {{ $logement->bathrooms == 1 ? 'salle de bains' : 'salles de bains' }}</p>
                                        <a href="/logement/{{ $logement->slug }}" wire:navigate
                                            class="inline-block px-4 py-2 mt-4 font-semibold text-white transition-all rounded bg-vert hover:bg-green-700">
                                            Découvrir
                                        </a>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                    <button type="button" class="slick-prev" role="button" aria-label="previous"><i
                            class="fas fa-chevron-left"></i></button>
                    <button type="button" class="slick-next" role="button" aria-label="next"><i
                            class="fas fa-chevron-right"></i></button>
                </div>

                <div style="width: 75%; border-top: 1px solid #ccc; margin: 80px auto;" id="paginated-logements"></div>
                @livewire('logements-list')
            </div>
        </div>
    </div>

    <script>
        $(document).ready(function() {
            $('.best-logements').slick({
                slidesToShow: 3,
                slidesToScroll: 1,
                autoplay: true,
                autoplaySpeed: 2500,
                dots: true,
                speed: 300,
                arrows: true,
                prevArrow: $('.slick-prev'),
                nextArrow: $('.slick-next'),
                responsive: [{
                    breakpoint: 1024,
                    settings: {
                        slidesToShow: 3,
                        slidesToScroll: 3,
                        infinite: true,
                        dots: true
                    }
                }, {
                    breakpoint: 600,
                    settings: {
                        slidesToShow: 1,
                        slidesToScroll: 1
                    }
                }, {
                    breakpoint: 480,
                    settings: {
                        slidesToShow: 1,
                        slidesToScroll: 1
                    }
                }]
            });
        });
    </script>
</x-app-layout>
