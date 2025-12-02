<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-nordic-dark leading-tight">
            {{ __('Detail Pengajuan Cuti') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="card">
                
                <div class="border-b border-nordic-mute pb-6 mb-6 flex flex-col md:flex-row justify-between items-start md:items-center gap-4">
                    <div>
                        <h3 class="text-2xl font-bold text-nordic-dark flex items-center">
                            {{ $leave->type === 'annual' ? 'Cuti Tahunan' : 'Cuti Sakit' }}
                            @if($leave->type === 'sick')
                                <span class="ml-3 text-xs bg-rose-100 text-rose-700 px-2 py-1 rounded-full border border-rose-200">Medis</span>
                            @else
                                <span class="ml-3 text-xs bg-blue-100 text-blue-700 px-2 py-1 rounded-full border border-blue-200">Pribadi</span>
                            @endif
                        </h3>
                        <p class="text-sm text-nordic-gray mt-1">Diajukan pada: {{ $leave->created_at->format('d F Y, H:i') }}</p>
                    </div>
                    
                    <div class="flex items-center gap-3">
                        @if($leave->status == 'pending')
                            <span class="px-3 py-1.5 text-sm font-bold rounded-lg bg-amber-100 text-amber-800 border border-amber-200">
                                ⏳ Menunggu Approval
                            </span>
                        @elseif($leave->status == 'approved_leader')
                            <span class="px-3 py-1.5 text-sm font-bold rounded-lg bg-blue-100 text-blue-800 border border-blue-200">
                                🔹 Disetujui Leader
                            </span>
                        @elseif($leave->status == 'approved_hrd')
                            <span class="px-3 py-1.5 text-sm font-bold rounded-lg bg-emerald-100 text-emerald-800 border border-emerald-200">
                                ✅ Disetujui HRD (Final)
                            </span>
                        @else
                            <span class="px-3 py-1.5 text-sm font-bold rounded-lg bg-rose-100 text-rose-800 border border-rose-200">
                                ❌ Ditolak
                            </span>
                        @endif

                        @if($leave->status == 'approved_hrd')
                            <a href="{{ route('leaves.download', $leave->id) }}" class="btn-primary flex items-center shadow-lg shadow-indigo-200">
                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"></path></svg>
                                Download Surat
                            </a>
                        @endif
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-8 mb-8">
                    <div class="space-y-6">
                        <div>
                            <h4 class="text-xs font-bold text-nordic-gray uppercase tracking-wider mb-2">Periode Cuti</h4>
                            <div class="p-4 bg-nordic-light rounded-xl border border-nordic-mute">
                                <p class="text-nordic-dark font-bold text-lg">
                                    {{ $leave->start_date->format('d M Y') }} 
                                    <span class="text-nordic-gray mx-2">&rarr;</span> 
                                    {{ $leave->end_date->format('d M Y') }}
                                </p>
                                <p class="text-sm text-emerald-600 font-bold mt-1">Total: {{ $leave->total_days }} Hari Kerja</p>
                            </div>
                        </div>

                        <div>
                            <h4 class="text-xs font-bold text-nordic-gray uppercase tracking-wider mb-2">Alasan Pengajuan</h4>
                            <div class="p-4 bg-white border border-nordic-mute rounded-xl shadow-sm">
                                <p class="text-nordic-dark italic">"{{ $leave->reason }}"</p>
                            </div>
                        </div>
                    </div>

                    <div class="space-y-6">
                        <div>
                            <h4 class="text-xs font-bold text-nordic-gray uppercase tracking-wider mb-2">Informasi Kontak</h4>
                            <ul class="text-sm space-y-3">
                                <li class="flex items-start">
                                    <svg class="w-5 h-5 text-nordic-gray mr-2 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                                    <span class="text-nordic-dark">{{ $leave->leave_address }}</span>
                                </li>
                                <li class="flex items-center">
                                    <svg class="w-5 h-5 text-nordic-gray mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"></path></svg>
                                    <span class="text-nordic-dark font-medium">{{ $leave->emergency_contact }}</span>
                                </li>
                            </ul>
                        </div>

                        <div>
                            <h4 class="text-xs font-bold text-nordic-gray uppercase tracking-wider mb-2">Lampiran Dokumen</h4>
                            @if($leave->attachment)
                                <a href="{{ asset('storage/' . $leave->attachment) }}" target="_blank" class="group flex items-center p-3 rounded-lg border border-nordic-mute hover:border-indigo-300 hover:bg-indigo-50 transition">
                                    <div class="p-2 bg-indigo-100 rounded-lg text-indigo-600 mr-3">
                                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                                    </div>
                                    <div>
                                        <p class="text-sm font-bold text-indigo-700 group-hover:underline">Lihat Lampiran</p>
                                        <p class="text-xs text-indigo-500">Klik untuk membuka file</p>
                                    </div>
                                </a>
                            @else
                                <div class="p-3 rounded-lg border border-dashed border-nordic-mute text-center text-nordic-gray text-sm">
                                    Tidak ada lampiran.
                                </div>
                            @endif
                        </div>
                    </div>
                </div>

                <div class="border-t border-nordic-mute pt-8">
                    <h4 class="text-sm font-bold text-nordic-dark uppercase tracking-wider mb-6">Timeline Persetujuan</h4>
                    
                    <div class="relative pl-4 border-l-2 border-nordic-mute space-y-8 ml-2">
                        <div class="relative">
                            <div class="absolute -left-[21px] bg-emerald-500 h-4 w-4 rounded-full border-2 border-white ring-2 ring-emerald-100"></div>
                            <div class="flex flex-col sm:flex-row sm:justify-between sm:items-center">
                                <div>
                                    <h5 class="font-bold text-nordic-dark">Pengajuan Terkirim</h5>
                                    <p class="text-sm text-nordic-gray">Menunggu verifikasi atasan.</p>
                                </div>
                                <time class="text-xs font-mono text-nordic-gray mt-1 sm:mt-0">{{ $leave->created_at->format('d M Y, H:i') }}</time>
                            </div>
                        </div>

                        <div class="relative">
                            <div class="absolute -left-[21px] h-4 w-4 rounded-full border-2 border-white ring-2 {{ $leave->leader_approver_id ? ($leave->status == 'rejected' && !$leave->hrd_approver_id ? 'bg-rose-500 ring-rose-100' : 'bg-emerald-500 ring-emerald-100') : 'bg-gray-300 ring-gray-100' }}"></div>
                            <div class="flex flex-col sm:flex-row sm:justify-between sm:items-center">
                                <div>
                                    <h5 class="font-bold text-nordic-dark">Verifikasi Leader</h5>
                                    @if($leave->leader_approver_id)
                                        <p class="text-sm text-nordic-gray">Oleh: <span class="font-semibold text-nordic-dark">{{ $leave->leaderApprover->name }}</span></p>
                                        @if($leave->status == 'rejected' && !$leave->hrd_approver_id)
                                            <div class="mt-2 p-2 bg-rose-50 border-l-2 border-rose-500 text-xs text-rose-700 italic">
                                                "{{ $leave->rejection_note }}"
                                            </div>
                                        @endif
                                    @else
                                        <p class="text-sm text-nordic-gray italic">Sedang diproses...</p>
                                    @endif
                                </div>
                            </div>
                        </div>

                        <div class="relative">
                            <div class="absolute -left-[21px] h-4 w-4 rounded-full border-2 border-white ring-2 {{ $leave->hrd_approver_id ? ($leave->status == 'rejected' ? 'bg-rose-500 ring-rose-100' : 'bg-emerald-500 ring-emerald-100') : 'bg-gray-300 ring-gray-100' }}"></div>
                            <div class="flex flex-col sm:flex-row sm:justify-between sm:items-center">
                                <div>
                                    <h5 class="font-bold text-nordic-dark">Verifikasi Akhir HRD</h5>
                                    @if($leave->hrd_approver_id)
                                        <p class="text-sm text-nordic-gray">Oleh: <span class="font-semibold text-nordic-dark">{{ $leave->hrdApprover->name }}</span></p>
                                        @if($leave->status == 'rejected')
                                            <div class="mt-2 p-2 bg-rose-50 border-l-2 border-rose-500 text-xs text-rose-700 italic">
                                                "{{ $leave->rejection_note }}"
                                            </div>
                                        @endif
                                    @else
                                        <p class="text-sm text-nordic-gray italic">Menunggu giliran...</p>
                                    @endif
                                </div>
                                @if($leave->hrd_approval_date)
                                    <time class="text-xs font-mono text-nordic-gray mt-1 sm:mt-0">{{ $leave->hrd_approval_date->format('d M Y') }}</time>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>

                <div class="mt-8 pt-6 border-t border-nordic-mute flex justify-end">
                    <a href="{{ route('leaves.index') }}" class="btn-secondary">
                        &larr; Kembali ke Daftar
                    </a>
                </div>

            </div>
        </div>
    </div>
</x-app-layout>