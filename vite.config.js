import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';

export default defineConfig({
    plugins: [
        laravel({
            input: ['resources/css/app.css', 'resources/js/app.js'],
            refresh: true,
            // PENTING: Beritahu Vite kalau folder public-nya adalah root (titik)
            publicDirectory: '.', 
        }),
    ],
    // Tambahkan ini agar folder build tercipta di lokasi yang benar
    build: {
        outDir: 'build',
    }
});