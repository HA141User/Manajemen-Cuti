<x-app-layout>
    <x-slot name="header">
        <h2 class="font-bold text-2xl text-primary leading-tight">
            {{ __('Persetujuan Cuti') }}
        </h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            
            @if($approvals->isEmpty())
                <div class="flex flex-col items-center justify-center bg-paper border border-cream rounded-3xl p-16 text-center shadow-sm">
                    <div class="bg-secondary/10 p-6 rounded-full mb-6 animate-pulse">
                        <svg class="w-16 h-16 text-secondary" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                    </div>
                    <h3 class="text-2xl font-bold text-primary mb-2">Semua Bersih!</h3>
                    <p class="text-secondary/70 max-w-md">Tidak ada pengajuan cuti yang perlu diproses saat ini. Silakan nikmati kopi Anda ☕</p>
                </div>
            @else
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                    @foreach($approvals as $leave)
                    <div class="bg-paper rounded-3xl shadow-[0_8px_30px_rgb(0,0,0,0.04)] hover:shadow-[0_8px_30px_rgb(0,0,0,0.08)] transition duration-300 border border-cream overflow-hidden flex flex-col group" x-data="{ showReject: false }">
                        
                        <div class="bg-primary/5 p-6 pb-4 flex items-start justify-between border-b border-cream">
                            <div class="flex items-center space-x-4">
                                <div class="h-12 w-12 rounded-2xl bg-primary text-cream flex items-center justify-center font-bold text-lg shadow-md group-hover:bg-accent transition duration-500">
                                    {{ substr($leave->user->name, 0, 1) }}
                                </div>
                                <div>
                                    <h4 class="text-base font-bold text-primary line-clamp-1">{{ $leave->user->name }}</h4>
                                    <p class="text-xs font-medium text-secondary/70">{{ $leave->user->division->name ?? 'Staff' }}</p>
                                </div>
                            </div>
                            <div class="bg-white px-3 py-1 rounded-full text-xs font-bold text-secondary shadow-sm border border-cream">
                                {{ $leave->created_at->diffForHumans(null, true) }}
                            </div>
                        </div>

                        <div class="p-6 flex-grow">
                            <div class="flex items-center gap-3 mb-6">
                                <span class="px-3 py-1 rounded-lg text-xs font-bold uppercase tracking-wider {{ $leave->leave_type == 'annual' ? 'bg-blue-50 text-blue-700 border border-blue-100' : 'bg-orange-50 text-orange-700 border border-orange-100' }}">
                                    {{ $leave->leave_type == 'annual' ? 'Tahunan' : 'Sakit' }}
                                </span>
                                <span class="text-sm font-bold text-primary flex items-center">
                                    <svg class="w-4 h-4 mr-1 text-accent" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                    {{ $leave->total_days }} Hari
                                </span>
                            </div>
                            
                            <div class="space-y-4 mb-4">
                                <div class="flex items-center text-sm text-secondary font-medium">
                                    <svg class="w-5 h-5 mr-3 text-accent" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                                    {{ $leave->start_date->format('d M') }} - {{ $leave->end_date->format('d M Y') }}
                                </div>
                                <div class="bg-cream/30 p-4 rounded-xl text-sm text-secondary italic border border-cream/50 relative">
                                    <span class="absolute top-2 left-2 text-accent/20 text-4xl leading-none">“</span>
                                    <span class="relative z-10 pl-2">{{ $leave->reason }}</span>
                                </div>
                            </div>

                            @if($leave->attachment_path)
                                <a href="{{ asset('storage/' . $leave->attachment_path) }}" target="_blank" class="flex items-center justify-center w-full py-2 text-xs font-bold text-accent bg-accent/5 rounded-lg border border-accent/20 hover:bg-accent hover:text-white transition mt-2">
                                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.172 7l-6.586 6.586a2 2 0 102.828 2.828l6.414-6.586a4 4 0 00-5.656-5.656l-6.415 6.585a6 6 0 108.486 8.486L20.5 13"></path></svg>
                                    Lihat Lampiran Dokter
                                </a>
                            @endif

                            <div x-show="showReject" x-transition.origin.top class="mt-4 pt-4 border-t border-cream">
                                <form action="{{ route('approvals.reject', $leave->id) }}" method="POST">
                                    @csrf
                                    @method('PATCH')
                                    <textarea name="rejection_reason" rows="2" class="w-full text-sm rounded-xl border-secondary/20 bg-white focus:ring-red-500 focus:border-red-500 mb-3" placeholder="Alasan penolakan..." required></textarea>
                                    <div class="flex justify-end gap-2">
                                        <button type="button" @click="showReject = false" class="px-3 py-1.5 text-xs font-bold text-secondary hover:bg-gray-100 rounded-lg transition">Batal</button>
                                        <button type="submit" class="px-4 py-1.5 bg-red-600 text-white text-xs rounded-lg hover:bg-red-700 font-bold shadow-lg shadow-red-200 transition">Kirim Tolak</button>
                                    </div>
                                </form>
                            </div>
                        </div>

                        <div class="bg-white p-4 border-t border-cream flex gap-3" x-show="!showReject">
                            <button @click="showReject = true" class="flex-1 py-3 rounded-xl border border-red-100 text-red-600 font-bold text-sm hover:bg-red-50 transition">
                                Tolak
                            </button>
                            
                            <form action="{{ route('approvals.approve', $leave->id) }}" method="POST" class="flex-1">
                                @csrf
                                @method('PATCH')
                                <button type="submit" class="w-full py-3 rounded-xl bg-primary text-cream font-bold text-sm hover:bg-secondary hover:shadow-lg transition transform hover:-translate-y-0.5">
                                    Setujui
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