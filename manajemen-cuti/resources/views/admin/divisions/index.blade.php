<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-nordic-dark leading-tight">
                {{ __('Manajemen Divisi') }}
            </h2>
            <a href="{{ route('admin.divisions.create') }}" class="btn-primary">
                + Tambah Divisi
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            
            @if(session('success'))
                <div class="bg-emerald-100 border border-emerald-400 text-emerald-700 px-4 py-3 rounded-lg relative mb-6" role="alert">
                    <span class="block sm:inline">{{ session('success') }}</span>
                </div>
            @endif

            <div class="card overflow-hidden p-0">
                <div class="overflow-x-auto">
                    <table class="w-full text-left text-sm">
                        <thead class="bg-nordic-light text-nordic-dark font-bold uppercase text-xs border-b border-nordic-mute">
                            <tr>
                                <th class="px-6 py-4">Nama Divisi</th>
                                <th class="px-6 py-4">Ketua Divisi</th>
                                <th class="px-6 py-4 text-center">Jumlah Anggota</th>
                                <th class="px-6 py-4 text-right">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-nordic-mute">
                            @foreach($divisions as $div)
                            <tr class="hover:bg-slate-50 transition">
                                <td class="px-6 py-4">
                                    <div class="font-bold text-nordic-dark text-base">{{ $div->name }}</div>
                                    <div class="text-xs text-nordic-gray mt-1 line-clamp-1">{{ $div->description ?? 'Tidak ada deskripsi' }}</div>
                                </td>
                                <td class="px-6 py-4">
                                    @if($div->leader)
                                        <div class="flex items-center">
                                            <div class="h-8 w-8 rounded-full bg-indigo-100 flex items-center justify-center text-indigo-700 font-bold text-xs mr-3">
                                                {{ substr($div->leader->name, 0, 2) }}
                                            </div>
                                            <div>
                                                <div class="font-bold text-nordic-dark">{{ $div->leader->name }}</div>
                                                <div class="text-xs text-nordic-gray">{{ $div->leader->email }}</div>
                                            </div>
                                        </div>
                                    @else
                                        <span class="badge bg-rose-100 text-rose-800 border border-rose-200">
                                            Kosong (Belum ada Ketua)
                                        </span>
                                    @endif
                                </td>
                                <td class="px-6 py-4 text-center">
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-nordic-light text-nordic-dark border border-nordic-mute">
                                        {{ $div->members_count }} Orang
                                    </span>
                                </td>
                                <td class="px-6 py-4 text-right space-x-2">
                                    <a href="{{ route('admin.divisions.show', $div->id) }}" class="text-emerald-600 hover:text-emerald-800 font-bold text-xs uppercase tracking-wide">
                                        Detail
                                    </a>
                                    
                                    <a href="{{ route('admin.divisions.edit', $div->id) }}" class="text-indigo-600 hover:text-indigo-900 font-bold text-xs uppercase tracking-wide">
                                        Edit
                                    </a>
                                    
                                    <form action="{{ route('admin.divisions.destroy', $div->id) }}" method="POST" class="inline-block" onsubmit="return confirm('Hapus divisi ini? Anggota akan kehilangan status divisi.');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-rose-600 hover:text-rose-900 font-bold text-xs uppercase tracking-wide">
                                            Hapus
                                        </button>
                                    </form>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                
                @if($divisions->isEmpty())
                    <div class="p-8 text-center text-nordic-gray italic">
                        Belum ada divisi yang dibuat. Silakan tambah divisi baru.
                    </div>
                @endif
            </div>
        </div>
    </div>
</x-app-layout>