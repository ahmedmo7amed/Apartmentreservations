import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';
import react from '@vitejs/plugin-react';

export default defineConfig({
    plugins: [
        laravel({
            input: ['resources/js/app.jsx',
                'resources/js/Pages/Auth/CustomerLogin.jsx',
                ],
            refresh: true,
        }),
        react(),
    ],

    // resolve: {
    //     alias: {
    //     }
    // }

});
