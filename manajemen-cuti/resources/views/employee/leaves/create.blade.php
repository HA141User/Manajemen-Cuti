<x-app-layout>
    <x-slot name="header">
        <h2 class="font-bold text-xl sm:text-2xl text-primary leading-tight px-4 sm:px-0">
            {{ __('Form Pengajuan Cuti') }}
        </h2>
    </x-slot>

    <div class="py-6 sm:py-10">
        <div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8">
            
            <div class="bg-paper shadow-[0_8px_30px_rgb(0,0,0,0.04)] sm:rounded-3xl border border-cream overflow-hidden">
                
                <div class="bg-primary/5 px-6 sm:px-8 py-6 border-b border-cream">
                    <h3 class="text-lg font-bold text-primary">Detail Permohonan</h3>
                    <p class="text-sm text-secondary/70 mt-1">Pastikan tanggal yang dipilih sudah benar. Pengajuan H-3 untuk cuti tahunan.</p>
                </div>

                <div class="p-6 sm:p-8">
                    @if ($errors->any())
                        <div class="mb-6 bg-red-50 border border-red-100 text-red-600 px-4 py-3 rounded-xl text-sm">
                            <ul class="list-disc list-inside">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form action="{{ route('leaves.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf

                        <div class="mb-6">
                            <label class="block text-sm font-bold text-secondary mb-2">Jenis Cuti</label>
                            <div class="grid grid-cols-2 gap-4">
                                <label class="cursor-pointer">
                                    <input type="radio" name="leave_type" value="annual" class="peer sr-only" checked onchange="toggleAttachment(this.value)">
                                    <div class="rounded-xl border-2 border-cream bg-white p-4 text-center transition-all peer-checked:border-accent peer-checked:bg-accent/5 hover:border-accent/50">
                                        <div class="font-bold text-primary">Cuti Tahunan</div>
                                        <div class="text-xs text-secondary/60 mt-1">Potong Kuota</div>
                                    </div>
                                </label>
                                <label class="cursor-pointer">
                                    <input type="radio" name="leave_type" value="sick" class="peer sr-only" onchange="toggleAttachment(this.value)">
                                    <div class="rounded-xl border-2 border-cream bg-white p-4 text-center transition-all peer-checked:border-accent peer-checked:bg-accent/5 hover:border-accent/50">
                                        <div class="font-bold text-primary">Sakit</div>
                                        <div class="text-xs text-secondary/60 mt-1">Wajib Surat Dokter</div>
                                    </div>
                                </label>
                            </div>
                        </div>

                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-6 mb-6">
                            <div>
                                <label class="block text-sm font-bold text-secondary mb-2">Tanggal Mulai</label>
                                <input type="date" name="start_date" id="start_date" onchange="calculateDays()" class="w-full rounded-xl border-secondary/20 bg-cream/10 focus:border-accent focus:ring-accent text-primary transition shadow-sm py-2.5" required>
                            </div>
                            <div>
                                <label class="block text-sm font-bold text-secondary mb-2">Tanggal Selesai</label>
                                <input type="date" name="end_date" id="end_date" onchange="calculateDays()" class="w-full rounded-xl border-secondary/20 bg-cream/10 focus:border-accent focus:ring-accent text-primary transition shadow-sm py-2.5" required>
                            </div>
                        </div>

                        <div id="duration_info" class="mb-6 hidden">
                            <div class="bg-accent/10 border border-accent/20 rounded-xl p-4 flex items-center gap-3">
                                <svg class="w-5 h-5 text-accent" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                <p class="text-sm font-bold text-primary">
                                    Total Durasi: <span id="total_days_display" class="text-accent text-lg">0</span> Hari Kerja
                                </p>
                            </div>
                        </div>

                        <div class="mb-6">
                            <label class="block text-sm font-bold text-secondary mb-2">Alasan Cuti</label>
                            <textarea name="reason" rows="3" class="w-full rounded-xl border-secondary/20 bg-cream/10 focus:border-accent focus:ring-accent text-primary placeholder-secondary/40 transition shadow-sm" placeholder="Jelaskan keperluan Anda secara singkat..." required></textarea>
                        </div>

                        <div id="attachment_field" class="mb-8 hidden transition-all duration-300">
                            <label class="block text-sm font-bold text-secondary mb-2">Lampiran Surat Dokter <span class="text-red-500">*</span></label>
                            <div class="mt-1 flex justify-center px-6 pt-5 pb-6 border-2 border-secondary/20 border-dashed rounded-xl hover:bg-cream/20 transition bg-white">
                                <div class="space-y-1 text-center">
                                    <svg class="mx-auto h-12 w-12 text-secondary/40" stroke="currentColor" fill="none" viewBox="0 0 48 48">
                                        <path d="M28 8H12a4 4 0 00-4 4v20m32-12v8m0 0v8a4 4 0 01-4 4H12a4 4 0 01-4-4v-4m32-4l-3.172-3.172a4 4 0 00-5.656 0L28 28M8 32l9.172-9.172a4 4 0 015.656 0L28 28m0 0l4 4m4-24h8m-4-4v8m-12 4h.02" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                                    </svg>
                                    <div class="flex text-sm text-secondary">
                                        <label for="file-upload" class="relative cursor-pointer bg-white rounded-md font-bold text-accent hover:text-[#8e6a4e] focus-within:outline-none focus-within:ring-2 focus-within:ring-offset-2 focus-within:ring-accent">
                                            <span>Upload file</span>
                                            <input id="file-upload" name="attachment" type="file" class="sr-only" accept="image/*,.pdf">
                                        </label>
                                        <p class="pl-1">atau drag and drop</p>
                                    </div>
                                    <p class="text-xs text-secondary/50">PNG, JPG, PDF up to 2MB</p>
                                </div>
                            </div>
                        </div>

                        <div class="flex items-center justify-end gap-4 pt-6 border-t border-cream">
                            <a href="{{ route('leaves.index') }}" class="px-6 py-3 rounded-xl text-sm font-bold text-secondary hover:bg-cream/50 transition">
                                Batal
                            </a>
                            <button type="submit" class="px-8 py-3 bg-accent text-white font-bold rounded-xl shadow-lg hover:bg-[#8e6a4e] hover:shadow-xl transition transform hover:-translate-y-1">
                                Kirim Pengajuan
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script>
        function toggleAttachment(type) {
            const field = document.getElementById('attachment_field');
            const fileInput = document.getElementById('file-upload');
            
            if (type === 'sick') {
                field.classList.remove('hidden');
                fileInput.required = true;
            } else {
                field.classList.add('hidden');
                fileInput.required = false;
                fileInput.value = ''; // Reset file jika ganti ke tahunan
            }
        }

        function calculateDays() {
            const start = document.getElementById('start_date').value;
            const end = document.getElementById('end_date').value;
            const infoBox = document.getElementById('duration_info');
            const display = document.getElementById('total_days_display');

            if (start && end) {
                const startDate = new Date(start);
                const endDate = new Date(end);
                
                // Hitung selisih hari (kasar)
                const diffTime = Math.abs(endDate - startDate);
                const diffDays = Math.ceil(diffTime / (1000 * 60 * 60 * 24)) + 1; 
                
                // Tampilkan hanya jika tanggal valid (end >= start)
                if (endDate >= startDate) {
                    infoBox.classList.remove('hidden');
                    // Note: Ini hitungan kasar visual JS saja. Hitungan pasti tetap di Backend PHP (Holidays)
                    display.innerText = diffDays + " (Estimasi)"; 
                } else {
                    infoBox.classList.add('hidden');
                }
            }
        }
    </script>
</x-app-layout>