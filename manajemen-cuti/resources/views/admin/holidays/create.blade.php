<x-app-layout>
    <x-slot name="header">
        <h2 class="font-bold text-2xl text-primary leading-tight">
            {{ __('Tambah Hari Libur') }}
        </h2>
    </x-slot>

    <div class="py-10">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-paper shadow-[0_8px_30px_rgb(0,0,0,0.04)] sm:rounded-3xl border border-cream overflow-hidden">
                
                <div class="bg-primary/5 px-8 py-6 border-b border-cream">
                    <h3 class="text-lg font-bold text-primary">Detail Tanggal Merah</h3>
                    <p class="text-sm text-secondary/70">Masukkan tanggal dan keterangan libur nasional.</p>
                </div>

                <div class="p-8">
                    <form action="{{ route('holidays.store') }}" method="POST">
                        @csrf

                        <div class="mb-6">
                            <label class="block text-sm font-bold text-secondary mb-2">Tanggal Libur</label>
                            <div class="relative">
                                <input type="date" name="holiday_date" class="w-full rounded-xl border-secondary/20 bg-cream/10 focus:border-accent focus:ring-accent text-primary transition shadow-sm" required>
                            </div>
                        </div>

                        <div class="mb-8">
                            <label class="block text-sm font-bold text-secondary mb-2">Keterangan / Perayaan</label>
                            <input type="text" name="description" class="w-full rounded-xl border-secondary/20 bg-cream/10 focus:border-accent focus:ring-accent text-primary placeholder-secondary/40 transition shadow-sm" placeholder="Contoh: Tahun Baru Imlek" required>
                        </div>

                        <div class="flex items-center justify-end gap-4 bg-cream/20 -m-8 p-6 mt-4 border-t border-cream">
                            <a href="{{ route('holidays.index') }}" class="px-6 py-3 rounded-xl text-sm font-bold text-secondary hover:bg-cream/50 transition">
                                Batal
                            </a>
                            <button type="submit" class="px-8 py-3 bg-primary text-cream font-bold rounded-xl shadow-lg hover:bg-secondary hover:shadow-xl transition transform hover:-translate-y-1">
                                Simpan Tanggal
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>