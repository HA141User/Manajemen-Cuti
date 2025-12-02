<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-nordic-dark leading-tight">
            {{ __('Laporan Rekapitulasi Cuti') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            
            <div class="card bg-nordic-light border-2 border-nordic-mute">
                <form method="GET" action="{{ route('hrd.recapitulation') }}">
                    <div class="grid grid-cols-1 md:grid-cols-4 gap-4 items-end">
                        <div class="col-span-1">
                            <label class="text-xs font-bold text-nordic-gray uppercase mb-1 block">Nama Karyawan</label>
                            <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari nama..." class="form-input w-full text-sm">
                        </div>

                        <div class="col-span-1">
                            <label class="text-xs font-bold text-nordic-gray uppercase mb-1 block">Divisi</label>
                            <select name="division_id" class="form-input w-full text-sm">
                                <option value="">Semua Divisi</option>
                                @foreach($divisions as $div)
                                    <option value="{{ $div->id }}" {{ request('division_id') == $div->id ? 'selected' : '' }}>
                                        {{ $div->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="col-span-1">
                            <label class="text-xs font-bold text-nordic-gray uppercase mb-1 block">Status</label>
                            <select name="status" class="form-input w-full text-sm">
                                <option value="">Semua Status</option>
                                <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>Pending</option>
                                <option value="approved_hrd" {{ request('status') == 'approved_hrd' ? 'selected' : '' }}>Disetujui</option>
                                <option value="rejected" {{ request('status') == 'rejected' ? 'selected' : '' }}>Ditolak</option>
                            </select>
                        </div>

                        <div class="col-span-1 flex gap-2">
                            <button type="submit" class="btn-primary w-full justify-center">
                                Tampilkan
                            </button>
                            @if(request()->anyFilled(['search', 'division_id', 'status', 'type']))
                                <a href="{{ route('hrd.recapitulation') }}" class="btn-secondary px-3">
                                    ✕
                                </a>
                            @endif
                        </div>
                    </div>
                </form>
            </div>

            <div class="card overflow-hidden p-0">
                <div class="overflow-x-auto">
                    <table class="w-full text-left text-sm">
                        <thead class="bg-nordic-light text-nordic-dark font-bold uppercase text-xs border-b border-nordic-mute">
                            <tr>
                                <th class="px-6 py-4">Karyawan</th>
                                <th class="px-6 py-4">Jenis & Tanggal</th>
                                <th class="px-6 py-4">Durasi</th>
                                <th class="px-6 py-4">Status Akhir</th>
                                <th class="px-6 py-4 text-right">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-nordic-mute">
                            @forelse($leaves as $leave)
                            <tr class="hover:bg-slate-50 transition">
                                <td class="px-6 py-4">
                                    <div class="font-bold text-nordic-dark">{{ $leave->user->name }}</div>
                                    <div class="text-xs text-nordic-gray">{{ $leave->user->division ? $leave->user->division->name : 'Non-Divisi' }}</div>
                                </td>
                                <td class="px-6 py-4">
                                    <span class="badge border mb-1 inline-block
                                        {{ $leave->type === 'annual' ? 'bg-indigo-50 text-indigo-700 border-indigo-200' : 'bg-rose-50 text-rose-700 border-rose-200' }}">
                                        {{ $leave->type === 'annual' ? 'Tahunan' : 'Sakit' }}
                                    </span>
                                    <div class="text-xs text-nordic-gray font-mono">
                                        {{ $leave->start_date->format('d/m/y') }} - {{ $leave->end_date->format('d/m/y') }}
                                    </div>
                                </td>
                                <td class="px-6 py-4 text-nordic-dark font-medium">
                                    {{ $leave->total_days }} Hari
                                </td>
                                <td class="px-6 py-4">
                                    @if($leave->status == 'approved_hrd')
                                        <span class="badge bg-emerald-100 text-emerald-800 border border-emerald-200">Disetujui</span>
                                    @elseif($leave->status == 'rejected')
                                        <span class="badge bg-rose-100 text-rose-800 border border-rose-200">Ditolak</span>
                                    @else
                                        <span class="badge bg-amber-100 text-amber-800 border border-amber-200">Proses</span>
                                    @endif
                                </td>
                                <td class="px-6 py-4 text-right">
                                    <a href="{{ route('leaves.show', $leave->id) }}" class="text-indigo-600 hover:text-indigo-900 font-bold text-xs uppercase tracking-wide">
                                        Detail
                                    </a>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="5" class="px-6 py-10 text-center text-nordic-gray italic">
                                    Tidak ada data cuti yang ditemukan.
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                @if($leaves->hasPages())
                    <div class="px-6 py-4 border-t border-nordic-mute bg-nordic-light">
                        {{ $leaves->links() }}
                    </div>
                @endif
            </div>
        </div>
    </div>
</x-app-layout>