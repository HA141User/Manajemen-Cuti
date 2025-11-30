<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'TalentFlow') }}</title>

        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
        
        <style>
            body { font-family: 'Plus Jakarta Sans', sans-serif !important; }
        </style>

        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="font-sans antialiased text-primary">
        
        <div class="min-h-screen bg-cream/30">
            
            @include('layouts.navigation')

            @isset($header)
                <header class="bg-transparent pt-8 pb-2">
                    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                        {{ $header }}
                    </div>
                </header>
            @endisset

            <main>
                {{ $slot }}
            </main>
        </div>

        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

        <script>
            // Passing Data Session ke JS (Safe Way)
            const sessionSuccess = @json(session('success'));
            const sessionError   = @json(session('error'));

            if (sessionSuccess) {
                Swal.fire({
                    icon: 'success',
                    title: 'Berhasil!',
                    text: sessionSuccess,
                    timer: 3000,
                    showConfirmButton: false,
                    background: '#FDFCF8', // Paper color
                    iconColor: '#2C3930',  // Primary color
                    color: '#2C3930'
                });
            }

            if (sessionError) {
                Swal.fire({
                    icon: 'error',
                    title: 'Gagal!',
                    text: sessionError,
                    background: '#FDFCF8',
                    confirmButtonColor: '#A27B5C' // Accent color
                });
            }

            // Fungsi Global Konfirmasi Hapus
            window.confirmDelete = function(formId) {
                Swal.fire({
                    title: 'Apakah Anda Yakin?',
                    text: "Data yang dihapus tidak dapat dikembalikan!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#d33', // Merah tetap merah untuk danger
                    cancelButtonColor: '#3F4F44', // Secondary color
                    confirmButtonText: 'Ya, Hapus!',
                    cancelButtonText: 'Batal',
                    background: '#FDFCF8',
                    color: '#2C3930'
                }).then((result) => {
                    if (result.isConfirmed) {
                        if (typeof formId === 'string') {
                            document.getElementById(formId).submit();
                        } else {
                            formId.closest('form').submit();
                        }
                    }
                });
            };
        </script>
    </body>
</html>