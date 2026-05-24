<x-layouts.lms>
    <x-slot name="sidebar">
        @include('layouts.sidebar-guru')
    </x-slot>

    <div class="mb-6">
        <a href="{{ route('guru.classes.show', $meeting->class) }}" class="text-blue-600 dark:text-blue-400 hover:underline text-sm mb-4 inline-block">← Kembali ke Kelas</a>
        <h1 class="text-2xl font-bold text-gray-800 dark:text-white">Buat Pengumuman Baru</h1>
        <p class="text-gray-500 dark:text-gray-400 mt-1">
            Pertemuan {{ $meeting->urutan_pertemuan }} - {{ $meeting->judul_pertemuan }}
        </p>
    </div>

    @if($errors->any())
        <div class="mb-6 bg-red-50 dark:bg-red-900/30 border-l-4 border-red-500 p-4 rounded-md">
            <div class="flex items-center">
                <svg class="w-5 h-5 text-red-500 mr-2" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"/>
                </svg>
                <span class="text-red-700 dark:text-red-300 font-medium">Ada error pada form:</span>
            </div>
            <ul class="mt-2 ml-7 text-sm text-red-600 dark:text-red-400 list-disc">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="max-w-2xl bg-white dark:bg-gray-800 rounded-lg shadow-sm border border-gray-200 dark:border-gray-700 p-6">
        <form method="POST" action="{{ route('guru.announcements.store', $meeting) }}" class="space-y-6">
            @csrf

            <div>
                <label for="judul_pengumuman" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                    Judul Pengumuman *
                </label>
                <input type="text" id="judul_pengumuman" name="judul_pengumuman" value="{{ old('judul_pengumuman') }}" required
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
                          class="w-full px-4 py-3 rounded-lg border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-800 dark:text-white focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('isi_pengumuman') border-red-500 @enderror">{{ old('isi_pengumuman') }}</textarea>
                <p class="mt-1 text-xs text-gray-500 dark:text-gray-400">Pengumuman akan ditampilkan kepada murid di halaman pertemuan</p>
            </div>

            <div>
                <label class="flex items-center gap-3 cursor-pointer">
                    <input type="checkbox" name="is_penting" value="1" {{ old('is_penting') ? 'checked' : '' }}
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
                            Pengumuman akan langsung tampil di halaman pertemuan dan dapat dilihat oleh semua murid yang terdaftar.
                        </p>
                    </div>
                </div>
            </div>

            <div class="flex gap-4 pt-4">
                <button type="submit" class="bg-blue-500 text-gray-100 px-6 py-3 rounded-lg hover:bg-blue-600 transition font-medium !important" style="background-color: #3b82f6 !important; color: #f3f4f6 !important;">
                    📢 Buat Pengumuman
                </button>
                <a href="{{ route('guru.classes.show', $meeting->class) }}"
                   class="bg-red-500 text-gray-100 px-6 py-3 rounded-lg hover:bg-red-600 transition font-medium !important" style="background-color: #ef4444 !important; color: #f3f4f6 !important;">
                    Batal
                </a>
            </div>
        </form>
    </div>
</x-layouts.lms>
