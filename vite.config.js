import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';
import path from 'path';

export default defineConfig({
    server: {
        host: '127.0.0.1',
        port: 3000
    },
    resolve: {
        alias: {
            // Alias pour accéder plus facilement aux polices
            '@fonts': path.resolve(__dirname, 'storage/app/public/fonts'),
        },
    },
    plugins: [
        laravel({
            input: [
                'resources/scss/style.scss',
                'resources/css/app.css',
                'resources/scss/filament/tailwind.scss',
                'resources/js/app.js',
                'resources/js/search.js',
            ],
            refresh: [
                'app/Livewire/**',
            ],
        }),
    ],
});
