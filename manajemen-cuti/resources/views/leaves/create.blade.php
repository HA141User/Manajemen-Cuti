<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-nordic-dark leading-tight">
            {{ __('Form Pengajuan Cuti') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-2xl mx-auto sm:px-6 lg:px-8 space-y-6">
            
            <div class="bg-indigo-50 border-l-4 border-indigo-500 p-4 rounded-r-lg shadow-sm flex items-start">
                <svg class="w-6 h-6 text-indigo-500 mr-3 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                <div>
                    <h4 class="text-sm font-bold text-indigo-800">Informasi Kuota</h4>
                    <p class="text-sm text-indigo-700 mt-1">
                        Sisa Kuota Cuti Tahunan Anda: <span class="font-bold text-lg">{{ Auth::user()->annual_leave_quota }} Hari</span>.
                        <br>Pengajuan Cuti Tahunan wajib dilakukan minimal <b>H-3</b>.
                    </p>
                </div>
            </div>

            <div class="card">
                <form action="{{ route('leaves.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf

                    <div class="mb-5">
                        <label class="block text-sm font-bold text-nordic-dark mb-2">Jenis Cuti</label>
                        <select name="type" id="type" onchange="toggleAttachment()" class="form-input w-full bg-slate-50">
                            <option value="annual" {{ old('type') == 'annual' ? 'selected' : '' }}>Cuti Tahunan</option>
                            <option value="sick" {{ old('type') == 'sick' ? 'selected' : '' }}>Cuti Sakit (Wajib Surat Dokter)</option>
                        </select>
                        @error('type') <span class="text-rose-500 text-xs mt-1 block">{{ $message }}</span> @enderror
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-5 mb-5">
                        <div>
                            <label class="block text-sm font-bold text-nordic-dark mb-2">Tanggal Mulai</label>
                            <input type="date" name="start_date" value="{{ old('start_date') }}" required
                                   class="form-input w-full">
                            @error('start_date') <span class="text-rose-500 text-xs mt-1 block">{{ $message }}</span> @enderror
                        </div>
                        <div>
                            <label class="block text-sm font-bold text-nordic-dark mb-2">Tanggal Selesai</label>
                            <input type="date" name="end_date" value="{{ old('end_date') }}" required
                                   class="form-input w-full">
                            @error('end_date') <span class="text-rose-500 text-xs mt-1 block">{{ $message }}</span> @enderror
                        </div>
                    </div>

                    <div class="mb-5">
                        <label class="block text-sm font-bold text-nordic-dark mb-2">Alasan Cuti</label>
                        <textarea name="reason" rows="3" required placeholder="Jelaskan keperluan Anda..."
                               class="form-input w-full">{{ old('reason') }}</textarea>
                        @error('reason') <span class="text-rose-500 text-xs mt-1 block">{{ $message }}</span> @enderror
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-5 mb-6">
                        <div>
                            <label class="block text-sm font-bold text-nordic-dark mb-2">Alamat Selama Cuti</label>
                            <input type="text" name="leave_address" value="{{ old('leave_address') }}" required
                                   class="form-input w-full">
                        </div>
                        <div>
                            <label class="block text-sm font-bold text-nordic-dark mb-2">Kontak Darurat (HP)</label>
                            <input type="text" name="emergency_contact" value="{{ old('emergency_contact') }}" required
                                   class="form-input w-full">
                        </div>
                    </div>

                    <div class="mb-8 hidden p-4 bg-blue-50 rounded-lg border border-blue-100" id="attachment-container">
                        <label class="block text-sm font-bold text-blue-800 mb-2">Surat Keterangan Dokter (Wajib PDF/JPG)</label>
                        <input type="file" name="attachment" id="attachment"
                               class="block w-full text-sm text-slate-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-blue-100 file:text-blue-700 hover:file:bg-blue-200 transition">
                        @error('attachment') <span class="text-rose-500 text-xs mt-1 block">{{ $message }}</span> @enderror
                    </div>

                    <div class="flex justify-end gap-3 pt-4 border-t border-nordic-mute">
                        <a href="{{ route('leaves.index') }}" class="btn-secondary">Batal</a>
                        <button type="submit" class="btn-primary">Kirim Pengajuan</button>
                    </div>

                </form>
            </div>
        </div>
    </div>

    <script>
        function toggleAttachment() {
            var type = document.getElementById('type').value;
            var container = document.getElementById('attachment-container');
            if (type === 'sick') {
                container.classList.remove('hidden');
            } else {
                container.classList.add('hidden');
            }
        }
        // Jalankan saat load (untuk handle old input saat error validasi)
        window.onload = toggleAttachment;
    </script>
</x-app-layout>