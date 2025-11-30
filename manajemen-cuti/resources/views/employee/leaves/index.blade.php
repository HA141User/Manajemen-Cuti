<x-app-layout>
    <x-slot name="header">
        <h2 class="font-bold text-xl sm:text-2xl text-primary leading-tight px-4 sm:px-0">
            {{ __('Riwayat Pengajuan Cuti') }}
        </h2>
    </x-slot>

    <div class="py-6 sm:py-10">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            
            <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-4 mb-8">
                
                <div class="bg-paper border border-cream px-5 py-4 rounded-2xl shadow-sm flex items-center gap-4 w-full md:w-auto min-w-[250px]">
                    <div class="h-12 w-12 flex-shrink-0 rounded-xl bg-primary text-cream flex items-center justify-center shadow-md">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                    </div>
                    <div>
                        <p class="text-[10px] sm:text-xs text-secondary uppercase tracking-wider font-bold mb-0.5">Sisa Kuota Tahunan</p>
                        <p class="text-2xl sm:text-3xl font-extrabold text-primary leading-none">
                            {{ Auth::user()->annual_leave_quota }} <span class="text-sm font-medium text-secondary/60">Hari</span>
                        </p>
                    </div>
                </div>
                
                <div class="w-full md:w-auto">
                    <a href="{{ route('leaves.create') }}" class="group inline-flex items-center justify-center w-full md:w-auto px-6 py-4 bg-accent text-white font-bold rounded-2xl shadow-lg hover:bg-[#8e6a4e] transition transform hover:-translate-y-0.5 text-sm sm:text-base">
                        <svg class="w-5 h-5 mr-2 group-hover:rotate-90 transition duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                        Buat Pengajuan Baru
                    </a>
                </div>
            </div>

            <div class="bg-paper overflow-hidden shadow-[0_8px_30px_rgb(0,0,0,0.04)] rounded-3xl border border-cream">
                
                @if($requests->isEmpty())
                    <div class="flex flex-col items-center justify-center py-16 text-center px-4">
                        <div class="bg-cream/30 p-6 rounded-full mb-4">
                            <svg class="w-16 h-16 text-secondary/40" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"></path></svg>
                        </div>
                        <h3 class="text-lg font-bold text-primary">Belum Ada Riwayat</h3>
                        <p class="text-secondary/70 max-w-xs mt-2 text-sm">Anda belum pernah mengajukan cuti.</p>
                    </div>
                @else
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-cream">
                            <thead class="bg-cream/30">
                                <tr>
                                    <th class="px-6 py-5 text-left text-xs font-extrabold text-secondary uppercase tracking-wider whitespace-nowrap">Tanggal & Jenis</th>
                                    <th class="px-6 py-5 text-left text-xs font-extrabold text-secondary uppercase tracking-wider whitespace-nowrap">Periode</th>
                                    <th class="px-6 py-5 text-left text-xs font-extrabold text-secondary uppercase tracking-wider whitespace-nowrap">Status</th>
                                    <th class="px-6 py-5 text-right text-xs font-extrabold text-secondary uppercase tracking-wider whitespace-nowrap">Aksi</th>
                                </tr>
                            </thead>
                            <tbody class="bg-paper divide-y divide-cream/50">
                                @foreach($requests as $leave)
                                <tr class="hover:bg-cream/10 transition duration-150 ease-in-out group">
                                    
                                    <td class="px-6 py-5 align-top">
                                        <div class="flex flex-col gap-1">
                                            <span class="text-sm font-bold text-primary">{{ $leave->created_at->format('d M Y') }}</span>
                                            <div>
                                                <span class="inline-flex items-center px-2 py-0.5 rounded-md text-[10px] font-bold uppercase tracking-wide {{ $leave->leave_type == 'annual' ? 'bg-blue-50 text-blue-700 border border-blue-100' : 'bg-orange-50 text-orange-700 border border-orange-100' }}">
                                                    {{ $leave->leave_type == 'annual' ? 'Tahunan' : 'Sakit' }}
                                                </span>
                                            </div>
                                        </div>
                                    </td>

                                    <td class="px-6 py-5 align-top">
                                        <div class="flex flex-col">
                                            <div class="text-sm font-medium text-secondary whitespace-nowrap">
                                                {{ $leave->start_date->format('d M') }} - {{ $leave->end_date->format('d M Y') }}
                                            </div>
                                            <span class="text-xs font-bold text-primary mt-1">{{ $leave->total_days }} Hari Kerja</span>
                                        </div>
                                    </td>
                                    
                                    <td class="px-6 py-5 align-top">
                                        @php
                                            $badgeClass = match($leave->status) {
                                                'pending' => 'bg-amber-50 text-amber-700 border-amber-100',
                                                'approved_by_leader' => 'bg-indigo-50 text-indigo-700 border-indigo-100',
                                                'approved' => 'bg-emerald-50 text-emerald-700 border-emerald-100',
                                                'rejected' => 'bg-rose-50 text-rose-700 border-rose-100',
                                                'cancelled' => 'bg-gray-100 text-gray-600 border-gray-200',
                                                default => 'bg-gray-100 text-gray-600'
                                            };
                                            
                                            $icon = match($leave->status) {
                                                'approved' => '<svg class="w-3.5 h-3.5 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"></path></svg>',
                                                'rejected' => '<svg class="w-3.5 h-3.5 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M6 18L18 6M6 6l12 12"></path></svg>',
                                                'pending' => '<svg class="w-3.5 h-3.5 mr-1.5 animate-spin" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>',
                                                default => ''
                                            };

                                            $statusLabel = match($leave->status) {
                                                'pending' => 'Menunggu',
                                                'approved_by_leader' => 'Verifikasi Manager',
                                                'approved' => 'Disetujui',
                                                'rejected' => 'Ditolak',
                                                'cancelled' => 'Dibatalkan',
                                                default => ucfirst($leave->status)
                                            };
                                        @endphp
                                        
                                        <div class="flex flex-col items-start gap-2">
                                            <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-bold border {{ $badgeClass }} whitespace-nowrap">
                                                {!! $icon !!} {{ $statusLabel }}
                                            </span>

                                            @if($leave->status == 'rejected' && $leave->rejection_reason)
                                                <div class="bg-rose-50 border border-rose-100 rounded-lg p-2 max-w-xs">
                                                    <p class="text-[10px] text-rose-800 italic leading-relaxed">
                                                        <span class="font-bold not-italic">HRD:</span> "{{ $leave->rejection_reason }}"
                                                    </p>
                                                </div>
                                            @endif
                                        </div>
                                    </td>
                                    
                                    <td class="px-6 py-5 whitespace-nowrap text-right text-sm font-medium align-top">
                                        @if($leave->status == 'pending')
                                            <form action="{{ route('leaves.destroy', $leave->id) }}" method="POST" onsubmit="return confirm('Yakin ingin membatalkan cuti ini?');">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="text-red-400 hover:text-red-600 font-bold transition text-xs border border-red-200 px-3 py-1.5 rounded-lg hover:bg-red-50">
                                                    Batalkan
                                                </button>
                                            </form>

                                        @elseif($leave->status == 'approved')
                                            <a href="{{ route('leaves.download_pdf', $leave->id) }}" target="_blank" class="inline-flex items-center px-4 py-2 bg-primary text-cream rounded-lg text-xs font-bold hover:bg-secondary hover:shadow-md transition">
                                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"></path></svg>
                                                Unduh PDF
                                            </a>
                                        @else
                                            <span class="text-secondary/30 text-xs italic">-</span>
                                        @endif
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    
                    <div class="px-6 py-4 border-t border-cream bg-cream/20">
                        {{ $requests->links() }}
                    </div>
                @endif
            </div>
        </div>
    </div>
</x-app-layout>