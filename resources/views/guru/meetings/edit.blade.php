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
            <div class="w-12 h-12 bg-amber-100 dark:bg-amber-900/40 rounded-xl flex items-center justify-center flex-shrink-0">
                <svg class="w-6 h-6 text-amber-600 dark:text-amber-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                </svg>
            </div>
            <div>
                <h1 class="text-2xl font-bold text-gray-800 dark:text-white tracking-tight">Edit Pertemuan</h1>
                <p class="text-sm text-gray-500 dark:text-gray-400 mt-0.5">Perbarui informasi pertemuan kelas Anda</p>
            </div>
        </div>
    </div>

    <div class="max-w-3xl">
        <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-md border border-gray-200 dark:border-gray-700 p-8">
            <form method="POST" action="{{ route('guru.meetings.update', $meeting) }}" class="space-y-7">
                @csrf
                @method('PUT')

                <div>
                    <label for="urutan_pertemuan" class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">
                        Urutan Pertemuan <span class="text-red-500">*</span>
                    </label>
                    <div class="relative">
                        <input type="number" id="urutan_pertemuan" name="urutan_pertemuan"
                            value="{{ old('urutan_pertemuan', $meeting->urutan_pertemuan) }}" min="1" required
                            class="w-full px-4 py-3 pr-11 rounded-xl border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-800 dark:text-white placeholder-gray-400 dark:placeholder-gray-500 focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all duration-200">
                        <div class="absolute inset-y-0 right-0 flex items-center pr-3.5 pointer-events-none">
                            <svg class="w-5 h-5 text-gray-400 dark:text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"/>
                            </svg>
                        </div>
                    </div>
                </div>

                <div>
                    <label for="judul_pertemuan" class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">
                        Judul Pertemuan <span class="text-red-500">*</span>
                    </label>
                    <div class="relative">
                        <input type="text" id="judul_pertemuan" name="judul_pertemuan"
                            value="{{ old('judul_pertemuan', $meeting->judul_pertemuan) }}" required
                            class="w-full px-4 py-3 pr-11 rounded-xl border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-800 dark:text-white placeholder-gray-400 dark:placeholder-gray-500 focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all duration-200">
                        <div class="absolute inset-y-0 right-0 flex items-center pr-3.5 pointer-events-none">
                            <svg class="w-5 h-5 text-gray-400 dark:text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 8h10M7 12h4m1 8l-4-4H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-3l-4 4z"/>
                            </svg>
                        </div>
                    </div>
                </div>

                <div>
                    <label for="deskripsi" class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">
                        Deskripsi
                    </label>
                    <div class="relative">
                        <textarea id="deskripsi" name="deskripsi" rows="5"
                            class="w-full px-4 py-3 rounded-xl border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-800 dark:text-white placeholder-gray-400 dark:placeholder-gray-500 focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all duration-200 resize-y min-h-[120px]">{{ old('deskripsi', $meeting->deskripsi) }}</textarea>
                    </div>
                    <p class="mt-1.5 text-xs text-gray-400 dark:text-gray-500">Deskripsikan materi atau topik yang akan dibahas pada pertemuan ini</p>
                </div>

                <div class="flex items-center gap-3 pt-4 border-t border-gray-100 dark:border-gray-700">
                    <button type="submit"
                        class="inline-flex items-center gap-2 bg-amber-500 text-white px-6 py-3 rounded-xl hover:bg-amber-600 focus:ring-2 focus:ring-amber-400 focus:ring-offset-2 dark:focus:ring-offset-gray-800 transition-all duration-200 font-semibold shadow-md shadow-amber-500/20 hover:shadow-lg hover:shadow-amber-500/30 active:scale-[0.98]">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"/>
                        </svg>
                        Update Pertemuan
                    </button>
                    <a href="{{ route('guru.classes.show', $meeting->class) }}"
                       class="inline-flex items-center gap-2 px-5 py-3 rounded-xl border border-gray-300 dark:border-gray-600 text-gray-700 dark:text-gray-300 bg-white dark:bg-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600 focus:ring-2 focus:ring-gray-300 dark:focus:ring-gray-500 focus:ring-offset-2 dark:focus:ring-offset-gray-800 transition-all duration-200 font-medium">
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
