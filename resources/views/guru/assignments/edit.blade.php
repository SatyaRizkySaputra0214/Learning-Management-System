<x-layouts.lms>
    <x-slot name="sidebar">
        @include('layouts.sidebar-guru')
    </x-slot>

    <div class="mb-6">
        <a href="{{ route('guru.assignments.submissions', $assignment) }}" class="text-blue-600 dark:text-blue-400 hover:underline text-sm mb-4 inline-block">← Kembali ke Daftar Submisi</a>
        <h1 class="text-2xl font-bold text-gray-800 dark:text-white">Edit Tugas</h1>
        <p class="text-gray-500 dark:text-gray-400 mt-1">{{ $assignment->judul_tugas }}</p>
    </div>

    <div class="max-w-2xl bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700 p-6">
        <form method="POST" action="{{ route('guru.assignments.update', $assignment) }}" class="space-y-6">
            @csrf
            @method('PUT')

            <div>
                <label for="id_skill" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                    Label Skill *
                </label>
                <select id="id_skill" name="id_skill" required
                        class="w-full px-4 py-3 rounded-lg border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-800 dark:text-white focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('id_skill') border-red-500 @enderror">
                    <option value="">Pilih Skill</option>
                    @foreach($skills as $skill)
                        <option value="{{ $skill->id }}" {{ old('id_skill', $assignment->id_skill) == $skill->id ? 'selected' : '' }}>
                            {{ $skill->nama_skill }}
                        </option>
                    @endforeach
                </select>
                @error('id_skill')
                    <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label for="judul_tugas" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                    Judul Tugas *
                </label>
                <input type="text" id="judul_tugas" name="judul_tugas" value="{{ old('judul_tugas', $assignment->judul_tugas) }}" required
                       placeholder="Contoh: Write Your Introduction"
                       class="w-full px-4 py-3 rounded-lg border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-800 dark:text-white focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('judul_tugas') border-red-500 @enderror">
                @error('judul_tugas')
                    <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label for="deskripsi" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                    Deskripsi Tugas *
                </label>
                <textarea id="deskripsi" name="deskripsi" rows="6" required
                          placeholder="Contoh:&#10;1. Tulis perkenalan diri dalam bahasa Inggris (minimal 100 kata)&#10;2. Sertakan: nama, asal, hobi, dan cita-cita&#10;3. Format: PDF atau DOC&#10;4. Upload sebelum deadline"
                          class="w-full px-4 py-3 rounded-lg border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-800 dark:text-white focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('deskripsi') border-red-500 @enderror">{{ old('deskripsi', $assignment->deskripsi) }}</textarea>
                <p class="mt-1 text-xs text-gray-500 dark:text-gray-400">Berikan instruksi yang jelas dan detail untuk murid</p>
            </div>

            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label for="deadline" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                        Deadline
                    </label>
                    <input type="datetime-local" id="deadline" name="deadline" value="{{ old('deadline', $assignment->deadline ? \Carbon\Carbon::parse($assignment->deadline)->format('Y-m-d\TH:i') : '') }}"
                           class="w-full px-4 py-3 rounded-lg border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-800 dark:text-white focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                    <p class="mt-1 text-xs text-gray-500 dark:text-gray-400">Opsional</p>
                </div>

                <div>
                    <label for="poin_maksimal" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                        Poin Maksimal
                    </label>
                    <input type="number" id="poin_maksimal" name="poin_maksimal" value="{{ old('poin_maksimal', $assignment->poin_maksimal ?? 100) }}" min="1" max="100"
                           class="w-full px-4 py-3 rounded-lg border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-800 dark:text-white focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                    <p class="mt-1 text-xs text-gray-500 dark:text-gray-400">Default: 100</p>
                </div>
            </div>

            <div class="bg-purple-50 dark:bg-purple-900/30 border border-purple-200 dark:border-purple-800 rounded-lg p-4">
                <div class="flex items-start gap-3">
                    <svg class="w-5 h-5 text-purple-600 dark:text-purple-400 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                    </svg>
                    <div>
                        <h4 class="font-medium text-purple-800 dark:text-purple-300 text-sm">Info:</h4>
                        <p class="text-xs text-purple-700 dark:text-purple-400 mt-1">
                            Perubahan pada tugas akan langsung terlihat oleh murid.<br>
                            Submisi yang sudah masuk tidak akan terpengaruh oleh perubahan ini.
                        </p>
                    </div>
                </div>
            </div>

            <div class="flex gap-4 pt-4">
                <button type="submit" class="inline-flex items-center gap-2 px-6 py-3 text-sm font-medium text-white bg-blue-600 rounded-lg hover:bg-blue-700 transition">
                    ✓ Simpan Perubahan
                </button>
                <a href="{{ route('guru.assignments.submissions', $assignment) }}"
                   class="inline-flex items-center gap-2 px-6 py-3 text-sm font-medium text-gray-700 dark:text-gray-300 bg-white dark:bg-gray-700 border border-gray-300 dark:border-gray-600 rounded-lg hover:bg-gray-50 dark:hover:bg-gray-600 transition">
                    Batal
                </a>
            </div>
        </form>
    </div>
</x-layouts.lms>
