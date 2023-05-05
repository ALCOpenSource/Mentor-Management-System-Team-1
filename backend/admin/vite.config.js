import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';

export default defineConfig({
    plugins: [
        laravel({
            // input: ['resources/css/app.css', 'resources/js/app.js'],
            input: ['resources/ignore/bootstrap.js'],
            // input: ['resources/ignore/echo.js'],
            refresh: true,
        }),
    ],
    build: {
        outDir: 'resources/ignore/build',
    }
});
