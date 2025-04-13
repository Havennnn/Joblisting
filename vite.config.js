import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';
import { resolve } from 'path';

export default defineConfig({
    plugins: [
        laravel({
            input: [
                'resources/css/app.css',
                'resources/css/style.css',
                'resources/js/app.js',
                'resources/js/pages/applicantRegister.js',
                'resources/js/pages/employerRegister.js',
                'resources/js/pages/applicantLogin.js',
                'resources/js/pages/employerLogin.js',
            ],
            refresh: true,
        }),
    ],
    resolve: {
        alias: {
            '@': '/resources/js'
        }
    }
});
