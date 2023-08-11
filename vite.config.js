import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';

export default defineConfig({
    plugins: [
        laravel({
            input: [
                'resources/css/app.css',
                'resources/js/app.js',
                'resources/js/chartFinansial.js',
                'resources/js/chartMonitoring.js',
                'resources/js/chartPakan.js',
                'resources/js/chartSampling.js',
                'resources/js/finansial.js',
                'resources/js/focus-trap.js',
            ],
            refresh: true,
        }),
    ],
});
