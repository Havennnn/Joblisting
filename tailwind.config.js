import defaultTheme from 'tailwindcss/defaultTheme';
import forms from '@tailwindcss/forms';

/** @type {import('tailwindcss').Config} */
export default {
    content: [
        './vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php',
        './storage/framework/views/*.php',
        './resources/views/**/*.blade.php',
    ],

    theme: {
        extend: {
            fontFamily: {
                sans: ['Figtree', ...defaultTheme.fontFamily.sans],
                poppins: ['Poppins', ...defaultTheme.fontFamily.sans],
                montserrat: ['Montserrat', ...defaultTheme.fontFamily.sans],
            },
            colors: {
                'nextjob-black': '#1A1A1A',
                'nextjob-white': '#FFFFFF',
                'nextjob-cream': '#F4F4F4',
                'nextjob-light-gray': '#CCCCCC',
                'nextjob-dark-gray': '#333333',
                'nextjob-red': '#FF6B6B',
                'nextjob-blue': '#1E90FF',
                'nextjob-green': '#32CD32',
                'nextjob-orange': '#FFA500',
                'nextjob-purple': '#800080',
                'nextjob-yellow': '#FFC107',
                'nextjob-blue-light': '#F0F7FF',
                'nextjob-blue-dark': '#125699'
            },
            maxWidth: {
                '8xl': '90rem',
            },
        },
    },

    plugins: [forms],
};
