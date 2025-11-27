<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Admin Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            
            <div class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-8">
                <div class="bg-white p-6 rounded-lg shadow-sm">
                    <div class="text-gray-500 text-xs uppercase font-bold">Total Karyawan</div>
                    <div class="text-2xl font-bold">{{ $total_employees }}</div>
                </div>
                <div class="bg-white p-6 rounded-lg shadow-sm">
                    <div class="text-gray-500 text-xs uppercase font-bold">Divisi</div>
                    <div class="text-2xl font-bold">{{ $total_divisions }}</div>
                </div>
                <div class="bg-white p-6 rounded-lg shadow-sm">
                    <div class="text-gray-500 text-xs uppercase font-bold">Request Bulan Ini</div>
                    <div class="text-2xl font-bold">{{ $total_leave_requests_month }}</div>
                </div>
                <div class="bg-white p-6 rounded-lg shadow-sm border-l-4 border-yellow-400">
                    <div class="text-gray-500 text-xs uppercase font-bold">Pending Approval</div>
                    <div class="text-2xl font-bold text-yellow-600">{{ $pending_approvals }}</div>
                </div>
            </div>

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 border-b border-gray-200">
                    <h3 class="text-lg font-bold mb-4">Karyawan Baru (Belum Eligible Cuti Tahunan)</h3>
                    
                    @if($new_employees->isEmpty())
                        <p class="text-gray-500 italic">Tidak ada karyawan dengan masa kerja < 1 tahun.</p>
                    @else
                        <table class="min-w-full leading-normal">
                            <thead>
                                <tr>
                                    <th class="px-5 py-3 border-b-2 border-gray-200 bg-gray-100 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                                        Nama
                                    </th>
                                    <th class="px-5 py-3 border-b-2 border-gray-200 bg-gray-100 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                                        Tanggal Bergabung
                                    </th>
                                    <th class="px-5 py-3 border-b-2 border-gray-200 bg-gray-100 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                                        Status Kuota
                                    </th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($new_employees as $emp)
                                <tr>
                                    <td class="px-5 py-5 border-b border-gray-200 bg-white text-sm">
                                        <div class="flex items-center">
                                            <div class="ml-3">
                                                <p class="text-gray-900 whitespace-no-wrap font-bold">
                                                    {{ $emp->name }}
                                                </p>
                                                <p class="text-gray-600 whitespace-no-wrap text-xs">
                                                    {{ $emp->email }}
                                                </p>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-5 py-5 border-b border-gray-200 bg-white text-sm">
                                        <p class="text-gray-900 whitespace-no-wrap">
                                            {{ \Carbon\Carbon::parse($emp->join_date)->format('d M Y') }}
                                        </p>
                                    </td>
                                    <td class="px-5 py-5 border-b border-gray-200 bg-white text-sm">
                                        <span class="relative inline-block px-3 py-1 font-semibold text-red-900 leading-tight">
                                            <span aria-hidden="true" class="absolute inset-0 bg-red-200 opacity-50 rounded-full"></span>
                                            <span class="relative">Belum Eligible</span>
                                        </span>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    @endif
                </div>
            </div>

        </div>
    </div>
</x-app-layout>