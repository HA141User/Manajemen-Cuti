<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>{{ config('app.name', 'NakCuti') }} - Manajemen Cuti Modern</title>

        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=inter:300,400,600,700,800&display=swap" rel="stylesheet" />

        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="antialiased bg-nordic-light text-nordic-dark font-sans selection:bg-nordic-dark selection:text-white">
        
        <nav class="fixed w-full z-50 bg-nordic-light/90 backdrop-blur-md border-b border-nordic-mute">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="flex justify-between items-center h-20">
                    <div class="flex items-center">
                        <x-application-logo class="w-10 h-10 fill-current text-nordic-dark" />
                        <span class="ml-3 text-xl font-bold tracking-tight text-nordic-dark">NakCuti</span>
                    </div>

                    <div class="flex items-center space-x-4">
                        @if (Route::has('login'))
                            @auth
                                <a href="{{ url('/dashboard') }}" class="text-sm font-semibold text-nordic-dark hover:text-nordic-gray transition">Dashboard</a>
                            @else
                                <a href="{{ route('login') }}" class="text-sm font-semibold text-nordic-dark hover:text-nordic-gray transition">Log in</a>
                                
                                {{-- Jika registrasi dibuka --}}
                                {{-- <a href="{{ route('register') }}" class="px-5 py-2.5 bg-nordic-dark text-white text-sm font-semibold rounded-full hover:bg-black transition shadow-lg">Daftar</a> --}}
                            @endauth
                        @endif
                    </div>
                </div>
            </div>
        </nav>

        <section class="pt-32 pb-20 overflow-hidden">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center relative z-10">
                
                <span class="inline-block py-1 px-3 rounded-full bg-indigo-50 text-indigo-700 text-xs font-bold uppercase tracking-wider mb-6 border border-indigo-100">
                    Sistem Manajemen SDM v1.0
                </span>
                
                <h1 class="text-5xl md:text-6xl font-extrabold text-nordic-dark tracking-tight mb-6 leading-tight">
                    Kelola Cuti Karyawan,<br>
                    <span class="text-transparent bg-clip-text bg-gradient-to-r from-nordic-gray to-nordic-dark">Tanpa Birokrasi Rumit.</span>
                </h1>
                
                <p class="mt-4 text-xl text-nordic-gray max-w-2xl mx-auto mb-10">
                    Platform digital terintegrasi untuk pengajuan, verifikasi, dan pelaporan cuti. Hemat waktu, transparan, dan akurat.
                </p>

                <div class="flex justify-center gap-4">
                    <a href="{{ route('login') }}" class="px-8 py-4 bg-nordic-dark text-white text-base font-bold rounded-xl shadow-xl hover:bg-black hover:-translate-y-1 transition transform duration-200">
                        Akses Aplikasi &rarr;
                    </a>
                </div>

            </div>

            <div class="mt-16 max-w-5xl mx-auto px-4 sm:px-6 lg:px-8 relative">
                <div class="absolute inset-0 bg-gradient-to-t from-nordic-light via-transparent to-transparent z-10 h-full w-full"></div>
                
                <div class="bg-white rounded-2xl shadow-2xl border border-nordic-mute p-2 transform rotate-x-12 perspective-1000">
                    <div class="bg-nordic-light rounded-xl overflow-hidden border border-nordic-mute">
                        <div class="h-8 bg-white border-b border-nordic-mute flex items-center px-4 space-x-2">
                            <div class="w-3 h-3 rounded-full bg-rose-400"></div>
                            <div class="w-3 h-3 rounded-full bg-amber-400"></div>
                            <div class="w-3 h-3 rounded-full bg-emerald-400"></div>
                        </div>
                        <div class="p-8 grid grid-cols-1 md:grid-cols-3 gap-6 opacity-80 select-none">
                            <div class="col-span-2 space-y-4">
                                <div class="h-32 bg-white rounded-xl shadow-sm border border-nordic-mute p-6 flex flex-col justify-between">
                                    <div class="h-4 w-1/3 bg-nordic-mute rounded"></div>
                                    <div class="h-8 w-1/2 bg-nordic-gray/20 rounded"></div>
                                </div>
                                <div class="h-64 bg-white rounded-xl shadow-sm border border-nordic-mute"></div>
                            </div>
                            <div class="col-span-1 space-y-4">
                                <div class="h-24 bg-indigo-50 rounded-xl border border-indigo-100"></div>
                                <div class="h-24 bg-emerald-50 rounded-xl border border-emerald-100"></div>
                                <div class="h-40 bg-white rounded-xl border border-nordic-mute"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <section class="py-20 bg-white border-t border-nordic-mute">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="grid grid-cols-1 md:grid-cols-3 gap-12">
                    
                    <div class="text-left">
                        <div class="w-12 h-12 bg-indigo-100 rounded-xl flex items-center justify-center text-indigo-700 mb-6">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                        </div>
                        <h3 class="text-xl font-bold text-nordic-dark mb-2">Persetujuan Cepat</h3>
                        <p class="text-nordic-gray leading-relaxed">
                            Alur persetujuan berjenjang dari Leader hingga HRD dengan notifikasi status real-time. Tidak ada lagi formulir kertas yang hilang.
                        </p>
                    </div>

                    <div class="text-left">
                        <div class="w-12 h-12 bg-emerald-100 rounded-xl flex items-center justify-center text-emerald-700 mb-6">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                        </div>
                        <h3 class="text-xl font-bold text-nordic-dark mb-2">Validasi Otomatis</h3>
                        <p class="text-nordic-gray leading-relaxed">
                            Sistem otomatis menghitung hari kerja, memotong tanggal merah, dan memvalidasi sisa kuota cuti tahunan karyawan.
                        </p>
                    </div>

                    <div class="text-left">
                        <div class="w-12 h-12 bg-rose-100 rounded-xl flex items-center justify-center text-rose-700 mb-6">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z"></path></svg>
                        </div>
                        <h3 class="text-xl font-bold text-nordic-dark mb-2">Surat Cuti Digital</h3>
                        <p class="text-nordic-gray leading-relaxed">
                            Generate surat izin cuti resmi dalam format PDF dengan satu klik setelah pengajuan disetujui sepenuhnya oleh HRD.
                        </p>
                    </div>

                </div>
            </div>
        </section>

        <footer class="bg-nordic-light py-10 border-t border-nordic-mute">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 flex flex-col md:flex-row justify-between items-center">
                <div class="mb-4 md:mb-0">
                    <span class="font-bold text-nordic-dark text-lg">NakCuti</span>
                    <span class="text-nordic-gray text-sm ml-2">© 2024</span>
                </div>
                <div class="text-sm text-nordic-gray">
                    Dibuat dengan Laravel & Tailwind CSS
                </div>
            </div>
        </footer>

    </body>
</html>