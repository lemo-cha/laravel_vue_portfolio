import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';
import vue from '@vitejs/plugin-vue';

export default defineConfig({
    plugins: [
        laravel({
            input: ['resources/js/app.js',
                    'resources/css/app.css',
                    'resources/css/app.scss'
                ],
            refresh: true,
        }),
        vue({
            template: {
                transformAssetUrls: {
                    base: null, //.envのAPP_URL
                    includeAbsolute: false,
                },
            },
        }),
    ],
    server: {
        proxy:{
            '/api':{
                target: null, //.envのAPP_URL
                changeOrigin: true,
                secure: true,
                rewrite:(path) => path.replace(/^\/api/, ''),
            },
        },
    },
});