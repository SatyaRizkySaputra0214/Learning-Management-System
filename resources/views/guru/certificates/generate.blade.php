<x-layouts.lms>
    <x-slot name="sidebar">
        @include('layouts.sidebar-guru')
    </x-slot>

    <div class="mb-6">
        <a href="{{ route('guru.classes.show', $class) }}" class="text-blue-600 dark:text-blue-400 hover:underline text-sm mb-4 inline-block">← Kembali ke Kelas</a>
        <h1 class="text-2xl font-bold text-gray-800 dark:text-white">Generate Sertifikat</h1>
        <p class="text-gray-500 dark:text-gray-400 mt-1">Untuk: {{ $student->nama_lengkap }}</p>
    </div>

    <form method="POST" action="{{ route('guru.certificates.store', ['class' => $class, 'student' => $student]) }}" class="max-w-4xl">
        @csrf
        
        <!-- Preview Sertifikat Halaman 1 -->
        <div class="mb-8 bg-white dark:bg-gray-800 rounded-lg shadow-sm border border-gray-200 dark:border-gray-700 p-8">
            <h2 class="text-lg font-semibold text-gray-800 dark:text-white mb-4 flex items-center gap-2">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                </svg>
                Halaman 1 - Depan (Kelulusan)
            </h2>
            
            <div class="border-4 border-double border-blue-500 rounded-lg p-8 text-center bg-gradient-to-br from-blue-50 to-purple-50 dark:from-gray-700 dark:to-gray-800">
                <div class="mb-4">
                    <svg class="w-16 h-16 mx-auto text-yellow-500" fill="currentColor" viewBox="0 0 20 20">
                        <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                    </svg>
                </div>
                <h3 class="text-2xl font-bold text-gray-800 dark:text-white mb-2">SERTIFIKAT KELULUSAN</h3>
                <p class="text-gray-600 dark:text-gray-300 mb-6">LMS Bahasa</p>
                <div class="my-6 border-t-2 border-gray-300 dark:border-gray-600"></div>
                <p class="text-gray-700 dark:text-gray-300 mb-4">Diberikan kepada:</p>
                <p class="text-3xl font-bold text-blue-600 dark:text-blue-400 mb-4">{{ $student->nama_lengkap }}</p>
                <p class="text-gray-700 dark:text-gray-300">Telah menyelesaikan kursus</p>
                <p class="text-xl font-semibold text-gray-800 dark:text-white mt-2">{{ $class->course->nama_bahasa }}</p>
                <p class="text-sm text-gray-500 dark:text-gray-400 mt-4">{{ $class->periode }}</p>
            </div>
        </div>

        <!-- Input Nilai Halaman 2 -->
        <div class="mb-8 bg-white dark:bg-gray-800 rounded-lg shadow-sm border border-gray-200 dark:border-gray-700 p-6">
            <h2 class="text-lg font-semibold text-gray-800 dark:text-white mb-4 flex items-center gap-2">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/>
                </svg>
                Halaman 2 - Rincian Nilai
            </h2>

            <div class="grid grid-cols-2 md:grid-cols-5 gap-4">
                @php
                    $skills = ['reading' => 'Reading', 'writing' => 'Writing', 'listening' => 'Listening', 'speaking' => 'Speaking', 'grammar' => 'Grammar'];
                @endphp
                @foreach($skills as $key => $label)
                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">{{ $label }}</label>
                        <input type="number" name="nilai_{{ $key }}" min="0" max="100" 
                               value="{{ old('nilai_' . $key, $skillScores[$key] ?? '') }}"
                               class="w-full px-4 py-3 rounded-lg border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-800 dark:text-white focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                    </div>
                @endforeach
            </div>

            @if($rataRata)
                <div class="mt-6 p-4 bg-blue-50 dark:bg-blue-900/30 rounded-lg">
                    <div class="flex items-center justify-between">
                        <span class="text-gray-700 dark:text-gray-300">Rata-rata Nilai:</span>
                        <span class="text-2xl font-bold text-blue-600 dark:text-blue-400">{{ number_format($rataRata, 2) }}</span>
                    </div>
                </div>
            @endif
        </div>

        <div class="flex gap-4">
            <button type="submit" class="bg-green-500 text-gray-100 px-8 py-3 rounded-lg hover:bg-green-600 transition font-medium !important" style="background-color: #22c55e !important; color: #f3f4f6 !important;">
                ✓ Generate & Simpan Sertifikat
            </button>
            <a href="{{ route('guru.classes.show', $class) }}"
               class="bg-red-500 text-gray-100 px-8 py-3 rounded-lg hover:bg-red-600 transition font-medium !important" style="background-color: #ef4444 !important; color: #f3f4f6 !important;">
                Batal
            </a>
        </div>
    </form>
</x-layouts.lms>
