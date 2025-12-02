<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-nordic-dark leading-tight">
            {{ __('Dashboard Karyawan') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            
            <div class="card flex flex-col md:flex-row justify-between items-center bg-white border-l-4 border-l-nordic-dark">
                <div class="mb-4 md:mb-0">
                    <h3 class="text-xl font-bold text-nordic-dark">Halo, {{ $user->name }}!</h3>
                    <p class="text-sm text-nordic-gray mt-1">
                        <span class="font-medium">Divisi:</span> {{ $user->division ? $user->division->name : '-' }} 
                        <span class="mx-2 text-nordic-mute">|</span>
                        <span class="font-medium">Ketua:</span> {{ $user->division && $user->division->leader ? $user->division->leader->name : '-' }}
                    </p>
                </div>
                
                <div class="flex space-x-3">
                    <a href="{{ route('leaves.index') }}" class="btn-secondary">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"></path></svg>
                        Riwayat
                    </a>
                    <a href="{{ route('leaves.create') }}" class="btn-primary">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                        Ajukan Cuti
                    </a>
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-4 gap-6">
                <div class="card relative overflow-hidden group hover:-translate-y-1 transition-transform duration-300">
                    <div class="absolute right-0 top-0 p-4 opacity-10">
                        <svg class="w-24 h-24 text-nordic-dark" fill="currentColor" viewBox="0 0 20 20"><path d="M10 2a6 6 0 00-6 6v3.586l-.707.707A1 1 0 004 14h12a1 1 0 00.707-1.707L16 11.586V8a6 6 0 00-6-6zM10 18a3 3 0 01-3-3h6a3 3 0 01-3 3z"/></svg>
                    </div>
                    <div class="text-nordic-gray text-sm font-medium uppercase tracking-wider">Sisa Kuota</div>
                    <div class="mt-2 flex items-baseline">
                        <span class="text-4xl font-bold text-nordic-dark">{{ $remainingQuota }}</span>
                        <span class="text-sm text-nordic-gray ml-2">/ 12 Hari</span>
                    </div>
                    <div class="mt-4 text-xs font-medium text-emerald-600 bg-emerald-50 px-2 py-1 rounded-full inline-block">
                        Terpakai: {{ $usedQuota }} hari
                    </div>
                </div>

                <div class="card relative overflow-hidden hover:-translate-y-1 transition-transform duration-300">
                    <div class="text-nordic-gray text-sm font-medium uppercase tracking-wider">Cuti Sakit</div>
                    <div class="mt-2 flex items-baseline">
                        <span class="text-4xl font-bold text-rose-600">{{ $sickLeaveCount }}</span>
                        <span class="text-sm text-nordic-gray ml-2">Kali</span>
                    </div>
                    <div class="mt-4 text-xs text-nordic-gray">
                        Tahun ini
                    </div>
                </div>

                <div class="card relative overflow-hidden hover:-translate-y-1 transition-transform duration-300">
                    <div class="text-nordic-gray text-sm font-medium uppercase tracking-wider">Total Riwayat</div>
                    <div class="mt-2 flex items-baseline">
                        <span class="text-4xl font-bold text-blue-600">{{ $totalRequests }}</span>
                        <span class="text-sm text-nordic-gray ml-2">Pengajuan</span>
                    </div>
                    <div class="mt-4 text-xs text-nordic-gray">
                        Seumur akun
                    </div>
                </div>

                <div class="card bg-nordic-dark text-white flex flex-col justify-center items-center text-center">
                    <div class="h-3 w-3 bg-emerald-400 rounded-full animate-pulse mb-2"></div>
                    <div class="text-sm font-bold">Sistem Aktif</div>
                    <div class="text-xs text-gray-400 mt-1">Siap menerima pengajuan</div>
                </div>
            </div>

        </div>
    </div>
</x-app-layout>