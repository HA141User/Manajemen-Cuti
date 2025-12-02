<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Profile') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            
            <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg border-l-4 border-indigo-500">
                <h3 class="text-lg font-medium text-gray-900 mb-4">Informasi Kuota Cuti Tahunan</h3>
                <div class="grid grid-cols-1 md:grid-cols-3 gap-4 text-center">
                    <div class="bg-gray-50 p-4 rounded">
                        <span class="block text-gray-500 text-xs uppercase font-bold">Total Jatah</span>
                        <span class="text-2xl font-bold text-gray-800">{{ $quotaInfo['total'] }} Hari</span>
                    </div>
                    <div class="bg-gray-50 p-4 rounded">
                        <span class="block text-gray-500 text-xs uppercase font-bold">Terpakai</span>
                        <span class="text-2xl font-bold text-blue-600">{{ $quotaInfo['used'] }} Hari</span>
                    </div>
                    <div class="bg-gray-50 p-4 rounded">
                        <span class="block text-gray-500 text-xs uppercase font-bold">Sisa Kuota</span>
                        <span class="text-3xl font-bold text-green-600">{{ $quotaInfo['remaining'] }} Hari</span>
                    </div>
                </div>
            </div>

            <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
                <div class="max-w-xl">
                    @include('profile.partials.update-profile-information-form')
                </div>
            </div>

            <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
                <div class="max-w-xl">
                    @include('profile.partials.update-password-form')
                </div>
            </div>

            <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
                <div class="max-w-xl">
                    @include('profile.partials.delete-user-form')
                </div>
            </div>
        </div>
    </div>
</x-app-layout>