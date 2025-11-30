<x-app-layout>
    <x-slot name="header">
        <h2 class="font-bold text-xl text-primary leading-tight">
            {{ __('Admin Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12 bg-cream/30 min-h-screen">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            
            <div class="bg-primary rounded-3xl shadow-xl p-8 text-cream mb-10 relative overflow-hidden group">
                <div class="relative z-10">
                    <div class="flex items-center gap-3 mb-2">
                        <div class="p-2 bg-accent/20 rounded-lg">
                            <svg class="w-6 h-6 text-accent" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 3v4M3 5h4M6 17v4m-2-2h4m5-16l2.286 6.857L21 12l-5.714 2.143L13 21l-2.286-6.857L5 12l5.714-2.143L13 3z"></path></svg>
                        </div>
                        <h3 class="text-3xl font-bold tracking-tight">Selamat Datang, Administrator!</h3>
                    </div>
                    <p class="opacity-80 text-lg font-light max-w-2xl">
                        Pantau aktivitas kepegawaian dengan nuansa yang lebih tenang dan terorganisir hari ini.
                    </p>
                </div>
                
                <div class="absolute right-0 top-0 h-full w-1/3 bg-gradient-to-l from-secondary/20 to-transparent pointer-events-none"></div>
                <div class="absolute -bottom-10 -right-10 w-64 h-64 bg-accent/10 rounded-full blur-3xl group-hover:bg-accent/20 transition duration-700"></div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-10">
                
                <div class="bg-paper p-6 rounded-2xl shadow-[0_4px_20px_rgb(0,0,0,0.05)] border border-cream hover:border-accent/50 transition duration-300 group">
                    <div class="flex justify-between items-start mb-4">
                        <div class="p-3 bg-cream/50 rounded-xl text-primary group-hover:bg-primary group-hover:text-cream transition">
                            <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
                        </div>
                        <span class="text-xs font-bold uppercase tracking-wider text-accent bg-accent/10 px-2 py-1 rounded-full">Aktif</span>
                    </div>
                    <div>
                        <div class="text-4xl font-extrabold text-primary mb-1">{{ $total_employees }}</div>
                        <div class="text-sm font-medium text-secondary/70">Total Karyawan</div>
                    </div>
                </div>

                <div class="bg-paper p-6 rounded-2xl shadow-[0_4px_20px_rgb(0,0,0,0.05)] border border-cream hover:border-accent/50 transition duration-300 group">
                    <div class="flex justify-between items-start mb-4">
                        <div class="p-3 bg-cream/50 rounded-xl text-primary group-hover:bg-primary group-hover:text-cream transition">
                            <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path></svg>
                        </div>
                        <span class="text-xs font-bold uppercase tracking-wider text-secondary bg-secondary/10 px-2 py-1 rounded-full">Unit</span>
                    </div>
                    <div>
                        <div class="text-4xl font-extrabold text-primary mb-1">{{ $total_divisions }}</div>
                        <div class="text-sm font-medium text-secondary/70">Departemen</div>
                    </div>
                </div>

                <div class="bg-paper p-6 rounded-2xl shadow-[0_4px_20px_rgb(0,0,0,0.05)] border border-cream hover:border-accent/50 transition duration-300 group">
                    <div class="flex justify-between items-start mb-4">
                        <div class="p-3 bg-cream/50 rounded-xl text-primary group-hover:bg-primary group-hover:text-cream transition">
                            <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                        </div>
                        <span class="text-xs font-bold uppercase tracking-wider text-primary bg-primary/10 px-2 py-1 rounded-full">Bulan Ini</span>
                    </div>
                    <div>
                        <div class="text-4xl font-extrabold text-primary mb-1">{{ $total_leave_requests_month }}</div>
                        <div class="text-sm font-medium text-secondary/70">Pengajuan Masuk</div>
                    </div>
                </div>

                <div class="bg-primary p-6 rounded-2xl shadow-[0_4px_20px_rgb(0,0,0,0.1)] border border-primary relative overflow-hidden group">
                    <div class="absolute right-0 top-0 p-3 opacity-10">
                        <svg class="w-24 h-24" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                    </div>
                    <div class="flex justify-between items-start mb-4 relative z-10">
                        <div class="p-3 bg-white/10 rounded-xl text-cream">
                            <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"></path></svg>
                        </div>
                        <span class="text-xs font-bold uppercase tracking-wider text-accent bg-white/90 px-2 py-1 rounded-full">Pending</span>
                    </div>
                    <div class="relative z-10">
                        <div class="text-4xl font-extrabold text-cream mb-1">{{ $pending_approvals }}</div>
                        <div class="text-sm font-medium text-cream/70">Perlu Tindakan</div>
                    </div>
                </div>
            </div>

            <div class="bg-paper rounded-2xl shadow-sm border border-cream overflow-hidden">
                <div class="px-6 py-5 border-b border-cream bg-cream/20 flex justify-between items-center">
                    <div>
                        <h3 class="text-lg font-bold text-primary">Karyawan Baru</h3>
                        <p class="text-xs text-secondary mt-1">Masa kerja < 1 tahun (Belum eligible cuti tahunan)</p>
                    </div>
                    <div class="w-8 h-8 rounded-full bg-cream flex items-center justify-center text-secondary">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path></svg>
                    </div>
                </div>
                
                <div class="p-0">
                    @if($new_employees->isEmpty())
                        <div class="flex flex-col items-center justify-center py-12 text-secondary/50">
                            <svg class="w-12 h-12 mb-3 opacity-50" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                            <p class="font-medium">Semua data karyawan eligible.</p>
                        </div>
                    @else
                        <div class="overflow-x-auto">
                            <table class="min-w-full text-left">
                                <thead class="bg-cream/20 text-secondary uppercase text-xs tracking-wider font-semibold">
                                    <tr>
                                        <th class="px-6 py-4">Nama Karyawan</th>
                                        <th class="px-6 py-4">Bergabung Sejak</th>
                                        <th class="px-6 py-4">Status</th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-cream">
                                    @foreach($new_employees as $emp)
                                    <tr class="hover:bg-cream/10 transition">
                                        <td class="px-6 py-4">
                                            <div class="flex items-center">
                                                <div class="h-9 w-9 rounded-xl bg-primary text-cream flex items-center justify-center font-bold text-xs mr-3 shadow-sm">
                                                    {{ substr($emp->name, 0, 1) }}
                                                </div>
                                                <div>
                                                    <div class="font-bold text-primary">{{ $emp->name }}</div>
                                                    <div class="text-xs text-secondary">{{ $emp->email }}</div>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="px-6 py-4 text-sm text-secondary">
                                            {{ \Carbon\Carbon::parse($emp->join_date)->translatedFormat('d F Y') }}
                                        </td>
                                        <td class="px-6 py-4">
                                            <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-bold bg-cream text-secondary border border-secondary/20">
                                                Probation
                                            </span>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @endif
                </div>
            </div>

        </div>
    </div>
</x-app-layout>