import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';
import tailwindcss from '@tailwindcss/vite';
import vue from '@vitejs/plugin-vue';
// Wajib diimpor untuk konfigurasi alias
import path from 'path'; 

export default defineConfig({
    plugins: [
        laravel({
            input: ['resources/css/app.css', 'resources/js/app.js'],
            refresh: true,
        }),
        tailwindcss(), 
        vue({ 
            template: {
                transformAssetUrls: {
                    base: null,
                    includeAbsolute: false,
                },
            },
        }),
    ],
    
    // !! BLOK KRITIS UNTUK MEMPERBAIKI ERROR VUE RUNTIME !!
    resolve: {
        alias: {
            // FIX: Menggunakan versi Vue yang memiliki compiler
            'vue': 'vue/dist/vue.esm-bundler.js', 
            // Alias standar untuk mempermudah path impor JS
            '@': path.resolve(__dirname, 'resources/js'), 
        },
    },
});