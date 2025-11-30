<x-app-layout>
    <x-slot name="header">
        <h2 class="font-bold text-2xl text-primary leading-tight">
            {{ __('Buat Divisi Baru') }}
        </h2>
    </x-slot>

    <div class="py-10">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-paper shadow-[0_8px_30px_rgb(0,0,0,0.04)] sm:rounded-3xl border border-cream overflow-hidden">
                
                <div class="bg-primary/5 px-8 py-6 border-b border-cream">
                    <h3 class="text-lg font-bold text-primary">Detail Departemen</h3>
                    <p class="text-sm text-secondary/70">Tentukan nama divisi dan ketuanya.</p>
                </div>

                <div class="p-8">
                    <form action="{{ route('divisions.store') }}" method="POST">
                        @csrf

                        <div class="mb-6">
                            <label class="block text-sm font-bold text-secondary mb-2">Nama Divisi</label>
                            <input type="text" name="name" class="w-full rounded-xl border-secondary/20 bg-cream/10 focus:border-accent focus:ring-accent text-primary placeholder-secondary/40 transition shadow-sm" placeholder="Contoh: Finance & Accounting" required>
                        </div>

                        <div class="mb-8">
                            <label class="block text-sm font-bold text-secondary mb-2">Ketua Divisi (Manager)</label>
                            
                            <div class="relative">
                                <select name="manager_id" class="w-full rounded-xl border-secondary/20 bg-cream/10 focus:border-accent focus:ring-accent text-primary transition shadow-sm appearance-none bg-none pr-10">
                                    <option value="">-- Pilih Manager (Opsional) --</option>
                                    @foreach($managers as $manager)
                                        <option value="{{ $manager->id }}">{{ $manager->name }}</option>
                                    @endforeach
                                </select>
                                
                                <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-4 text-secondary">
                                    <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                                </div>
                            </div>
                            <p class="text-xs text-secondary/50 mt-2">*Hanya user dengan role "Division Manager" yang muncul di sini.</p>
                        </div>

                        <div class="flex items-center justify-end gap-4 bg-cream/20 -m-8 p-6 mt-4 border-t border-cream">
                            <a href="{{ route('divisions.index') }}" class="px-6 py-3 rounded-xl text-sm font-bold text-secondary hover:bg-cream/50 transition">
                                Batal
                            </a>
                            <button type="submit" class="px-8 py-3 bg-primary text-cream font-bold rounded-xl shadow-lg hover:bg-secondary hover:shadow-xl transition transform hover:-translate-y-1">
                                Simpan Divisi
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>