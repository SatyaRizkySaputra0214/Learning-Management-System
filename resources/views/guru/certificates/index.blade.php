<x-layouts.lms>
    <x-slot name="sidebar">
        @include('layouts.sidebar-guru')
    </x-slot>

    <div class="mb-6">
        <a href="{{ route('guru.classes.show', $class) }}" class="text-blue-600 dark:text-blue-400 hover:underline text-sm mb-4 inline-block">
            <span class="flex items-center gap-1">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
                </svg>
                Kembali ke Kelas
            </span>
        </a>
        <h1 class="text-2xl font-bold text-gray-800 dark:text-white">Generate Sertifikat Murid</h1>
        <p class="text-gray-500 dark:text-gray-400 mt-1">Kelola dan generate sertifikat kelulusan untuk murid di kelas <span class="font-medium text-gray-700 dark:text-gray-300">{{ $class->nama_kelas }}</span> &mdash; {{ $class->course->nama_bahasa }}</p>
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


    <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm overflow-hidden">
        <div class="p-5 border-b border-gray-100 dark:border-gray-700/50">
            <div class="flex flex-col sm:flex-row gap-4 items-start sm:items-center justify-between">

                <div class="flex flex-col sm:flex-row gap-3 w-full sm:w-auto">
                    <form method="GET" action="{{ route('guru.certificates.index', $class) }}" class="flex gap-2">
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                                <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                                </svg>
                            </div>
                            <input
                                type="text"
                                name="search"
                                value="{{ request('search') }}"
                                placeholder="Cari nama murid..."
                                class="w-56 pl-10 pr-4 py-2.5 rounded-xl border border-gray-200 dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-800 dark:text-white focus:ring-2 focus:ring-blue-500 focus:border-transparent text-sm"
                            >
                        </div>
                        <button type="submit" class="px-4 py-2.5 bg-blue-600 hover:bg-blue-700 text-white rounded-xl transition text-sm font-medium whitespace-nowrap">
                            Cari
                        </button>
                        @if(request('search'))
                            <a href="{{ route('guru.certificates.index', $class) }}" class="px-4 py-2.5 bg-gray-500 hover:bg-gray-600 text-white rounded-xl transition text-sm font-medium whitespace-nowrap">
                                Reset
                            </a>
                        @endif
                    </form>
                </div>
            </div>
        </div>

        @if($students->count() > 0)
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                    <thead class="bg-gray-50 dark:bg-gray-700">
                        <tr>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider w-12">No</th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Nama Murid</th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Username</th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Progress</th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Status Kelas</th>
                            <th scope="col" class="px-6 py-3 text-center text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
                        @foreach($students as $student)
                            @php
                                $meetingIds = $class->meetings()->pluck('id');

                                $totalQuizzes = \App\Models\Quiz::whereIn('id_meeting', $meetingIds)->count();
                                $totalAssignments = \App\Models\Assignment::whereIn('id_meeting', $meetingIds)->count();

                                $completedQuizzes = \App\Models\QuizScore::whereIn('id_quiz', function($query) use ($meetingIds, $student) {
                                    $query->select('id')->from('quizzes')->whereIn('id_meeting', $meetingIds);
                                })
                                ->where('id_student', $student->id)
                                ->whereNotNull('skor')
                                ->count();

                                $completedAssignments = \App\Models\AssignmentSubmission::whereIn('id_assignment', function($query) use ($meetingIds, $student) {
                                    $query->select('id')->from('assignments')->whereIn('id_meeting', $meetingIds);
                                })
                                ->where('id_student', $student->id)
                                ->whereNotNull('nilai_guru')
                                ->count();

                                $isAllCompleted = ($completedQuizzes >= $totalQuizzes) &&
                                                 ($completedAssignments >= $totalAssignments);

                                $certExists = \App\Models\Certificate::where('id_student', $student->id)
                                    ->where('id_class', $class->id)
                                    ->first();

                                $totalItems = $totalQuizzes + $totalAssignments;
                                $completedItems = $completedQuizzes + $completedAssignments;
                                $percentage = $totalItems > 0 ? round($completedItems / $totalItems * 100) : 100;
                            @endphp

                            <tr class="hover:bg-gray-50 dark:hover:bg-gray-700/30 transition-colors duration-150">
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-400">{{ $loop->iteration }}</td>

                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="flex items-center gap-3">
                                        <div class="w-9 h-9 bg-gradient-to-br from-blue-500 to-purple-600 rounded-full flex items-center justify-center text-white font-bold text-sm flex-shrink-0 shadow-sm">
                                            {{ strtoupper(substr($student->nama_lengkap, 0, 1)) }}
                                        </div>
                                        <span class="text-sm font-medium text-gray-800 dark:text-white">{{ $student->nama_lengkap }}</span>
                                    </div>
                                </td>

                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-400">{{ $student->username }}</td>

                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="flex items-center gap-3 min-w-[140px]">
                                        <div class="flex-1">
                                            <div class="w-full h-2 bg-gray-200 dark:bg-gray-600 rounded-full overflow-hidden">
                                                <div class="h-full rounded-full transition-all duration-500 ease-out {{ $percentage >= 100 ? 'bg-green-500' : ($percentage >= 50 ? 'bg-yellow-400' : 'bg-red-500') }}" style="width: {{ $percentage }}%"></div>
                                            </div>
                                        </div>
                                        <span class="text-xs font-semibold whitespace-nowrap {{ $percentage >= 100 ? 'text-green-600 dark:text-green-400' : ($percentage >= 50 ? 'text-yellow-600 dark:text-yellow-400' : 'text-red-600 dark:text-red-400') }}">
                                            {{ $percentage }}%
                                        </span>
                                    </div>
                                    <div class="flex items-center gap-4 mt-1.5 text-xs text-gray-400 dark:text-gray-500">
                                        <span class="flex items-center gap-1">
                                            <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
                                            </svg>
                                            Kuis {{ $completedQuizzes }}/{{ $totalQuizzes }}
                                        </span>
                                        <span class="flex items-center gap-1">
                                            <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                                            </svg>
                                            Tugas {{ $completedAssignments }}/{{ $totalAssignments }}
                                        </span>
                                    </div>
                                </td>

                                <td class="px-6 py-4 whitespace-nowrap">
                                    @if($certExists)
                                        <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-semibold bg-green-100 text-green-700 dark:bg-green-900/40 dark:text-green-400">
                                            <svg class="w-3.5 h-3.5" fill="currentColor" viewBox="0 0 20 20">
                                                <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/>
                                            </svg>
                                            Selesai
                                        </span>
                                    @elseif($isAllCompleted)
                                        <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-semibold bg-blue-100 text-blue-700 dark:bg-blue-900/40 dark:text-blue-400">
                                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                            </svg>
                                            Siap Generate
                                        </span>
                                    @else
                                        <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-semibold bg-red-100 text-red-700 dark:bg-red-900/40 dark:text-red-400">
                                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                            </svg>
                                            Belum Selesai
                                        </span>
                                    @endif
                                </td>

                                <td class="px-6 py-4 whitespace-nowrap text-center">
                                    @if($isAllCompleted && !$certExists)
                                        <a href="{{ route('guru.certificates.generate', ['class' => $class, 'student' => $student]) }}"
                                           class="inline-flex items-center gap-1.5 px-4 py-2 bg-green-600 hover:bg-green-700 active:bg-green-800 text-white text-sm font-medium rounded-xl transition-all shadow-sm hover:shadow">
                                             <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                 <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                             </svg>
                                             Generate
                                         </a>
                                     @elseif($certExists)
                                         <a href="{{ route('guru.certificates.view', ['class' => $class, 'student' => $student]) }}"
                                            class="inline-flex items-center gap-1.5 px-4 py-2 bg-blue-600 hover:bg-blue-700 active:bg-blue-800 text-white text-sm font-medium rounded-xl transition-all shadow-sm hover:shadow">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                                            </svg>
                                            Lihat
                                        </a>
                                    @else
                                        <button disabled
                                           class="inline-flex items-center gap-1.5 px-4 py-2 bg-gray-100 dark:bg-gray-700 text-gray-400 dark:text-gray-500 text-sm font-medium rounded-xl cursor-not-allowed border border-gray-200 dark:border-gray-600">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18.364 18.364A9 9 0 005.636 5.636m12.728 12.728A9 9 0 015.636 5.636m12.728 12.728L5.636 5.636"/>
                                            </svg>
                                            Belum Eligible
                                        </button>
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @else
            <div class="text-center py-16 px-6">
                <svg class="mx-auto h-16 w-16 text-gray-300 dark:text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"/>
                </svg>
                @if(request('search'))
                    <h3 class="mt-4 text-lg font-medium text-gray-800 dark:text-white">Tidak Ada Murid Ditemukan</h3>
                    <p class="mt-2 text-gray-500 dark:text-gray-400">Tidak ada murid yang cocok dengan pencarian "<strong>{{ request('search') }}</strong>".</p>
                    <a href="{{ route('guru.certificates.index', $class) }}" class="mt-4 inline-flex items-center gap-1.5 text-blue-600 dark:text-blue-400 hover:underline text-sm font-medium">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/>
                        </svg>
                        Reset pencarian
                    </a>
                @else
                    <h3 class="mt-4 text-lg font-medium text-gray-800 dark:text-white">Belum Ada Murid</h3>
                    <p class="mt-2 text-gray-500 dark:text-gray-400">Belum ada murid yang terdaftar di kelas ini.</p>
                    <p class="mt-1 text-sm text-gray-400 dark:text-gray-500">Hubungi admin untuk memasukkan murid ke kelas.</p>
                @endif
            </div>
        @endif
    </div>
</x-layouts.lms>
