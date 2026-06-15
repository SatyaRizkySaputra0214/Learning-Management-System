<x-layouts.lms>
    <x-slot name="sidebar">
        @include('layouts.sidebar-guru')
    </x-slot>

    <div class="mb-8">
        <a href="{{ route('guru.classes.show', $meeting->class) }}"
           class="inline-flex items-center gap-1.5 text-blue-600 dark:text-blue-400 hover:text-blue-700 dark:hover:text-blue-300 text-sm font-medium transition-colors duration-200 mb-4">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
            </svg>
            Kembali ke Kelas
        </a>
        <div class="flex items-center gap-4">
            <div class="w-12 h-12 bg-blue-100 dark:bg-blue-900/40 rounded-xl flex items-center justify-center flex-shrink-0">
                <svg class="w-6 h-6 text-blue-600 dark:text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                </svg>
            </div>
            <div>
                <h1 class="text-2xl font-bold text-gray-800 dark:text-white tracking-tight">Tambah Materi</h1>
                <p class="text-sm text-gray-500 dark:text-gray-400 mt-0.5">{{ $meeting->judul_pertemuan }}</p>
            </div>
        </div>
    </div>

    <div class="max-w-3xl">
        <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700 p-6">
            <form method="POST" action="{{ route('guru.materials.store', $meeting) }}" enctype="multipart/form-data" class="space-y-7">
                @csrf

                <div>
                    <label for="judul" class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">
                        Judul Materi <span class="text-red-500">*</span>
                    </label>
                    <div class="relative">
                        <input type="text" id="judul" name="judul" value="{{ old('judul') }}" required
                            class="w-full px-4 py-3 rounded-lg border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-800 dark:text-white placeholder-gray-400 dark:placeholder-gray-500 focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all duration-200">
                    </div>
                </div>

                <div>
                    <label for="tipe" class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">
                        Tipe Materi <span class="text-red-500">*</span>
                    </label>
                    <div class="relative">
                        <select id="tipe" name="tipe" required onchange="toggleFileInput()"
                            class="w-full px-4 py-3 rounded-lg border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-800 dark:text-white focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all duration-200 appearance-none">
                            <option value="">Pilih Tipe</option>
                            <option value="video" {{ old('tipe') === 'video' ? 'selected' : '' }}>Video (Link)</option>
                            <option value="pdf" {{ old('tipe') === 'pdf' ? 'selected' : '' }}>PDF</option>
                            <option value="doc" {{ old('tipe') === 'doc' ? 'selected' : '' }}>Dokumen</option>
                        </select>
                        <div class="absolute inset-y-0 right-0 flex items-center pr-3.5 pointer-events-none">
                            <svg class="w-5 h-5 text-gray-400 dark:text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                            </svg>
                        </div>
                    </div>
                </div>

                <div id="videoInput" style="display:none;">
                    <label for="file_url" class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">Link Video</label>
                    <div class="relative">
                        <input type="url" id="file_url" name="file_url" value="{{ old('file_url') }}"
                            class="w-full px-4 py-3 rounded-lg border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-800 dark:text-white placeholder-gray-400 dark:placeholder-gray-500 focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all duration-200">
                    </div>
                    <p class="mt-1.5 text-xs text-gray-400 dark:text-gray-500">Link YouTube, Google Drive, atau platform video lainnya</p>
                </div>

                <div id="fileUploadInput" style="display:none;">
                    <label for="file_upload" class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">Upload File</label>
                    <div class="relative">
                        <input type="file" id="file_upload" name="file_upload" accept=".pdf,.doc,.docx"
                            class="w-full px-4 py-3 rounded-lg border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-800 dark:text-white file:mr-4 file:py-2 file:px-4 file:rounded-xl file:border-0 file:text-sm file:font-semibold file:bg-blue-50 dark:file:bg-blue-900/30 file:text-blue-700 dark:file:text-blue-300 hover:file:bg-blue-100 dark:hover:file:bg-blue-900/50 focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all duration-200">
                    </div>
                    <p class="mt-1.5 text-xs text-gray-400 dark:text-gray-500">Format file: PDF, DOC, DOCX</p>
                </div>

                <div>
                    <label for="deskripsi" class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">
                        Deskripsi
                    </label>
                    <div class="relative">
                        <textarea id="deskripsi" name="deskripsi" rows="4"
                            class="w-full px-4 py-3 rounded-lg border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-800 dark:text-white placeholder-gray-400 dark:placeholder-gray-500 focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all duration-200 resize-y min-h-[120px]">{{ old('deskripsi') }}</textarea>
                    </div>
                    <p class="mt-1.5 text-xs text-gray-400 dark:text-gray-500">Deskripsikan materi yang akan ditambahkan</p>
                </div>

                <div class="flex items-center gap-3 pt-4 border-t border-gray-100 dark:border-gray-700">
                    <button type="submit"
                        class="inline-flex items-center gap-2 px-6 py-3 text-sm font-medium text-white bg-blue-600 rounded-lg hover:bg-blue-700 transition-all duration-200">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                        </svg>
                        Simpan
                    </button>
                    <a href="{{ route('guru.classes.show', $meeting->class) }}"
                       class="inline-flex items-center gap-2 px-6 py-3 text-sm font-medium text-gray-700 dark:text-gray-300 bg-white dark:bg-gray-700 border border-gray-300 dark:border-gray-600 rounded-lg hover:bg-gray-50 dark:hover:bg-gray-600 transition-all duration-200">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                        </svg>
                        Batal
                    </a>
                </div>
            </form>
        </div>
    </div>
</x-layouts.lms>
<script>
function toggleFileInput() {
    const tipe = document.getElementById('tipe').value;
    document.getElementById('videoInput').style.display = tipe === 'video' ? 'block' : 'none';
    document.getElementById('fileUploadInput').style.display = (tipe === 'pdf' || tipe === 'doc') ? 'block' : 'none';
}
toggleFileInput();
</script>
