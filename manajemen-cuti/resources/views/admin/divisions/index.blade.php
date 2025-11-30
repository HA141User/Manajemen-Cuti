<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col md:flex-row justify-between items-center gap-6">
            <h2 class="font-bold text-2xl text-primary leading-tight tracking-tight">
                {{ __('Manajemen Divisi') }}
            </h2>
            
            <a href="{{ route('divisions.create') }}" class="group inline-flex items-center px-8 py-3 bg-primary border border-transparent rounded-full font-bold text-xs text-cream uppercase tracking-widest hover:bg-secondary active:bg-primary focus:outline-none focus:border-secondary focus:ring ring-secondary/50 disabled:opacity-25 transition ease-in-out duration-300 shadow-lg hover:shadow-xl transform hover:-translate-y-1 gap-3">
                <svg class="w-5 h-5 text-accent group-hover:text-white transition" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                <span>Tambah Divisi Baru</span>
            </a>
        </div>
    </x-slot>

    <div class="py-10">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            
            <div class="bg-paper overflow-hidden shadow-[0_8px_30px_rgb(0,0,0,0.04)] sm:rounded-3xl border border-cream">
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-cream">
                        <thead class="bg-cream/30">
                            <tr>
                                <th scope="col" class="px-8 py-6 text-left text-xs font-extrabold text-secondary uppercase tracking-wider">Nama Divisi</th>
                                <th scope="col" class="px-6 py-6 text-left text-xs font-extrabold text-secondary uppercase tracking-wider">Manager / Ketua</th>
                                <th scope="col" class="px-6 py-6 text-left text-xs font-extrabold text-secondary uppercase tracking-wider">Anggota</th>
                                <th scope="col" class="px-8 py-6 text-right text-xs font-extrabold text-secondary uppercase tracking-wider">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="bg-paper divide-y divide-cream/50">
                            @foreach($divisions as $division)
                            <tr class="hover:bg-cream/10 transition duration-150 ease-in-out group">
                                
                                <td class="px-8 py-5 whitespace-nowrap">
                                    <div class="flex items-center">
                                        <div class="p-3 rounded-xl bg-primary/5 text-primary group-hover:bg-primary group-hover:text-cream transition duration-300">
                                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path></svg>
                                        </div>
                                        <div class="ml-4">
                                            <div class="text-sm font-bold text-primary">{{ $division->name }}</div>
                                            <div class="text-xs text-secondary/60">Dept. ID: #{{ $division->id }}</div>
                                        </div>
                                    </div>
                                </td>

                                <td class="px-6 py-5 whitespace-nowrap">
                                    @if($division->manager)
                                        <div class="flex items-center">
                                            <div class="h-8 w-8 rounded-full bg-accent text-white flex items-center justify-center text-xs font-bold mr-3 shadow-sm">
                                                {{ substr($division->manager->name, 0, 1) }}
                                            </div>
                                            <div>
                                                <div class="text-sm font-bold text-secondary">{{ $division->manager->name }}</div>
                                                <div class="text-[10px] text-secondary/50 uppercase">Division Manager</div>
                                            </div>
                                        </div>
                                    @else
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-red-50 text-red-600 border border-red-100">
                                            Kosong
                                        </span>
                                    @endif
                                </td>

                                <td class="px-6 py-5 whitespace-nowrap">
                                    <div class="flex items-center">
                                        <span class="text-lg font-bold text-primary">{{ $division->users_count }}</span>
                                        <span class="text-xs text-secondary/60 ml-2">Pegawai</span>
                                    </div>
                                </td>

                                <td class="px-8 py-5 whitespace-nowrap text-right text-sm font-medium">
                                    <div class="flex justify-end items-center gap-3">
                                        <a href="{{ route('divisions.edit', $division->id) }}" class="text-secondary hover:text-accent font-bold transition">Edit</a>
                                        
                                        <form action="{{ route('divisions.destroy', $division->id) }}" method="POST" class="inline-block" id="delete-div-{{ $division->id }}">
                                            @csrf
                                            @method('DELETE')
                                            <button type="button" onclick="confirmDelete('delete-div-{{ $division->id }}')" class="text-red-400 hover:text-red-600 font-bold transition">
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
            </div>
        </div>
    </div>
</x-app-layout>