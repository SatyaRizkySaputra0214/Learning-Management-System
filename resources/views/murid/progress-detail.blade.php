<x-layouts.lms>
    <x-slot name="sidebar">
        @include('layouts.sidebar-murid')
    </x-slot>

    <script>
        function progressDetailData() {
            return {
                selectedClassId: '{{ $selectedClassId ?? '' }}',
                classAverages: @json($classAverages),
            }
        }
    </script>

    <div x-data="progressDetailData()">

        <div class="mb-8 flex items-start justify-between gap-4">
            <div>
                <h1 class="text-3xl font-extrabold text-gray-900 dark:text-white tracking-tight">Progres Belajar</h1>
                <p class="text-gray-400 dark:text-gray-500 mt-1.5 text-sm leading-relaxed">
                    Laporan detail kuis, tugas, dan absensi per pertemuan.
                </p>
            </div>

            <a href="{{ route('murid.dashboard') }}"
               class="inline-flex items-center px-5 py-2.5 bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700 rounded-xl text-xs font-semibold text-gray-600 dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-gray-700 transition-all shadow-sm shrink-0">
                <svg class="w-3.5 h-3.5 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                          d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                </svg>
                Kembali
            </a>
        </div>

        <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-sm border border-gray-200 dark:border-gray-700 p-5 mb-6">
            <div class="max-w-md">
                <label class="block text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wider mb-2.5">
                    Pilih Kelas
                </label>

                <div class="relative">
                    <select x-model="selectedClassId"
                            class="w-full pl-4 pr-10 py-3.5 rounded-xl border-gray-200 dark:border-gray-600 dark:bg-gray-700 dark:text-white focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 shadow-sm transition appearance-none bg-white dark:bg-gray-700 text-sm">
                        <option value="">-- Pilih Kelas untuk Melihat Detail --</option>
                        @foreach($classes as $class)
                            <option value="{{ $class->id }}">{{ $class->nama_kelas }}</option>
                        @endforeach
                    </select>

                    <div class="absolute inset-y-0 right-0 flex items-center px-3 pointer-events-none text-gray-400">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                  d="M19 9l-7 7-7-7"/>
                        </svg>
                    </div>
                </div>
            </div>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 gap-5 mb-6">
            <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-sm border border-gray-200 dark:border-gray-700 p-5">
                <div class="flex items-center gap-4">
                    <div class="w-14 h-14 bg-blue-50 dark:bg-blue-900/20 rounded-2xl flex items-center justify-center flex-shrink-0">
                        <svg class="w-7 h-7 text-blue-600 dark:text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                  d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/>
                        </svg>
                    </div>
                    <div>
                        <p class="text-3xl font-extrabold text-gray-800 dark:text-white">
                            <span x-text="classAverages[selectedClassId]?.nilai ?? 0"></span>
                        </p>
                        <p class="text-xs font-medium text-gray-500 dark:text-gray-400 mt-0.5">Rata-rata Nilai</p>
                    </div>
                </div>
            </div>

            <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-sm border border-gray-200 dark:border-gray-700 p-5">
                <div class="flex items-center gap-4">
                    <div class="w-14 h-14 bg-green-50 dark:bg-green-900/20 rounded-2xl flex items-center justify-center flex-shrink-0">
                        <svg class="w-7 h-7 text-green-600 dark:text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                  d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/>
                        </svg>
                    </div>
                    <div>
                        <p class="text-3xl font-extrabold text-gray-800 dark:text-white">
                            <span x-text="(classAverages[selectedClassId]?.kehadiran ?? 0) + '%'"></span>
                        </p>
                        <p class="text-xs font-medium text-gray-500 dark:text-gray-400 mt-0.5">Rata-rata Kehadiran</p>
                    </div>
                </div>
            </div>
        </div>

        <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-sm border border-gray-200 dark:border-gray-700 overflow-hidden">
            <div class="p-3 md:p-5">
                @foreach($classes as $class)
                    <div x-show="selectedClassId == '{{ $class->id }}'"
                         x-transition:enter="transition ease-out duration-300"
                         x-transition:enter-start="opacity-0"
                         x-transition:enter-end="opacity-100"
                         style="display: none;">

                        <div class="rounded-xl bg-gray-50 dark:bg-gray-900/20 border border-gray-100 dark:border-gray-700 p-5 mb-6">
                            <div class="flex items-center gap-4">
                                <div class="w-12 h-12 bg-blue-600 rounded-xl flex items-center justify-center text-white shadow-sm flex-shrink-0">
                                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                              d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/>
                                    </svg>
                                </div>

                                <div>
                                    <h2 class="text-lg font-bold text-gray-800 dark:text-white">
                                        {{ $class->nama_kelas }}
                                    </h2>
                                    <p class="text-sm text-gray-500 dark:text-gray-400 mt-0.5">
                                        {{ $class->course->nama_bahasa }} • Guru: {{ $class->guru->nama_lengkap }}
                                    </p>
                                </div>
                            </div>
                        </div>

                        <div class="overflow-x-auto -mx-3 md:-mx-5">
                            <table class="w-full">
                                <thead>
                                    <tr>
                                        <th class="text-left py-4 px-5 text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wider">Pertemuan</th>
                                        <th class="text-left py-4 px-5 text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wider">Kehadiran</th>
                                        <th class="text-left py-4 px-5 text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wider">Kuis</th>
                                        <th class="text-left py-4 px-5 text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wider">Tugas</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($class->meetings->sortBy('urutan_pertemuan') as $meeting)
                                        <tr class="border-t border-gray-100 dark:border-gray-700/50 hover:bg-gray-50/50 dark:hover:bg-gray-700/20 transition-colors">
                                            <td class="py-4 px-5">
                                                <div class="flex items-center gap-3">
                                                    <div class="w-9 h-9 bg-blue-50 dark:bg-blue-900/30 rounded-lg flex items-center justify-center border border-blue-100 dark:border-blue-800/40 flex-shrink-0">
                                                        <span class="text-blue-600 dark:text-blue-400 font-bold text-xs">{{ $meeting->urutan_pertemuan }}</span>
                                                    </div>
                                                    <div class="min-w-0">
                                                        <div class="text-sm font-semibold text-gray-800 dark:text-white truncate">{{ $meeting->judul_pertemuan }}</div>
                                                        <div class="text-xs text-gray-400 dark:text-gray-500 mt-0.5">
                                                            {{ $meeting->quiz_scores->count() }} Kuis • {{ $meeting->assignment_scores->count() }} Tugas
                                                        </div>
                                                    </div>
                                                </div>
                                            </td>
                                            <td class="py-4 px-5 align-top">
                                                @if($meeting->attendance)
                                                    @php
                                                        $status = strtolower($meeting->attendance->status);
                                                        $initial = match(true) {
                                                            in_array($status, ['present', 'hadir']) => 'H',
                                                            in_array($status, ['permission', 'izin']) => 'I',
                                                            in_array($status, ['sick', 'sakit']) => 'S',
                                                            default => 'A',
                                                        };
                                                        $colorClasses = match($initial) {
                                                            'H' => 'bg-green-50 text-green-700 border-green-200 dark:bg-green-500/10 dark:text-green-400 dark:border-green-500/20',
                                                            'I' => 'bg-yellow-50 text-yellow-700 border-yellow-200 dark:bg-yellow-500/10 dark:text-yellow-400 dark:border-yellow-500/20',
                                                            'S' => 'bg-blue-50 text-blue-700 border-blue-200 dark:bg-blue-500/10 dark:text-blue-400 dark:border-blue-500/20',
                                                            'A' => 'bg-red-50 text-red-700 border-red-200 dark:bg-red-500/10 dark:text-red-400 dark:border-red-500/20',
                                                        };
                                                    @endphp
                                                    <div class="flex items-center gap-2">
                                                        <span class="inline-flex items-center justify-center w-7 h-7 rounded-full text-xs font-bold border {{ $colorClasses }}" title="{{ ucfirst($meeting->attendance->status) }}">
                                                            {{ $initial }}
                                                        </span>
                                                        @if($meeting->attendance->keterangan)
                                                            <span class="text-[11px] text-gray-400 dark:text-gray-500 truncate max-w-[120px]">{{ $meeting->attendance->keterangan }}</span>
                                                        @endif
                                                    </div>
                                                @else
                                                    <span class="text-gray-300 dark:text-gray-600 text-sm">—</span>
                                                @endif
                                            </td>
                                            <td class="py-4 px-5 align-top">
                                                @if($meeting->quiz_scores->count() > 0)
                                                    <div class="space-y-2 min-w-[160px]">
                                                        @foreach($meeting->quiz_scores as $score)
                                                            <div class="flex items-center justify-between gap-3 py-1">
                                                                <span class="text-xs text-gray-600 dark:text-gray-400 flex-1 truncate" title="{{ $score->quiz->judul_kuis }}">{{ $score->quiz->judul_kuis }}</span>
                                                                <span class="text-sm font-bold text-emerald-600 dark:text-emerald-400 bg-emerald-50 dark:bg-emerald-900/20 px-2 py-0.5 rounded-md">
                                                                    {{ round($score->skor) }}
                                                                </span>
                                                            </div>
                                                        @endforeach
                                                    </div>
                                                @else
                                                    <span class="text-gray-300 dark:text-gray-600 text-sm">—</span>
                                                @endif
                                            </td>
                                            <td class="py-4 px-5 align-top">
                                                @if($meeting->assignment_scores->count() > 0)
                                                    <div class="space-y-2 min-w-[160px]">
                                                        @foreach($meeting->assignment_scores as $submission)
                                                            <div class="flex items-center justify-between gap-3 py-1">
                                                                <span class="text-xs text-gray-600 dark:text-gray-400 flex-1 truncate" title="{{ $submission->assignment->judul_tugas }}">{{ $submission->assignment->judul_tugas }}</span>
                                                                <span class="text-sm font-bold text-violet-600 dark:text-violet-400 bg-violet-50 dark:bg-violet-900/20 px-2 py-0.5 rounded-md">
                                                                    {{ round($submission->nilai_guru) }}
                                                                </span>
                                                            </div>
                                                        @endforeach
                                                    </div>
                                                @else
                                                    <span class="text-gray-300 dark:text-gray-600 text-sm">—</span>
                                                @endif
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                @endforeach

                <div x-show="selectedClassId == '' || selectedClassId == null" class="py-24 text-center bg-gray-50/30 dark:bg-gray-900/10 rounded-2xl">
                    <div class="w-20 h-20 bg-white dark:bg-gray-800 rounded-2xl shadow-lg shadow-gray-200/30 dark:shadow-none border border-gray-100 dark:border-gray-700 flex items-center justify-center mx-auto mb-6">
                        <svg class="w-10 h-10 text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                  d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/>
                        </svg>
                    </div>

                    <h3 class="text-lg font-bold text-gray-800 dark:text-white mb-2">
                        Siap Melihat Progres Anda?
                    </h3>

                    <p class="text-sm text-gray-500 dark:text-gray-400 max-w-sm mx-auto leading-relaxed">
                        Pilih salah satu kelas Anda dari menu di atas untuk menampilkan seluruh histori nilai dan absensi secara mendetail.
                    </p>
                </div>
            </div>
        </div>
    </div>
</x-layouts.lms>