import "./bootstrap";
import "instantsearch.css/themes/satellite.css";
import search from "./search.js";
import { gsap } from "gsap";

import "tom-select/dist/css/tom-select.css";
import TomSelect from "tom-select/dist/js/tom-select.complete.js";

var selectEquipement = document.querySelector("select#equipements");
if (selectEquipement) {
    new TomSelect("#equipements", {
        plugins: {
            remove_button: {
                title: "Supprimer",
            },
        },
    });
}

// document.addEventListener('DOMContentLoaded', onContentLoadedAndNavigated);
document.addEventListener("livewire:navigated", onContentLoadedAndNavigated);

function onContentLoadedAndNavigated() {
    initializeSearch();
    gsap.fromTo("main", { opacity: 0 }, { opacity: 1, duration: 0.3 });

    $(".carousel").slick({
        slidesToShow: 3,
        slidesToScroll: 1,
        autoplay: true,
        autoplaySpeed: 2500,
        speed: 300,
        arrows: true,
        prevArrow: $(".slick-prev"),
        nextArrow: $(".slick-next"),
        adaptiveHeight: true,
        responsive: [
            {
                breakpoint: 1024,
                settings: {
                    slidesToShow: 2,
                    slidesToScroll: 1,
                    infinite: true,
                    dots: true,
                },
            },
            {
                breakpoint: 600,
                settings: {
                    slidesToShow: 1,
                    slidesToScroll: 1,
                    dots: true,
                },
            },
        ],
    });

    $(".avis-slider").slick({
        infinite: true,
        slidesToShow: 3,
        slidesToScroll: 1,
        dots: false,
        arrows: false,
        adaptiveHeight: true,
        responsive: [
            {
                breakpoint: 1024,
                settings: {
                    slidesToShow: 2,
                    slidesToScroll: 1,
                    infinite: false,
                    dots: false,
                },
            },
            {
                breakpoint: 600,
                settings: {
                    slidesToShow: 1,
                    slidesToScroll: 1,
                },
            },
            {
                breakpoint: 480,
                settings: {
                    slidesToShow: 1,
                    slidesToScroll: 1,
                    dots: false,
                    arrow: false,
                },
            },
        ],
    });
}

function initializeSearch() {
    const searchIcon = document.getElementById("search-icon");
    const searchOverlay = document.getElementById("search-overlay");
    const searchContainer = document.querySelector(".search-container");

    if (searchIcon && searchOverlay && searchContainer) {
        // Remove previous event listeners if they exist
        searchIcon.removeEventListener("click", openSearch);
        searchOverlay.removeEventListener("click", closeSearch);

        function openSearch() {
            searchOverlay.classList.add("visible");
            setTimeout(() => {
                searchOverlay.style.opacity = "1";
                searchContainer.classList.add("visible");
            }, 50);
            search.start();
        }

        function closeSearch(event) {
            if (event.target === searchOverlay) {
                searchOverlay.style.opacity = "0";
                searchContainer.classList.remove("visible");
                setTimeout(() => {
                    searchOverlay.classList.remove("visible");
                }, 500);
                search.helper.clearQuery();
                search.helper.search();
            }
        }

        searchIcon.addEventListener("click", openSearch);
        searchOverlay.addEventListener("click", closeSearch);
    }
}
