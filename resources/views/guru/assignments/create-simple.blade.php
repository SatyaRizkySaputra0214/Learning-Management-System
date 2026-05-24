<x-layouts.lms>
    <x-slot name="sidebar">
        @include('layouts.sidebar-guru')
    </x-slot>

    <div class="mb-6">
        <a href="{{ route('guru.classes.show', $class) }}" class="text-blue-600 dark:text-blue-400 hover:underline text-sm mb-4 inline-block">← Kembali</a>
        <h1 class="text-2xl font-bold text-gray-800 dark:text-white">Tambah Tugas Cepat</h1>
        <p class="text-gray-500 dark:text-gray-400 mt-1">{{ $meeting->judul_pertemuan }} - Pertemuan {{ $meeting->urutan_pertemuan }}</p>
    </div>

    <div class="max-w-4xl grid grid-cols-1 md:grid-cols-2 gap-6">
        <!-- Form Buat Tugas -->
        <div class="bg-white dark:bg-gray-800 rounded-lg shadow-sm border border-gray-200 dark:border-gray-700 p-6">
            <h2 class="text-lg font-semibold text-gray-800 dark:text-white mb-4">📋 Buat Tugas Baru</h2>
            
            <form method="POST" action="{{ route('guru.assignments.store', $meeting) }}" class="space-y-4">
                @csrf
                
                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Label Skill *</label>
                    <select name="id_skill" required class="w-full px-3 py-2 rounded-lg border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-800 dark:text-white focus:ring-2 focus:ring-purple-500">
                        @foreach($skills as $skill)
                            <option value="{{ $skill->id }}">{{ $skill->nama_skill }}</option>
                        @endforeach
                    </select>
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Judul Tugas *</label>
                    <input type="text" name="judul_tugas" required class="w-full px-3 py-2 rounded-lg border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-800 dark:text-white focus:ring-2 focus:ring-purple-500" placeholder="Contoh: Write Your Introduction">
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Deskripsi *</label>
                    <textarea name="deskripsi" rows="6" required class="w-full px-3 py-2 rounded-lg border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-800 dark:text-white focus:ring-2 focus:ring-purple-500" placeholder="Tulis instruksi tugas di sini..."></textarea>
                </div>

                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Deadline</label>
                        <input type="datetime-local" name="deadline" class="w-full px-3 py-2 rounded-lg border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-800 dark:text-white focus:ring-2 focus:ring-purple-500">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Poin</label>
                        <input type="number" name="poin_maksimal" value="100" min="1" max="100" class="w-full px-3 py-2 rounded-lg border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-800 dark:text-white focus:ring-2 focus:ring-purple-500">
                    </div>
                </div>

                <button type="submit" class="w-full bg-purple-500 text-gray-100 py-3 rounded-lg hover:bg-purple-600 transition font-semibold !important" style="background-color: #a855f7 !important; color: #f3f4f6 !important;">
                    📋 Buat Tugas
                </button>
            </form>
        </div>

        <!-- Info Panel -->
        <div class="space-y-6">
            <div class="bg-blue-50 dark:bg-blue-900/30 border border-blue-200 dark:border-blue-800 rounded-lg p-6">
                <h3 class="font-semibold text-blue-800 dark:text-blue-300 mb-3">ℹ️ Informasi</h3>
                <ul class="space-y-2 text-sm text-blue-700 dark:text-blue-400">
                    <li>✅ Pilih skill yang sesuai dengan tugas</li>
                    <li>✅ Tulis deskripsi yang jelas dan detail</li>
                    <li>✅ Deadline bersifat opsional</li>
                    <li>✅ Murid dapat upload: JPG, PNG, PDF, DOC</li>
                    <li>✅ Anda dapat menilai & memberi feedback</li>
                </ul>
            </div>

            <div class="bg-green-50 dark:bg-green-900/30 border border-green-200 dark:border-green-800 rounded-lg p-6">
                <h3 class="font-semibold text-green-800 dark:text-green-300 mb-3">📋 Contoh Deskripsi</h3>
                <div class="text-sm text-green-700 dark:text-green-400 space-y-2">
                    <p><strong>Tugas: Write Your Introduction</strong></p>
                    <p>Instruksi:</p>
                    <ol class="list-decimal list-inside space-y-1">
                        <li>Tulis perkenalan diri dalam bahasa Inggris</li>
                        <li>Minimal 100 kata</li>
                        <li>Sertakan: nama, asal, hobi, cita-cita</li>
                        <li>Format: PDF atau DOC</li>
                        <li>Upload sebelum deadline</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>
</x-layouts.lms>
