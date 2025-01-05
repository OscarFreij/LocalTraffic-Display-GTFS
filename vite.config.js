import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';

export default defineConfig({
    plugins: [
        laravel({
            input: [
                'resources/css/app.css',
                'resources/js/app.js',
                'resources/js/paginate_set_limit.js',
                'resources/js/clear_filter.js',
                'resources/css/bg_dots.css',
                'resources/js/create_screenComponents.js'
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
