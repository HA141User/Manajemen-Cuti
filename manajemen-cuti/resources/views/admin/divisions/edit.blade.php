<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-nordic-dark leading-tight">
            {{ __('Edit Divisi: ') . $division->name }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-2xl mx-auto sm:px-6 lg:px-8">
            <div class="card">
                
                <form action="{{ route('admin.divisions.update', $division->id) }}" method="POST">
                    @csrf
                    @method('PUT')

                    <div class="mb-5">
                        <label class="block text-sm font-bold text-nordic-dark mb-2">Nama Divisi</label>
                        <input type="text" name="name" value="{{ old('name', $division->name) }}" required
                               class="form-input w-full">
                        @error('name') <span class="text-rose-500 text-xs mt-1 block">{{ $message }}</span> @enderror
                    </div>

                    <div class="mb-5">
                        <label class="block text-sm font-bold text-nordic-dark mb-2">Deskripsi</label>
                        <textarea name="description" rows="3"
                               class="form-input w-full">{{ old('description', $division->description) }}</textarea>
                    </div>

                    <div class="mb-8">
                        <label class="block text-sm font-bold text-nordic-dark mb-2">Ketua Divisi</label>
                        <select name="leader_id" required class="form-input w-full bg-slate-50">
                            @foreach($potentialLeaders as $leader)
                                <option value="{{ $leader->id }}" {{ old('leader_id', $division->leader_id) == $leader->id ? 'selected' : '' }}>
                                    {{ $leader->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="flex justify-end gap-3 pt-4 border-t border-nordic-mute">
                        <a href="{{ route('admin.divisions.index') }}" class="btn-secondary">Batal</a>
                        <button type="submit" class="btn-primary">Update Divisi</button>
                    </div>

                </form>
            </div>
        </div>
    </div>
</x-app-layout>