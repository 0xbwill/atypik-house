<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>AtypikHouse - Locations de Logements Atypique et Éco-Responsables</title>
    <meta name="description"
        content="Découvrez AtypikHouse, votre plateforme pour louer des logements insolites et écologiques. Vivez une expérience unique en pleine nature ou dans des lieux d'exception.">
    <meta name="keywords"
        content="location, logement, insolite, atypique, écologie, écotourisme, cabane, yourte, maison dans les arbres, expérience unique">
    <meta name="robots" content="index, follow">
    <meta property="og:title" content="AtypikHouse - Locations de Logements Insolites et Éco-Responsables">
    <meta property="og:description"
        content="Explorez des logements hors du commun avec AtypikHouse. Louez une cabane dans les arbres, une yourte, ou une maison écologique pour une escapade unique et mémorable.">
    <meta property="og:url" content="https://f2i-devo22a-wd-nv-pd-bb.atypikhouse.site" />

    <link rel="canonical" href="https://f2i-devo22a-wd-nv-pd-bb.atypikhouse.site/" aria-label="link">

    <!-- Google tag (gtag.js) -->
    <script async src="https://www.googletagmanager.com/gtag/js?id=G-LEV2DJQB3W"></script>
    <script>
        window.dataLayer = window.dataLayer || [];

        function gtag() {
            dataLayer.push(arguments);
        }
        gtag('js', new Date());

        gtag('config', 'G-LEV2DJQB3W');
    </script>


    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net" aria-label="link">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet"
        aria-label="link" />
    <link href="{{ asset('css/styles.css') }}" rel="stylesheet" aria-label="link">
    <!-- flatpickr CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css" aria-label="link">
    <!-- flatpickr French Locale -->
    <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
    <script src="https://cdn.jsdelivr.net/npm/flatpickr/dist/l10n/fr.js"></script>
    <!-- Scripts -->
    @vite(['resources/scss/style.scss', 'resources/css/app.css', 'resources/js/app.js', 'resources/js/search.js'])

    <!-- JQuery & Slick -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css"
        aria-label="link">
    <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick.css"
        aria-label="link" />
    <link rel="stylesheet" type="text/css"
        href="https://cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick-theme.css" aria-label="link" />
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick.min.js"></script>
    <script src="https://kit.fontawesome.com/104583988c.js" crossorigin="anonymous"></script>
    @livewireStyles
    @cookieconsentscripts
</head>

<body>
    <div class="mx-auto font-sans antialiased max-w-[1500px] min-h-screen">

        <dialog id="my_modal_3" class="modal">
            <div class="modal-box max-w-3xl">
                <form method="dialog">
                    <button class="btn btn-sm btn-circle btn-ghost absolute right-2 top-2">✕</button>
                </form>
                <livewire:subscribe-newsletter />
            </div>
        </dialog>

        <livewire:layout.navigation />


        <!-- Page Heading -->
        @if (isset($header))
            <header class="bg-white text-noir">
                <div class="px-4 py-6 mx-auto max-w-7xl sm:px-6 lg:px-8">
                    {{ $header }}
                </div>
            </header>
        @endif

        <!-- Page Content -->
        <main>
            {{ $slot }}
        </main>

        @yield('content')

    </div>
    <livewire:footer />
    @livewireScripts
    @cookieconsentview

</body>

</html>
