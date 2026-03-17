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
            colors: {
                colegioAzul: '#046bd2',
                colegioAzulClaro: '#1e88e5',
                colegioVerde: '#1b9e77',
                colegioVerdeClaro: '#43a047',
            },
            borderRadius: {
                'xl': '1.5rem',
                '2xl': '2rem',
            },
            boxShadow: {
                'custom': '0 20px 40px rgba(0,0,0,0.08)',
                'custom-hover': '0 20px 35px rgba(0,0,0,0.12)',
            }
        },
    },
    plugins: [forms],
};
