<x-layouts.lms>
    <x-slot name="sidebar">
        @include('layouts.sidebar-admin')
    </x-slot>

    <div class="mb-6">
        <a href="{{ route('admin.classes.index') }}" class="text-blue-600 dark:text-blue-400 hover:underline text-sm mb-4 inline-block">← Kembali ke Daftar Kelas</a>
        <h1 class="text-2xl font-bold text-gray-800 dark:text-white">Edit Kelas</h1>
        <p class="text-gray-500 dark:text-gray-400 mt-1">{{ $class->nama_kelas }}</p>
    </div>

    <div class="max-w-2xl bg-white dark:bg-gray-800 rounded-lg shadow-sm border border-gray-200 dark:border-gray-700 p-6">
        <form method="POST" action="{{ route('admin.classes.update', $class) }}" class="space-y-6">
            @csrf
            @method('PUT')

            <div>
                <label for="nama_kelas" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                    Nama Kelas *
                </label>
                <input type="text"
                       id="nama_kelas"
                       name="nama_kelas"
                       value="{{ old('nama_kelas', $class->nama_kelas) }}"
                       required
                       class="w-full px-4 py-3 rounded-lg border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-800 dark:text-white focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('nama_kelas') border-red-500 @enderror">
                @error('nama_kelas')
                    <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label for="id_course" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                    Kursus *
                </label>
                <select id="id_course"
                        name="id_course"
                        required
                        class="w-full px-4 py-3 rounded-lg border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-800 dark:text-white focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('id_course') border-red-500 @enderror">
                    <option value="">-- Pilih Kursus --</option>
                    @foreach($courses as $course)
                        <option value="{{ $course->id }}" {{ old('id_course', $class->id_course) == $course->id ? 'selected' : '' }}>
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
                <select id="id_guru"
                        name="id_guru"
                        required
                        class="w-full px-4 py-3 rounded-lg border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-800 dark:text-white focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('id_guru') border-red-500 @enderror">
                    <option value="">-- Pilih Guru --</option>
                    @foreach($gurus as $guru)
                        <option value="{{ $guru->id }}" {{ old('id_guru', $class->id_guru) == $guru->id ? 'selected' : '' }}>
                            {{ $guru->nama_lengkap }}
                        </option>
                    @endforeach
                </select>
                @error('id_guru')
                    <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label for="periode" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                    Periode *
                </label>
                <input type="text"
                       id="periode"
                       name="periode"
                       value="{{ old('periode', $class->periode) }}"
                       required
                       placeholder="Contoh: Januari - Maret 2026"
                       class="w-full px-4 py-3 rounded-lg border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-800 dark:text-white focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('periode') border-red-500 @enderror">
                @error('periode')
                    <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label for="jumlah_hari" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                    Jumlah Hari/Pertemuan *
                </label>
                <input type="number"
                       id="jumlah_hari"
                       name="jumlah_hari"
                       value="{{ old('jumlah_hari', $class->jumlah_hari) }}"
                       required
                       min="1"
                       max="100"
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
                <select id="status"
                        name="status"
                        required
                        class="w-full px-4 py-3 rounded-lg border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-800 dark:text-white focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('status') border-red-500 @enderror">
                    <option value="aktif" {{ old('status', $class->status) === 'aktif' ? 'selected' : '' }}>Aktif</option>
                    <option value="selesai" {{ old('status', $class->status) === 'selesai' ? 'selected' : '' }}>Selesai</option>
                </select>
                @error('status')
                    <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                @enderror
            </div>

            <div class="flex gap-4 pt-4">
                <button type="submit" class="bg-green-600 text-white px-6 py-3 rounded-lg hover:bg-green-700 transition font-medium flex-1 !important" style="background-color: #16a34a !important; color: #ffffff !important;">
                    ✓ Simpan Perubahan
                </button>
                <a href="{{ route('admin.classes.index') }}"
                   class="inline-flex items-center gap-2 px-6 py-3 text-sm font-medium text-gray-700 dark:text-gray-300 bg-white dark:bg-gray-700 border border-gray-300 dark:border-gray-600 rounded-lg hover:bg-gray-50 dark:hover:bg-gray-600 transition">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                    </svg>
                    Batal
                </a>
            </div>
        </form>
    </div>
</x-layouts.lms>
