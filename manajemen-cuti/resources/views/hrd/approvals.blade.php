<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-nordic-dark leading-tight">
            {{ __('Final Approval (HRD)') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            
            @if(session('success'))
                <div class="bg-emerald-100 border border-emerald-400 text-emerald-700 px-4 py-3 rounded-lg relative mb-6">{{ session('success') }}</div>
            @endif
            @if(session('error'))
                <div class="bg-rose-100 border border-rose-400 text-rose-700 px-4 py-3 rounded-lg relative mb-6">{{ session('error') }}</div>
            @endif

            <div class="space-y-6">
                @if($requests->isEmpty())
                    <div class="card text-center py-12">
                        <div class="inline-flex items-center justify-center w-16 h-16 rounded-full bg-emerald-100 mb-4">
                            <svg class="w-8 h-8 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                        </div>
                        <h3 class="text-lg font-bold text-nordic-dark">Semua Beres!</h3>
                        <p class="text-nordic-gray">Tidak ada pengajuan yang menunggu persetujuan Anda saat ini.</p>
                    </div>
                @else
                    
                    <form action="{{ route('hrd.bulk_action') }}" method="POST" id="bulkForm">
                        @csrf
                        
                        <div class="sticky top-4 z-10 bg-white border border-nordic-mute rounded-xl shadow-lg p-4 mb-6 flex flex-col md:flex-row justify-between items-center gap-4">
                            <div class="flex items-center gap-3">
                                <input type="checkbox" id="selectAll" class="rounded border-nordic-mute text-indigo-600 focus:ring-indigo-500 h-5 w-5 cursor-pointer">
                                <label for="selectAll" class="text-sm font-bold text-nordic-dark cursor-pointer select-none">Pilih Semua</label>
                            </div>
                            
                            <div class="flex items-center gap-2 w-full md:w-auto">
                                <input type="text" name="bulk_note" placeholder="Catatan Massal (Opsional)" class="form-input text-sm w-full md:w-64">
                                
                                <button type="submit" name="action" value="approve" class="btn-primary bg-emerald-600 hover:bg-emerald-700 border-none" onclick="return confirm('Approve semua yang dipilih?')">
                                    Approve
                                </button>
                                
                                <button type="submit" name="action" value="reject" class="btn-danger" onclick="return confirm('Tolak semua yang dipilih? Kuota akan dikembalikan.')">
                                    Tolak
                                </button>
                            </div>
                        </div>

                        <div class="grid grid-cols-1 gap-6">
                            @foreach($requests as $req)
                            <div class="card border-l-4 border-l-yellow-400 hover:shadow-md transition">
                                <div class="flex flex-row items-start">
                                    
                                    <div class="mr-4 pt-1">
                                        <input type="checkbox" name="ids[]" value="{{ $req->id }}" class="item-checkbox rounded border-nordic-mute text-indigo-600 focus:ring-indigo-500 h-5 w-5 cursor-pointer">
                                    </div>

                                    <div class="flex-grow flex flex-col md:flex-row justify-between items-start md:items-center">
                                        <div class="mb-4 md:mb-0">
                                            <div class="flex items-center mb-2">
                                                <span class="font-bold text-lg text-nordic-dark mr-2">{{ $req->user->name }}</span>
                                                <span class="text-xs text-nordic-gray mr-2 border-r border-nordic-mute pr-2">{{ $req->user->division ? $req->user->division->name : 'No Div' }}</span>
                                                <span class="badge {{ $req->type == 'annual' ? 'bg-indigo-50 text-indigo-700' : 'bg-rose-50 text-rose-700' }}">
                                                    {{ $req->type == 'annual' ? 'Cuti Tahunan' : 'Cuti Sakit' }}
                                                </span>
                                            </div>
                                            
                                            <div class="text-sm text-nordic-dark font-medium mb-1">
                                                {{ $req->start_date->format('d M') }} - {{ $req->end_date->format('d M Y') }} 
                                                <span class="text-nordic-gray">({{ $req->total_days }} Hari Kerja)</span>
                                            </div>
                                            <p class="text-sm text-nordic-gray italic mb-2">"{{ $req->reason }}"</p>
                                            
                                            <div class="inline-flex items-center text-xs px-2 py-1 rounded bg-slate-100 border border-slate-200">
                                                @if($req->status == 'approved_leader')
                                                    <span class="text-emerald-600 font-bold mr-1">✔ Approved by Leader:</span>
                                                    <span class="text-nordic-dark">{{ $req->leaderApprover->name ?? '-' }}</span>
                                                    <span class="text-nordic-gray ml-1">({{ $req->updated_at->format('d M H:i') }})</span>
                                                @else
                                                    <span class="text-orange-600 font-bold">⚠ Direct Request (Level Leader)</span>
                                                @endif
                                            </div>

                                            @if($req->attachment)
                                                <a href="{{ asset('storage/' . $req->attachment) }}" target="_blank" class="block mt-2 text-xs font-bold text-indigo-600 hover:underline">
                                                    📎 Lihat Lampiran
                                                </a>
                                            @endif
                                        </div>

                                        <div class="flex flex-col items-end gap-2">
                                            <a href="{{ route('leaves.show', $req->id) }}" class="btn-secondary text-xs py-1">
                                                Lihat Detail
                                            </a>

                                            <details class="relative">
                                                <summary class="text-rose-600 hover:text-rose-800 text-xs font-bold cursor-pointer select-none list-none underline">Tolak Satuan</summary>
                                                <div class="absolute right-0 mt-2 w-72 bg-white border border-nordic-mute rounded-xl shadow-xl p-4 z-20">
                                                    <div class="mb-2 text-xs font-bold text-nordic-dark">Alasan Penolakan:</div>
                                                    <textarea name="rejection_note_single" id="note_{{ $req->id }}" class="form-input w-full text-xs mb-2" rows="2"></textarea>
                                                    <button type="button" 
                                                        onclick="submitSingleReject({{ $req->id }})"
                                                        class="w-full bg-rose-600 text-white text-xs font-bold py-1 rounded hover:bg-rose-700">
                                                        Konfirmasi Tolak
                                                    </button>
                                                </div>
                                            </details>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            @endforeach
                        </div>
                    </form>

                    <form id="singleRejectForm" method="POST" style="display:none;">
                        @csrf
                        <input type="hidden" name="rejection_note" id="single_note_input">
                    </form>
                @endif
            </div>
        </div>
    </div>

    <script>
        // Select All Script
        const selectAll = document.getElementById('selectAll');
        if(selectAll){
            selectAll.addEventListener('change', function() {
                var checkboxes = document.querySelectorAll('.item-checkbox');
                for (var checkbox of checkboxes) {
                    checkbox.checked = this.checked;
                }
            });
        }

        // Single Reject Script Helper
        function submitSingleReject(id) {
            const note = document.getElementById('note_' + id).value;
            if(note.length < 5) {
                alert('Alasan penolakan minimal 5 karakter.');
                return;
            }
            if(confirm('Tolak pengajuan ini?')) {
                const form = document.getElementById('singleRejectForm');
                form.action = '/hrd/reject/' + id;
                document.getElementById('single_note_input').value = note;
                form.submit();
            }
        }
    </script>
</x-app-layout>