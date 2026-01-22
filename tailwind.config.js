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
            },
            colors: {
                'helarisi': {
                    'maroon': '#8B1538',
                    'orange': '#F39C12',
                    'teal': '#16a34a',
                    'teal-dark': '#065f46',
                },
            },
        },
    },

    plugins: [forms],
};
