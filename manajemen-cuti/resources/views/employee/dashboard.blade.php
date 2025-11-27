<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard Karyawan') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-6">
                <div class="p-6 text-gray-900">
                    <h3 class="text-lg font-bold">Halo, {{ Auth::user()->name }}!</h3>
                    <p class="text-gray-600">Divisi: <span class="font-semibold">{{ $division_name }}</span> | Manager: <span class="font-semibold">{{ $manager_name }}</span></p>
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-6">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6 border-l-4 border-blue-500">
                    <div class="text-gray-500 text-sm">Sisa Kuota Cuti Tahunan</div>
                    <div class="text-3xl font-bold text-gray-800">{{ $quota_remaining }} <span class="text-sm font-normal">Hari</span></div>
                </div>

                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6 border-l-4 border-red-500">
                    <div class="text-gray-500 text-sm">Total Cuti Sakit Diajukan</div>
                    <div class="text-3xl font-bold text-gray-800">{{ $sick_leave_count }} <span class="text-sm font-normal">Kali</span></div>
                </div>

                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6 border-l-4 border-green-500">
                    <div class="text-gray-500 text-sm">Total Riwayat Pengajuan</div>
                    <div class="text-3xl font-bold text-gray-800">{{ $total_requests }} <span class="text-sm font-normal">Pengajuan</span></div>
                </div>
            </div>

            <div class="flex justify-end">
                <a href="#" class="bg-indigo-600 text-white px-4 py-2 rounded-md hover:bg-indigo-700">
                    + Buat Pengajuan Cuti Baru
                </a>
            </div>

        </div>
    </div>
</x-app-layout>