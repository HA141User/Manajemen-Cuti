import defaultTheme from 'tailwindcss/defaultTheme';
import forms from '@tailwindcss/forms';

/** @type {import('tailwindcss').Config} */
export default {
    darkMode: 'class', // Pastikan ini tetap 'class' agar Light Mode prioritas

    content: [
        './vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php',
        './storage/framework/views/*.php',
        './resources/views/**/*.blade.php',
    ],

    theme: {
        extend: {
            fontFamily: {
                sans: ['Plus Jakarta Sans', ...defaultTheme.fontFamily.sans], // Kita pakai font modern
            },
            // DAFTARKAN PALET WARNA BARU DI SINI
            colors: {
                primary: '#2C3930',   // Dark Forest (Untuk Navbar, Heading, Footer)
                secondary: '#3F4F44', // Moss Green (Untuk Subheading, Border)
                accent: '#A27B5C',    // Bronze/Brown (Untuk Tombol Utama/CTA)
                cream: '#DCD7C9',     // Beige (Untuk Background Halaman)
                paper: '#FDFCF8',     // Putih gading (Untuk Card/Kontainer biar kontras dengan cream)
            },
        },
    },

    plugins: [forms],
};