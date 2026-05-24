<x-layouts.lms>
    <x-slot name="sidebar">
        @include('layouts.sidebar-guru')
    </x-slot>

    <div class="mb-6">
        <a href="{{ route('guru.classes.show', $quiz->meeting->class) }}" class="text-blue-600 dark:text-blue-400 hover:underline text-sm mb-4 inline-block">← Kembali ke Kelas</a>
        <h1 class="text-2xl font-bold text-gray-800 dark:text-white">Edit Kuis</h1>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <div class="lg:col-span-2 space-y-6">
            <!-- Form Edit Kuis -->
            <div class="bg-white dark:bg-gray-800 rounded-lg shadow-sm border border-gray-200 dark:border-gray-700 p-6">
                <h2 class="text-lg font-semibold text-gray-800 dark:text-white mb-4">Informasi Kuis</h2>
                <form method="POST" action="{{ route('guru.quizzes.update', $quiz) }}" class="space-y-4">
                    @csrf
                    @method('PUT')
                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Judul Kuis</label>
                        <input type="text" name="judul_kuis" value="{{ old('judul_kuis', $quiz->judul_kuis) }}" required 
                               class="w-full px-4 py-3 rounded-lg border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-800 dark:text-white focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Skill</label>
                        <select name="id_skill" required class="w-full px-4 py-3 rounded-lg border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-800 dark:text-white focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                            @foreach($skills as $skill)
                                <option value="{{ $skill->id }}" {{ $quiz->id_skill == $skill->id ? 'selected' : '' }}>{{ $skill->nama_skill }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Tanggal Mulai *</label>
                            <input type="date" name="tanggal_mulai" value="{{ old('tanggal_mulai', $quiz->start_at ? $quiz->start_at->format('Y-m-d') : '') }}" required
                                   class="w-full px-4 py-3 rounded-lg border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-800 dark:text-white focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Jam Mulai *</label>
                            <input type="time" name="jam_mulai" value="{{ old('jam_mulai', $quiz->start_at ? $quiz->start_at->format('H:i') : '') }}" required
                                   class="w-full px-4 py-3 rounded-lg border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-800 dark:text-white focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Tanggal Berakhir *</label>
                            <input type="date" name="tanggal_berakhir" value="{{ old('tanggal_berakhir', $quiz->end_at ? $quiz->end_at->format('Y-m-d') : '') }}" required
                                   class="w-full px-4 py-3 rounded-lg border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-800 dark:text-white focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Jam Berakhir *</label>
                            <input type="time" name="jam_berakhir" value="{{ old('jam_berakhir', $quiz->end_at ? $quiz->end_at->format('H:i') : '') }}" required
                                   class="w-full px-4 py-3 rounded-lg border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-800 dark:text-white focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                        </div>
                    </div>
                    <button type="submit" class="bg-blue-500 text-gray-100 px-6 py-2 rounded-lg hover:bg-blue-600 transition !important" style="background-color: #3b82f6 !important; color: #f3f4f6 !important;">Update Kuis</button>
                </form>
            </div>

            <!-- Daftar Soal -->
            <div class="bg-white dark:bg-gray-800 rounded-lg shadow-sm border border-gray-200 dark:border-gray-700 p-6">
                <h2 class="text-lg font-semibold text-gray-800 dark:text-white mb-4">Daftar Soal ({{ $quiz->questions->count() }})</h2>
                
                @if($quiz->questions->count() > 0)
                    <div class="space-y-4">
                        @foreach($quiz->questions as $question)
                            <div class="border border-gray-200 dark:border-gray-700 rounded-lg p-4">
                                <div class="flex justify-between items-start mb-2">
                                    <div class="flex items-center gap-2">
                                        <span class="bg-blue-100 dark:bg-blue-900 text-blue-800 dark:text-blue-200 text-xs font-semibold px-2 py-1 rounded">Soal #{{ $loop->iteration }}</span>
                                        <span class="text-xs text-gray-500 dark:text-gray-400">{{ $question->poin }} poin</span>
                                    </div>
                                    <div class="flex items-center gap-3">
                                        <a href="{{ route('guru.questions.edit', $question) }}" 
                                           class="text-amber-600 dark:text-amber-400 hover:underline text-sm font-medium">✏️ Edit</a>
                                        <x-confirm-modal
                                            action="{{ route('guru.questions.delete', $question) }}"
                                            title="Hapus Soal"
                                            message="Hapus soal #{{ $loop->iteration }}?"
                                        >
                                            <x-slot name="trigger">
                                                <button type="button" class="text-red-600 dark:text-red-400 hover:underline text-sm font-medium">🗑️ Hapus</button>
                                            </x-slot>
                                        </x-confirm-modal>
                                    </div>
                                </div>
                                <p class="font-medium text-gray-800 dark:text-white mb-3">{{ $question->soal }}</p>
                                <div class="grid grid-cols-2 gap-2 text-sm">
                                    <span class="{{ $question->kunci_jawaban === 'A' ? 'bg-green-100 dark:bg-green-900 text-green-800 dark:text-green-200 font-semibold px-2 py-1 rounded' : 'text-gray-600 dark:text-gray-400' }}">A. {{ $question->opsi_a }}</span>
                                    <span class="{{ $question->kunci_jawaban === 'B' ? 'bg-green-100 dark:bg-green-900 text-green-800 dark:text-green-200 font-semibold px-2 py-1 rounded' : 'text-gray-600 dark:text-gray-400' }}">B. {{ $question->opsi_b }}</span>
                                    <span class="{{ $question->kunci_jawaban === 'C' ? 'bg-green-100 dark:bg-green-900 text-green-800 dark:text-green-200 font-semibold px-2 py-1 rounded' : 'text-gray-600 dark:text-gray-400' }}">C. {{ $question->opsi_c }}</span>
                                    <span class="{{ $question->kunci_jawaban === 'D' ? 'bg-green-100 dark:bg-green-900 text-green-800 dark:text-green-200 font-semibold px-2 py-1 rounded' : 'text-gray-600 dark:text-gray-400' }}">D. {{ $question->opsi_d }}</span>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @else
                    <p class="text-gray-500 dark:text-gray-400 text-center py-4">Belum ada soal.</p>
                @endif
            </div>
        </div>

        <!-- Tambah Soal -->
        <div>
            <div class="bg-white dark:bg-gray-800 rounded-lg shadow-sm border border-gray-200 dark:border-gray-700 p-6 sticky top-6">
                <h3 class="font-semibold text-gray-800 dark:text-white mb-4">Tambah Soal Baru</h3>
                <form method="POST" action="{{ route('guru.questions.add', $quiz) }}" class="space-y-4">
                    @csrf
                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Soal</label>
                        <textarea name="soal" rows="3" required class="w-full px-4 py-3 rounded-lg border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-800 dark:text-white focus:ring-2 focus:ring-blue-500 focus:border-transparent"></textarea>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Opsi A</label>
                        <input type="text" name="opsi_a" required class="w-full px-4 py-3 rounded-lg border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-800 dark:text-white focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Opsi B</label>
                        <input type="text" name="opsi_b" required class="w-full px-4 py-3 rounded-lg border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-800 dark:text-white focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Opsi C</label>
                        <input type="text" name="opsi_c" required class="w-full px-4 py-3 rounded-lg border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-800 dark:text-white focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Opsi D</label>
                        <input type="text" name="opsi_d" required class="w-full px-4 py-3 rounded-lg border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-800 dark:text-white focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Kunci Jawaban</label>
                        <select name="kunci_jawaban" required class="w-full px-4 py-3 rounded-lg border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-800 dark:text-white focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                            <option value="A">A</option>
                            <option value="B">B</option>
                            <option value="C">C</option>
                            <option value="D">D</option>
                        </select>
                    </div>
                    <button type="submit" class="w-full bg-blue-500 text-gray-100 py-2 rounded-lg hover:bg-blue-600 transition font-medium !important" style="background-color: #3b82f6 !important; color: #f3f4f6 !important;">Tambah Soal</button>
                </form>
            </div>
        </div>
    </div>
</x-layouts.lms>
