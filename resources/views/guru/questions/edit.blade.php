<x-layouts.lms>
    <x-slot name="sidebar">
        @include('layouts.sidebar-guru')
    </x-slot>

    <div class="mb-6">
        <a href="{{ route('guru.quizzes.edit', $question->quiz) }}" class="text-blue-600 dark:text-blue-400 hover:underline text-sm mb-4 inline-block">← Kembali ke Edit Kuis</a>
        <h1 class="text-2xl font-bold text-gray-800 dark:text-white">Edit Soal</h1>
    </div>

    <div class="max-w-3xl bg-white dark:bg-gray-800 rounded-lg shadow-sm border border-gray-200 dark:border-gray-700 p-6">
        <form method="POST" action="{{ route('guru.questions.update', $question) }}" class="space-y-6">
            @csrf
            @method('PUT')

            <div>
                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Soal *</label>
                <textarea name="soal" rows="4" required 
                          class="w-full px-4 py-3 rounded-lg border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-800 dark:text-white focus:ring-2 focus:ring-blue-500 focus:border-transparent">{{ old('soal', $question->soal) }}</textarea>
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Opsi A *</label>
                <input type="text" name="opsi_a" value="{{ old('opsi_a', $question->opsi_a) }}" required 
                       class="w-full px-4 py-3 rounded-lg border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-800 dark:text-white focus:ring-2 focus:ring-blue-500 focus:border-transparent">
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Opsi B *</label>
                <input type="text" name="opsi_b" value="{{ old('opsi_b', $question->opsi_b) }}" required 
                       class="w-full px-4 py-3 rounded-lg border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-800 dark:text-white focus:ring-2 focus:ring-blue-500 focus:border-transparent">
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Opsi C *</label>
                <input type="text" name="opsi_c" value="{{ old('opsi_c', $question->opsi_c) }}" required 
                       class="w-full px-4 py-3 rounded-lg border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-800 dark:text-white focus:ring-2 focus:ring-blue-500 focus:border-transparent">
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Opsi D *</label>
                <input type="text" name="opsi_d" value="{{ old('opsi_d', $question->opsi_d) }}" required 
                       class="w-full px-4 py-3 rounded-lg border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-800 dark:text-white focus:ring-2 focus:ring-blue-500 focus:border-transparent">
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Kunci Jawaban *</label>
                <select name="kunci_jawaban" required 
                        class="w-full px-4 py-3 rounded-lg border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-800 dark:text-white focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                    <option value="A" {{ old('kunci_jawaban', $question->kunci_jawaban) === 'A' ? 'selected' : '' }}>A</option>
                    <option value="B" {{ old('kunci_jawaban', $question->kunci_jawaban) === 'B' ? 'selected' : '' }}>B</option>
                    <option value="C" {{ old('kunci_jawaban', $question->kunci_jawaban) === 'C' ? 'selected' : '' }}>C</option>
                    <option value="D" {{ old('kunci_jawaban', $question->kunci_jawaban) === 'D' ? 'selected' : '' }}>D</option>
                </select>
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Poin (opsional)</label>
                <input type="number" name="poin" value="{{ old('poin', $question->poin) }}" min="1" 
                       class="w-full px-4 py-3 rounded-lg border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-800 dark:text-white focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                <p class="mt-1 text-xs text-gray-500 dark:text-gray-400">Kosongkan atau isi 1 untuk poin default</p>
            </div>

            <div class="flex gap-4 pt-4">
                <button type="submit" class="bg-green-500 text-gray-100 px-6 py-3 rounded-lg hover:bg-green-600 transition font-medium flex-1 !important" style="background-color: #22c55e !important; color: #f3f4f6 !important;">
                    ✓ Update Soal
                </button>
                <a href="{{ route('guru.quizzes.edit', $question->quiz) }}"
                   class="bg-red-500 text-gray-100 px-6 py-3 rounded-lg hover:bg-red-600 transition font-medium !important" style="background-color: #ef4444 !important; color: #f3f4f6 !important;">
                    Batal
                </a>
            </div>
        </form>
    </div>
</x-layouts.lms>
