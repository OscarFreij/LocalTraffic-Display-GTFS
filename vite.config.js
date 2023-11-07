import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';

export default defineConfig({
    plugins: [
        laravel({
            input: [
                'resources/css/app.css',
                'resources/css/statusBox.css',
                'resources/js/app.js',
                'resources/js/screen.js',
                'resources/js/screen2x2.js',
                'resources/css/legend.css'
            ],
            refresh: true,
        }),
    ],
    server: {
        hmr: {
            host: 'localhost',
        },
      }
});
