<x-layouts.lms>
    <x-slot name="sidebar">
        @include('layouts.sidebar-admin')
    </x-slot>

    <div class="mb-6">
        <div class="flex items-center justify-between">
            <div>
                <h1 class="text-2xl font-bold text-gray-800 dark:text-white">Detail Monitoring Murid</h1>
                <p class="text-gray-500 dark:text-gray-400 mt-1">{{ $student->nama_lengkap }} - {{ $class->nama_kelas }}</p>
            </div>
            <div class="flex gap-2">
                <a href="{{ route('admin.monitoring.index', request()->only(['course', 'tingkat', 'class_id', 'guru_id'])) }}"
                   class="bg-gray-500 text-white px-4 py-2 rounded-lg hover:bg-gray-600 transition text-sm flex items-center gap-2">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                    </svg>
                    Kembali ke Monitoring
                </a>
            </div>
        </div>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4 mb-6">
        <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700 p-5">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm text-gray-500 dark:text-gray-400">Kelas</p>
                    <p class="text-lg font-bold text-gray-800 dark:text-white mt-1">{{ $class->nama_kelas }}</p>
                </div>
            </div>
        </div>
        <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700 p-5">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm text-gray-500 dark:text-gray-400">Bahasa</p>
                    <p class="text-lg font-bold text-gray-800 dark:text-white mt-1">{{ $class->course->nama_bahasa }}</p>
                </div>
            </div>
        </div>
        <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700 p-5">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm text-gray-500 dark:text-gray-400">Tingkat</p>
                    <p class="text-lg font-bold text-gray-800 dark:text-white mt-1">{{ $student->tingkat_bahasa ?? '-' }}</p>
                </div>
            </div>
        </div>
        <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700 p-5">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm text-gray-500 dark:text-gray-400">Guru</p>
                    <p class="text-lg font-bold text-gray-800 dark:text-white mt-1">{{ $class->guru->nama_lengkap }}</p>
                </div>
            </div>
        </div>
    </div>

    <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700 p-6 mb-6">
        <h3 class="text-lg font-semibold text-gray-800 dark:text-white mb-4">Rata-rata Nilai Per Skill</h3>
        <div class="grid grid-cols-1 md:grid-cols-5 gap-4">
            @foreach($skills as $skill)
                @php
                    $score = $grades['skill_scores'][$skill->kode] ?? null;
                    if ($score !== null) {
                        $score = round($score, 1);
                        $cardClass = $score >= 80 ? 'bg-green-50 dark:bg-green-900/20 border-green-200 dark:border-green-800' :
                                     ($score >= 60 ? 'bg-yellow-50 dark:bg-yellow-900/20 border-yellow-200 dark:border-yellow-800' : 'bg-red-50 dark:bg-red-900/20 border-red-200 dark:border-red-800');
                        $textClass = $score >= 80 ? 'text-green-700 dark:text-green-300' :
                                     ($score >= 60 ? 'text-yellow-700 dark:text-yellow-300' : 'text-red-700 dark:text-red-300');
                    }
                @endphp
                <div class="border {{ $cardClass ?? 'border-gray-200 dark:border-gray-700' }} rounded-lg p-4 text-center">
                    <div class="text-xs font-semibold text-gray-600 dark:text-gray-300 uppercase tracking-wide mb-2">{{ strtoupper($skill->nama) }}</div>
                    @if($score !== null)
                        <div class="text-3xl font-bold {{ $textClass }}">{{ $score }}</div>
                    @else
                        <div class="text-3xl font-bold text-gray-400 dark:text-gray-500">-</div>
                    @endif
                </div>
            @endforeach
        </div>
    </div>

    <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700 p-6 mb-6">
        <h3 class="text-lg font-semibold text-gray-800 dark:text-white mb-4">Riwayat Kehadiran & Nilai Per Pertemuan</h3>

        @if($class->meetings->count() > 0)
            <div class="overflow-x-auto">
                <table class="w-full">
                    <thead>
                        <tr class="border-b border-gray-200 dark:border-gray-700">
                            <th class="text-left py-3 px-4 text-sm font-semibold text-gray-700 dark:text-gray-300">Pertemuan</th>
                            <th class="text-left py-3 px-4 text-sm font-semibold text-gray-700 dark:text-gray-300">Kehadiran</th>
                            <th class="text-left py-3 px-4 text-sm font-semibold text-gray-700 dark:text-gray-300">Kuis</th>
                            <th class="text-left py-3 px-4 text-sm font-semibold text-gray-700 dark:text-gray-300">Tugas</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($class->meetings->sortBy('urutan_pertemuan') as $meeting)
                            @php
                                $meetingAttendance = $attendance->firstWhere('id_meeting', $meeting->id);
                                $meetingQuizzes = collect($allQuizzesWithScores)->filter(function($q) use ($meeting) {
                                    return $q['meeting']->id == $meeting->id;
                                });
                                $meetingAssignments = collect($allAssignmentsWithScores)->filter(function($a) use ($meeting) {
                                    return $a['meeting']->id == $meeting->id;
                                });
                            @endphp
                            <tr class="border-b border-gray-100 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-700">
                                <td class="py-4 px-4">
                                    <div class="flex items-center gap-3">
                                        <div class="w-10 h-10 bg-blue-100 dark:bg-blue-900 rounded-lg flex items-center justify-center">
                                            <span class="text-blue-600 dark:text-blue-400 font-bold text-sm">{{ $meeting->urutan_pertemuan }}</span>
                                        </div>
                                        <div>
                                            <div class="text-sm font-medium text-gray-800 dark:text-white">{{ $meeting->judul_pertemuan }}</div>
                                            <div class="text-xs text-gray-500 dark:text-gray-400">
                                                {{ $meeting->quizzes->count() }} Kuis • {{ $meeting->assignments->count() }} Tugas
                                            </div>
                                        </div>
                                    </div>
                                </td>
                                <td class="py-4 px-4">
                                    @if($meetingAttendance)
                                        <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-medium
                                            @if($meetingAttendance->status === 'hadir') bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-200
                                            @elseif($meetingAttendance->status === 'izin') bg-yellow-100 text-yellow-800 dark:bg-yellow-900 dark:text-yellow-200
                                            @elseif($meetingAttendance->status === 'sakit') bg-blue-100 text-blue-800 dark:bg-blue-900 dark:text-blue-200
                                            @else bg-red-100 text-red-800 dark:bg-red-900 dark:text-red-200
                                            @endif">
                                            @if($meetingAttendance->status === 'hadir') ✓
                                            @elseif($meetingAttendance->status === 'izin') I
                                            @elseif($meetingAttendance->status === 'sakit') S
                                            @else A
                                            @endif
                                            {{ ucfirst($meetingAttendance->status) }}
                                        </span>
                                        @if($meetingAttendance->keterangan)
                                            <div class="text-xs text-gray-500 dark:text-gray-400 mt-1">{{ Str::limit($meetingAttendance->keterangan, 30) }}</div>
                                        @endif
                                    @else
                                        <span class="text-gray-400 dark:text-gray-500 text-sm">-</span>
                                    @endif
                                </td>
                                <td class="py-4 px-4">
                                    @if($meetingQuizzes->count() > 0)
                                        <div class="space-y-1">
                                            @foreach($meetingQuizzes as $q)
                                                <div class="flex items-center justify-between gap-2">
                                                    <span class="text-xs text-gray-600 dark:text-gray-400 flex-1">{{ Str::limit($q['quiz']->judul_kuis, 25) }}</span>
                                                    <span class="text-sm font-bold {{ $q['completed'] ? 'text-green-600 dark:text-green-400' : 'text-red-600 dark:text-red-400' }}">
                                                        {{ round($q['score']) }}
                                                    </span>
                                                </div>
                                            @endforeach
                                        </div>
                                    @else
                                        <span class="text-gray-400 dark:text-gray-500 text-sm">-</span>
                                    @endif
                                </td>
                                <td class="py-4 px-4">
                                    @if($meetingAssignments->count() > 0)
                                        <div class="space-y-1">
                                            @foreach($meetingAssignments as $a)
                                                <div class="flex items-center justify-between gap-2">
                                                    <span class="text-xs text-gray-600 dark:text-gray-400 flex-1">{{ Str::limit($a['assignment']->judul_tugas, 25) }}</span>
                                                    <span class="text-sm font-bold {{ $a['completed'] ? 'text-purple-600 dark:text-purple-400' : 'text-red-600 dark:text-red-400' }}">
                                                        {{ round($a['score']) }}
                                                    </span>
                                                </div>
                                            @endforeach
                                        </div>
                                    @else
                                        <span class="text-gray-400 dark:text-gray-500 text-sm">-</span>
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @else
            <p class="text-gray-500 dark:text-gray-400 text-sm text-center py-8">Belum ada pertemuan</p>
        @endif
    </div>

    <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700 p-6">
        <h3 class="text-lg font-semibold text-gray-800 dark:text-white mb-4">Ringkasan Progres</h3>
        <div class="grid grid-cols-2 md:grid-cols-4 gap-4 mb-6">
            @php
                $completedQuizzes = collect($allQuizzesWithScores)->filter(function($q) {
                    return $q['completed'];
                })->count();
                $totalQuizzes = count($allQuizzesWithScores);
                $completedAssignments = collect($allAssignmentsWithScores)->filter(function($a) {
                    return $a['completed'];
                })->count();
                $totalAssignments = count($allAssignmentsWithScores);

                $totalHadir = $attendance->where('status', 'hadir')->count();
                $totalIzin = $attendance->where('status', 'izin')->count();
                $totalSakit = $attendance->where('status', 'sakit')->count();
                $totalAlfa = $attendance->where('status', 'alfa')->count();
                $totalPertemuan = $class->meetings->count();
                $persentaseHadir = $totalPertemuan > 0 ? round(($totalHadir / $totalPertemuan) * 100, 1) : 0;
            @endphp
            <div class="text-center p-4 bg-blue-50 dark:bg-blue-900/20 rounded-lg">
                <div class="text-2xl font-bold text-blue-600 dark:text-blue-400">{{ $completedQuizzes }}/{{ $totalQuizzes }}</div>
                <div class="text-sm text-gray-600 dark:text-gray-400 mt-1">Kuis Dikerjakan</div>
            </div>
            <div class="text-center p-4 bg-purple-50 dark:bg-purple-900/20 rounded-lg">
                <div class="text-2xl font-bold text-purple-600 dark:text-purple-400">{{ $completedAssignments }}/{{ $totalAssignments }}</div>
                <div class="text-sm text-gray-600 dark:text-gray-400 mt-1">Tugas Dinilai</div>
            </div>
            <div class="text-center p-4 bg-green-50 dark:bg-green-900/20 rounded-lg">
                <div class="text-2xl font-bold text-green-600 dark:text-green-400">{{ $totalHadir }}/{{ $totalPertemuan }}</div>
                <div class="text-sm text-gray-600 dark:text-gray-400 mt-1">Total Hadir</div>
            </div>
            <div class="text-center p-4 bg-yellow-50 dark:bg-yellow-900/20 rounded-lg">
                <div class="text-2xl font-bold text-yellow-600 dark:text-yellow-400">
                    @if($grades['average'] !== null)
                        {{ round($grades['average'], 1) }}
                    @else
                        0
                    @endif
                </div>
                <div class="text-sm text-gray-600 dark:text-gray-400 mt-1">Nilai Rata-rata</div>
            </div>
        </div>

        <div class="border-t border-gray-200 dark:border-gray-700 pt-4">
            <h4 class="text-sm font-semibold text-gray-700 dark:text-gray-300 mb-3">Detail Kehadiran</h4>
            <div class="grid grid-cols-2 md:grid-cols-5 gap-3">
                <div class="text-center p-3 bg-green-50 dark:bg-green-900/20 rounded-lg">
                    <div class="text-lg font-bold text-green-600 dark:text-green-400">{{ $totalHadir }}</div>
                    <div class="text-xs text-gray-600 dark:text-gray-400">Hadir</div>
                </div>
                <div class="text-center p-3 bg-yellow-50 dark:bg-yellow-900/20 rounded-lg">
                    <div class="text-lg font-bold text-yellow-600 dark:text-yellow-400">{{ $totalIzin }}</div>
                    <div class="text-xs text-gray-600 dark:text-gray-400">Izin</div>
                </div>
                <div class="text-center p-3 bg-blue-50 dark:bg-blue-900/20 rounded-lg">
                    <div class="text-lg font-bold text-blue-600 dark:text-blue-400">{{ $totalSakit }}</div>
                    <div class="text-xs text-gray-600 dark:text-gray-400">Sakit</div>
                </div>
                <div class="text-center p-3 bg-red-50 dark:bg-red-900/20 rounded-lg">
                    <div class="text-lg font-bold text-red-600 dark:text-red-400">{{ $totalAlfa }}</div>
                    <div class="text-xs text-gray-600 dark:text-gray-400">Alfa</div>
                </div>
                <div class="text-center p-3 bg-gray-100 dark:bg-gray-700 rounded-lg">
                    <div class="text-lg font-bold text-gray-800 dark:text-white">{{ $totalPertemuan - ($totalHadir + $totalIzin + $totalSakit + $totalAlfa) }}</div>
                    <div class="text-xs text-gray-600 dark:text-gray-400">Belum Dicatat</div>
                </div>
            </div>
            <div class="mt-3 text-center">
                <span class="text-sm text-gray-600 dark:text-gray-400">
                    Persentase Kehadiran: <strong class="text-gray-800 dark:text-white {{ $persentaseHadir >= 75 ? 'text-green-600' : 'text-red-600' }}">{{ $persentaseHadir }}%</strong>
                </span>
                <span class="mx-2">|</span>
                <span class="text-sm text-gray-600 dark:text-gray-400">
                    Total Tidak Hadir: <strong class="text-red-600 dark:text-red-400">{{ $totalPertemuan - $totalHadir }}</strong>
                </span>
            </div>
        </div>
    </div>
</x-layouts.lms>