<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'NakCuti') }}</title>

        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=inter:400,500,600,700&display=swap" rel="stylesheet" />

        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="font-sans antialiased text-nordic-dark bg-nordic-light">
        
        <div class="min-h-screen flex">
            
            <div class="hidden lg:flex lg:w-1/2 bg-nordic-dark items-center justify-center relative overflow-hidden">
                <div class="absolute top-0 left-0 w-64 h-64 bg-white opacity-5 rounded-full -translate-x-1/2 -translate-y-1/2 filter blur-3xl"></div>
                <div class="absolute bottom-0 right-0 w-96 h-96 bg-nordic-gray opacity-10 rounded-full translate-x-1/3 translate-y-1/3 filter blur-3xl"></div>

                <div class="z-10 text-center px-12">
                    <div class="mb-8 flex justify-center">
                        <svg class="w-24 h-24 text-white fill-current" viewBox="0 0 317 48" xmlns="http://www.w3.org/2000/svg">
                            <path d="M16 4C9.3 4 4 9.3 4 16s5.3 12 12 12 12-5.3 12-12S22.7 4 16 4zm0 20c-4.4 0-8-3.6-8-8s3.6-8 8-8 8 3.6 8 8-3.6 8-8 8z"/>
                            <rect x="40" y="4" width="24" height="24" rx="4" fill="currentColor"/>
                            <rect x="72" y="14" width="24" height="24" rx="4" fill="currentColor"/>
                        </svg>
                    </div>
                    <h2 class="text-4xl font-bold text-white mb-4 tracking-tight">NakCuti System</h2>
                    <p class="text-nordic-mute text-lg leading-relaxed">
                        "Efisiensi manajemen SDM dimulai dari pengelolaan waktu istirahat yang terorganisir. Kelola cuti tim Anda dengan lebih profesional."
                    </p>
                </div>
            </div>

            <div class="w-full lg:w-1/2 flex items-center justify-center p-8 bg-nordic-light">
                <div class="w-full max-w-md space-y-8">
                    
                    <div class="lg:hidden text-center">
                        <x-application-logo class="w-16 h-16 mx-auto text-nordic-dark fill-current" />
                        <h2 class="mt-4 text-2xl font-bold text-nordic-dark">Selamat Datang Kembali</h2>
                    </div>

                    <div class="bg-white p-8 rounded-2xl shadow-xl border border-nordic-mute">
                        {{ $slot }}
                    </div>

                    <div class="text-center text-sm text-nordic-gray">
                        &copy; {{ date('Y') }} PT. Maju Mundur Jaya. All rights reserved.
                    </div>
                </div>
            </div>

        </div>
    </body>
</html>