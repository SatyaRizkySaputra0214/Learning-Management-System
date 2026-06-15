<x-layouts.lms>
    <x-slot name="sidebar">
        @include('layouts.sidebar-guru')
    </x-slot>

    <div class="mb-6">
        <a href="{{ route('guru.classes.show', $announcement->meeting->class) }}" class="text-blue-600 dark:text-blue-400 hover:underline text-sm mb-4 inline-block">← Kembali ke Kelas</a>
        <h1 class="text-2xl font-bold text-gray-800 dark:text-white">Edit Pengumuman</h1>
        <p class="text-gray-500 dark:text-gray-400 mt-1">
            Pertemuan {{ $announcement->meeting->urutan_pertemuan }} - {{ $announcement->meeting->judul_pertemuan }}
        </p>
    </div>

    <div class="max-w-2xl bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700 p-6">
        <form method="POST" action="{{ route('guru.announcements.update', $announcement) }}" class="space-y-6">
            @csrf
            @method('PUT')

            <div>
                <label for="judul_pengumuman" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                    Judul Pengumuman *
                </label>
                <input type="text" id="judul_pengumuman" name="judul_pengumuman" value="{{ old('judul_pengumuman', $announcement->judul_pengumuman) }}" required
                       placeholder="Contoh: Perubahan Jadwal Kuis"
                       class="w-full px-4 py-3 rounded-lg border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-800 dark:text-white focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('judul_pengumuman') border-red-500 @enderror">
                @error('judul_pengumuman')
                    <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label for="isi_pengumuman" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                    Isi Pengumuman *
                </label>
                <textarea id="isi_pengumuman" name="isi_pengumuman" rows="8" required
                          placeholder="Tulis isi pengumuman di sini..."
                          class="w-full px-4 py-3 rounded-lg border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-800 dark:text-white focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('isi_pengumuman') border-red-500 @enderror">{{ old('isi_pengumuman', $announcement->isi_pengumuman) }}</textarea>
                <p class="mt-1 text-xs text-gray-500 dark:text-gray-400">Pengumuman akan ditampilkan kepada murid di halaman pertemuan</p>
            </div>

            <div>
                <label class="flex items-center gap-3 cursor-pointer">
                    <input type="checkbox" name="is_penting" value="1" {{ old('is_penting', $announcement->is_penting) ? 'checked' : '' }}
                           class="w-5 h-5 text-yellow-600 border-gray-300 rounded focus:ring-yellow-500">
                    <span class="text-sm font-medium text-gray-700 dark:text-gray-300">Tandai sebagai pengumuman penting</span>
                </label>
                <p class="mt-1 text-xs text-gray-500 dark:text-gray-400 ml-8">Pengumuman penting akan ditampilkan dengan highlight khusus</p>
            </div>

            <div class="bg-blue-50 dark:bg-blue-900/30 border border-blue-200 dark:border-blue-800 rounded-lg p-4">
                <div class="flex items-start gap-3">
                    <svg class="w-5 h-5 text-blue-600 dark:text-blue-400 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5.882V19.24a1.76 1.76 0 01-3.417.592l-2.147-6.15M18 13a3 3 0 100-6M5.436 13.683A4.001 4.001 0 017 6h1.832c4.1 0 7.625-1.234 9.168-3v14c-1.543-1.766-5.067-3-9.168-3H7a3.988 3.988 0 01-1.564-.317z"/>
                    </svg>
                    <div>
                        <h4 class="font-medium text-blue-800 dark:text-blue-300 text-sm">Info:</h4>
                        <p class="text-xs text-blue-700 dark:text-blue-400 mt-1">
                            Perubahan pada pengumuman akan langsung terlihat oleh murid.
                        </p>
                    </div>
                </div>
            </div>

            <div class="flex gap-4 pt-4">
                <button type="submit" class="bg-blue-600 text-white px-6 py-3 rounded-lg hover:bg-blue-700 transition font-medium">
                    ✓ Simpan Perubahan
                </button>
                <a href="{{ route('guru.classes.show', $announcement->meeting->class) }}"
                   class="inline-flex items-center gap-2 px-6 py-3 text-sm font-medium text-gray-700 dark:text-gray-300 bg-white dark:bg-gray-700 border border-gray-300 dark:border-gray-600 rounded-lg hover:bg-gray-50 dark:hover:bg-gray-600 transition-all duration-200">
                    Batal
                </a>
            </div>
        </form>
    </div>
</x-layouts.lms>
