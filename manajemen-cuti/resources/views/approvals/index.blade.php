<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Persetujuan Cuti') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            
            @if(session('success'))
                <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
                    {{ session('success') }}
                </div>
            @endif

            @if($approvals->isEmpty())
                <div class="bg-white p-6 rounded-lg shadow text-center text-gray-500">
                    Tidak ada pengajuan cuti yang perlu diproses saat ini.
                </div>
            @else
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    @foreach($approvals as $leave)
                    <div class="bg-white rounded-lg shadow-md overflow-hidden border border-gray-200" x-data="{ showReject: false }">
                        
                        <div class="bg-gray-50 px-6 py-4 border-b border-gray-200 flex justify-between items-center">
                            <div class="flex items-center">
                                <div class="h-10 w-10 rounded-full bg-indigo-500 flex items-center justify-center text-white font-bold mr-3">
                                    {{ substr($leave->user->name, 0, 1) }}
                                </div>
                                <div>
                                    <h3 class="text-lg font-bold text-gray-800">{{ $leave->user->name }}</h3>
                                    <p class="text-xs text-gray-500">{{ $leave->user->email }}</p>
                                </div>
                            </div>
                            <span class="text-xs font-mono text-gray-400">{{ $leave->created_at->diffForHumans() }}</span>
                        </div>

                        <div class="p-6">
                            <div class="flex justify-between mb-2">
                                <span class="text-sm text-gray-500">Jenis Cuti:</span>
                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full {{ $leave->leave_type == 'annual' ? 'bg-blue-100 text-blue-800' : 'bg-yellow-100 text-yellow-800' }}">
                                    {{ $leave->leave_type == 'annual' ? 'Tahunan' : 'Sakit' }}
                                </span>
                            </div>
                            
                            <div class="flex justify-between mb-2">
                                <span class="text-sm text-gray-500">Durasi:</span>
                                <span class="font-bold">{{ $leave->total_days }} Hari Kerja</span>
                            </div>
                            
                            <div class="mb-4">
                                <p class="text-sm text-gray-500">Tanggal:</p>
                                <p class="text-gray-800 font-medium">
                                    {{ $leave->start_date->format('d M') }} s/d {{ $leave->end_date->format('d M Y') }}
                                </p>
                            </div>

                            <div class="mb-4 bg-gray-50 p-3 rounded">
                                <p class="text-xs text-gray-400 uppercase font-bold mb-1">Alasan:</p>
                                <p class="text-sm text-gray-700 italic">"{{ $leave->reason }}"</p>
                            </div>

                            @if($leave->attachment_path)
                                <div class="mb-4">
                                    <a href="{{ asset('storage/' . $leave->attachment_path) }}" target="_blank" class="text-blue-600 hover:underline text-sm flex items-center">
                                        <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.172 7l-6.586 6.586a2 2 0 102.828 2.828l6.414-6.586a4 4 0 00-5.656-5.656l-6.415 6.585a6 6 0 108.486 8.486L20.5 13"></path></svg>
                                        Lihat Surat Dokter
                                    </a>
                                </div>
                            @endif

                            <div x-show="showReject" class="mt-4 pt-4 border-t border-gray-100" style="display: none;">
                                <form action="{{ route('approvals.reject', $leave->id) }}" method="POST">
                                    @csrf
                                    @method('PATCH')
                                    <label class="block text-sm font-medium text-gray-700 mb-1">Alasan Penolakan (Wajib):</label>
                                    <textarea name="rejection_reason" rows="2" class="w-full rounded border-gray-300 shadow-sm focus:border-red-300 focus:ring focus:ring-red-200 focus:ring-opacity-50" required placeholder="Contoh: Kuota tim sedang tipis..."></textarea>
                                    <div class="mt-2 flex justify-end space-x-2">
                                        <button type="button" @click="showReject = false" class="text-gray-500 text-sm hover:underline">Batal</button>
                                        <button type="submit" class="bg-red-600 text-white px-3 py-1 rounded text-sm hover:bg-red-700">Kirim Penolakan</button>
                                    </div>
                                </form>
                            </div>

                        </div>

                        <div class="bg-gray-50 px-6 py-3 border-t border-gray-200 flex justify-end space-x-3" x-show="!showReject">
                            <button @click="showReject = true" class="bg-red-100 text-red-700 px-4 py-2 rounded-md text-sm font-bold hover:bg-red-200 transition">
                                Tolak
                            </button>
                            
                            <form action="{{ route('approvals.approve', $leave->id) }}" method="POST">
                                @csrf
                                @method('PATCH')
                                <button type="submit" class="bg-green-600 text-white px-4 py-2 rounded-md text-sm font-bold hover:bg-green-700 transition shadow">
                                    Setujui (Approve)
                                </button>
                            </form>
                        </div>
                    </div>
                    @endforeach
                </div>
            @endif
        </div>
    </div>
</x-app-layout>