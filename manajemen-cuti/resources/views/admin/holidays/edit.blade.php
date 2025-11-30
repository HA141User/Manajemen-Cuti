<x-app-layout>
    <x-slot name="header">
        <h2 class="font-bold text-2xl text-primary leading-tight">
            {{ __('Edit Hari Libur') }}
        </h2>
    </x-slot>

    <div class="py-10">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-paper shadow-[0_8px_30px_rgb(0,0,0,0.04)] sm:rounded-3xl border border-cream overflow-hidden">
                
                <div class="bg-primary/5 px-8 py-6 border-b border-cream flex items-center gap-4">
                    <div class="h-12 w-12 rounded-2xl bg-white border border-cream flex flex-col items-center justify-center shadow-sm">
                        <span class="text-[8px] font-bold text-red-500 uppercase">{{ $holiday->holiday_date->format('M') }}</span>
                        <span class="text-lg font-extrabold text-primary leading-none">{{ $holiday->holiday_date->format('d') }}</span>
                    </div>
                    <div>
                        <h3 class="text-lg font-bold text-primary">Edit Tanggal</h3>
                        <p class="text-sm text-secondary/70">{{ $holiday->description }}</p>
                    </div>
                </div>

                <div class="p-8">
                    <form action="{{ route('holidays.update', $holiday->id) }}" method="POST">
                        @csrf
                        @method('PUT')

                        <div class="mb-6">
                            <label class="block text-sm font-bold text-secondary mb-2">Tanggal Libur</label>
                            <input type="date" name="holiday_date" value="{{ $holiday->holiday_date->format('Y-m-d') }}" class="w-full rounded-xl border-secondary/20 bg-cream/10 focus:border-accent focus:ring-accent text-primary transition shadow-sm" required>
                        </div>

                        <div class="mb-8">
                            <label class="block text-sm font-bold text-secondary mb-2">Keterangan / Perayaan</label>
                            <input type="text" name="description" value="{{ old('description', $holiday->description) }}" class="w-full rounded-xl border-secondary/20 bg-cream/10 focus:border-accent focus:ring-accent text-primary placeholder-secondary/40 transition shadow-sm" required>
                        </div>

                        <div class="flex items-center justify-end gap-4 bg-cream/20 -m-8 p-6 mt-4 border-t border-cream">
                            <a href="{{ route('holidays.index') }}" class="px-6 py-3 rounded-xl text-sm font-bold text-secondary hover:bg-cream/50 transition">
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