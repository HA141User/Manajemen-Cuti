<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-nordic-dark leading-tight">
                {{ __('Riwayat Cuti Saya') }}
            </h2>
            <a href="{{ route('leaves.create') }}" class="btn-primary">
                + Ajukan Cuti
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            
            @if(session('success'))
                <div class="bg-emerald-100 border border-emerald-400 text-emerald-700 px-4 py-3 rounded-lg relative">
                    {{ session('success') }}
                </div>
            @endif
            @if(session('error'))
                <div class="bg-rose-100 border border-rose-400 text-rose-700 px-4 py-3 rounded-lg relative">
                    {{ session('error') }}
                </div>
            @endif

            <div class="card bg-nordic-light border border-nordic-mute">
                <form method="GET" action="{{ route('leaves.index') }}">
                    <div class="grid grid-cols-1 md:grid-cols-5 gap-4 items-end">
                        <div>
                            <label class="text-xs font-bold text-nordic-gray uppercase mb-1 block">Jenis Cuti</label>
                            <select name="type" class="form-input w-full text-sm">
                                <option value="">Semua</option>
                                <option value="annual" {{ request('type') == 'annual' ? 'selected' : '' }}>Tahunan</option>
                                <option value="sick" {{ request('type') == 'sick' ? 'selected' : '' }}>Sakit</option>
                            </select>
                        </div>

                        <div>
                            <label class="text-xs font-bold text-nordic-gray uppercase mb-1 block">Status</label>
                            <select name="status" class="form-input w-full text-sm">
                                <option value="">Semua</option>
                                <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>Menunggu</option>
                                <option value="approved_leader" {{ request('status') == 'approved_leader' ? 'selected' : '' }}>Acc Leader</option>
                                <option value="approved_hrd" {{ request('status') == 'approved_hrd' ? 'selected' : '' }}>Disetujui</option>
                                <option value="rejected" {{ request('status') == 'rejected' ? 'selected' : '' }}>Ditolak</option>
                            </select>
                        </div>

                        <div>
                            <label class="text-xs font-bold text-nordic-gray uppercase mb-1 block">Bulan</label>
                            <select name="month" class="form-input w-full text-sm">
                                <option value="">Semua</option>
                                @for($i = 1; $i <= 12; $i++)
                                    <option value="{{ $i }}" {{ request('month') == $i ? 'selected' : '' }}>
                                        {{ date('F', mktime(0, 0, 0, $i, 1)) }}
                                    </option>
                                @endfor
                            </select>
                        </div>

                        <div>
                            <label class="text-xs font-bold text-nordic-gray uppercase mb-1 block">Tahun</label>
                            <select name="year" class="form-input w-full text-sm">
                                <option value="">Semua</option>
                                @foreach(range(date('Y'), 2023) as $year)
                                    <option value="{{ $year }}" {{ request('year') == $year ? 'selected' : '' }}>{{ $year }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div>
                            <button type="submit" class="btn-primary w-full justify-center bg-nordic-dark hover:bg-black">
                                Filter Data
                            </button>
                        </div>
                    </div>
                </form>
            </div>

            <div class="card overflow-hidden p-0">
                <div class="overflow-x-auto">
                    <table class="w-full text-left text-sm">
                        <thead class="bg-nordic-light text-nordic-dark font-bold uppercase text-xs border-b border-nordic-mute">
                            <tr>
                                <th class="px-6 py-4">Tanggal Pengajuan</th>
                                <th class="px-6 py-4">Jenis</th>
                                <th class="px-6 py-4">Periode</th>
                                <th class="px-6 py-4">Status</th>
                                <th class="px-6 py-4 text-right">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-nordic-mute">
                            @forelse($leaves as $leave)
                            <tr class="hover:bg-slate-50 transition">
                                <td class="px-6 py-4 text-nordic-gray">
                                    {{ $leave->created_at->format('d M Y') }}
                                    <span class="text-xs block">{{ $leave->created_at->format('H:i') }}</span>
                                </td>
                                <td class="px-6 py-4">
                                    <span class="badge border 
                                        {{ $leave->type === 'annual' ? 'bg-indigo-50 text-indigo-700 border-indigo-200' : 'bg-rose-50 text-rose-700 border-rose-200' }}">
                                        {{ $leave->type === 'annual' ? 'Tahunan' : 'Sakit' }}
                                    </span>
                                </td>
                                <td class="px-6 py-4">
                                    <div class="font-bold text-nordic-dark">
                                        {{ $leave->start_date->format('d M') }} - {{ $leave->end_date->format('d M Y') }}
                                    </div>
                                    <div class="text-xs text-nordic-gray">Durasi: {{ $leave->total_days }} Hari Kerja</div>
                                </td>
                                <td class="px-6 py-4">
                                    @if($leave->status == 'pending')
                                        <span class="badge bg-amber-100 text-amber-800 border border-amber-200">Menunggu</span>
                                    @elseif($leave->status == 'approved_leader')
                                        <span class="badge bg-blue-100 text-blue-800 border border-blue-200">Acc Leader</span>
                                    @elseif($leave->status == 'approved_hrd')
                                        <span class="badge bg-emerald-100 text-emerald-800 border border-emerald-200">Disetujui</span>
                                    @else
                                        <span class="badge bg-rose-100 text-rose-800 border border-rose-200">Ditolak</span>
                                    @endif
                                </td>
                                <td class="px-6 py-4 text-right space-x-2">
                                    <a href="{{ route('leaves.show', $leave->id) }}" class="text-indigo-600 hover:text-indigo-900 font-bold text-xs uppercase tracking-wide">
                                        Detail
                                    </a>
                                    
                                    @if($leave->status == 'pending')
                                    <form action="{{ route('leaves.destroy', $leave->id) }}" method="POST" class="inline-block" onsubmit="return confirm('Batalkan pengajuan ini? Kuota akan dikembalikan.');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-rose-600 hover:text-rose-900 font-bold text-xs uppercase tracking-wide">
                                            Batal
                                        </button>
                                    </form>
                                    @endif
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="5" class="px-6 py-10 text-center text-nordic-gray italic">
                                    <div class="flex flex-col items-center justify-center">
                                        <p>Belum ada riwayat pengajuan cuti.</p>
                                    </div>
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