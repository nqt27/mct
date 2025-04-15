import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';

export default defineConfig({
    plugins: [
        laravel({
            input: ['resources/css/app.css', 'resources/js/app.js'],
            refresh: true,
        }),
    ],
    // server: {
    //     https: true, // Bật HTTPS cho server Vite
    //     hmr: {
    //         host: 'dfd4-171-252-189-125.ngrok-free.app', // Host ngrok
    //     },
    // },
});
