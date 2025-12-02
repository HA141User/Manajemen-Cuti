<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-nordic-dark leading-tight">
            {{ __('Admin Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            
            <div class="bg-gradient-to-r from-nordic-dark to-slate-800 rounded-2xl p-6 text-white shadow-lg">
                <h3 class="text-xl font-bold">Selamat Datang, Administrator!</h3>
                <p class="text-sm text-gray-300 mt-1">Berikut adalah ringkasan data sistem manajemen cuti hari ini.</p>
            </div>
            
            <div class="grid grid-cols-1 md:grid-cols-4 gap-6">
                <div class="card">
                    <div class="text-nordic-gray text-xs font-bold uppercase tracking-wider">Total Karyawan</div>
                    <div class="mt-2 flex items-end justify-between">
                        <span class="text-3xl font-bold text-nordic-dark">{{ $totalEmployees }}</span>
                        <div class="text-xs text-right">
                            <span class="block text-emerald-600 font-bold">{{ $activeEmployees }} Aktif</span>
                            <span class="block text-rose-500">{{ $inactiveEmployees }} Non-Aktif</span>
                        </div>
                    </div>
                </div>

                <div class="card">
                    <div class="text-nordic-gray text-xs font-bold uppercase tracking-wider">Total Divisi</div>
                    <div class="mt-2 flex items-end justify-between">
                        <span class="text-3xl font-bold text-nordic-dark">{{ $totalDivisions }}</span>
                        <a href="{{ route('admin.divisions.index') }}" class="text-xs text-blue-600 hover:underline">Lihat Detail &rarr;</a>
                    </div>
                </div>

                <div class="card">
                    <div class="text-nordic-gray text-xs font-bold uppercase tracking-wider">Cuti Bulan Ini</div>
                    <div class="mt-2 flex items-end">
                        <span class="text-3xl font-bold text-emerald-600">{{ $leavesThisMonth }}</span>
                        <span class="text-xs text-nordic-gray ml-2 mb-1">Approved</span>
                    </div>
                </div>

                <div class="card border-l-4 border-l-yellow-400">
                    <div class="text-nordic-gray text-xs font-bold uppercase tracking-wider">Pending Approval</div>
                    <div class="mt-2 flex items-end">
                        <span class="text-3xl font-bold text-yellow-600">{{ $pendingApprovals }}</span>
                        <span class="text-xs text-nordic-gray ml-2 mb-1">Request</span>
                    </div>
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <div class="md:col-span-2 card">
                    <div class="flex justify-between items-center mb-6">
                        <h3 class="text-lg font-bold text-nordic-dark">Karyawan Baru (< 1 Tahun)</h3>
                        <a href="{{ route('admin.users.index') }}" class="text-sm text-blue-600 hover:underline font-medium">Lihat Semua</a>
                    </div>
                    
                    <div class="overflow-x-auto">
                        <table class="w-full text-left text-sm text-nordic-gray">
                            <thead class="bg-nordic-light text-nordic-dark font-semibold uppercase text-xs">
                                <tr>
                                    <th class="px-4 py-3 rounded-l-lg">Nama</th>
                                    <th class="px-4 py-3">Divisi</th>
                                    <th class="px-4 py-3 rounded-r-lg">Bergabung</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-nordic-mute">
                                @forelse($probationEmployees as $emp)
                                <tr class="hover:bg-nordic-light/50 transition">
                                    <td class="px-4 py-3">
                                        <div class="font-bold text-nordic-dark">{{ $emp->name }}</div>
                                        <div class="text-xs">{{ $emp->email }}</div>
                                    </td>
                                    <td class="px-4 py-3">
                                        @if($emp->division)
                                            <span class="badge bg-blue-50 text-blue-700 border border-blue-100">
                                                {{ $emp->division->name }}
                                            </span>
                                        @else
                                            <span class="text-xs text-gray-400 italic">-</span>
                                        @endif
                                    </td>
                                    <td class="px-4 py-3">
                                        <div class="text-nordic-dark">{{ $emp->join_date ? $emp->join_date->format('d M Y') : '-' }}</div>
                                        <div class="text-xs text-emerald-600 font-medium">
                                            {{ $emp->join_date ? $emp->join_date->diffForHumans() : '' }}
                                        </div>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="3" class="px-4 py-6 text-center italic text-gray-400">Tidak ada karyawan baru.</td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>

                <div class="card">
                    <h3 class="text-lg font-bold text-nordic-dark mb-4">Aksi Cepat</h3>
                    <div class="space-y-3">
                        <a href="{{ route('admin.users.create') }}" class="group flex items-center justify-between p-3 rounded-lg border border-nordic-mute hover:border-nordic-dark hover:shadow-md transition">
                            <span class="text-sm font-medium text-nordic-dark group-hover:text-black">+ Tambah Karyawan</span>
                            <span class="text-nordic-mute group-hover:text-nordic-dark transition">&rarr;</span>
                        </a>
                        <a href="{{ route('admin.divisions.create') }}" class="group flex items-center justify-between p-3 rounded-lg border border-nordic-mute hover:border-nordic-dark hover:shadow-md transition">
                            <span class="text-sm font-medium text-nordic-dark group-hover:text-black">+ Buat Divisi Baru</span>
                            <span class="text-nordic-mute group-hover:text-nordic-dark transition">&rarr;</span>
                        </a>
                        <a href="{{ route('admin.holidays.index') }}" class="group flex items-center justify-between p-3 rounded-lg border border-nordic-mute hover:border-nordic-dark hover:shadow-md transition">
                            <span class="text-sm font-medium text-nordic-dark group-hover:text-black">Atur Hari Libur</span>
                            <span class="text-nordic-mute group-hover:text-nordic-dark transition">&rarr;</span>
                        </a>
                        <a href="{{ route('admin.users.index') }}" class="group flex items-center justify-between p-3 rounded-lg border border-nordic-mute hover:border-nordic-dark hover:shadow-md transition">
                            <span class="text-sm font-medium text-nordic-dark group-hover:text-black">Kelola User</span>
                            <span class="text-nordic-mute group-hover:text-nordic-dark transition">&rarr;</span>
                        </a>
                    </div>

                    <div class="mt-8 pt-4 border-t border-nordic-mute text-center">
                        <p class="text-xs text-nordic-gray">Server Time: {{ now()->format('H:i') }}</p>
                        <p class="text-xs text-nordic-gray font-mono mt-1">v1.0.0 Stable</p>
                    </div>
                </div>
            </div>

        </div>
    </div>
</x-app-layout>