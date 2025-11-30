<x-app-layout>
    <x-slot name="header">
        <h2 class="font-bold text-2xl text-primary leading-tight">
            {{ __('Tambah User Baru') }}
        </h2>
    </x-slot>

    <div class="py-10">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            
            <div class="bg-paper shadow-[0_8px_30px_rgb(0,0,0,0.04)] sm:rounded-3xl border border-cream overflow-hidden">
                
                <div class="bg-primary/5 px-8 py-6 border-b border-cream">
                    <h3 class="text-lg font-bold text-primary">Informasi Pengguna</h3>
                    <p class="text-sm text-secondary/70">Lengkapi data di bawah ini untuk menambahkan karyawan baru.</p>
                </div>

                <div class="p-8">
                    <form action="{{ route('users.store') }}" method="POST">
                        @csrf

                        <div class="mb-6">
                            <label class="block text-sm font-bold text-secondary mb-2">Nama Lengkap</label>
                            <input type="text" name="name" class="w-full rounded-xl border-secondary/20 bg-cream/10 focus:border-accent focus:ring-accent text-primary placeholder-secondary/40 transition shadow-sm" placeholder="Contoh: Andi Pratama" required>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                            <div>
                                <label class="block text-sm font-bold text-secondary mb-2">Username</label>
                                <input type="text" name="username" class="w-full rounded-xl border-secondary/20 bg-cream/10 focus:border-accent focus:ring-accent text-primary placeholder-secondary/40 transition shadow-sm" placeholder="andi.p" required>
                            </div>
                            <div>
                                <label class="block text-sm font-bold text-secondary mb-2">Email Kantor</label>
                                <input type="email" name="email" class="w-full rounded-xl border-secondary/20 bg-cream/10 focus:border-accent focus:ring-accent text-primary placeholder-secondary/40 transition shadow-sm" placeholder="andi@kantor.com" required>
                            </div>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                            <div>
                                <label class="block text-sm font-bold text-secondary mb-2">Password</label>
                                <input type="password" name="password" class="w-full rounded-xl border-secondary/20 bg-cream/10 focus:border-accent focus:ring-accent text-primary placeholder-secondary/40 transition shadow-sm" required>
                            </div>
                            <div>
                                <label class="block text-sm font-bold text-secondary mb-2">Konfirmasi Password</label>
                                <input type="password" name="password_confirmation" class="w-full rounded-xl border-secondary/20 bg-cream/10 focus:border-accent focus:ring-accent text-primary placeholder-secondary/40 transition shadow-sm" required>
                            </div>
                        </div>

                        <hr class="border-cream my-8">

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                            <div>
                                <label class="block text-sm font-bold text-secondary mb-2">Role / Jabatan</label>
                                <select name="role" class="w-full rounded-xl border-secondary/20 bg-cream/10 focus:border-accent focus:ring-accent text-primary transition shadow-sm" required>
                                    <option value="employee">Employee (Karyawan)</option>
                                    <option value="division_manager">Division Manager (Ketua Divisi)</option>
                                    <option value="hr">HRD</option>
                                    <option value="admin">Admin Sistem</option>
                                </select>
                            </div>
                            <div>
                                <label class="block text-sm font-bold text-secondary mb-2">Divisi</label>
                                <select name="division_id" class="w-full rounded-xl border-secondary/20 bg-cream/10 focus:border-accent focus:ring-accent text-primary transition shadow-sm">
                                    <option value="">-- Tidak Ada / Admin --</option>
                                    @foreach($divisions as $div)
                                        <option value="{{ $div->id }}">{{ $div->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="mb-8">
                            <label class="block text-sm font-bold text-secondary mb-2">Kuota Cuti Tahunan</label>
                            <div class="flex items-center">
                                <input type="number" name="annual_leave_quota" value="12" class="w-24 rounded-xl border-secondary/20 bg-cream/10 focus:border-accent focus:ring-accent text-primary text-center font-bold transition shadow-sm" required>
                                <span class="ml-3 text-secondary font-medium">Hari</span>
                            </div>
                        </div>

                        <div class="flex items-center justify-end gap-4 bg-cream/20 -m-8 p-6 mt-4 border-t border-cream">
                            <a href="{{ route('users.index') }}" class="px-6 py-3 rounded-xl text-sm font-bold text-secondary hover:bg-cream/50 transition">
                                Batal
                            </a>
                            <button type="submit" class="px-8 py-3 bg-primary text-cream font-bold rounded-xl shadow-lg hover:bg-secondary hover:shadow-xl transition transform hover:-translate-y-1">
                                Simpan Data User
                            </button>
                        </div>
                    </form>

                </div>
            </div>
        </div>
    </div>
</x-app-layout>