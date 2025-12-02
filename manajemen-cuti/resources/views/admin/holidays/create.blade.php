<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-nordic-dark leading-tight">
            {{ __('Tambah Hari Libur') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-2xl mx-auto sm:px-6 lg:px-8">
            <div class="card">
                <form action="{{ route('admin.holidays.store') }}" method="POST">
                    @csrf
                    
                    <div class="mb-5">
                        <label class="block text-sm font-bold text-nordic-dark mb-2">Nama Hari Libur</label>
                        <input type="text" name="title" value="{{ old('title') }}" required 
                               class="form-input w-full" placeholder="Contoh: Tahun Baru Imlek">
                        @error('title') <span class="text-rose-500 text-xs mt-1 block">{{ $message }}</span> @enderror
                    </div>

                    <div class="mb-5">
                        <label class="block text-sm font-bold text-nordic-dark mb-2">Tanggal</label>
                        <input type="date" name="holiday_date" value="{{ old('holiday_date') }}" required 
                               class="form-input w-full">
                        @error('holiday_date') <span class="text-rose-500 text-xs mt-1 block">{{ $message }}</span> @enderror
                    </div>

                    <div class="mb-8">
                        <label class="block text-sm font-bold text-nordic-dark mb-2">Deskripsi (Opsional)</label>
                        <textarea name="description" rows="3" 
                                  class="form-input w-full" placeholder="Keterangan tambahan...">{{ old('description') }}</textarea>
                    </div>

                    <div class="flex justify-end gap-3 pt-4 border-t border-nordic-mute">
                        <a href="{{ route('admin.holidays.index') }}" class="btn-secondary">Batal</a>
                        <button type="submit" class="btn-primary">Simpan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>