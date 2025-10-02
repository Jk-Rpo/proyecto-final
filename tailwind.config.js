import defaultTheme from 'tailwindcss/defaultTheme';
import forms from '@tailwindcss/forms';

/** @type {import('tailwindcss').Config} */
export default {
    content: [
        './vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php',
        './storage/framework/views/*.php',
        './resources/views/**/*.blade.php',
        './resources/js/**/*.vue',
    ],

    theme: {
        extend: {
            fontFamily: {
                sans: ['Figtree', ...defaultTheme.fontFamily.sans],
            },
            colors: {
                gray: {
                    DEFAULT: '#212121',
                    2: '#666666',
                    3: '#A1A1A1',
                    4: '#FAFAFA',
                    darker: '#606f7b',
                    darkest: '#3d4852',
                    light: '#dae1e7',
                    lighter: '#f1f5f8',
                },
                transparent: 'transparent',
                primary: {
                    DEFAULT: '#1A237E',
                    2: '#9FA8DA',
                    3: '#E8EAF6',
                },
                secondary: {
                    DEFAULT: '#DE1C7D',
                    2: '#D65595',
                    3: '#FFFBFC',
                    4: '#FCE4EC',
                },
                success: {
                    DEFAULT: '#8BC34A',
                    2: '#C5E1A5',
                    3: '#F1F8E9',
                },
                info: {
                    DEFAULT: '#2196F3',
                    2: '#90CAF9',
                    3: '#E3F2FD',
                },
                warning: {
                    DEFAULT: '#FF8F00',
                    2: '#FFD54F',
                    3: '#FFF8E1',
                },
                danger: {
                    DEFAULT: '#F44336',
                    2: '#E57373',
                    3: '#FFCDD2',
                },
            },
        },
    },

    plugins: [
        forms,
        function ({ addComponents }) {
            addComponents({
                '.container': {
                    maxWidth: '100%',
                    margin: '0 auto',
                    '@screen lg': {
                        maxWidth: '1240px',
                    },
                },
            });
        },
    ],
};
