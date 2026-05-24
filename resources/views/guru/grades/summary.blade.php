<x-layouts.lms>
    <x-slot name="sidebar">
        @include('layouts.sidebar-guru')
    </x-slot>

    <div class="mb-6">
        <div class="flex items-center justify-between">
            <div>
                <h1 class="text-2xl font-bold text-gray-800 dark:text-white">Rekap Nilai Kelas</h1>
                <p class="text-gray-500 dark:text-gray-400 mt-1">{{ $class->nama_kelas }} - {{ $class->course->nama_bahasa }} ({{ $class->periode }})</p>
            </div>
            <div class="flex gap-2">
                <a href="{{ route('guru.grades.export', $class) }}"
                   class="bg-green-500 text-gray-100 px-4 py-2 rounded-lg hover:bg-green-600 transition text-sm flex items-center gap-2 !important" style="background-color: #22c55e !important; color: #f3f4f6 !important;">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                    </svg>
                    Export Excel
                </a>
                <a href="{{ route('guru.classes.show', $class) }}"
                   class="bg-gray-500 text-gray-100 px-4 py-2 rounded-lg hover:bg-gray-600 transition text-sm flex items-center gap-2 !important" style="background-color: #6b7280 !important; color: #f3f4f6 !important;">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                    </svg>
                    Kembali
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

    @if(count($studentGrades) > 0)
        <div class="bg-white dark:bg-gray-800 rounded-lg shadow-sm border border-gray-200 dark:border-gray-700 overflow-hidden">
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                    <thead class="bg-gray-50 dark:bg-gray-700">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Murid</th>
                            @foreach($skills as $skill)
                                <th class="px-4 py-3 text-center text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                    {{ strtoupper($skill->nama) }}
                                </th>
                            @endforeach
                            <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider bg-blue-50 dark:bg-blue-900/20">
                                RATA-RATA
                            </th>
                            <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Progress</th>
                            <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
                        @foreach($studentGrades as $item)
                            @php
                                $student = $item['student'];
                                $skillScores = $item['skill_scores'];
                                $average = $item['average'];
                                $quizCount = $item['quiz_count'];
                                $assignmentCount = $item['assignment_count'];
                            @endphp
                            <tr class="hover:bg-gray-50 dark:hover:bg-gray-700 transition">
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
                                @foreach($skills as $skill)
                                    <td class="px-4 py-4 whitespace-nowrap text-center">
                                        @if(isset($skillScores[$skill->kode]) && $skillScores[$skill->kode] !== null)
                                            @php
                                                $score = round($skillScores[$skill->kode], 1);
                                                $colorClass = $score >= 80 ? 'text-green-600 dark:text-green-400' :
                                                              ($score >= 60 ? 'text-yellow-600 dark:text-yellow-400' : 'text-red-600 dark:text-red-400');
                                            @endphp
                                            <span class="font-semibold {{ $colorClass }}">{{ $score }}</span>
                                        @else
                                            <span class="text-gray-400 dark:text-gray-500">-</span>
                                        @endif
                                    </td>
                                @endforeach
                                <td class="px-6 py-4 whitespace-nowrap text-center bg-blue-50 dark:bg-blue-900/20">
                                    @if($average !== null)
                                        @php
                                            $avgRounded = round($average, 1);
                                            $badgeClass = $average >= 80 ? 'bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-200' : 
                                                          ($average >= 60 ? 'bg-yellow-100 text-yellow-800 dark:bg-yellow-900 dark:text-yellow-200' : 'bg-red-100 text-red-800 dark:bg-red-900 dark:text-red-200');
                                        @endphp
                                        <span class="px-3 py-1 rounded-full text-sm font-bold {{ $badgeClass }}">{{ $avgRounded }}</span>
                                    @else
                                        <span class="text-gray-400 dark:text-gray-500">-</span>
                                    @endif
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-center">
                                    <div class="text-sm text-gray-500 dark:text-gray-400">
                                        <span class="inline-flex items-center gap-1">
                                            <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                                <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                                            </svg>
                                            {{ $quizCount }} Kuis
                                        </span>
                                        <span class="mx-2">•</span>
                                        <span class="inline-flex items-center gap-1">
                                            <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                                <path fill-rule="evenodd" d="M6 2a2 2 0 00-2 2v12a2 2 0 002 2h8a2 2 0 002-2V7a2 2 0 00-2-2h-2M8 3a1 1 0 011-1h4a1 1 0 110 2H9a1 1 0 01-1-1z" clip-rule="evenodd"/>
                                            </svg>
                                            {{ $assignmentCount }} Tugas
                                        </span>
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-center">
                                    <a href="{{ route('guru.grades.student', ['class' => $class, 'student' => $student]) }}"
                                       class="inline-flex items-center gap-1 px-3 py-1.5 bg-blue-500 text-gray-100 text-xs font-medium rounded-md hover:bg-blue-600 transition !important" style="background-color: #3b82f6 !important; color: #f3f4f6 !important;">
                                        <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                                        </svg>
                                        Detail
                                    </a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    @else
        <div class="bg-white dark:bg-gray-800 rounded-lg shadow-sm border border-gray-200 dark:border-gray-700 p-12 text-center">
            <svg class="mx-auto h-16 w-16 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"/>
            </svg>
            <h3 class="mt-4 text-lg font-medium text-gray-800 dark:text-white">Belum Ada Murid</h3>
            <p class="mt-2 text-gray-500 dark:text-gray-400">Belum ada murid yang terdaftar di kelas ini.</p>
        </div>
    @endif

    <div class="mt-6 p-4 bg-blue-50 dark:bg-blue-900/30 border border-blue-200 dark:border-blue-800 rounded-lg">
        <p class="text-sm text-blue-800 dark:text-blue-300 font-medium mb-2">📊 Keterangan:</p>
        <ul class="text-sm text-blue-700 dark:text-blue-400 space-y-1">
            <li>• Nilai ditampilkan per skill (Reading, Writing, Listening, Speaking, Grammar)</li>
            <li>• Rata-rata dihitung dari semua kuis dan tugas yang sudah dinilai</li>
            <li>• Klik tombol "Detail" untuk melihat rincian nilai lengkap per murid</li>
        </ul>
    </div>
</x-layouts.lms>
