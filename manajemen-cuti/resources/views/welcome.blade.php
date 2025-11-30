<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="scroll-smooth">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>{{ config('app.name', 'TalentFlow') }}</title>
        
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
        
        <style>body { font-family: 'Plus Jakarta Sans', sans-serif; }</style>

        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="antialiased bg-cream text-primary selection:bg-accent selection:text-white">
        
        <nav class="fixed w-full z-50 transition-all duration-300 bg-primary/95 backdrop-blur-sm border-b border-secondary/30 shadow-lg">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="flex justify-between items-center h-20">
                    <div class="flex-shrink-0 flex items-center gap-3">
                        <div class="w-10 h-10 bg-accent rounded-xl flex items-center justify-center shadow-lg text-white">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path></svg>
                        </div>
                        <span class="font-bold text-2xl tracking-tight text-cream">Talent<span class="text-accent">Flow</span></span>
                    </div>

                    <div class="flex items-center gap-4">
                        @auth
                            <a href="{{ url('/dashboard') }}" class="px-6 py-2.5 text-sm font-bold text-primary bg-cream rounded-full hover:bg-white transition shadow-lg transform hover:-translate-y-0.5">
                                Dashboard
                            </a>
                        @else
                            <a href="{{ route('login') }}" class="group relative px-6 py-2.5 text-sm font-bold text-cream border border-cream/30 rounded-full hover:bg-accent hover:border-accent transition overflow-hidden">
                                <span class="relative z-10">Login Akses</span>
                            </a>
                        @endauth
                    </div>
                </div>
            </div>
        </nav>

        <section class="relative pt-40 pb-20 md:pt-48 md:pb-32 overflow-hidden">
            <div class="absolute top-0 left-1/2 -translate-x-1/2 w-full h-full z-0 pointer-events-none">
                <div class="absolute top-20 left-10 w-72 h-72 bg-accent/10 rounded-full blur-3xl"></div>
                <div class="absolute bottom-10 right-10 w-96 h-96 bg-secondary/10 rounded-full blur-3xl"></div>
            </div>

            <div class="relative z-10 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
                <div class="inline-flex items-center gap-2 px-4 py-2 rounded-full bg-primary/5 border border-primary/10 text-secondary text-xs font-bold uppercase tracking-wider mb-8">
                    <span class="w-2 h-2 rounded-full bg-accent animate-pulse"></span> Sistem Manajemen Cuti 2025
                </div>

                <h1 class="text-5xl md:text-7xl font-extrabold text-primary tracking-tight mb-6 leading-tight">
                    Simplifikasi Birokrasi <br>
                    <span class="text-transparent bg-clip-text bg-gradient-to-r from-accent to-secondary">Kenyamanan Karyawan.</span>
                </h1>

                <p class="text-lg md:text-xl text-secondary/80 max-w-2xl mx-auto mb-10 leading-relaxed">
                    Platform HR modern dengan palet warna yang menenangkan. Kelola cuti, persetujuan, dan administrasi tanpa stres.
                </p>

                <div class="flex flex-col sm:flex-row justify-center gap-4">
                    @auth
                        <a href="{{ url('/dashboard') }}" class="px-8 py-4 text-lg font-bold text-white bg-primary rounded-full hover:bg-secondary transition shadow-xl hover:shadow-2xl hover:-translate-y-1">
                            Kembali ke Dashboard
                        </a>
                    @else
                        <a href="{{ route('login') }}" class="px-8 py-4 text-lg font-bold text-white bg-accent rounded-full hover:bg-[#8e6a4e] transition shadow-xl hover:shadow-2xl hover:-translate-y-1">
                            Mulai Sekarang
                        </a>
                    @endauth
                </div>

                <div class="mt-16 grid grid-cols-2 md:grid-cols-4 gap-6 max-w-4xl mx-auto border-t border-primary/10 pt-10">
                    <div>
                        <div class="text-3xl font-bold text-primary">100%</div>
                        <div class="text-sm text-secondary">Paperless</div>
                    </div>
                    <div>
                        <div class="text-3xl font-bold text-primary">H-3</div>
                        <div class="text-sm text-secondary">Validasi Otomatis</div>
                    </div>
                    <div>
                        <div class="text-3xl font-bold text-primary">24/7</div>
                        <div class="text-sm text-secondary">Akses Sistem</div>
                    </div>
                    <div>
                        <div class="text-3xl font-bold text-primary">PDF</div>
                        <div class="text-sm text-secondary">Surat Resmi</div>
                    </div>
                </div>
            </div>
        </section>

        <section class="py-24 bg-paper rounded-t-[3rem] shadow-[0_-20px_40px_rgba(0,0,0,0.05)] relative z-20">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="text-center mb-16">
                    <h2 class="text-primary text-3xl md:text-4xl font-bold mb-4">Fitur Unggulan</h2>
                    <p class="text-secondary max-w-2xl mx-auto">Dirancang untuk efisiensi Admin, HRD, dan kenyamanan Karyawan.</p>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                    <div class="group p-8 bg-cream/30 rounded-3xl border border-cream hover:border-accent hover:bg-white transition duration-300">
                        <div class="w-14 h-14 bg-primary text-cream rounded-2xl flex items-center justify-center mb-6 shadow-lg group-hover:scale-110 transition">
                            <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                        </div>
                        <h3 class="text-xl font-bold text-primary mb-3">Approval Berjenjang</h3>
                        <p class="text-secondary text-sm leading-relaxed">Dari Manager ke HRD. Alur persetujuan transparan dengan notifikasi real-time.</p>
                    </div>

                    <div class="group p-8 bg-cream/30 rounded-3xl border border-cream hover:border-accent hover:bg-white transition duration-300">
                        <div class="w-14 h-14 bg-accent text-white rounded-2xl flex items-center justify-center mb-6 shadow-lg group-hover:scale-110 transition">
                            <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z"></path></svg>
                        </div>
                        <h3 class="text-xl font-bold text-primary mb-3">Surat Izin Digital</h3>
                        <p class="text-secondary text-sm leading-relaxed">Generate PDF otomatis setelah disetujui. Tidak perlu printer dan kertas lagi.</p>
                    </div>

                    <div class="group p-8 bg-cream/30 rounded-3xl border border-cream hover:border-accent hover:bg-white transition duration-300">
                        <div class="w-14 h-14 bg-secondary text-cream rounded-2xl flex items-center justify-center mb-6 shadow-lg group-hover:scale-110 transition">
                            <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                        </div>
                        <h3 class="text-xl font-bold text-primary mb-3">Validasi Cerdas</h3>
                        <p class="text-secondary text-sm leading-relaxed">Sistem otomatis menolak pengajuan mendadak (H-3) dan mengecualikan hari libur.</p>
                    </div>
                </div>
            </div>
        </section>

        <footer class="bg-primary text-cream py-12 border-t border-secondary/20">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 flex flex-col md:flex-row justify-between items-center gap-6">
                <div class="flex items-center gap-2">
                    <div class="w-8 h-8 bg-accent rounded-lg flex items-center justify-center text-white">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path></svg>
                    </div>
                    <span class="font-bold text-lg">TalentFlow</span>
                </div>
                <div class="text-sm text-secondary/60">
                    &copy; 2025 TalentFlow. Individual Project 8.
                </div>
            </div>
        </footer>

    </body>
</html>