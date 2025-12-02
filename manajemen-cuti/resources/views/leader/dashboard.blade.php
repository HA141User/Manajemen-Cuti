<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-nordic-dark leading-tight">
            {{ __('Dashboard Ketua Divisi') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            
            <div class="card flex justify-between items-center bg-nordic-dark text-white">
                <div>
                    <h3 class="text-lg font-bold">Divisi: {{ $managedDivision ? $managedDivision->name : 'Tidak Ada' }}</h3>
                    <p class="text-xs text-gray-300">Sisa Cuti Pribadi Anda: {{ $remainingQuota }} Hari</p>
                </div>
                <div>
                    <a href="{{ route('leaves.create') }}" class="px-4 py-2 bg-white/20 hover:bg-white/30 rounded-lg text-sm transition">
                        + Cuti Pribadi
                    </a>
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div class="card border-l-4 border-l-blue-500">
                    <div class="text-nordic-gray text-xs font-bold uppercase tracking-wider">Total Request Tim (All Time)</div>
                    <div class="mt-2 text-3xl font-bold text-blue-600">{{ $incomingRequests }}</div>
                </div>

                <div class="card border-l-4 border-l-yellow-500">
                    <div class="text-nordic-gray text-xs font-bold uppercase tracking-wider">Perlu Verifikasi Anda</div>
                    <div class="mt-2 flex justify-between items-end">
                        <span class="text-3xl font-bold text-yellow-600">{{ $pendingVerification }}</span>
                        @if($pendingVerification > 0)
                            <a href="{{ route('leader.approvals') }}" class="text-sm font-bold text-yellow-700 hover:underline">
                                Proses Sekarang &rarr;
                            </a>
                        @endif
                    </div>
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div class="card">
                    <h3 class="text-lg font-bold text-nordic-dark mb-4">Anggota Tim Saya</h3>
                    <ul class="space-y-3">
                        @forelse($teamMembers as $member)
                            <li class="flex justify-between items-center p-2 hover:bg-nordic-light rounded transition">
                                <div class="flex items-center">
                                    <div class="h-8 w-8 rounded-full bg-gray-200 flex items-center justify-center text-xs font-bold mr-3">
                                        {{ substr($member->name, 0, 2) }}
                                    </div>
                                    <div>
                                        <p class="text-sm font-bold text-nordic-dark">{{ $member->name }}</p>
                                        <p class="text-xs text-nordic-gray">{{ $member->email }}</p>
                                    </div>
                                </div>
                                <span class="badge {{ $member->is_active ? 'bg-green-100 text-green-700' : 'bg-red-100 text-red-700' }}">
                                    {{ $member->is_active ? 'Aktif' : 'Non-Aktif' }}
                                </span>
                            </li>
                        @empty
                            <li class="text-sm text-gray-400 italic">Belum ada anggota.</li>
                        @endforelse
                    </ul>
                </div>

                <div class="card">
                    <h3 class="text-lg font-bold text-nordic-dark mb-4">Anggota Sedang Cuti (Minggu Ini)</h3>
                    @if($membersOnLeave->isEmpty())
                        <div class="p-6 text-center border border-dashed border-nordic-mute rounded-lg">
                            <p class="text-sm text-nordic-gray">Semua anggota hadir.</p>
                        </div>
                    @else
                        <ul class="space-y-3">
                            @foreach($membersOnLeave as $leave)
                                <li class="p-3 bg-red-50 border border-red-100 rounded-lg flex justify-between items-center">
                                    <span class="text-sm font-bold text-red-800">{{ $leave->user->name }}</span>
                                    <span class="text-xs text-red-600 bg-white px-2 py-1 rounded border border-red-200">
                                        {{ $leave->start_date->format('d M') }} - {{ $leave->end_date->format('d M') }}
                                    </span>
                                </li>
                            @endforeach
                        </ul>
                    @endif
                </div>
            </div>

        </div>
    </div>
</x-app-layout>