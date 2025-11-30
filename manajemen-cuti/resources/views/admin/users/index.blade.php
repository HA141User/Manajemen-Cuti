<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col md:flex-row justify-between items-center gap-6">
            <h2 class="font-bold text-2xl text-primary leading-tight tracking-tight">
                {{ __('Manajemen Pengguna') }}
            </h2>
            
            <a href="{{ route('users.create') }}" class="group inline-flex items-center px-8 py-3 bg-primary border border-transparent rounded-full font-bold text-xs text-cream uppercase tracking-widest hover:bg-secondary active:bg-primary focus:outline-none focus:border-secondary focus:ring ring-secondary/50 disabled:opacity-25 transition ease-in-out duration-300 shadow-lg hover:shadow-xl transform hover:-translate-y-1 gap-3">
                <svg class="w-5 h-5 text-accent group-hover:text-white transition" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                <span>Tambah User Baru</span>
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
                                <th scope="col" class="px-8 py-6 text-left text-xs font-extrabold text-secondary uppercase tracking-wider">User Profile</th>
                                <th scope="col" class="px-6 py-6 text-left text-xs font-extrabold text-secondary uppercase tracking-wider">Role & Jabatan</th>
                                <th scope="col" class="px-6 py-6 text-left text-xs font-extrabold text-secondary uppercase tracking-wider">Divisi</th>
                                <th scope="col" class="px-6 py-6 text-left text-xs font-extrabold text-secondary uppercase tracking-wider">Sisa Cuti</th>
                                <th scope="col" class="px-8 py-6 text-right text-xs font-extrabold text-secondary uppercase tracking-wider">Aksi</th>
                            </tr>
                        </thead>
                        
                        <tbody class="bg-paper divide-y divide-cream/50">
                            @foreach($users as $user)
                            <tr class="hover:bg-cream/10 transition duration-150 ease-in-out group">
                                
                                <td class="px-8 py-5 whitespace-nowrap">
                                    <div class="flex items-center">
                                        <div class="flex-shrink-0 h-11 w-11">
                                            <div class="h-11 w-11 rounded-2xl bg-secondary text-cream flex items-center justify-center font-bold text-base shadow-sm group-hover:bg-accent group-hover:text-white transition duration-300">
                                                {{ substr($user->name, 0, 1) }}
                                            </div>
                                        </div>
                                        <div class="ml-4">
                                            <div class="text-sm font-bold text-primary">{{ $user->name }}</div>
                                            <div class="text-xs text-secondary/70">{{ $user->email }}</div>
                                        </div>
                                    </div>
                                </td>

                                <td class="px-6 py-5 whitespace-nowrap">
                                    <span class="px-3 py-1 inline-flex text-[11px] leading-5 font-bold uppercase tracking-wide rounded-lg 
                                        {{ $user->role == 'admin' ? 'bg-red-50 text-red-700 border border-red-100' : 
                                          ($user->role == 'hr' ? 'bg-purple-50 text-purple-700 border border-purple-100' : 
                                          ($user->role == 'division_manager' ? 'bg-orange-50 text-orange-700 border border-orange-100' : 
                                          'bg-green-50 text-green-700 border border-green-100')) }}">
                                        {{ str_replace('_', ' ', $user->role) }}
                                    </span>
                                </td>

                                <td class="px-6 py-5 whitespace-nowrap text-sm text-secondary font-medium">
                                    @if($user->division)
                                        <div class="flex items-center gap-2">
                                            <div class="w-2 h-2 rounded-full bg-accent"></div>
                                            {{ $user->division->name }}
                                        </div>
                                    @else
                                        <span class="text-gray-400 italic text-xs pl-4">- Non Divisi -</span>
                                    @endif
                                </td>

                                <td class="px-6 py-5 whitespace-nowrap">
                                    <div class="flex items-center">
                                        <span class="text-lg font-bold text-primary">{{ $user->annual_leave_quota }}</span>
                                        <span class="text-xs text-secondary/60 ml-1 font-medium">Hari</span>
                                    </div>
                                </td>

                                <td class="px-8 py-5 whitespace-nowrap text-right text-sm font-medium">
                                    <div class="flex justify-end items-center gap-3">
                                        <a href="{{ route('users.edit', $user->id) }}" class="text-secondary hover:text-accent font-bold transition">Edit</a>
                                        
                                        @if(auth()->id() !== $user->id)
                                        <form action="{{ route('users.destroy', $user->id) }}" method="POST" class="inline-block" id="delete-form-{{ $user->id }}">
                                            @csrf
                                            @method('DELETE')
                                            <button type="button" onclick="confirmDelete('delete-form-{{ $user->id }}')" class="text-red-400 hover:text-red-600 font-bold transition">
                                                Hapus
                                            </button>
                                        </form>
                                        @endif
                                    </div>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                
                <div class="px-8 py-5 border-t border-cream bg-cream/20">
                    {{ $users->links() }}
                </div>
            </div>
        </div>
    </div>
</x-app-layout>