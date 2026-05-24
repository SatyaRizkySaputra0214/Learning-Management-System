<x-layouts.lms>
    <x-slot name="sidebar">
        @include('layouts.sidebar-guru')
    </x-slot>

    <div class="mb-6">
        <div class="flex items-center justify-between">
            <div>
                <a href="{{ route('guru.classes.show', $assignment->meeting->class) }}" class="text-blue-600 dark:text-blue-400 hover:underline text-sm mb-2 inline-block">← Kembali ke Kelas</a>
                <h1 class="text-2xl font-bold text-gray-800 dark:text-white">Penilaian Tugas</h1>
                <p class="text-gray-500 dark:text-gray-400 mt-1">{{ $assignment->judul_tugas }} - {{ $assignment->skill->nama_skill }}</p>
            </div>
            <div class="flex gap-2">
                <a href="{{ route('guru.assignments.edit', $assignment) }}"
                   class="bg-purple-500 text-gray-100 px-4 py-2 rounded-lg hover:bg-purple-600 transition text-sm flex items-center gap-2 !important" style="background-color: #a855f7 !important; color: #f3f4f6 !important;">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                    </svg>
                    Edit Tugas
                </a>
            </div>
        </div>
    </div>

    @if(session('success'))
        <div class="mb-6 bg-green-50 dark:bg-green-900/30 border-l-4 border-green-500 p-4 rounded-md">
            <div class="flex items-center">
                <svg class="w-5 h-5 text-green-500 mr-2" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                </svg>
                <span class="text-green-700 dark:text-green-300">{{ session('success') }}</span>
            </div>
        </div>
    @endif

    @if(count($studentSubmissions) > 0)
        <div class="bg-white dark:bg-gray-800 rounded-lg shadow-sm border border-gray-200 dark:border-gray-700 overflow-hidden">
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                    <thead class="bg-gray-50 dark:bg-gray-900">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Murid</th>
                            <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Status</th>
                            <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Tanggal Pengumpulan</th>
                            <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Nilai</th>
                            <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
                        @foreach($studentSubmissions as $item)
                            @php
                                $student = $item['student'];
                                $submission = $item['submission'];
                                $hasSubmitted = $item['has_submitted'];
                                $isGraded = $item['is_graded'];
                            @endphp
                            <tr class="hover:bg-gray-50 dark:hover:bg-gray-700 transition {{ !$hasSubmitted ? 'bg-gray-100 dark:bg-gray-900' : '' }}">
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="flex items-center">
                                        <div class="w-10 h-10 bg-purple-500 rounded-full flex items-center justify-center text-white text-sm font-semibold">
                                            {{ strtoupper(substr($student->nama_lengkap, 0, 1)) }}
                                        </div>
                                        <div class="ml-4">
                                            <div class="text-sm font-medium text-gray-900 dark:text-white">{{ $student->nama_lengkap }}</div>
                                            <div class="text-sm text-gray-500 dark:text-gray-400">{{ $student->email }}</div>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-center">
                                    @if($hasSubmitted)
                                        @if($isGraded)
                                            <span class="px-3 py-1 rounded-full text-xs font-medium bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-200">
                                                ✓ Sudah Dinilai
                                            </span>
                                        @else
                                            <span class="px-3 py-1 rounded-full text-xs font-medium bg-blue-100 text-blue-800 dark:bg-blue-900 dark:text-blue-200">
                                                ✓ Sudah Mengumpul
                                            </span>
                                        @endif
                                    @else
                                        <span class="px-3 py-1 rounded-full text-xs font-medium bg-red-100 text-red-800 dark:bg-red-900 dark:text-red-200">
                                            ✗ Belum Mengumpul
                                        </span>
                                    @endif
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-center">
                                    @if($hasSubmitted)
                                        <span class="text-sm text-gray-700 dark:text-gray-300">
                                            {{ $submission->submitted_at->format('d M Y, H:i') }}
                                        </span>
                                    @else
                                        <span class="text-gray-400 dark:text-gray-500">-</span>
                                    @endif
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-center">
                                    @if($isGraded)
                                        <span class="px-3 py-1 rounded-full text-sm font-bold bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-200">
                                            {{ $submission->nilai_guru }}
                                        </span>
                                    @elseif($hasSubmitted)
                                        <span class="text-sm text-orange-600 dark:text-orange-400 font-medium">
                                            Belum dinilai
                                        </span>
                                    @else
                                        <span class="text-gray-400 dark:text-gray-500">-</span>
                                    @endif
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-center">
                                    @if($hasSubmitted)
                                        <div class="flex items-center justify-center gap-2">
                                            @if(!$isGraded)
                                                <button onclick="toggleGradeForm({{ $submission->id }})" 
                                                        class="inline-flex items-center gap-1 px-3 py-1.5 bg-blue-500 text-gray-100 text-xs font-medium rounded-md hover:bg-blue-600 transition !important" style="background-color: #3b82f6 !important; color: #f3f4f6 !important;">
                                                    <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                                                    </svg>
                                                    Nilai
                                                </button>
                                            @else
                                                <button onclick="toggleGradeForm({{ $submission->id }})" 
                                                        class="inline-flex items-center gap-1 px-3 py-1.5 bg-purple-500 text-gray-100 text-xs font-medium rounded-md hover:bg-purple-600 transition !important" style="background-color: #a855f7 !important; color: #f3f4f6 !important;">
                                                    <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                                                    </svg>
                                                    Lihat File
                                                </button>
                                            @endif
                                        </div>
                                    @else
                                        <span class="text-gray-400 dark:text-gray-500 text-sm">-</span>
                                    @endif
                                </td>
                            </tr>
                            
                            @if($hasSubmitted)
                                <!-- Hidden row for grading form -->
                                <tr id="grade-form-{{ $submission->id }}" class="hidden bg-gray-50 dark:bg-gray-900">
                                    <td colspan="5" class="px-6 py-4">
                                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                                            <div>
                                                <a href="{{ route('guru.assignments.file', $submission) }}" target="_blank"
                                                   class="inline-flex items-center gap-2 text-blue-600 dark:text-blue-400 hover:underline text-sm">
                                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                                                    </svg>
                                                    Lihat File Jawaban
                                                </a>
                                            </div>
                                            @if($submission->catatan_siswa)
                                                <div class="text-sm text-gray-600 dark:text-gray-300">
                                                    <span class="font-medium">Catatan Siswa:</span> {{ $submission->catatan_siswa }}
                                                </div>
                                            @endif
                                        </div>
                                        
                                        <form method="POST" action="{{ route('guru.assignments.grade', $submission) }}" class="flex flex-col md:flex-row gap-4">
                                            @csrf
                                            <div class="flex-1">
                                                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Nilai (0-100)</label>
                                                <input type="number" name="nilai_guru" min="0" max="100" value="{{ old('nilai_guru', $submission->nilai_guru) }}" required
                                                       class="w-full px-4 py-3 rounded-lg border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-800 dark:text-white focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                                            </div>
                                            <div class="flex-1">
                                                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Feedback</label>
                                                <input type="text" name="feedback" value="{{ old('feedback', $submission->feedback) }}"
                                                       class="w-full px-4 py-3 rounded-lg border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-800 dark:text-white focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                                            </div>
                                            <div class="flex items-end gap-2">
                                                <button type="submit" class="bg-green-500 text-gray-100 px-6 py-3 rounded-lg hover:bg-green-600 transition font-medium !important" style="background-color: #22c55e !important; color: #f3f4f6 !important;">
                                                    Simpan Nilai
                                                </button>
                                                <button type="button" onclick="toggleGradeForm({{ $submission->id }})" 
                                                        class="bg-gray-500 text-gray-100 px-6 py-3 rounded-lg hover:bg-gray-600 transition font-medium !important" style="background-color: #6b7280 !important; color: #f3f4f6 !important;">
                                                    Batal
                                                </button>
                                            </div>
                                        </form>
                                    </td>
                                </tr>
                                
                            @endif
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    @else
        <div class="bg-white dark:bg-gray-800 rounded-lg shadow-sm border border-gray-200 dark:border-gray-700 p-12 text-center">
            <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"/>
            </svg>
            <h3 class="mt-4 text-lg font-medium text-gray-800 dark:text-white">Belum Ada Murid</h3>
            <p class="mt-2 text-gray-500 dark:text-gray-400">Belum ada murid yang terdaftar di kelas ini.</p>
        </div>
    @endif

    <script>
        function toggleGradeForm(submissionId) {
            const gradeForm = document.getElementById('grade-form-' + submissionId);
            const viewForm = document.getElementById('view-form-' + submissionId);
            
            if (gradeForm && gradeForm.classList.contains('hidden')) {
                gradeForm.classList.remove('hidden');
                if (viewForm) viewForm.classList.add('hidden');
            } else if (viewForm && viewForm.classList.contains('hidden')) {
                viewForm.classList.remove('hidden');
                if (gradeForm) gradeForm.classList.add('hidden');
            } else {
                if (gradeForm) gradeForm.classList.add('hidden');
                if (viewForm) viewForm.classList.add('hidden');
            }
        }
    </script>
</x-layouts.lms>
