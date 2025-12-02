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
                sans: ['Inter', ...defaultTheme.fontFamily.sans],
            },
            colors: {
                // PALET WARNA PILIHAN ANDA: "Nordic Slate"
                nordic: {
                    light: '#F0F5F9',  // Main Background
                    mute:  '#C9D6DF',  // Borders / Secondary Backgrounds
                    gray:  '#52616B',  // Subtext / Secondary Text
                    dark:  '#1E2022',  // Headings / Primary Buttons
                },
                // Kita tetap butuh warna status (Hijau/Merah) untuk Approved/Rejected
                // Menggunakan default Tailwind colors untuk status agar tetap intuitif
            }
        },
    },

    plugins: [forms],
};