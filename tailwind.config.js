import defaultTheme from 'tailwindcss/defaultTheme';
import forms from '@tailwindcss/forms';

/** @type {import('tailwindcss').Config} */
export default {
    content: [
        './vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php',
        './storage/framework/views/*.php',
        './resources/views/**/*.blade.php',
        './resources/js/**/*.js',
    ],

    theme: {
        extend: {
            colors: {
                'bovi-green': {
                    25:  '#f9fdf9',
                    50:  '#f0f7f0',
                    100: '#e8f5e9',
                    200: '#d4edda',
                    300: '#a8d5b8',
                    400: '#6bb380',
                    500: '#4a9960',
                    600: '#3E7C47',
                    700: '#2F6038',
                    800: '#1F4D2B',
                    900: '#163d20',
                    950: '#0F2A17',
                },
                'bovi-brown': {
                    50:  '#faf6f1',
                    100: '#f5f0eb',
                    200: '#e8ddd0',
                    300: '#D4A574',
                    400: '#c4956a',
                    500: '#a07a5a',
                    600: '#8B6B4E',
                    700: '#7a5d44',
                    800: '#6B5440',
                    900: '#5a4636',
                },
                'bovi-beige': {
                    50:  '#f5f0eb',
                    100: '#F4EFE6',
                    200: '#E8DED0',
                    300: '#D4C5B0',
                    400: '#c4b49a',
                },
                'bovi-dark': '#2B2B2B',
            },
            fontFamily: {
                sans: ['Figtree', ...defaultTheme.fontFamily.sans],
            },
            boxShadow: {
                'bovi':    '0 4px 14px -3px rgba(31, 77, 43, 0.15)',
                'bovi-lg': '0 10px 25px -5px rgba(31, 77, 43, 0.2)',
                'bovi-xl': '0 20px 40px -10px rgba(31, 77, 43, 0.25)',
                '3xl':     '0 35px 60px -15px rgba(0, 0, 0, 0.3)',
            },
            animation: {
                'fade-in':      'fadeIn 0.5s ease-out',
                'fade-in-up':   'fadeInUp 0.5s ease-out',
                'slide-down':   'slideDown 0.3s ease-out',
                'check-bounce': 'checkBounce 0.3s ease-in-out',
                'pulse-slow':   'pulse 3s cubic-bezier(0.4, 0, 0.6, 1) infinite',
            },
            keyframes: {
                fadeIn: {
                    '0%':   { opacity: '0' },
                    '100%': { opacity: '1' },
                },
                fadeInUp: {
                    '0%':   { opacity: '0', transform: 'translateY(20px)' },
                    '100%': { opacity: '1', transform: 'translateY(0)' },
                },
                slideDown: {
                    '0%':   { opacity: '0', transform: 'translateY(-10px)' },
                    '100%': { opacity: '1', transform: 'translateY(0)' },
                },
                checkBounce: {
                    '0%, 100%': { transform: 'scale(1)' },
                    '50%':      { transform: 'scale(1.2)' },
                },
            },
            backgroundImage: {
                'gradient-bovi-green':   'linear-gradient(to right, #1F4D2B, #3E7C47)',
                'gradient-bovi-brown':   'linear-gradient(to right, #8B6B4E, #6B5440)',
                'gradient-bovi-amber':   'linear-gradient(to right, #d97706, #b45309)',
                'gradient-bovi-green-v': 'linear-gradient(to bottom right, #1F4D2B, #3E7C47)',
                'gradient-bovi-body':    'linear-gradient(to bottom right, #F4EFE6, #E8DED0, #F4EFE6)',
            },
        },
    },

    plugins: [forms],
};
