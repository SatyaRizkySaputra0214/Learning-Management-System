<x-layouts.lms>
    <x-slot name="sidebar">
        @include('layouts.sidebar-murid')
    </x-slot>

    <div class="mb-6">
        <a href="{{ route('murid.enrolled-classes.show', $assignment->meeting->class) }}" class="text-blue-600 dark:text-blue-400 hover:underline text-sm mb-4 inline-block">← Kembali ke Kelas</a>
        <h1 class="text-2xl font-bold text-gray-800 dark:text-white">Review Tugas</h1>
        <p class="text-gray-500 dark:text-gray-400 mt-1">{{ $assignment->judul_tugas }} • {{ $assignment->skill->nama_skill }}</p>
    </div>

    <div class="max-w-4xl space-y-6">
        {{-- Status Pengumpulan --}}
        <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700 p-6">
            <div class="flex items-center justify-between mb-4">
                <h2 class="text-lg font-semibold text-gray-800 dark:text-white flex items-center gap-2">
                    <svg class="w-6 h-6 text-green-600 dark:text-green-400" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                    </svg>
                    Tugas Sudah Dikumpulkan
                </h2>
                <span class="px-3 py-1 rounded-full text-xs font-medium bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-200">
                    Submitted
                </span>
            </div>

            <div class="grid grid-cols-2 gap-4">
                <div class="bg-gray-50 dark:bg-gray-700 rounded-lg p-4 border border-gray-200 dark:border-gray-600">
                    <p class="text-xs text-gray-500 dark:text-gray-400">Tanggal Pengumpulan</p>
                    <p class="text-sm font-medium text-gray-800 dark:text-white mt-1">
                        {{ $submission->submitted_at ? \Carbon\Carbon::parse($submission->submitted_at)->format('d M Y, H:i') : '-' }}
                    </p>
                </div>
                <div class="bg-gray-50 dark:bg-gray-700 rounded-lg p-4 border border-gray-200 dark:border-gray-600">
                    <p class="text-xs text-gray-500 dark:text-gray-400">Status Penilaian</p>
                    <p class="text-sm font-medium mt-1 {{ $submission->nilai_guru !== null ? 'text-green-600 dark:text-green-400' : 'text-gray-600 dark:text-gray-400' }}">
                        {{ $submission->nilai_guru !== null ? 'Sudah Dinilai' : 'Menunggu Penilaian' }}
                    </p>
                </div>
            </div>

            @if($submission->nilai_guru !== null)
                <div class="mt-4 bg-green-50 dark:bg-green-900/30 border border-green-200 dark:border-green-800 rounded-lg p-4">
                    <div class="flex items-center gap-3">
                        <span class="text-sm font-medium text-gray-700 dark:text-gray-300">Nilai Anda:</span>
                        <span class="text-2xl font-bold text-green-600 dark:text-green-400">{{ $submission->nilai_guru }}</span>
                    </div>
                </div>
            @endif
        </div>

        {{-- File Jawaban --}}
        <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700 p-6">
            <h2 class="text-lg font-semibold text-gray-800 dark:text-white mb-4 flex items-center gap-2">
                <svg class="w-5 h-5 text-gray-600 dark:text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                </svg>
                File Jawaban
            </h2>

            <a href="{{ route('murid.assignment.file', $submission) }}" target="_blank"
               class="flex items-center gap-3 p-4 bg-gray-50 dark:bg-gray-700 rounded-lg border border-gray-200 dark:border-gray-600 hover:bg-gray-100 dark:hover:bg-gray-600 transition">
                <svg class="w-8 h-8 text-gray-600 dark:text-gray-400 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z"/>
                </svg>
                <div class="flex-1 min-w-0">
                    <p class="font-medium text-gray-800 dark:text-white text-sm">Jawaban Anda</p>
                    <p class="text-xs text-gray-500 dark:text-gray-400 mt-1">Klik untuk melihat/download</p>
                </div>
                <svg class="w-5 h-5 text-gray-600 dark:text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"/>
                </svg>
            </a>
        </div>

        {{-- Catatan Siswa --}}
        @if($submission->catatan_siswa)
            <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700 p-6">
                <h2 class="text-lg font-semibold text-gray-800 dark:text-white mb-4 flex items-center gap-2">
                    <svg class="w-5 h-5 text-gray-600 dark:text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                    </svg>
                    Catatan Anda
                </h2>
                <p class="text-gray-700 dark:text-gray-300 bg-gray-50 dark:bg-gray-700 rounded-lg p-4 border border-gray-200 dark:border-gray-600">
                    {{ $submission->catatan_siswa }}
                </p>
            </div>
        @endif

        {{-- Deskripsi Tugas --}}
        <div class="bg-gray-50 dark:bg-gray-700 rounded-xl shadow-sm border border-gray-200 dark:border-gray-600 p-6">
            <h2 class="text-lg font-semibold text-gray-800 dark:text-white mb-4">Deskripsi Tugas</h2>
            <p class="text-gray-700 dark:text-gray-300">{!! nl2br(e($assignment->deskripsi)) !!}</p>
        </div>

        <div class="flex gap-4">
            @if($assignment->deadline && \Carbon\Carbon::parse($assignment->deadline)->isFuture())
                <a href="{{ route('murid.assignment.submit', $assignment) }}"
                   class="bg-amber-500 hover:bg-amber-600 text-white px-6 py-3 rounded-lg transition font-medium">
                    ✏️ Edit Jawaban
                </a>
            @endif

            @if(!$submission->nilai_guru)
                <form action="{{ route('murid.assignment.delete', $assignment) }}" method="POST"
                      onsubmit="return confirm('Apakah Anda yakin ingin menghapus jawaban tugas ini? Tindakan ini tidak dapat dibatalkan.')">
                    @csrf
                    @method('DELETE')
                    <button type="submit"
                            class="bg-red-500 hover:bg-red-600 text-white px-6 py-3 rounded-lg transition font-medium">
                          Hapus Jawaban
                    </button>
                </form>
            @endif
        </div>
    </div>
</x-layouts.lms>
