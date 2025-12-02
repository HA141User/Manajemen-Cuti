<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-nordic-dark leading-tight">
            {{ __('Buat Divisi Baru') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-2xl mx-auto sm:px-6 lg:px-8">
            <div class="card">
                
                <form action="{{ route('admin.divisions.store') }}" method="POST">
                    @csrf

                    <div class="mb-5">
                        <label class="block text-sm font-bold text-nordic-dark mb-2">Nama Divisi</label>
                        <input type="text" name="name" value="{{ old('name') }}" required placeholder="Contoh: Marketing, IT, Finance"
                               class="form-input w-full">
                        @error('name') <span class="text-rose-500 text-xs mt-1 block">{{ $message }}</span> @enderror
                    </div>

                    <div class="mb-5">
                        <label class="block text-sm font-bold text-nordic-dark mb-2">Deskripsi (Opsional)</label>
                        <textarea name="description" rows="3" placeholder="Jelaskan fungsi divisi ini..."
                               class="form-input w-full">{{ old('description') }}</textarea>
                    </div>

                    <div class="mb-8">
                        <label class="block text-sm font-bold text-nordic-dark mb-2">Ketua Divisi</label>
                        <select name="leader_id" required class="form-input w-full bg-slate-50">
                            <option value="">-- Pilih User (Role Leader) --</option>
                            @foreach($potentialLeaders as $leader)
                                <option value="{{ $leader->id }}" {{ old('leader_id') == $leader->id ? 'selected' : '' }}>
                                    {{ $leader->name }} ({{ $leader->email }})
                                </option>
                            @endforeach
                        </select>
                        <div class="mt-2 p-3 bg-blue-50 border border-blue-100 rounded-lg text-xs text-blue-700 flex items-start">
                            <svg class="w-4 h-4 mr-2 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                            <span>Hanya user dengan Role <b>'Leader'</b> yang belum memimpin divisi lain yang muncul di sini. Jika kosong, pastikan Anda sudah membuat user dengan role Leader terlebih dahulu.</span>
                        </div>
                        @error('leader_id') <span class="text-rose-500 text-xs mt-1 block">{{ $message }}</span> @enderror
                    </div>

                    <div class="flex justify-end gap-3 pt-4 border-t border-nordic-mute">
                        <a href="{{ route('admin.divisions.index') }}" class="btn-secondary">Batal</a>
                        <button type="submit" class="btn-primary">Simpan Divisi</button>
                    </div>

                </form>
            </div>
        </div>
    </div>
</x-app-layout>