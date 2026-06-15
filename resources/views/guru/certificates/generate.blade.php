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
                    <img src="{{ asset('Logo.png') }}" alt="" class="w-24 h-24 mx-auto object-contain">
                </div>
                <h3 class="text-2xl font-bold text-gray-800 dark:text-white mb-6">SERTIFIKAT KELULUSAN</h3>
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
            <button type="submit" class="inline-flex items-center gap-2 px-6 py-3 text-sm font-medium text-white bg-green-600 rounded-lg hover:bg-green-700 transition">
                ✓ Generate & Simpan Sertifikat
            </button>
            <a href="{{ route('guru.classes.show', $class) }}"
               class="inline-flex items-center gap-2 px-6 py-3 text-sm font-medium text-gray-700 dark:text-gray-300 bg-white dark:bg-gray-700 border border-gray-300 dark:border-gray-600 rounded-lg hover:bg-gray-50 dark:hover:bg-gray-600 transition">
                Batal
            </a>
        </div>
    </form>
</x-layouts.lms>
