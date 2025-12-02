<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-nordic-dark leading-tight">
            {{ __('Edit User: ') . $user->name }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="card">
                
                <form action="{{ route('admin.users.update', $user->id) }}" method="POST">
                    @csrf
                    @method('PUT')

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        
                        <div class="space-y-4">
                            <h3 class="text-md font-bold text-nordic-dark border-b border-nordic-mute pb-2">Informasi Akun</h3>

                            <div>
                                <label class="block text-sm font-medium text-nordic-dark mb-1">Nama Lengkap</label>
                                <input type="text" name="name" value="{{ old('name', $user->name) }}" required class="form-input w-full">
                                @error('name') <span class="text-rose-500 text-xs">{{ $message }}</span> @enderror
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-nordic-dark mb-1">Username</label>
                                <input type="text" name="username" value="{{ old('username', $user->username) }}" required class="form-input w-full bg-slate-50">
                                @error('username') <span class="text-rose-500 text-xs">{{ $message }}</span> @enderror
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-nordic-dark mb-1">Email</label>
                                <input type="email" name="email" value="{{ old('email', $user->email) }}" required class="form-input w-full">
                                @error('email') <span class="text-rose-500 text-xs">{{ $message }}</span> @enderror
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-nordic-dark mb-1">Password Baru (Opsional)</label>
                                <input type="password" name="password" placeholder="Kosongkan jika tidak ingin mengganti" class="form-input w-full">
                                <p class="text-xs text-nordic-gray mt-1">Isi hanya jika ingin mereset password user ini.</p>
                                @error('password') <span class="text-rose-500 text-xs">{{ $message }}</span> @enderror
                            </div>
                        </div>

                        <div class="space-y-4">
                            <h3 class="text-md font-bold text-nordic-dark border-b border-nordic-mute pb-2">Detail Pekerjaan & Status</h3>

                            <div>
                                <label class="block text-sm font-medium text-nordic-dark mb-1">Role</label>
                                <select name="role" required class="form-input w-full">
                                    <option value="user" {{ old('role', $user->role) == 'user' ? 'selected' : '' }}>Karyawan (User)</option>
                                    <option value="leader" {{ old('role', $user->role) == 'leader' ? 'selected' : '' }}>Ketua Divisi</option>
                                    <option value="hrd" {{ old('role', $user->role) == 'hrd' ? 'selected' : '' }}>HRD</option>
                                    <option value="admin" {{ old('role', $user->role) == 'admin' ? 'selected' : '' }}>Admin</option>
                                </select>
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-nordic-dark mb-1">Divisi</label>
                                <select name="division_id" class="form-input w-full">
                                    <option value="">-- Tidak Ada Divisi --</option>
                                    @foreach($divisions as $div)
                                        <option value="{{ $div->id }}" {{ old('division_id', $user->division_id) == $div->id ? 'selected' : '' }}>
                                            {{ $div->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-nordic-dark mb-1">Kuota Cuti Tahunan</label>
                                <input type="number" name="annual_leave_quota" value="{{ old('annual_leave_quota', $user->annual_leave_quota) }}" required min="0" class="form-input w-full">
                            </div>

                            <div class="pt-4">
                                <label class="inline-flex items-center p-3 bg-nordic-light rounded-lg border border-nordic-mute w-full cursor-pointer hover:bg-white transition">
                                    <input type="checkbox" name="is_active" value="1" class="rounded border-nordic-mute text-nordic-dark shadow-sm focus:ring-nordic-gray"
                                    {{ old('is_active', $user->is_active) ? 'checked' : '' }}>
                                    <div class="ml-3">
                                        <span class="block text-sm font-bold text-nordic-dark">Status Akun Aktif</span>
                                        <span class="block text-xs text-nordic-gray">Jika tidak dicentang, user tidak bisa login.</span>
                                    </div>
                                </label>
                            </div>
                        </div>
                    </div>

                    <div class="flex justify-end gap-3 mt-8 pt-4 border-t border-nordic-mute">
                        <a href="{{ route('admin.users.index') }}" class="btn-secondary">Batal</a>
                        <button type="submit" class="btn-primary">Update User</button>
                    </div>

                </form>
            </div>
        </div>
    </div>
</x-app-layout>