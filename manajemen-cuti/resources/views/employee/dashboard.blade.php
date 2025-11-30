<x-app-layout>
    <x-slot name="header">
        <h2 class="font-bold text-xl sm:text-2xl text-primary leading-tight px-4 sm:px-0">
            {{ __('Dashboard Karyawan') }}
        </h2>
    </x-slot>

    <div class="py-6 sm:py-10">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            
            <div class="bg-primary rounded-3xl shadow-xl p-6 sm:p-10 text-cream mb-8 relative overflow-hidden group">
                <div class="relative z-10">
                    <div class="flex items-center gap-2 mb-2">
                        <span class="px-3 py-1 bg-white/10 rounded-full text-[10px] sm:text-xs font-bold uppercase tracking-wider text-accent border border-white/10">
                            Employee Panel
                        </span>
                    </div>
                    <h3 class="text-2xl sm:text-4xl font-extrabold tracking-tight mb-4 text-white">
                        Halo, {{ Auth::user()->name }}! 👋
                    </h3>
                    
                    <div class="inline-flex flex-col sm:flex-row gap-3 sm:gap-4">
                        <div class="flex items-center gap-3 bg-black/20 px-4 py-2 rounded-xl backdrop-blur-sm border border-white/5">
                            <div class="p-1.5 bg-accent/20 rounded-lg">
                                <svg class="w-4 h-4 text-accent" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path></svg>
                            </div>
                            <div class="flex flex-col">
                                <span class="text-[10px] uppercase text-white/50 font-bold tracking-wider">Divisi</span>
                                <span class="text-sm font-bold text-white">{{ $division_name }}</span>
                            </div>
                        </div>

                        <div class="flex items-center gap-3 bg-black/20 px-4 py-2 rounded-xl backdrop-blur-sm border border-white/5">
                            <div class="p-1.5 bg-accent/20 rounded-lg">
                                <svg class="w-4 h-4 text-accent" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
                            </div>
                            <div class="flex flex-col">
                                <span class="text-[10px] uppercase text-white/50 font-bold tracking-wider">Manager</span>
                                <span class="text-sm font-bold text-white">{{ $manager_name }}</span>
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="absolute right-0 top-0 h-full w-1/2 bg-gradient-to-l from-secondary/40 to-transparent pointer-events-none"></div>
                <div class="absolute -bottom-10 -right-10 w-64 h-64 bg-accent/10 rounded-full blur-3xl"></div>
                <div class="absolute top-10 right-20 w-32 h-32 bg-white/5 rounded-full blur-2xl"></div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-10 items-stretch">
                
                <div class="bg-paper p-6 sm:p-8 rounded-[2rem] shadow-[0_8px_30px_rgb(0,0,0,0.04)] border border-cream hover:border-accent/50 transition duration-300 h-full flex flex-col justify-between group">
                    <div>
                        <div class="flex justify-between items-start mb-4">
                            <div class="p-3 bg-primary/10 rounded-2xl text-primary group-hover:bg-primary group-hover:text-cream transition">
                                <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                            </div>
                            <span class="inline-flex items-center px-2 py-1 rounded-lg bg-cream/50 border border-cream text-[10px] font-bold text-primary">
                                Reset: Jan {{ date('Y') + 1 }}
                            </span>
                        </div>
                        
                        <div class="text-xs font-bold uppercase tracking-wider text-secondary mb-1">Sisa Kuota Tahunan</div>
                        <div class="flex items-baseline gap-2">
                            <span class="text-4xl sm:text-5xl font-extrabold text-primary">{{ $quota_remaining }}</span>
                            <span class="text-base font-bold text-secondary/60">Hari</span>
                        </div>
                    </div>
                </div>

                <div class="bg-paper p-6 sm:p-8 rounded-[2rem] shadow-[0_8px_30px_rgb(0,0,0,0.04)] border border-cream hover:border-accent/50 transition duration-300 h-full flex flex-col justify-between group">
                    <div>
                        <div class="flex justify-between items-start mb-4">
                            <div class="p-3 bg-red-50 rounded-2xl text-red-600 group-hover:bg-red-100 transition">
                                <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"></path></svg>
                            </div>
                        </div>
                        <div class="text-xs font-bold uppercase tracking-wider text-secondary mb-1">Total Cuti Sakit</div>
                        <div class="flex items-baseline gap-2">
                            <span class="text-4xl sm:text-5xl font-extrabold text-primary">{{ $sick_leave_count }}</span>
                            <span class="text-base font-bold text-secondary/60">Kali</span>
                        </div>
                    </div>
                </div>

                <div class="bg-paper p-6 sm:p-8 rounded-[2rem] shadow-[0_8px_30px_rgb(0,0,0,0.04)] border border-cream hover:border-accent/50 transition duration-300 h-full flex flex-col justify-between group">
                    <div>
                        <div class="flex justify-between items-start mb-4">
                            <div class="p-3 bg-blue-50 rounded-2xl text-blue-600 group-hover:bg-blue-100 transition">
                                <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"></path></svg>
                            </div>
                        </div>
                        <div class="text-xs font-bold uppercase tracking-wider text-secondary mb-1">Riwayat Pengajuan</div>
                        <div class="flex items-baseline gap-2">
                            <span class="text-4xl sm:text-5xl font-extrabold text-primary">{{ $total_requests }}</span>
                            <span class="text-base font-bold text-secondary/60">Pengajuan</span>
                        </div>
                    </div>
                </div>
            </div>

            <div class="flex justify-end">
                <a href="{{ route('leaves.create') }}" class="group relative inline-flex items-center justify-center px-8 py-4 bg-accent text-white font-bold text-lg rounded-2xl shadow-lg hover:shadow-xl hover:bg-[#8e6a4e] transition duration-300 transform hover:-translate-y-1 w-full sm:w-auto">
                    <svg class="w-6 h-6 mr-3 group-hover:rotate-90 transition duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                    <span>Buat Pengajuan Cuti Baru</span>
                </a>
            </div>

        </div>
    </div>
</x-app-layout>