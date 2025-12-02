<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-nordic-dark leading-tight">
            {{ __('Tambah User Baru') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="card">
                
                <form action="{{ route('admin.users.store') }}" method="POST">
                    @csrf

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        
                        <div class="space-y-4">
                            <h3 class="text-md font-bold text-nordic-dark border-b border-nordic-mute pb-2">Informasi Akun</h3>
                            
                            <div>
                                <label class="block text-sm font-medium text-nordic-dark mb-1">Nama Lengkap</label>
                                <input type="text" name="name" value="{{ old('name') }}" required class="form-input w-full">
                                @error('name') <span class="text-rose-500 text-xs">{{ $message }}</span> @enderror
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-nordic-dark mb-1">Username</label>
                                <input type="text" name="username" value="{{ old('username') }}" required class="form-input w-full bg-slate-50">
                                @error('username') <span class="text-rose-500 text-xs">{{ $message }}</span> @enderror
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-nordic-dark mb-1">Email</label>
                                <input type="email" name="email" value="{{ old('email') }}" required class="form-input w-full">
                                @error('email') <span class="text-rose-500 text-xs">{{ $message }}</span> @enderror
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-nordic-dark mb-1">Password</label>
                                <input type="password" name="password" required class="form-input w-full">
                                @error('password') <span class="text-rose-500 text-xs">{{ $message }}</span> @enderror
                            </div>
                        </div>

                        <div class="space-y-4">
                            <h3 class="text-md font-bold text-nordic-dark border-b border-nordic-mute pb-2">Detail Pekerjaan</h3>

                            <div>
                                <label class="block text-sm font-medium text-nordic-dark mb-1">Role / Jabatan</label>
                                <select name="role" required class="form-input w-full">
                                    <option value="user" {{ old('role') == 'user' ? 'selected' : '' }}>Karyawan (User)</option>
                                    <option value="leader" {{ old('role') == 'leader' ? 'selected' : '' }}>Ketua Divisi</option>
                                    <option value="hrd" {{ old('role') == 'hrd' ? 'selected' : '' }}>HRD</option>
                                    <option value="admin" {{ old('role') == 'admin' ? 'selected' : '' }}>Admin</option>
                                </select>
                                @error('role') <span class="text-rose-500 text-xs">{{ $message }}</span> @enderror
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-nordic-dark mb-1">Divisi</label>
                                <select name="division_id" class="form-input w-full">
                                    <option value="">-- Tidak Ada Divisi --</option>
                                    @foreach($divisions as $div)
                                        <option value="{{ $div->id }}" {{ old('division_id') == $div->id ? 'selected' : '' }}>
                                            {{ $div->name }}
                                        </option>
                                    @endforeach
                                </select>
                                <p class="text-xs text-nordic-gray mt-1">*Wajib masuk divisi agar bisa mengajukan cuti ke atasan.</p>
                                @error('division_id') <span class="text-rose-500 text-xs">{{ $message }}</span> @enderror
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-nordic-dark mb-1">Kuota Cuti Tahunan</label>
                                <input type="number" name="annual_leave_quota" value="{{ old('annual_leave_quota', 12) }}" required min="0" class="form-input w-full">
                                @error('annual_leave_quota') <span class="text-rose-500 text-xs">{{ $message }}</span> @enderror
                            </div>
                        </div>
                    </div>

                    <div class="flex justify-end gap-3 mt-8 pt-4 border-t border-nordic-mute">
                        <a href="{{ route('admin.users.index') }}" class="btn-secondary">Batal</a>
                        <button type="submit" class="btn-primary">Simpan User</button>
                    </div>

                </form>
            </div>
        </div>
    </div>
</x-app-layout>