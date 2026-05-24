<x-layouts.lms>
    <x-slot name="sidebar">
        @include('layouts.sidebar-murid')
    </x-slot>

    <div class="mb-6">
        <a href="{{ route('murid.enrolled-classes') }}" class="text-blue-600 dark:text-blue-400 hover:underline text-sm mb-4 inline-block">← Kembali ke Daftar Kelas</a>
        <h1 class="text-2xl font-bold text-gray-800 dark:text-white">{{ $class->nama_kelas }}</h1>
        <p class="text-gray-500 dark:text-gray-400 mt-1">{{ $class->course->nama_bahasa }} - {{ $class->periode }}</p>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <div class="lg:col-span-2">
            <div class="bg-white dark:bg-gray-800 rounded-lg shadow-sm border border-gray-200 dark:border-gray-700 p-6">
                <h2 class="text-lg font-semibold text-gray-800 dark:text-white mb-4">Daftar Pertemuan</h2>

                @if($class->meetings->count() > 0)
                    <div class="space-y-3">
                        @foreach($class->meetings as $meeting)
                            <a href="{{ route('murid.meeting', $meeting) }}"
                               class="block border border-gray-200 dark:border-gray-700 rounded-lg p-4 hover:bg-gray-50 dark:hover:bg-gray-700 transition">
                                <div class="flex items-center gap-4">
                                    <div class="w-12 h-12 bg-blue-100 dark:bg-blue-900 rounded-lg flex items-center justify-center">
                                        <span class="text-blue-600 dark:text-blue-400 font-bold">{{ $meeting->urutan_pertemuan }}</span>
                                    </div>
                                    <div class="flex-1">
                                        <h3 class="font-semibold text-gray-800 dark:text-white">{{ $meeting->judul_pertemuan }}</h3>
                                        <p class="text-sm text-gray-500 dark:text-gray-400">
                                            {{ $meeting->materials->count() }} Materi • {{ $meeting->quizzes->count() }} Kuis • {{ $meeting->assignments->count() }} Tugas
                                            @if($meeting->announcements->count() > 0)
                                                <span class="ml-2 text-yellow-600 dark:text-yellow-400">• {{ $meeting->announcements->count() }} Pengumuman</span>
                                            @endif
                                        </p>

                                        @if($meeting->announcements->count() > 0)
                                            <div class="mt-3 pt-3 border-t border-gray-200 dark:border-gray-700">
                                                @foreach($meeting->announcements->sortByDesc('is_penting')->take(2) as $announcement)
                                                    <div class="flex items-start gap-2 mb-2 last:mb-0">
                                                        @if($announcement->is_penting)
                                                            <svg class="w-4 h-4 text-yellow-600 dark:text-yellow-400 mt-0.5 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                                                                <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                                                            </svg>
                                                        @endif
                                                        <div class="flex-1 min-w-0">
                                                            <p class="text-xs font-medium text-gray-700 dark:text-gray-300 truncate">{{ $announcement->judul_pengumuman }}</p>
                                                            <p class="text-xs text-gray-500 dark:text-gray-400 truncate">{{ Str::limit($announcement->isi_pengumuman, 60) }}</p>
                                                        </div>
                                                    </div>
                                                @endforeach
                                                @if($meeting->announcements->count() > 2)
                                                    <p class="text-xs text-blue-600 dark:text-blue-400 mt-1">+ {{ $meeting->announcements->count() - 2 }} pengumuman lainnya</p>
                                                @endif
                                            </div>
                                        @endif
                                    </div>
                                    <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                                    </svg>
                                </div>
                            </a>
                        @endforeach
                    </div>
                @else
                    <p class="text-gray-500 dark:text-gray-400 text-center py-8">Belum ada pertemuan.</p>
                @endif
            </div>
        </div>

        <div>
            <div class="bg-white dark:bg-gray-800 rounded-lg shadow-sm border border-gray-200 dark:border-gray-700 p-6">
                <h3 class="font-semibold text-gray-800 dark:text-white mb-4">Informasi Kelas</h3>
                <dl class="space-y-3">
                    <div>
                        <dt class="text-sm text-gray-500 dark:text-gray-400">Guru Pengampu</dt>
                        <dd class="text-gray-800 dark:text-white">{{ $class->guru->nama_lengkap }}</dd>
                    </div>
                    <div>
                        <dt class="text-sm text-gray-500 dark:text-gray-400">Periode</dt>
                        <dd class="text-gray-800 dark:text-white">{{ $class->periode }}</dd>
                    </div>
                </dl>
            </div>
        </div>
    </div>
</x-layouts.lms>
