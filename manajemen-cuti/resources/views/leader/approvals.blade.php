<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-nordic-dark leading-tight">
            {{ __('Verifikasi Pengajuan (Tim Saya)') }}
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
                        <div class="inline-flex items-center justify-center w-16 h-16 rounded-full bg-blue-100 mb-4">
                            <svg class="w-8 h-8 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                        </div>
                        <h3 class="text-lg font-bold text-nordic-dark">Semua Bersih!</h3>
                        <p class="text-nordic-gray">Tim Anda belum mengajukan cuti baru.</p>
                    </div>
                @else
                    <div class="grid grid-cols-1 gap-6">
                        @foreach($requests as $req)
                        <div class="card border-l-4 border-l-blue-500 hover:shadow-md transition">
                            <div class="flex flex-col md:flex-row justify-between items-start md:items-center">
                                
                                <div class="mb-4 md:mb-0">
                                    <div class="flex items-center mb-2">
                                        <div class="h-10 w-10 rounded-full bg-slate-200 flex items-center justify-center font-bold text-slate-600 mr-3">
                                            {{ substr($req->user->name, 0, 2) }}
                                        </div>
                                        <div>
                                            <div class="flex items-center">
                                                <span class="font-bold text-lg text-nordic-dark mr-2">{{ $req->user->name }}</span>
                                                <span class="badge {{ $req->type == 'annual' ? 'bg-indigo-50 text-indigo-700' : 'bg-rose-50 text-rose-700' }}">
                                                    {{ $req->type == 'annual' ? 'Tahunan' : 'Sakit' }}
                                                </span>
                                            </div>
                                            <div class="text-sm text-nordic-gray">
                                                {{ $req->start_date->format('d M') }} - {{ $req->end_date->format('d M Y') }}
                                                <span class="font-bold">({{ $req->total_days }} Hari)</span>
                                            </div>
                                        </div>
                                    </div>
                                    
                                    <div class="ml-13 pl-3 border-l-2 border-nordic-mute mt-2">
                                        <p class="text-sm text-nordic-dark italic">"{{ $req->reason }}"</p>
                                    </div>

                                    @if($req->attachment)
                                        <a href="{{ asset('storage/' . $req->attachment) }}" target="_blank" class="inline-flex items-center mt-3 text-xs font-bold text-blue-600 hover:underline">
                                            <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.172 7l-6.586 6.586a2 2 0 102.828 2.828l6.414-6.586a4 4 0 00-5.656-5.656l-6.415 6.585a6 6 0 108.486 8.486L20.5 13"></path></svg>
                                            Cek Lampiran
                                        </a>
                                    @endif
                                </div>

                                <div class="flex items-center gap-3">
                                    <form action="{{ route('leader.approve', $req->id) }}" method="POST">
                                        @csrf
                                        <button type="submit" class="btn-primary bg-blue-600 hover:bg-blue-700 border-none" onclick="return confirm('Setujui pengajuan ini?')">
                                            Setujui
                                        </button>
                                    </form>

                                    <div x-data="{ open: false }" class="relative">
                                        <button @click="open = !open" class="btn-primary bg-rose-600 text-white border border-rose-200 hover:bg-rose-50">
                                            Tolak
                                        </button>
                                        
                                        <div x-show="open" @click.away="open = false" class="absolute right-0 mt-2 w-72 bg-white border border-nordic-mute rounded-xl shadow-xl p-4 z-20">
                                            <form action="{{ route('leader.reject', $req->id) }}" method="POST">
                                                @csrf
                                                <label class="block text-xs font-bold mb-1 text-nordic-dark">Alasan Penolakan:</label>
                                                <textarea name="rejection_note" class="form-input w-full text-xs mb-2" rows="2" required></textarea>
                                                <button type="submit" class="w-full bg-rose-600 text-white text-xs font-bold py-2 rounded hover:bg-rose-700">Kirim Penolakan</button>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>
                @endif
            </div>
        </div>
    </div>
</x-app-layout>