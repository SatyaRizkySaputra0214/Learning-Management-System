<x-layouts.lms>
    <x-slot name="sidebar">
        @include('layouts.sidebar-guru')
    </x-slot>

    <div class="mb-6">
        <h1 class="text-2xl font-bold text-gray-800 dark:text-white">{{ $class->nama_kelas }}</h1>
        <p class="text-gray-500 dark:text-gray-400 mt-1">{{ $class->course->nama_bahasa }} - {{ $class->periode }}</p>


    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <div class="lg:col-span-2 space-y-6">
            <!-- Daftar Pertemuan -->
            <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700 p-6">
                <div class="flex items-center justify-between mb-6">
                    <h2 class="text-lg font-semibold text-gray-800 dark:text-white">Daftar Pertemuan</h2>
                    <a href="{{ route('guru.meetings.create', $class) }}"
                       class="inline-flex items-center gap-2 bg-blue-600 text-white px-4 py-2.5 rounded-lg hover:bg-blue-700 transition text-sm font-medium shadow-sm">
                        <svg class="w-4 h-4 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                        </svg>
                        Tambah Pertemuan
                    </a>
                </div>

                @if($class->meetings->count() > 0)
                    <div class="space-y-4">
                        @foreach($class->meetings as $meeting)
                            <div x-data="{ open: false }"
                                 class="border border-gray-200 dark:border-gray-700 rounded-xl bg-white dark:bg-gray-800 shadow-sm hover:shadow-md transition-all duration-200">

                                <!-- Meeting Header - Click to toggle -->
                                <div @click="open = !open"
                                     class="w-full flex items-center justify-between gap-4 px-5 py-4 cursor-pointer select-none rounded-xl hover:bg-gray-50 dark:hover:bg-gray-700/30 transition-colors duration-150">
                                    <div class="flex items-center gap-4 min-w-0 flex-1">
                                        <div class="w-11 h-11 bg-blue-100 dark:bg-blue-900/40 rounded-xl flex items-center justify-center flex-shrink-0 shadow-sm">
                                            <span class="text-blue-600 dark:text-blue-400 font-bold text-lg">{{ $meeting->urutan_pertemuan }}</span>
                                        </div>
                                        <div class="min-w-0 flex-1">
                                            <h3 class="font-semibold text-gray-800 dark:text-white truncate">{{ $meeting->judul_pertemuan }}</h3>
                                            <div class="flex flex-wrap items-center gap-x-2.5 gap-y-1 mt-1">
                                                <span class="inline-flex items-center gap-1 text-xs text-gray-500 dark:text-gray-400">
                                                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                                                    {{ $meeting->materials->count() }} Materi
                                                </span>
                                                <span class="text-gray-300 dark:text-gray-600">•</span>
                                                <span class="inline-flex items-center gap-1 text-xs text-gray-500 dark:text-gray-400">
                                                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4"/></svg>
                                                    {{ $meeting->quizzes->count() }} Kuis
                                                </span>
                                                <span class="text-gray-300 dark:text-gray-600">•</span>
                                                <span class="inline-flex items-center gap-1 text-xs text-gray-500 dark:text-gray-400">
                                                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                                                    {{ $meeting->assignments->count() }} Tugas
                                                </span>
                                                <span class="text-gray-300 dark:text-gray-600">•</span>
                                                <span class="inline-flex items-center gap-1 text-xs text-gray-500 dark:text-gray-400">
                                                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5.882V19.24a1.76 1.76 0 01-3.417.592l-2.147-6.15M18 13a3 3 0 100-6M5.436 13.683A4.001 4.001 0 017 6h1.832c4.1 0 7.625-1.234 9.168-3v14c-1.543-1.766-5.067-3-9.168-3H7a3.988 3.988 0 01-1.564-.317z"/></svg>
                                                    {{ $meeting->announcements->count() }} Pengumuman
                                                </span>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="flex items-center gap-1 flex-shrink-0">
                                        <a href="{{ route('guru.meetings.edit', $meeting) }}"
                                           @click.stop
                                           class="text-blue-600 dark:text-blue-400 hover:text-blue-700 text-sm font-medium px-2.5 py-1.5 rounded-lg hover:bg-blue-50 dark:hover:bg-blue-900/30 transition">
                                            Edit
                                        </a>
                                        <x-confirm-modal
                                            action="{{ route('guru.meetings.delete', $meeting) }}"
                                            title="Hapus Pertemuan"
                                            message="Hapus pertemuan <strong>{{ $meeting->judul_pertemuan }}</strong>?"
                                        >
                                            <x-slot name="trigger">
                                                <button type="button" class="text-red-600 dark:text-red-400 hover:text-red-700 text-sm font-medium px-2.5 py-1.5 rounded-lg hover:bg-red-50 dark:hover:bg-red-900/30 transition">Hapus</button>
                                            </x-slot>
                                        </x-confirm-modal>
                                        <svg x-show="!open" class="w-5 h-5 text-gray-400 transition-transform duration-200" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                                        </svg>
                                        <svg x-show="open" class="w-5 h-5 text-gray-500 transition-transform duration-200" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 15l7-7 7 7"/>
                                        </svg>
                                    </div>
                                </div>

                                <!-- Collapsible Content -->
                                <div x-show="open"
                                     x-transition:enter="transition ease-out duration-200"
                                     x-transition:enter-start="opacity-0"
                                     x-transition:enter-end="opacity-100"
                                     x-transition:leave="transition ease-in duration-150"
                                     x-transition:leave-start="opacity-100"
                                     x-transition:leave-end="opacity-0"
                                     class="border-t border-gray-200 dark:border-gray-700">
                                    <div class="px-5 py-4 space-y-5">

                                        <!-- Action Buttons -->
                                        <div>
                                            <p class="text-xs font-semibold text-gray-400 dark:text-gray-500 uppercase tracking-wider mb-3 flex items-center gap-1.5">
                                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/></svg>
                                                Aksi Cepat
                                            </p>
                                            <div class="flex flex-wrap gap-2.5">
                                                <a href="{{ route('guru.announcements.create', $meeting) }}"
                                                   class="inline-flex items-center gap-1.5 px-3.5 py-2.5 bg-yellow-500 text-white text-xs font-medium rounded-lg hover:bg-yellow-600 transition shadow-sm hover:shadow">
                                                    <svg class="w-4 h-4 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5.882V19.24a1.76 1.76 0 01-3.417.592l-2.147-6.15M18 13a3 3 0 100-6M5.436 13.683A4.001 4.001 0 017 6h1.832c4.1 0 7.625-1.234 9.168-3v14c-1.543-1.766-5.067-3-9.168-3H7a3.988 3.988 0 01-1.564-.317z"/>
                                                    </svg>
                                                    Buat Pengumuman
                                                </a>

                                                <a href="{{ route('guru.attendance.index', $meeting) }}"
                                                   class="inline-flex items-center gap-1.5 px-3.5 py-2.5 bg-indigo-500 text-white text-xs font-medium rounded-lg hover:bg-indigo-600 transition shadow-sm hover:shadow">
                                                    <svg class="w-4 h-4 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4"/>
                                                    </svg>
                                                    Check Kehadiran
                                                </a>

                                                <a href="{{ route('guru.materials.create', $meeting) }}"
                                                   class="inline-flex items-center gap-1.5 px-3.5 py-2.5 bg-blue-600 text-white text-xs font-medium rounded-lg hover:bg-blue-700 transition shadow-sm hover:shadow">
                                                    <svg class="w-4 h-4 flex-shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" d="M5 10l7-7m0 0l7 7m-7-7v18"/>
                                                    </svg>
                                                    Upload Materi
                                                </a>

                                                <a href="{{ route('guru.quizzes.create', $meeting) }}"
                                                   class="inline-flex items-center gap-1.5 px-3.5 py-2.5 bg-green-600 text-white text-xs font-medium rounded-lg hover:bg-green-700 transition shadow-sm hover:shadow">
                                                    <svg class="w-4 h-4 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4"/>
                                                    </svg>
                                                    Buat Kuis
                                                </a>

                                                <a href="{{ route('guru.assignments.create', $meeting) }}"
                                                   class="inline-flex items-center gap-1.5 px-3.5 py-2.5 bg-purple-600 text-white text-xs font-medium rounded-lg hover:bg-purple-700 transition shadow-sm hover:shadow">
                                                    <svg class="w-4 h-4 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                                                    </svg>
                                                    Buat Tugas
                                                </a>
                                            </div>
                                        </div>

                                        <!-- List Materi, Kuis, Tugas, Pengumuman -->
                                        @if($meeting->materials->count() > 0 || $meeting->quizzes->count() > 0 || $meeting->assignments->count() > 0)
                                            <div class="space-y-4 pt-1">
                                                @if($meeting->materials->count() > 0)
                                                    <div>
                                                        <p class="text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wider mb-2.5 flex items-center gap-1.5">
                                                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                                                            Materi
                                                        </p>
                                                        <div class="flex flex-wrap gap-2">
                                                            @foreach($meeting->materials as $material)
                                                                <span class="inline-flex items-center gap-1.5 px-3 py-1.5 bg-blue-50 dark:bg-blue-900/20 text-blue-700 dark:text-blue-300 text-xs font-medium rounded-full border border-blue-200/60 dark:border-blue-800/50 shadow-sm">
                                                                    {{ $material->judul }}
                                                                    <x-confirm-modal
                                                                        action="{{ route('guru.materials.delete', $material) }}"
                                                                        title="Hapus Materi"
                                                                        message="Hapus materi <strong>{{ $material->judul }}</strong>?"
                                                                    >
                                                                        <x-slot name="trigger">
                                                                            <button type="button" class="text-blue-400 hover:text-red-500 hover:bg-red-50 dark:hover:bg-red-900/20 rounded-full p-0.5 transition-colors">×</button>
                                                                        </x-slot>
                                                                    </x-confirm-modal>
                                                                </span>
                                                            @endforeach
                                                        </div>
                                                    </div>
                                                @endif

                                                @if($meeting->quizzes->count() > 0)
                                                    <div>
                                                        <p class="text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wider mb-2.5 flex items-center gap-1.5">
                                                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4"/></svg>
                                                            Kuis
                                                        </p>
                                                        <div class="flex flex-wrap gap-2">
                                                @foreach($meeting->quizzes as $quiz)
                                                                 <span class="inline-flex items-center gap-1.5 px-3 py-1.5 bg-green-50 dark:bg-green-900/20 text-green-700 dark:text-green-300 text-xs font-medium rounded-full border border-green-200/60 dark:border-green-800/50 shadow-sm hover:bg-green-100 dark:hover:bg-green-900/30 transition">
                                                                     <a href="{{ route('guru.quizzes.edit', $quiz) }}" class="hover:underline">
                                                                         {{ $quiz->judul_kuis }}
                                                                     </a>
                                                                     <x-confirm-modal
                                                                         action="{{ route('guru.quizzes.delete', $quiz) }}"
                                                                         title="Hapus Kuis"
                                                                         message="Hapus kuis <strong>{{ $quiz->judul_kuis }}</strong>?"
                                                                     >
                                                                         <x-slot name="trigger">
                                                                             <button type="button" class="text-green-400 hover:text-red-500 hover:bg-red-50 dark:hover:bg-red-900/20 rounded-full p-0.5 transition-colors">×</button>
                                                                         </x-slot>
                                                                     </x-confirm-modal>
                                                                 </span>
                                                             @endforeach
                                                        </div>
                                                    </div>
                                                @endif

                                                @if($meeting->assignments->count() > 0)
                                                    <div>
                                                        <p class="text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wider mb-2.5 flex items-center gap-1.5">
                                                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                                                            Tugas
                                                        </p>
                                                        <div class="flex flex-wrap gap-2">
                                                            @foreach($meeting->assignments as $assignment)
                                                                <span class="inline-flex items-center gap-1.5 px-3 py-1.5 bg-purple-50 dark:bg-purple-900/20 text-purple-700 dark:text-purple-300 text-xs font-medium rounded-full border border-purple-200/60 dark:border-purple-800/50 shadow-sm hover:bg-purple-100 dark:hover:bg-purple-900/30 transition">
                                                                    <a href="{{ route('guru.assignments.submissions', $assignment) }}" class="hover:underline">
                                                                        {{ $assignment->judul_tugas }}
                                                                    </a>
                                                                    <x-confirm-modal
                                                                        action="{{ route('guru.assignments.delete', $assignment) }}"
                                                                        title="Hapus Tugas"
                                                                        message="Hapus tugas <strong>{{ $assignment->judul_tugas }}</strong>?"
                                                                    >
                                                                        <x-slot name="trigger">
                                                                            <button type="button" class="text-purple-400 hover:text-red-500 hover:bg-red-50 dark:hover:bg-red-900/20 rounded-full p-0.5 transition-colors">×</button>
                                                                        </x-slot>
                                                                    </x-confirm-modal>
                                                                </span>
                                                            @endforeach
                                                        </div>
                                                    </div>
                                                @endif

                                                @if($meeting->announcements->count() > 0)
                                                    <div>
                                                        <p class="text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wider mb-2.5 flex items-center gap-1.5">
                                                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5.882V19.24a1.76 1.76 0 01-3.417.592l-2.147-6.15M18 13a3 3 0 100-6M5.436 13.683A4.001 4.001 0 017 6h1.832c4.1 0 7.625-1.234 9.168-3v14c-1.543-1.766-5.067-3-9.168-3H7a3.988 3.988 0 01-1.564-.317z"/></svg>
                                                            Pengumuman
                                                        </p>
                                                        <div class="space-y-2.5">
                                                            @foreach($meeting->announcements->sortBy('is_penting') as $announcement)
                                                                <div class="p-4 rounded-xl border {{ $announcement->is_penting ? 'bg-yellow-50/80 dark:bg-yellow-900/15 border-yellow-300 dark:border-yellow-700' : 'bg-gray-50 dark:bg-gray-700/50 border-gray-200 dark:border-gray-600' }}">
                                                                    <div class="flex items-start justify-between gap-3">
                                                                        <div class="flex-1 min-w-0">
                                                                            <div class="flex items-center gap-2 mb-1.5">
                                                                                @if($announcement->is_penting)
                                                                                    <svg class="w-4 h-4 text-yellow-600 dark:text-yellow-400 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                                                                                        <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                                                                                    </svg>
                                                                                @endif
                                                                                <span class="text-sm font-semibold text-gray-800 dark:text-white truncate">{{ $announcement->judul_pengumuman }}</span>
                                                                            </div>
                                                                            <p class="text-xs text-gray-600 dark:text-gray-300 line-clamp-2">{{ Str::limit($announcement->isi_pengumuman, 100) }}</p>
                                                                            <p class="text-xs text-gray-400 dark:text-gray-500 mt-1.5">{{ $announcement->published_at->diffForHumans() }}</p>
                                                                        </div>
                                                                        <div class="flex items-center gap-1.5 flex-shrink-0">
                                                                            <a href="{{ route('guru.announcements.edit', $announcement) }}"
                                                                               class="text-blue-600 dark:text-blue-400 hover:text-blue-700 text-xs font-medium px-2.5 py-1.5 rounded-lg hover:bg-blue-50 dark:hover:bg-blue-900/30 transition">
                                                                                Edit
                                                                            </a>
                                                                            <x-confirm-modal
                                                                                action="{{ route('guru.announcements.delete', $announcement) }}"
                                                                                title="Hapus Pengumuman"
                                                                                message="Hapus pengumuman <strong>{{ $announcement->judul_pengumuman }}</strong>?"
                                                                            >
                                                                                <x-slot name="trigger">
                                                                                    <button type="button" class="text-red-500 hover:text-red-700 hover:bg-red-50 dark:hover:bg-red-900/30 text-xs px-2.5 py-1.5 rounded-lg transition">Hapus</button>
                                                                                </x-slot>
                                                                            </x-confirm-modal>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            @endforeach
                                                        </div>
                                                    </div>
                                                @endif
                                            </div>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @else
                    <div class="text-center py-12">
                        <svg class="mx-auto h-16 w-16 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                        </svg>
                        <h3 class="mt-4 text-lg font-medium text-gray-800 dark:text-white">Belum Ada Pertemuan</h3>
                        <p class="mt-2 text-gray-500 dark:text-gray-400">Mulai dengan menambahkan pertemuan pertama Anda.</p>
                        <div class="mt-6">
                            <a href="{{ route('guru.meetings.create', $class) }}"
                               class="inline-flex items-center gap-2 bg-blue-600 text-white px-6 py-3 rounded-lg hover:bg-blue-700 transition font-medium shadow-sm hover:shadow">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                                </svg>
                                Tambah Pertemuan Sekarang
                            </a>
                        </div>
                        <div class="mt-8 p-5 bg-blue-50 dark:bg-blue-900/30 border border-blue-200 dark:border-blue-800 rounded-xl">
                            <p class="text-sm text-blue-800 dark:text-blue-300 font-medium mb-2">📋 Langkah-langkah:</p>
                            <ol class="text-sm text-blue-700 dark:text-blue-400 text-left space-y-1.5 list-decimal list-inside">
                                <li>Klik "Tambah Pertemuan Sekarang"</li>
                                <li>Isi judul dan urutan pertemuan</li>
                                <li>Setelah ada pertemuan, Anda bisa:</li>
                                <ul class="ml-6 mt-2 space-y-1.5">
                                    <li>📄 Upload Materi</li>
                                    <li>📝 Buat Kuis</li>
                                    <li>📋 Buat Tugas</li>
                                </ul>
                            </ol>
                        </div>
                    </div>
                @endif
            </div>
        </div>

        <!-- Sidebar Info Kelas -->
        <div class="space-y-6">
            <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700 p-6">
                <h3 class="font-semibold text-gray-800 dark:text-white mb-4">Informasi Kelas</h3>
                <dl class="space-y-4">
                    <div>
                        <dt class="text-sm text-gray-500 dark:text-gray-400">Guru Pengampu</dt>
                        <dd class="text-gray-800 dark:text-white font-medium">{{ $class->guru->nama_lengkap }}</dd>
                    </div>
                    <div>
                        <dt class="text-sm text-gray-500 dark:text-gray-400">Periode</dt>
                        <dd class="text-gray-800 dark:text-white font-medium">{{ $class->periode }}</dd>
                    </div>
                    <div>
                        <dt class="text-sm text-gray-500 dark:text-gray-400">Status</dt>
                        <dd>
                            <span class="px-2.5 py-1 rounded-full text-xs font-medium
                                @if($class->status === 'aktif') bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-200
                                @else bg-gray-100 text-gray-800 dark:bg-gray-700 dark:text-gray-200
                                @endif">
                                {{ ucfirst($class->status) }}
                            </span>
                        </dd>
                    </div>
                </dl>
            </div>

            <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700 p-6">
                <div class="flex items-center justify-between mb-4">
                    <h3 class="font-semibold text-gray-800 dark:text-white">Daftar Murid ({{ $class->students->count() }})</h3>
                </div>
                @if($class->students->count() > 0)
                    <div class="space-y-2">
                        @foreach($class->students as $student)
                            <a href="{{ route('guru.students.detail', [$class, $student]) }}"
                               class="flex items-center justify-between p-2.5 bg-gray-50 dark:bg-gray-700/50 rounded-xl hover:bg-gray-100 dark:hover:bg-gray-600/50 transition group">
                                <div class="flex items-center gap-3">
                                    <div class="w-8 h-8 bg-gradient-to-br from-purple-500 to-purple-600 rounded-full flex items-center justify-center text-white text-sm font-semibold shadow-sm">
                                        {{ strtoupper(substr($student->nama_lengkap, 0, 1)) }}
                                    </div>
                                    <span class="text-sm text-gray-700 dark:text-gray-300 font-medium">{{ $student->nama_lengkap }}</span>
                                </div>
                                <svg class="w-4 h-4 text-gray-400 group-hover:text-gray-600 dark:group-hover:text-gray-300 transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                                </svg>
                            </a>
                        @endforeach
                    </div>

                    <div class="mt-5 pt-5 border-t border-gray-200 dark:border-gray-700">
                        <a href="{{ route('guru.certificates.index', $class) }}"
                           class="block w-full text-center py-2.5 px-4 text-sm font-semibold text-white bg-yellow-500 rounded-xl hover:bg-yellow-600 transition shadow-sm">
                            Kelola Sertifikat Kelas
                        </a>
                    </div>
                @else
                    <p class="text-gray-500 dark:text-gray-400 text-sm">Belum ada murid di kelas ini.</p>
                @endif
            </div>
        </div>
    </div>

</x-layouts.lms>