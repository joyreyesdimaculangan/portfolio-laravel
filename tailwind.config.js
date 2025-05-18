import defaultTheme from 'tailwindcss/defaultTheme';
import forms from '@tailwindcss/forms';

/** @type {import('tailwindcss').Config} */
export default {
    content: [
        './vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php',
        './storage/framework/views/*.php',
        './resources/views/**/*.blade.php',
        "./resources/**/*.blade.php",
        "./resources/**/*.js",
        "./resources/**/*.vue",
    ],

    theme: {
        extend: {
            fontFamily: {
                sans: ['Figtree', ...defaultTheme.fontFamily.sans],
            },
            colors: {
                'primary': 'var(--color-primary)',
                'primary-50': 'var(--color-primary-50)',
                'primary-100': 'var(--color-primary-100)',
                'primary-200': 'var(--color-primary-200)',
                'primary-300': 'var(--color-primary-300)',
                'primary-400': 'var(--color-primary-400)',
                'primary-500': 'var(--color-primary-500)',
                'primary-600': 'var(--color-primary-600)',
                'primary-700': 'var(--color-primary-700)',
                'primary-800': 'var(--color-primary-800)',
                'primary-900': 'var(--color-primary-900)',
                'secondary': 'var(--color-secondary)',
                'secondary-light': 'var(--color-secondary-light)',
                'secondary-dark': 'var(--color-secondary-dark)',
                'accent': 'var(--color-accent)',
              },
              textColor: {
                'theme': 'var(--color-text)',
                'theme-light': 'var(--color-text-light)',
                'theme-lighter': 'var(--color-text-lighter)',
              },
        },
    },

    plugins: [
        require('@tailwindcss/forms'),
    ],
};
