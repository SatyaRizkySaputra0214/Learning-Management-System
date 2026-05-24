<x-layouts.lms>
    <x-slot name="sidebar">
        @include('layouts.sidebar-admin')
    </x-slot>

    <div class="mb-6">
        <a href="{{ route('admin.classes.index') }}" class="text-blue-600 dark:text-blue-400 hover:underline text-sm mb-4 inline-block">
            ← Kembali ke Daftar Kelas
        </a>
        <h1 class="text-2xl font-bold text-gray-800 dark:text-white">Tambah Kelas Baru</h1>
    </div>

    <div class="max-w-2xl bg-white dark:bg-gray-800 rounded-lg shadow-sm border border-gray-200 dark:border-gray-700 p-6">
        <form method="POST" action="{{ route('admin.classes.store') }}" class="space-y-6">
            @csrf
            
            <div>
                <label for="id_course" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                    Kursus Bahasa *
                </label>
                <select id="id_course" name="id_course" required 
                        class="w-full px-4 py-3 rounded-lg border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-800 dark:text-white focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('id_course') border-red-500 @enderror">
                    <option value="">Pilih Kursus</option>
                    @foreach($courses as $course)
                        <option value="{{ $course->id }}" {{ old('id_course') == $course->id ? 'selected' : '' }}>
                            {{ $course->nama_bahasa }}
                        </option>
                    @endforeach
                </select>
                @error('id_course')
                    <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label for="id_guru" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                    Guru Pengampu *
                </label>
                <select id="id_guru" name="id_guru" required 
                        class="w-full px-4 py-3 rounded-lg border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-800 dark:text-white focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('id_guru') border-red-500 @enderror">
                    <option value="">Pilih Guru</option>
                    @foreach($gurus as $guru)
                        <option value="{{ $guru->id }}" {{ old('id_guru') == $guru->id ? 'selected' : '' }}>
                            {{ $guru->nama_lengkap }}
                        </option>
                    @endforeach
                </select>
                @error('id_guru')
                    <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label for="nama_kelas" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                    Nama Kelas *
                </label>
                <input type="text" id="nama_kelas" name="nama_kelas" value="{{ old('nama_kelas') }}" required 
                       class="w-full px-4 py-3 rounded-lg border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-800 dark:text-white focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('nama_kelas') border-red-500 @enderror">
                @error('nama_kelas')
                    <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label for="periode" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                    Periode *
                </label>
                <input type="text" id="periode" name="periode" value="{{ old('periode', date('F Y')) }}" required
                       placeholder="Contoh: January 2026"
                       class="w-full px-4 py-3 rounded-lg border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-800 dark:text-white focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('periode') border-red-500 @enderror">
                @error('periode')
                    <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label for="jumlah_hari" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                    Jumlah Hari/Pertemuan *
                </label>
                <input type="number" id="jumlah_hari" name="jumlah_hari" value="{{ old('jumlah_hari') }}" required min="1" max="100"
                       placeholder="Contoh: 12"
                       class="w-full px-4 py-3 rounded-lg border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-800 dark:text-white focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('jumlah_hari') border-red-500 @enderror">
                @error('jumlah_hari')
                    <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label for="status" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                    Status *
                </label>
                <select id="status" name="status" required 
                        class="w-full px-4 py-3 rounded-lg border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-800 dark:text-white focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('status') border-red-500 @enderror">
                    <option value="aktif" {{ old('status') === 'aktif' ? 'selected' : '' }}>Aktif</option>
                    <option value="selesai" {{ old('status') === 'selesai' ? 'selected' : '' }}>Selesai</option>
                </select>
                @error('status')
                    <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                @enderror
            </div>

            <div class="flex gap-4 pt-4">
                <button type="submit" class="bg-green-600 text-white px-6 py-3 rounded-lg hover:bg-green-700 transition font-medium !important" style="background-color: #16a34a !important; color: #ffffff !important;">
                    ✓ Simpan Kelas
                </button>
                <a href="{{ route('admin.classes.index') }}"
                   class="bg-red-500 text-gray-100 px-6 py-3 rounded-lg hover:bg-red-600 transition font-medium text-center !important" style="background-color: #ef4444 !important; color: #f3f4f6 !important;">
                    Batal
                </a>
            </div>
        </form>
    </div>
</x-layouts.lms>
