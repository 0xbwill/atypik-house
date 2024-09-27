import defaultTheme from 'tailwindcss/defaultTheme';
import forms from '@tailwindcss/forms';
import aspectRatio from '@tailwindcss/aspect-ratio';
import daisyui from "daisyui"


/** @type {import('tailwindcss').Config} */
export default {
    daisyui: {
        themes: ["light"],
      },
    darkMode: 'false',
    content: [
        './vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php',
        './storage/framework/views/*.php',
        './resources/views/**/*.blade.php',
        './vendor/filament/**/*.blade.php',
        './app/Filament/**/*.php',
        './resources/views/filament/**/*.blade.php',
        './vendor/filament/**/*.blade.php',
    ],

    theme: {
        extend: {
            fontFamily: {
                sans: ['Figtree', ...defaultTheme.fontFamily.sans],
            },
            colors: {
                transparent: 'transparent',
                current: 'currentColor',
                vert: '#3E9836',
                vert_hover: '#3E9000',
                bleu: '#00202B',
                noir: '#16171D'
            },
        },
    },

    plugins: [
        forms,
        aspectRatio,
        daisyui
    ],
};
