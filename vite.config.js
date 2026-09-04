import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';
import { bunny } from 'laravel-vite-plugin/fonts';
import tailwindcss from '@tailwindcss/vite';

export default defineConfig({
    plugins: [
        laravel({
            input: ['resources/css/app.css', 'resources/js/app.js', 'resources/css/filament/admin/theme.css'],
            refresh: true,
            fonts: [
                // Arabic display font
                bunny('Noto Kufi Arabic', {
                    weights: [400, 500, 600, 700],
                }),
                // Arabic serif display font (fallback for Thmanyah Serif Display)
                bunny('Noto Naskh Arabic', {
                    weights: [400, 500, 600, 700],
                }),
                // Arabic/Latin UI font
                bunny('IBM Plex Sans Arabic', {
                    weights: [300, 400, 500, 600],
                }),
                // Latin display/UI font
                bunny('Space Grotesk', {
                    weights: [400, 500, 600, 700],
                }),
                // Monospace font
                bunny('IBM Plex Mono', {
                    weights: [400, 500],
                }),
            ],
        }),
        tailwindcss(),
    ],
    server: {
        cors: true,
        watch: {
            ignored: [
                '**/.agents/**',
                '**/.claude/**',
                '**/.cursor/**',
                '**/.junie/**',
                '**/storage/framework/views/**',
                '**/vendor/**',
            ],
        },
    },
});
