<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-nordic-dark leading-tight">
            {{ __('Dashboard HRD') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <div class="card border-l-4 border-l-yellow-500">
                    <div class="text-nordic-gray text-xs font-bold uppercase tracking-wider">Menunggu Final Approval</div>
                    <div class="mt-2 flex items-center">
                        <span class="text-4xl font-bold text-yellow-600">{{ $pendingFinalApproval }}</span>
                        <span class="ml-3 text-sm font-medium text-nordic-gray">Pengajuan</span>
                    </div>
                    <div class="mt-4">
                        <a href="{{ route('hrd.approvals') }}" class="text-xs font-bold text-yellow-700 hover:underline">Proses Sekarang &rarr;</a>
                    </div>
                </div>

                <div class="card border-l-4 border-l-emerald-500">
                    <div class="text-nordic-gray text-xs font-bold uppercase tracking-wider">Cuti Disetujui (Bulan Ini)</div>
                    <div class="mt-2 flex items-center">
                        <span class="text-4xl font-bold text-emerald-600">{{ $leavesThisMonth }}</span>
                        <span class="ml-3 text-sm font-medium text-nordic-gray">Pengajuan</span>
                    </div>
                </div>

                <div class="card bg-nordic-dark text-white flex flex-col justify-center items-center">
                    <h4 class="font-bold text-lg">Laporan Lengkap</h4>
                    <p class="text-xs text-gray-400 mb-3 text-center">Lihat rekapitulasi data cuti seluruh karyawan</p>
                    <a href="{{ route('hrd.recapitulation') }}" class="px-4 py-2 bg-white text-nordic-dark rounded-lg text-xs font-bold hover:bg-gray-200 transition">
                        Buka Laporan
                    </a>
                </div>
            </div>

            <div class="card">
                <h3 class="text-lg font-bold text-nordic-dark mb-4">Karyawan Sedang Cuti Hari Ini</h3>
                
                @if($employeesOnLeave->isEmpty())
                    <div class="p-8 text-center bg-nordic-light rounded-lg border border-dashed border-nordic-mute">
                        <p class="text-nordic-gray font-medium">Tidak ada karyawan yang sedang cuti hari ini.</p>
                    </div>
                @else
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                        @foreach($employeesOnLeave as $leave)
                        <div class="flex items-center p-3 rounded-lg border border-nordic-mute bg-nordic-light/30">
                            <div class="h-10 w-10 rounded-full bg-indigo-100 flex items-center justify-center text-indigo-700 font-bold text-sm mr-3">
                                {{ substr($leave->user->name, 0, 2) }}
                            </div>
                            <div>
                                <h4 class="text-sm font-bold text-nordic-dark">{{ $leave->user->name }}</h4>
                                <p class="text-xs text-nordic-gray">{{ $leave->user->division ? $leave->user->division->name : '-' }}</p>
                                <p class="text-xs text-emerald-600 mt-1 font-medium">
                                    Sampai: {{ $leave->end_date->format('d M') }}
                                </p>
                            </div>
                        </div>
                        @endforeach
                    </div>
                @endif
            </div>

            <div class="card">
                <h3 class="text-lg font-bold text-nordic-dark mb-4">Ringkasan Divisi</h3>
                <div class="overflow-x-auto">
                    <table class="w-full text-sm text-left">
                        <thead class="bg-nordic-light text-nordic-dark font-semibold border-b border-nordic-mute">
                            <tr>
                                <th class="px-4 py-2">Nama Divisi</th>
                                <th class="px-4 py-2">Ketua</th>
                                <th class="px-4 py-2 text-right">Jumlah Anggota</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-nordic-mute">
                            @foreach($divisions as $div)
                            <tr>
                                <td class="px-4 py-3 font-medium">{{ $div->name }}</td>
                                <td class="px-4 py-3 text-nordic-gray">{{ $div->leader ? $div->leader->name : '-' }}</td>
                                <td class="px-4 py-3 text-right">
                                    <span class="badge bg-gray-100 text-gray-800">{{ $div->members_count }}</span>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>

        </div>
    </div>
</x-app-layout>