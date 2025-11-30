<x-app-layout>
    <x-slot name="header">
        <h2 class="font-bold text-2xl text-primary leading-tight">
            {{ __('Edit Data User') }}
        </h2>
    </x-slot>

    <div class="py-10">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-paper shadow-[0_8px_30px_rgb(0,0,0,0.04)] sm:rounded-3xl border border-cream overflow-hidden">
                
                <div class="bg-primary/5 px-8 py-6 border-b border-cream flex items-center gap-4">
                    <div class="h-12 w-12 rounded-2xl bg-secondary text-cream flex items-center justify-center font-bold text-xl shadow-md">
                        {{ substr($user->name, 0, 1) }}
                    </div>
                    <div>
                        <h3 class="text-lg font-bold text-primary">{{ $user->name }}</h3>
                        <p class="text-sm text-secondary/70">{{ $user->email }}</p>
                    </div>
                </div>

                <div class="p-8">
                    <form action="{{ route('users.update', $user->id) }}" method="POST">
                        @csrf
                        @method('PUT')

                        <div class="mb-6">
                            <label class="block text-sm font-bold text-secondary mb-2">Nama Lengkap</label>
                            <input type="text" name="name" value="{{ old('name', $user->name) }}" class="w-full rounded-xl border-secondary/20 bg-cream/10 focus:border-accent focus:ring-accent text-primary placeholder-secondary/40 transition shadow-sm" required>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                            <div>
                                <label class="block text-sm font-bold text-secondary mb-2">Username</label>
                                <input type="text" name="username" value="{{ old('username', $user->username) }}" class="w-full rounded-xl border-secondary/20 bg-cream/10 focus:border-accent focus:ring-accent text-primary transition shadow-sm" required>
                            </div>
                            <div>
                                <label class="block text-sm font-bold text-secondary mb-2">Email</label>
                                <input type="email" name="email" value="{{ old('email', $user->email) }}" class="w-full rounded-xl border-secondary/20 bg-cream/10 focus:border-accent focus:ring-accent text-primary transition shadow-sm" required>
                            </div>
                        </div>

                        <div class="mb-8 p-6 bg-cream/20 rounded-2xl border border-cream">
                            <h4 class="text-sm font-bold text-accent uppercase tracking-wider mb-4 flex items-center gap-2">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path></svg>
                                Keamanan Akun
                            </h4>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <div>
                                    <label class="block text-sm font-bold text-secondary mb-2">Password Baru (Opsional)</label>
                                    <input type="password" name="password" class="w-full rounded-xl border-secondary/20 bg-white focus:border-accent focus:ring-accent text-primary transition shadow-sm" placeholder="Isi jika ingin mengganti">
                                </div>
                                <div>
                                    <label class="block text-sm font-bold text-secondary mb-2">Konfirmasi Password</label>
                                    <input type="password" name="password_confirmation" class="w-full rounded-xl border-secondary/20 bg-white focus:border-accent focus:ring-accent text-primary transition shadow-sm" placeholder="Ulangi password baru">
                                </div>
                            </div>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                            <div>
                                <label class="block text-sm font-bold text-secondary mb-2">Role</label>
                                <select name="role" class="w-full rounded-xl border-secondary/20 bg-cream/10 focus:border-accent focus:ring-accent text-primary transition shadow-sm" required>
                                    <option value="employee" {{ $user->role == 'employee' ? 'selected' : '' }}>Employee</option>
                                    <option value="division_manager" {{ $user->role == 'division_manager' ? 'selected' : '' }}>Division Manager</option>
                                    <option value="hr" {{ $user->role == 'hr' ? 'selected' : '' }}>HRD</option>
                                    <option value="admin" {{ $user->role == 'admin' ? 'selected' : '' }}>Admin</option>
                                </select>
                            </div>
                            <div>
                                <label class="block text-sm font-bold text-secondary mb-2">Divisi</label>
                                <select name="division_id" class="w-full rounded-xl border-secondary/20 bg-cream/10 focus:border-accent focus:ring-accent text-primary transition shadow-sm">
                                    <option value="">-- Tidak Ada / Admin --</option>
                                    @foreach($divisions as $div)
                                        <option value="{{ $div->id }}" {{ $user->division_id == $div->id ? 'selected' : '' }}>{{ $div->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="mb-8">
                            <label class="block text-sm font-bold text-secondary mb-2">Kuota Cuti Tahunan</label>
                            <div class="flex items-center">
                                <input type="number" name="annual_leave_quota" value="{{ old('annual_leave_quota', $user->annual_leave_quota) }}" class="w-24 rounded-xl border-secondary/20 bg-cream/10 focus:border-accent focus:ring-accent text-primary text-center font-bold transition shadow-sm" required>
                                <span class="ml-3 text-secondary font-medium">Hari</span>
                            </div>
                        </div>

                        <div class="flex items-center justify-end gap-4 bg-cream/20 -m-8 p-6 mt-4 border-t border-cream">
                            <a href="{{ route('users.index') }}" class="px-6 py-3 rounded-xl text-sm font-bold text-secondary hover:bg-cream/50 transition">
                                Batal
                            </a>
                            <button type="submit" class="px-8 py-3 bg-primary text-cream font-bold rounded-xl shadow-lg hover:bg-secondary hover:shadow-xl transition transform hover:-translate-y-1">
                                Update Data
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>