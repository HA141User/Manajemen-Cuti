<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-nordic-dark leading-tight">
            {{ __('Detail Divisi') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            
            @if(session('success'))
                <div class="bg-emerald-100 border border-emerald-400 text-emerald-700 px-4 py-3 rounded-lg relative mb-6">
                    {{ session('success') }}
                </div>
            @endif
            @if(session('error'))
                <div class="bg-rose-100 border border-rose-400 text-rose-700 px-4 py-3 rounded-lg relative mb-6">
                    {{ session('error') }}
                </div>
            @endif

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                
                <div class="space-y-6">
                    
                    <div class="card border-t-4 border-t-nordic-dark">
                        <div class="mb-4">
                            <h3 class="text-xl font-bold text-nordic-dark">{{ $division->name }}</h3>
                            <p class="text-sm text-nordic-gray mt-1">{{ $division->description ?? 'Tidak ada deskripsi.' }}</p>
                        </div>

                        <div class="space-y-4 border-t border-nordic-mute pt-4">
                            <div>
                                <label class="text-xs text-nordic-gray uppercase font-bold tracking-wider">Ketua Divisi</label>
                                <div class="mt-1 flex items-center">
                                    @if($division->leader)
                                        <div class="h-8 w-8 rounded-full bg-indigo-100 flex items-center justify-center text-indigo-700 font-bold text-xs mr-3">
                                            {{ substr($division->leader->name, 0, 2) }}
                                        </div>
                                        <span class="text-sm font-bold text-nordic-dark">{{ $division->leader->name }}</span>
                                    @else
                                        <span class="text-rose-500 text-sm italic">Belum ada ketua</span>
                                    @endif
                                </div>
                            </div>
                            
                            <div>
                                <label class="text-xs text-nordic-gray uppercase font-bold tracking-wider">Total Anggota</label>
                                <p class="text-2xl font-bold text-nordic-dark mt-1">{{ $division->members->count() }} <span class="text-sm font-normal text-nordic-gray">Orang</span></p>
                            </div>
                        </div>

                        <div class="mt-6 pt-4 border-t border-nordic-mute">
                            <a href="{{ route('admin.divisions.index') }}" class="btn-secondary w-full justify-center">
                                &larr; Kembali ke Daftar
                            </a>
                        </div>
                    </div>

                    <div class="card bg-nordic-light border-dashed border-2 border-nordic-mute">
                        <h3 class="text-sm font-bold text-nordic-dark mb-3 flex items-center">
                            <svg class="w-4 h-4 mr-2 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z"></path></svg>
                            Tambah Anggota Baru
                        </h3>
                        
                        @if($nonDivisionalEmployees->count() > 0)
                            <form action="{{ route('admin.divisions.members.add', $division->id) }}" method="POST">
                                @csrf
                                <div class="mb-3">
                                    <select name="user_id" required class="form-input w-full text-sm">
                                        <option value="">-- Pilih Karyawan (Non-Divisi) --</option>
                                        @foreach($nonDivisionalEmployees as $emp)
                                            <option value="{{ $emp->id }}">{{ $emp->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <button type="submit" class="btn-primary w-full justify-center bg-emerald-600 hover:bg-emerald-700 focus:ring-emerald-500">
                                    + Masukkan
                                </button>
                            </form>
                        @else
                            <div class="p-3 bg-white rounded border border-nordic-mute text-center">
                                <p class="text-xs text-nordic-gray">Semua karyawan User sudah memiliki divisi.</p>
                                <a href="{{ route('admin.users.create') }}" class="text-xs text-blue-600 hover:underline mt-1 block">Buat user baru?</a>
                            </div>
                        @endif
                    </div>

                </div>

                <div class="lg:col-span-2">
                    <div class="card overflow-hidden p-0 h-full">
                        <div class="px-6 py-4 border-b border-nordic-mute bg-white flex justify-between items-center">
                            <h3 class="text-lg font-bold text-nordic-dark">Daftar Anggota</h3>
                            <span class="badge bg-nordic-light text-nordic-dark">{{ $division->members->count() }} Item</span>
                        </div>
                        
                        <div class="overflow-x-auto">
                            <table class="w-full text-left text-sm">
                                <thead class="bg-nordic-light text-nordic-gray uppercase text-xs">
                                    <tr>
                                        <th class="px-6 py-3 font-bold">Nama</th>
                                        <th class="px-6 py-3 font-bold">Role</th>
                                        <th class="px-6 py-3 font-bold">Status</th>
                                        <th class="px-6 py-3 font-bold text-right">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-nordic-mute bg-white">
                                    @forelse($division->members as $member)
                                    <tr class="hover:bg-slate-50 transition">
                                        <td class="px-6 py-4">
                                            <div class="flex items-center">
                                                <div class="font-bold text-nordic-dark">{{ $member->name }}</div>
                                                @if($division->leader_id == $member->id)
                                                    <span class="ml-2 badge bg-indigo-100 text-indigo-800 border border-indigo-200">KETUA</span>
                                                @endif
                                            </div>
                                            <div class="text-xs text-nordic-gray">{{ $member->email }}</div>
                                        </td>
                                        <td class="px-6 py-4">
                                            <span class="uppercase text-xs font-bold text-nordic-gray">{{ $member->role }}</span>
                                        </td>
                                        <td class="px-6 py-4">
                                            @if($member->is_active)
                                                <span class="text-emerald-600 text-xs font-bold flex items-center">
                                                    <span class="w-1.5 h-1.5 bg-emerald-500 rounded-full mr-2"></span> Active
                                                </span>
                                            @else
                                                <span class="text-rose-500 text-xs font-bold flex items-center">
                                                    <span class="w-1.5 h-1.5 bg-rose-500 rounded-full mr-2"></span> Inactive
                                                </span>
                                            @endif
                                        </td>
                                        <td class="px-6 py-4 text-right">
                                            @if($division->leader_id != $member->id)
                                                <form action="{{ route('admin.divisions.members.remove', $member->id) }}" method="POST" class="inline-block" onsubmit="return confirm('Keluarkan {{ $member->name }} dari divisi ini?');">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="text-rose-600 hover:text-rose-800 text-xs font-bold uppercase tracking-wide border border-rose-200 bg-rose-50 px-3 py-1 rounded hover:bg-rose-100 transition">
                                                        Keluarkan
                                                    </button>
                                                </form>
                                            @else
                                                <span class="text-nordic-mute text-xs italic">Ketua</span>
                                            @endif
                                        </td>
                                    </tr>
                                    @empty
                                    <tr>
                                        <td colspan="4" class="px-6 py-8 text-center text-nordic-gray italic">
                                            Belum ada anggota di divisi ini.
                                        </td>
                                    </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
</x-app-layout>