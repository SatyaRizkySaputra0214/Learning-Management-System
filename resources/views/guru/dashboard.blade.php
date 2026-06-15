<x-layouts.lms>
    <x-slot name="sidebar">
        @include('layouts.sidebar-guru')
    </x-slot>

    <div class="mb-6">
        <h1 class="text-2xl font-bold text-gray-800 dark:text-white">Dashboard Guru</h1>
        <p class="text-gray-500 dark:text-gray-400 mt-1">Selamat datang, {{ auth()->user()->nama_lengkap }}! 👋</p>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
        
        <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm p-6 border border-gray-200 dark:border-gray-700">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-gray-500 dark:text-gray-400">Total Kelas</p>
                    <p class="text-3xl font-bold text-blue-600 mt-1">{{ $totalClasses }}</p>
                </div>
                <div class="p-4 rounded-full bg-blue-100 dark:bg-blue-900/50">
                    <svg class="w-8 h-8 text-blue-600 dark:text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/>
                    </svg>
                </div>
            </div>
            <a href="{{ route('guru.classes.index') }}" class="mt-4 block text-sm text-blue-600 dark:text-blue-400 hover:underline">
                Lihat semua →
            </a>
        </div>

        <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm p-6 border border-gray-200 dark:border-gray-700">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-gray-500 dark:text-gray-400">Total Murid</p>
                    <p class="text-3xl font-bold text-green-600 mt-1">{{ $totalStudents }}</p>
                </div>
                <div class="p-4 rounded-full bg-green-100 dark:bg-green-900/50">
                    <svg class="w-8 h-8 text-green-600 dark:text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"/>
                    </svg>
                </div>
            </div>
            <div class="mt-4 text-sm text-gray-500 dark:text-gray-400">
                Aktif di semua kelas
            </div>
        </div>

        <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm p-6 border border-gray-200 dark:border-gray-700">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-gray-500 dark:text-gray-400">Perlu Dinilai</p>
                    <p class="text-3xl font-bold text-orange-600 mt-1">{{ $ungradedAssignments }}</p>
                </div>
                <div class="p-4 rounded-full bg-orange-100 dark:bg-orange-900/50">
                    <svg class="w-8 h-8 text-orange-600 dark:text-orange-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                    </svg>
                </div>
            </div>
            <div class="mt-4">
                <span class="text-xs font-bold px-2 py-1 rounded {{ $ungradedAssignments > 0 ? 'bg-orange-100 dark:bg-orange-900/50 text-orange-700 dark:text-orange-300' : 'bg-green-100 dark:bg-green-900/50 text-green-700 dark:text-green-300' }}">
                    {{ $ungradedAssignments > 0 ? '⚠️ PERIKSA SEKARANG' : '✓ BERSIH' }}
                </span>
            </div>
        </div>

        <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm p-6 border border-gray-200 dark:border-gray-700">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-gray-500 dark:text-gray-400">Kuis Menunggu</p>
                    <p class="text-3xl font-bold text-purple-600 mt-1">{{ $incompleteQuizzes }}</p>
                </div>
                <div class="p-4 rounded-full bg-purple-100 dark:bg-purple-900/50">
                    <svg class="w-8 h-8 text-purple-600 dark:text-purple-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4"/>
                    </svg>
                </div>
            </div>
            <div class="mt-4 text-sm text-gray-500 dark:text-gray-400">
                Pengerjaan sedang berjalan
            </div>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <div class="lg:col-span-2">
            <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700 p-6">
                <div class="flex items-center justify-between mb-6">
                    <h2 class="text-lg font-bold text-gray-800 dark:text-white flex items-center gap-2">
                        <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/>
                        </svg>
                        Kelas Aktif
                    </h2>
                    <a href="{{ route('guru.classes.index') }}" class="text-blue-600 dark:text-blue-400 hover:underline text-sm font-medium">Lihat Semua</a>
                </div>

                @if($activeClasses->count() > 0)
                    <div class="space-y-4">
                        @foreach($activeClasses->take(5) as $class)
                            <div class="border border-gray-200 dark:border-gray-700 rounded-xl p-4 hover:shadow-md transition">
                                <div class="flex items-center justify-between">
                                    <div class="flex items-center gap-4 flex-1">
                                        <div class="w-12 h-12 bg-gradient-to-br from-blue-500 to-purple-600 rounded-lg flex items-center justify-center text-white font-bold">
                                            {{ strtoupper(substr($class->nama_kelas, 0, 1)) }}
                                        </div>
                                        <div class="flex-1">
                                            <h3 class="font-semibold text-gray-800 dark:text-white">{{ $class->nama_kelas }}</h3>
                                            <p class="text-sm text-gray-500 dark:text-gray-400">{{ $class->course->nama_bahasa }} • {{ $class->periode }}</p>
                                        </div>
                                    </div>
                                    <div class="text-right">
                                        <div class="flex items-center gap-2 text-sm text-gray-600 dark:text-gray-300 mb-1">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"/>
                                            </svg>
                                            {{ $class->students->count() }} murid
                                        </div>
                                        <a href="{{ route('guru.classes.show', $class) }}" class="text-blue-600 dark:text-blue-400 hover:underline text-sm font-medium">Kelola →</a>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @else
                    <div class="text-center py-12">
                        <svg class="mx-auto h-16 w-16 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/>
                        </svg>
                        <p class="mt-4 text-gray-500 dark:text-gray-400">Belum ada kelas aktif</p>
                        <p class="text-sm text-gray-400 dark:text-gray-500 mt-1">Hubungi admin untuk ditambahkan ke kelas</p>
                    </div>
                @endif
            </div>
        </div>

        <div>
            <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700 p-6">
                <div class="flex items-center justify-between mb-6">
                    <h2 class="text-lg font-bold text-gray-800 dark:text-white flex items-center gap-2">
                        <svg class="w-5 h-5 text-yellow-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                        </svg>
                        Perlu Dinilai
                    </h2>
                    <span class="bg-yellow-100 dark:bg-yellow-900 text-yellow-800 dark:text-yellow-200 text-xs font-bold px-2 py-1 rounded-full">{{ $ungradedAssignments }}</span>
                </div>

                @if($recentSubmissions->count() > 0)
                    <div class="space-y-3">
                        @foreach($recentSubmissions as $submission)
                            <div class="border border-gray-200 dark:border-gray-700 rounded-xl p-3 hover:bg-gray-50 dark:hover:bg-gray-700 transition">
                                <div class="flex items-start justify-between mb-2">
                                    <div class="flex-1">
                                        <p class="font-medium text-gray-800 dark:text-white text-sm">{{ $submission->student->nama_lengkap }}</p>
                                        <p class="text-xs text-gray-500 dark:text-gray-400 mt-1">
                                            {{ $submission->assignment->judul_tugas }}
                                        </p>
                                        <p class="text-xs text-gray-400 dark:text-gray-500 mt-1">
                                            {{ $submission->assignment->meeting->class->nama_kelas }}
                                        </p>
                                    </div>
                                </div>
                                <div class="flex items-center justify-between">
                                    <span class="text-xs text-gray-500 dark:text-gray-400">
                                        {{ $submission->submitted_at->diffForHumans() }}
                                    </span>
                                    <a href="{{ route('guru.assignments.submissions', $submission->assignment) }}" 
                                       class="text-yellow-600 dark:text-yellow-400 hover:underline text-xs font-medium">
                                        Nilai →
                                    </a>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @else
                    <div class="text-center py-8">
                        <svg class="mx-auto h-12 w-12 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                        <p class="mt-3 text-sm text-gray-600 dark:text-gray-300 font-medium">🎉 Semua tugas sudah dinilai!</p>
                        <p class="text-xs text-gray-400 dark:text-gray-500 mt-1">Tidak ada tugas yang perlu dinilai</p>
                    </div>
                @endif
            </div>            
        </div>
    </div>
</x-layouts.lms>