import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';
import react from '@vitejs/plugin-react';
import path from 'path';

export default defineConfig({
    plugins: [
        laravel({
            input: ['resources/css/app.css', 'resources/js/app.jsx'],
            refresh: true,
        }),
        react(),
    ],

    resolve: {
        alias: {
            '@': path.resolve(__dirname, 'resources/js'),
        },
    },

    optimizeDeps: {
        include: [
            //
        ],
    },

    define: {
        'process.env': {}, // Fix for AdminLTE / jQuery plugins
    },

    server: {
        cors: true,
        host: 'mahbub.limu',
        port: 5173,
        hmr: {
            host: 'mahbub.limu',
        },
    },
});