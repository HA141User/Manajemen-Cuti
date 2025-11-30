<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col md:flex-row justify-between items-center gap-6">
            <h2 class="font-bold text-2xl text-primary leading-tight tracking-tight">
                {{ __('Kalender Libur') }}
            </h2>
            
            <a href="{{ route('holidays.create') }}" class="group inline-flex items-center px-8 py-3 bg-accent border border-transparent rounded-full font-bold text-xs text-white uppercase tracking-widest hover:bg-[#8e6a4e] active:bg-accent focus:outline-none transition ease-in-out duration-300 shadow-lg hover:shadow-xl transform hover:-translate-y-1 gap-3">
                <svg class="w-5 h-5 group-hover:scale-110 transition" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                <span>Tambah Tanggal Merah</span>
            </a>
        </div>
    </x-slot>

    <div class="py-10">
        <div class="max-w-5xl mx-auto sm:px-6 lg:px-8">
            
            <div class="bg-paper overflow-hidden shadow-[0_8px_30px_rgb(0,0,0,0.04)] sm:rounded-3xl border border-cream">
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-cream">
                        <thead class="bg-cream/30">
                            <tr>
                                <th scope="col" class="px-8 py-6 text-left text-xs font-extrabold text-secondary uppercase tracking-wider">Tanggal</th>
                                <th scope="col" class="px-6 py-6 text-left text-xs font-extrabold text-secondary uppercase tracking-wider">Keterangan / Perayaan</th>
                                <th scope="col" class="px-8 py-6 text-right text-xs font-extrabold text-secondary uppercase tracking-wider">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="bg-paper divide-y divide-cream/50">
                            @foreach($holidays as $holiday)
                            <tr class="hover:bg-cream/10 transition duration-150 ease-in-out group">
                                
                                <td class="px-8 py-5 whitespace-nowrap">
                                    <div class="flex items-center gap-4">
                                        <div class="w-12 h-12 bg-white border border-cream rounded-xl flex flex-col items-center justify-center shadow-sm group-hover:border-accent transition">
                                            <span class="text-[10px] font-bold text-red-500 uppercase">{{ $holiday->holiday_date->format('M') }}</span>
                                            <span class="text-lg font-extrabold text-primary leading-none">{{ $holiday->holiday_date->format('d') }}</span>
                                        </div>
                                        <div class="flex flex-col">
                                            <span class="text-sm font-bold text-primary">{{ $holiday->holiday_date->translatedFormat('l') }}</span>
                                            <span class="text-xs text-secondary/60">{{ $holiday->holiday_date->format('Y') }}</span>
                                        </div>
                                    </div>
                                </td>

                                <td class="px-6 py-5 whitespace-nowrap text-sm font-medium text-secondary">
                                    {{ $holiday->description }}
                                </td>

                                <td class="px-8 py-5 whitespace-nowrap text-right text-sm font-medium">
                                    <div class="flex justify-end items-center gap-3">
                                        <a href="{{ route('holidays.edit', $holiday->id) }}" class="text-secondary hover:text-accent font-bold transition">Edit</a>
                                        <form action="{{ route('holidays.destroy', $holiday->id) }}" method="POST" class="inline-block" id="delete-hol-{{ $holiday->id }}">
                                            @csrf
                                            @method('DELETE')
                                            <button type="button" onclick="confirmDelete('delete-hol-{{ $holiday->id }}')" class="text-red-400 hover:text-red-600 font-bold transition">
                                                Hapus
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                <div class="px-8 py-5 border-t border-cream bg-cream/20">
                    {{ $holidays->links() }}
                </div>
            </div>
        </div>
    </div>
</x-app-layout>