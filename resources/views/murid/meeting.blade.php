<x-layouts.lms>
    <x-slot name="sidebar">
        @include('layouts.sidebar-murid')
    </x-slot>

    {{-- ================= HEADER ================= --}}
    <div class="mb-4">
        <a href="{{ route('murid.enrolled-classes.show', $meeting->class) }}"
           class="text-blue-600 dark:text-blue-400 hover:underline text-sm mb-2 inline-block">
            ← Kembali ke Kelas
        </a>

        <h1 class="text-2xl font-bold text-gray-800 dark:text-white">
            Pertemuan {{ $meeting->urutan_pertemuan }}: {{ $meeting->judul_pertemuan }}
        </h1>
    </div>


    {{-- ================= PENGUMUMAN ================= --}}
    @if($meeting->announcements->count() > 0)
        <div class="mb-4">
            <div class="bg-white dark:bg-gray-800 rounded-lg shadow-sm border border-gray-200 dark:border-gray-700 p-4">
                <h2 class="text-lg font-semibold text-gray-800 dark:text-white mb-3">
                    Pengumuman
                </h2>

                <div class="space-y-3 max-h-[420px] overflow-y-auto pr-2">
                    @foreach($meeting->announcements->sortByDesc('is_penting')->sortByDesc('published_at') as $announcement)
                        <div class="p-3 bg-gray-50 dark:bg-gray-700 rounded-lg border border-gray-200 dark:border-gray-600">
                            <h4 class="font-semibold text-gray-800 dark:text-white text-sm">
                                {{ $announcement->judul_pengumuman }}
                            </h4>
                            <p class="text-xs text-gray-600 dark:text-gray-300 mt-1">
                                {{ $announcement->isi_pengumuman }}
                            </p>
                            <p class="text-[11px] text-gray-500 mt-2">
                                {{ $announcement->published_at->format('d M Y, H:i') }}
                            </p>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    @endif



    {{-- ================= MAIN GRID ================= --}}
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-4 items-stretch">

        {{-- ================= LEFT COLUMN (MATERI) ================= --}}
        <div class="h-full">
            <div class="bg-white dark:bg-gray-800 rounded-lg shadow-sm border border-gray-200 dark:border-gray-700 p-4 h-full">
                
                <h2 class="text-lg font-semibold text-gray-800 dark:text-white mb-3">
                    Materi
                </h2>

                @if($meeting->materials->count() > 0)
                    <div class="grid grid-cols-1 gap-3 max-h-[420px] overflow-y-auto pr-2">
                        @foreach($meeting->materials as $material)
                            <a href="{{ route('murid.material.download', $material) }}"
                               class="p-3 bg-gray-50 dark:bg-gray-700 rounded-lg border border-gray-200 dark:border-gray-600 hover:bg-gray-100 dark:hover:bg-gray-600 transition">

                                <h4 class="font-medium text-gray-800 dark:text-white text-sm truncate">
                                    {{ $material->judul }}
                                </h4>

                                <div class="flex items-center gap-2 text-xs text-gray-500 mt-2">
                                    <svg xmlns="http://www.w3.org/2000/svg"
                                         class="w-4 h-4 flex-shrink-0"
                                         fill="none"
                                         viewBox="0 0 24 24"
                                         stroke="currentColor">
                                        <path stroke-linecap="round"
                                              stroke-linejoin="round"
                                              stroke-width="2"
                                              d="M7 7h10M7 11h10M7 15h6M6 3h9l5 5v13a1 1 0 01-1 1H6a1 1 0 01-1-1V4a1 1 0 011-1z"/>
                                    </svg>
                                    <span class="truncate">{{ $material->judul }}</span>
                                </div>

                            </a>
                        @endforeach
                    </div>
                @else
                    <p class="text-sm text-gray-500 italic">
                        Konten blm tersedia
                    </p>
                @endif

            </div>
        </div>



        {{-- ================= RIGHT COLUMN ================= --}}
        <div class="space-y-4 h-full">

            {{-- ================= KUIS ================= --}}
            <div class="bg-white dark:bg-gray-800 rounded-lg shadow-sm border border-gray-200 dark:border-gray-700 p-4">
                <h2 class="text-lg font-semibold text-gray-800 dark:text-white mb-3">
                    Kuis
                </h2>

                @if($meeting->quizzes->count() > 0)
                    <div class="space-y-3 max-h-[300px] overflow-y-auto pr-2">
                        @foreach($meeting->quizzes as $quiz)
                            @php
                                $score = \App\Models\QuizScore::where('id_quiz', $quiz->id)
                                    ->where('id_student', auth()->id())
                                    ->whereNotNull('skor')
                                    ->first();
                                $notStarted = $quiz->isNotYetStarted();
                                $isEnded = $quiz->isEnded();
                            @endphp

                            <div class="p-3 bg-gray-50 dark:bg-gray-700 rounded-lg border border-gray-200 dark:border-gray-600 flex justify-between items-center">
                                <div>
                                    <h4 class="font-medium text-gray-800 dark:text-white text-sm">
                                        {{ $quiz->judul_kuis }}
                                    </h4>
                                    <p class="text-xs text-gray-600 dark:text-gray-300">
                                        {{ $quiz->questions->count() }} Soal
                                        @if($quiz->start_at)
                                            <br>{{ $quiz->start_at->format('d/m/Y H:i') }} - {{ $quiz->end_at ? $quiz->end_at->format('d/m/Y H:i') : '-' }}
                                        @endif
                                    </p>
                                </div>

                                @if($score)
                                    <a href="{{ route('murid.quiz.result', $score) }}"
                                       class="bg-green-600 hover:bg-green-700 text-white px-3 py-1.5 rounded-lg text-xs font-medium whitespace-nowrap">
                                        Hasil
                                    </a>
                                @elseif($notStarted)
                                    <span class="bg-gray-500 text-white px-3 py-1.5 rounded-lg text-xs font-medium whitespace-nowrap">
                                        Belum Dimulai
                                    </span>
                                @elseif($isEnded)
                                    <span class="bg-red-600 text-white px-3 py-1.5 rounded-lg text-xs font-medium whitespace-nowrap">
                                        Berakhir
                                    </span>
                                @else
                                    <a href="{{ route('murid.quiz.take', $quiz) }}"
                                       class="bg-blue-600 hover:bg-blue-700 text-white px-3 py-1.5 rounded-lg text-xs font-medium whitespace-nowrap">
                                        Kerjakan
                                    </a>
                                @endif
                            </div>
                        @endforeach
                    </div>
                @else
                    <p class="text-sm text-gray-500 italic">
                        Konten blm tersedia
                    </p>
                @endif
            </div>



            {{-- ================= TUGAS ================= --}}
            <div class="bg-white dark:bg-gray-800 rounded-lg shadow-sm border border-gray-200 dark:border-gray-700 p-4">
                <h2 class="text-lg font-semibold text-gray-800 dark:text-white mb-3">
                    Tugas
                </h2>

                @if($meeting->assignments->count() > 0)
                    <div class="space-y-3 max-h-[300px] overflow-y-auto pr-2">
                        @foreach($meeting->assignments as $assignment)
                            @php
                                $submission = \App\Models\AssignmentSubmission::where('id_assignment', $assignment->id)
                                    ->where('id_student', auth()->id())
                                    ->first();
                                $isOverdue = !$submission && $assignment->deadline < now();
                                $isGraded = $submission && $submission->nilai_guru !== null;
                            @endphp

                            <div class="p-3 bg-gray-50 dark:bg-gray-700 rounded-lg border border-gray-200 dark:border-gray-600 flex justify-between items-center">
                                <div class="flex-1">
                                    <h4 class="font-medium text-gray-800 dark:text-white text-sm">
                                        {{ $assignment->judul_tugas }}
                                    </h4>
                                    <p class="text-xs text-gray-600 dark:text-gray-300">
                                        {{ \Carbon\Carbon::parse($assignment->deadline)->format('d M Y, H:i') }}
                                    </p>
                                </div>

                                @if($submission)
                                    @if($isGraded)
                                        <a href="{{ route('murid.assignment.review', $assignment) }}"
                                           class="bg-green-600 hover:bg-green-700 text-white px-3 py-1.5 rounded-lg text-xs font-medium whitespace-nowrap flex items-center gap-1"
                                           style="background-color: #16a34a !important; color: #ffffff !important;">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                                            </svg>
                                            Dinilai
                                        </a>
                                    @else
                                        <a href="{{ route('murid.assignment.review', $assignment) }}"
                                           class="bg-blue-600 hover:bg-blue-700 text-white px-3 py-1.5 rounded-lg text-xs font-medium whitespace-nowrap"
                                           style="background-color: #2563eb !important; color: #ffffff !important;">
                                            Status
                                        </a>
                                    @endif
                                @else
                                    <a href="{{ route('murid.assignment.submit', $assignment) }}"
                                       class="{{ $isOverdue ? 'bg-red-600 hover:bg-red-700' : 'bg-orange-600 hover:bg-orange-700' }} text-white px-3 py-1.5 rounded-lg text-xs font-medium whitespace-nowrap"
                                       style="{{ $isOverdue ? 'background-color: #dc2626 !important;' : 'background-color: #ea580c !important;' }} color: #ffffff !important;">
                                        {{ $isOverdue ? 'Terlewat' : 'Kumpulkan' }}
                                    </a>
                                @endif
                            </div>
                        @endforeach
                    </div>
                @else
                    <p class="text-sm text-gray-500 italic">
                        Konten blm tersedia
                    </p>
                @endif
            </div>

        </div>

    </div>

</x-layouts.lms>