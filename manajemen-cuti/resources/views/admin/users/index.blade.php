<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-nordic-dark leading-tight">
                {{ __('Manajemen Pengguna') }}
            </h2>
            <a href="{{ route('admin.users.create') }}" class="btn-primary">
                + Tambah User
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            
            @if(session('success'))
                <div class="bg-emerald-100 border border-emerald-400 text-emerald-700 px-4 py-3 rounded-lg relative" role="alert">
                    <span class="block sm:inline">{{ session('success') }}</span>
                </div>
            @endif

             @if(session('error'))
                <div class="bg-rose-100 border border-rose-400 text-rose-700 px-4 py-3 rounded-lg relative" role="alert">
                    <span class="block sm:inline">{{ session('error') }}</span>
                </div>
            @endif

            <div class="card">
                <form method="GET" action="{{ route('admin.users.index') }}">
                    <div class="grid grid-cols-1 md:grid-cols-4 gap-4 items-end">
                        <div class="col-span-1">
                            <label class="text-xs font-bold text-nordic-gray uppercase mb-1 block">Pencarian</label>
                            <input type="text" name="search" placeholder="Nama atau Email..." value="{{ request('search') }}" 
                                   class="form-input w-full text-sm">
                        </div>

                        <div class="col-span-1">
                            <label class="text-xs font-bold text-nordic-gray uppercase mb-1 block">Role</label>
                            <select name="role" class="form-input w-full text-sm">
                                <option value="">-- Semua Role --</option>
                                <option value="user" {{ request('role') == 'user' ? 'selected' : '' }}>Karyawan (User)</option>
                                <option value="leader" {{ request('role') == 'leader' ? 'selected' : '' }}>Ketua Divisi</option>
                                <option value="hrd" {{ request('role') == 'hrd' ? 'selected' : '' }}>HRD</option>
                                <option value="admin" {{ request('role') == 'admin' ? 'selected' : '' }}>Admin</option>
                            </select>
                        </div>

                        <div class="col-span-1">
                            <label class="text-xs font-bold text-nordic-gray uppercase mb-1 block">Divisi</label>
                            <select name="division_id" class="form-input w-full text-sm">
                                <option value="">-- Semua Divisi --</option>
                                @foreach($divisions as $div)
                                    <option value="{{ $div->id }}" {{ request('division_id') == $div->id ? 'selected' : '' }}>
                                        {{ $div->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="col-span-1 flex gap-2">
                            <button type="submit" class="btn-primary w-full justify-center">
                                Filter
                            </button>
                            @if(request()->has('search') || request()->has('role') || request()->has('division_id'))
                                <a href="{{ route('admin.users.index') }}" class="btn-secondary w-auto flex items-center justify-center">
                                    Reset
                                </a>
                            @endif
                        </div>
                    </div>
                </form>
            </div>

            <div class="card overflow-hidden p-0"> <div class="overflow-x-auto">
                    <table class="w-full text-left text-sm">
                        <thead class="bg-nordic-light text-nordic-dark font-bold uppercase text-xs border-b border-nordic-mute">
                            <tr>
                                <th class="px-6 py-4">Nama / Email</th>
                                <th class="px-6 py-4">Role</th>
                                <th class="px-6 py-4">Divisi</th>
                                <th class="px-6 py-4">Status</th>
                                <th class="px-6 py-4 text-right">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-nordic-mute">
                            @forelse($users as $user)
                            <tr class="hover:bg-slate-50 transition">
                                <td class="px-6 py-4">
                                    <div class="font-bold text-nordic-dark">{{ $user->name }}</div>
                                    <div class="text-xs text-nordic-gray">{{ $user->email }}</div>
                                </td>
                                <td class="px-6 py-4">
                                    <span class="badge 
                                        {{ $user->role === 'admin' ? 'bg-rose-100 text-rose-800' : '' }}
                                        {{ $user->role === 'hrd' ? 'bg-purple-100 text-purple-800' : '' }}
                                        {{ $user->role === 'leader' ? 'bg-amber-100 text-amber-800' : '' }}
                                        {{ $user->role === 'user' ? 'bg-emerald-100 text-emerald-800' : '' }}">
                                        {{ ucfirst($user->role) }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 text-nordic-gray">
                                    {{ $user->division ? $user->division->name : '-' }}
                                </td>
                                <td class="px-6 py-4">
                                    @if($user->is_active)
                                        <span class="inline-flex items-center text-xs font-bold text-emerald-600">
                                            <span class="w-2 h-2 bg-emerald-500 rounded-full mr-2"></span> Active
                                        </span>
                                    @else
                                        <span class="inline-flex items-center text-xs font-bold text-rose-600">
                                            <span class="w-2 h-2 bg-rose-500 rounded-full mr-2"></span> Inactive
                                        </span>
                                    @endif
                                </td>
                                <td class="px-6 py-4 text-right space-x-2">
                                    <a href="{{ route('admin.users.edit', $user->id) }}" class="text-indigo-600 hover:text-indigo-900 font-medium text-xs uppercase tracking-wide">Edit</a>
                                    
                                    @if($user->id !== auth()->id())
                                    <form action="{{ route('admin.users.destroy', $user->id) }}" method="POST" class="inline-block" onsubmit="return confirm('Yakin ingin menghapus user ini secara permanen?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-rose-600 hover:text-rose-900 font-medium text-xs uppercase tracking-wide">Hapus</button>
                                    </form>
                                    @endif
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="5" class="px-6 py-8 text-center text-nordic-gray italic">
                                    Tidak ada data user yang sesuai filter.
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                @if($users->hasPages())
                    <div class="px-6 py-4 border-t border-nordic-mute bg-nordic-light">
                        {{ $users->links() }}
                    </div>
                @endif
            </div>
        </div>
    </div>
</x-app-layout>