<x-layouts.lms>
    <x-slot name="sidebar">
        @include('layouts.sidebar-murid')
    </x-slot>

    <div class="mb-6">
        <a href="{{ route('murid.enrolled-classes.show', $assignment->meeting->class) }}" class="text-blue-600 dark:text-blue-400 hover:underline text-sm mb-4 inline-block">← Kembali ke Kelas</a>
        <h1 class="text-2xl font-bold text-gray-800 dark:text-white">{{ $assignment->judul_tugas }}</h1>
        <p class="text-gray-500 dark:text-gray-400 mt-1">Skill: {{ $assignment->skill->nama_skill }}</p>
    </div>

    <div class="max-w-2xl bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700 p-6">
        @if($existingSubmission)
            <div class="mb-6 bg-green-50 dark:bg-green-900/30 border border-green-200 dark:border-green-800 rounded-lg p-4">
                <div class="flex items-center gap-2 text-green-700 dark:text-green-300">
                    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                    </svg>
                    <span>Anda sudah mengumpulkan tugas ini.</span>
                </div>
            </div>
        @endif

        <div class="mb-6 bg-gray-50 dark:bg-gray-700 border border-gray-200 dark:border-gray-600 rounded-lg p-4">
            <h3 class="font-semibold text-gray-800 dark:text-white mb-2 flex items-center gap-2">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
                Deskripsi Tugas
            </h3>
            <p class="text-gray-700 dark:text-gray-300">{!! nl2br(e($assignment->deskripsi)) !!}</p>
        </div>

        <form action="{{ route('murid.assignment.store', $assignment) }}" method="POST" enctype="multipart/form-data" class="space-y-4">
            @csrf

            <div>
                <label for="file_upload" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Upload Jawaban *</label>
                <input type="file" name="file_upload" id="file_upload" required
                       class="w-full px-4 py-3 rounded-lg border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-800 dark:text-white focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                <p class="text-xs text-gray-500 dark:text-gray-400 mt-1">Maksimal 10MB</p>
            </div>

            <div>
                <label for="catatan_siswa" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Catatan (Opsional)</label>
                <textarea name="catatan_siswa" id="catatan_siswa" rows="3"
                          class="w-full px-4 py-3 rounded-lg border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-800 dark:text-white focus:ring-2 focus:ring-blue-500 focus:border-transparent">{{ old('catatan_siswa', $existingSubmission->catatan_siswa ?? '') }}</textarea>
            </div>

            <div class="flex items-center justify-between gap-4">
                <a href="{{ route('murid.enrolled-classes.show', $assignment->meeting->class) }}"
                   class="inline-flex items-center gap-2 px-6 py-3 text-sm font-medium text-gray-700 dark:text-gray-300 bg-white dark:bg-gray-700 border border-gray-300 dark:border-gray-600 rounded-lg hover:bg-gray-50 dark:hover:bg-gray-600 transition">
                    ← Batal
                </a>
                <button type="submit"
                        class="inline-flex items-center gap-2 px-6 py-3 text-sm font-medium text-white bg-blue-600 rounded-lg hover:bg-blue-700 transition shadow-sm">
                    {{ $existingSubmission ? '✏️ Update Jawaban' : '✓ Kumpulkan Tugas' }}
                </button>
            </div>
        </form>
    </div>
</x-layouts.lms>
