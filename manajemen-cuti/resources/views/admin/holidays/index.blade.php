<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-nordic-dark leading-tight">
                {{ __('Manajemen Hari Libur') }}
            </h2>
            <a href="{{ route('admin.holidays.create') }}" class="btn-primary">
                + Tambah Hari Libur
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            
            @if(session('success'))
                <div class="bg-emerald-100 border border-emerald-400 text-emerald-700 px-4 py-3 rounded-lg relative mb-6">
                    {{ session('success') }}
                </div>
            @endif

            <div class="card overflow-hidden p-0">
                <div class="overflow-x-auto">
                    <table class="w-full text-left text-sm">
                        <thead class="bg-nordic-light text-nordic-dark font-bold uppercase text-xs border-b border-nordic-mute">
                            <tr>
                                <th class="px-6 py-4">Tanggal</th>
                                <th class="px-6 py-4">Nama Libur</th>
                                <th class="px-6 py-4">Deskripsi</th>
                                <th class="px-6 py-4 text-right">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-nordic-mute">
                            @forelse($holidays as $h)
                            <tr class="hover:bg-slate-50 transition">
                                <td class="px-6 py-4">
                                    <div class="flex items-center">
                                        <div class="bg-indigo-50 text-indigo-700 rounded-lg p-2 mr-3 text-center min-w-[50px]">
                                            <span class="block text-xs font-bold uppercase">{{ $h->holiday_date->format('M') }}</span>
                                            <span class="block text-lg font-bold">{{ $h->holiday_date->format('d') }}</span>
                                        </div>
                                        <div>
                                            <span class="font-bold text-nordic-dark block">{{ $h->holiday_date->format('l') }}</span>
                                            <span class="text-xs text-nordic-gray">{{ $h->holiday_date->format('Y') }}</span>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-6 py-4 font-bold text-nordic-dark">
                                    {{ $h->title }}
                                </td>
                                <td class="px-6 py-4 text-nordic-gray">
                                    {{ $h->description ?? '-' }}
                                </td>
                                <td class="px-6 py-4 text-right space-x-2">
                                    <a href="{{ route('admin.holidays.edit', $h->id) }}" class="text-indigo-600 hover:text-indigo-900 font-bold text-xs uppercase tracking-wide">
                                        Edit
                                    </a>
                                    <form action="{{ route('admin.holidays.destroy', $h->id) }}" method="POST" class="inline-block" onsubmit="return confirm('Hapus hari libur ini?');">
                                        @csrf @method('DELETE')
                                        <button type="submit" class="text-rose-600 hover:text-rose-900 font-bold text-xs uppercase tracking-wide">
                                            Hapus
                                        </button>
                                    </form>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="4" class="px-6 py-10 text-center text-nordic-gray italic">
                                    <div class="flex flex-col items-center justify-center">
                                        <svg class="w-12 h-12 text-nordic-mute mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                                        <p>Belum ada data hari libur.</p>
                                    </div>
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                
                @if($holidays->hasPages())
                    <div class="px-6 py-4 border-t border-nordic-mute bg-nordic-light">
                        {{ $holidays->links() }}
                    </div>
                @endif
            </div>
        </div>
    </div>
</x-app-layout>