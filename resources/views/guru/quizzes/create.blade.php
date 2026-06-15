<x-layouts.lms>
    <x-slot name="sidebar">
        @include('layouts.sidebar-guru')
    </x-slot>

    <div class="mb-6">
        <a href="{{ route('guru.classes.show', $meeting->class) }}" class="text-blue-600 dark:text-blue-400 hover:underline text-sm mb-4 inline-block">← Kembali ke Kelas</a>
        <h1 class="text-2xl font-bold text-gray-800 dark:text-white">Buat Kuis Baru</h1>
        <p class="text-gray-500 dark:text-gray-400 mt-1">{{ $meeting->judul_pertemuan }}</p>
    </div>

    <div class="max-w-2xl bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700 p-6">
        <form method="POST" action="{{ route('guru.quizzes.store', $meeting) }}" class="space-y-6">
            @csrf
            
            <div>
                <label for="id_skill" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                    Label Skill *
                </label>
                <select id="id_skill" name="id_skill" required 
                        class="w-full px-4 py-3 rounded-lg border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-800 dark:text-white focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('id_skill') border-red-500 @enderror">
                    <option value="">Pilih Skill</option>
                    @foreach($skills as $skill)
                        <option value="{{ $skill->id }}" {{ old('id_skill') == $skill->id ? 'selected' : '' }}>
                            {{ $skill->nama_skill }}
                        </option>
                    @endforeach
                </select>
                @error('id_skill')
                    <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label for="judul_kuis" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                    Judul Kuis *
                </label>
                <input type="text" id="judul_kuis" name="judul_kuis" value="{{ old('judul_kuis') }}" required 
                       placeholder="Contoh: Quiz 1 - Introduction"
                       class="w-full px-4 py-3 rounded-lg border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-800 dark:text-white focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('judul_kuis') border-red-500 @enderror">
                @error('judul_kuis')
                    <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label for="deskripsi" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                    Deskripsi (Opsional)
                </label>
                <textarea id="deskripsi" name="deskripsi" rows="3" 
                          class="w-full px-4 py-3 rounded-lg border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-800 dark:text-white focus:ring-2 focus:ring-blue-500 focus:border-transparent">{{ old('deskripsi') }}</textarea>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <label for="tanggal_mulai" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                        Tanggal Mulai *
                    </label>
                    <input type="date" id="tanggal_mulai" name="tanggal_mulai" value="{{ old('tanggal_mulai') }}" required
                           class="w-full px-4 py-3 rounded-lg border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-800 dark:text-white focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('tanggal_mulai') border-red-500 @enderror">
                    @error('tanggal_mulai')
                        <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                    @enderror
                </div>
                <div>
                    <label for="jam_mulai" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                        Jam Mulai *
                    </label>
                    <input type="time" id="jam_mulai" name="jam_mulai" value="{{ old('jam_mulai') }}" required
                           class="w-full px-4 py-3 rounded-lg border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-800 dark:text-white focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('jam_mulai') border-red-500 @enderror">
                    @error('jam_mulai')
                        <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                    @enderror
                </div>
                <div>
                    <label for="tanggal_berakhir" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                        Tanggal Berakhir *
                    </label>
                    <input type="date" id="tanggal_berakhir" name="tanggal_berakhir" value="{{ old('tanggal_berakhir') }}" required
                           class="w-full px-4 py-3 rounded-lg border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-800 dark:text-white focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('tanggal_berakhir') border-red-500 @enderror">
                    @error('tanggal_berakhir')
                        <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                    @enderror
                </div>
                <div>
                    <label for="jam_berakhir" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                        Jam Berakhir *
                    </label>
                    <input type="time" id="jam_berakhir" name="jam_berakhir" value="{{ old('jam_berakhir') }}" required
                           class="w-full px-4 py-3 rounded-lg border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-800 dark:text-white focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('jam_berakhir') border-red-500 @enderror">
                    @error('jam_berakhir')
                        <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <div class="bg-blue-50 dark:bg-blue-900/30 border border-blue-200 dark:border-blue-800 rounded-lg p-4">
                <div class="flex items-start gap-3">
                    <svg class="w-5 h-5 text-blue-600 dark:text-blue-400 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                    <div>
                        <h4 class="font-medium text-blue-800 dark:text-blue-300 text-sm">Info:</h4>
                        <p class="text-xs text-blue-700 dark:text-blue-400 mt-1">
                            Setelah kuis dibuat, Anda akan diarahkan ke halaman untuk menambahkan soal-soal pilihan ganda.
                        </p>
                    </div>
                </div>
            </div>

            <div class="flex gap-4 pt-4">
                <button type="submit" class="bg-blue-600 text-white px-6 py-3 rounded-lg hover:bg-blue-700 transition font-medium">
                    📝 Buat Kuis
                </button>
                <a href="{{ route('guru.classes.show', $meeting->class) }}"
                   class="inline-flex items-center gap-2 px-6 py-3 text-sm font-medium text-gray-700 dark:text-gray-300 bg-white dark:bg-gray-700 border border-gray-300 dark:border-gray-600 rounded-lg hover:bg-gray-50 dark:hover:bg-gray-600 transition-all duration-200">
                    Batal
                </a>
            </div>
        </form>
    </div>
</x-layouts.lms>
