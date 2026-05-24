<x-layouts.lms>
    <x-slot name="sidebar">
        @include('layouts.sidebar-murid')
    </x-slot>

    {{-- Header dengan spacing lebih lega --}}
    <div class="mb-8">
        <h1 class="text-2xl font-bold text-gray-800 dark:text-white">Dashboard Murid</h1>
        <p class="text-gray-500 dark:text-gray-400 mt-1.5">Selamat datang, {{ auth()->user()->nama_lengkap }}!</p>
    </div>

    {{-- Grid: Tugas + Notifikasi bersebelahan --}}
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-8">

        {{-- Tugas --}}
        <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-sm border border-gray-200 dark:border-gray-700 p-6">
            <div class="flex items-center justify-between mb-5">
                <h2 class="text-lg font-semibold text-gray-800 dark:text-white flex items-center gap-2">
                    <svg class="w-5 h-5 text-orange-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
                    </svg>
                    Tugas
                </h2>
                @if($assignments->count() > 0)
                    <span class="text-xs font-semibold px-2.5 py-1 rounded-full bg-orange-100 text-orange-800 dark:bg-orange-900 dark:text-orange-200">
                        {{ $assignments->count() }} tugas
                    </span>
                @endif
            </div>

            @if($assignments->count() > 0)
                <div class="space-y-3 max-h-72 overflow-y-auto pr-1 custom-scrollbar">
                    @foreach($assignments as $assignment)
                        <div class="border border-gray-200 dark:border-gray-700 rounded-xl p-4 hover:bg-gray-50 dark:hover:bg-gray-700/50 transition">
                            <div class="flex items-start justify-between">
                                <div class="flex-1 min-w-0">
                                    <h3 class="font-semibold text-gray-800 dark:text-white text-sm truncate">{{ $assignment->judul_tugas }}</h3>
                                    <p class="text-xs text-gray-500 dark:text-gray-400 mt-0.5">
                                        {{ $assignment->meeting->class->nama_kelas }}
                                    </p>
                                </div>
                                <span class="text-xs font-semibold px-2.5 py-1 rounded-full ml-2 flex-shrink-0
                                    @if($assignment->deadline < now())
                                        bg-red-100 text-red-700 dark:bg-red-900/50 dark:text-red-300
                                    @elseif($assignment->deadline->diffInDays(now()) <= 2)
                                        bg-yellow-100 text-yellow-700 dark:bg-yellow-900/50 dark:text-yellow-300
                                    @else
                                        bg-green-100 text-green-700 dark:bg-green-900/50 dark:text-green-300
                                    @endif">
                                    @if($assignment->deadline < now())
                                        Terlewat
                                    @elseif($assignment->deadline->diffInHours(now()) < 24)
                                        {{ $assignment->deadline->diffInHours(now()) }}j
                                    @else
                                        {{ $assignment->deadline->diffInDays(now()) }}h
                                    @endif
                                </span>
                            </div>
                            <div class="flex items-center justify-between mt-3">
                                <p class="text-xs text-gray-500 dark:text-gray-400">
                                    <svg class="w-3.5 h-3.5 inline mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                    </svg>
                                    {{ $assignment->deadline ? $assignment->deadline->format('d M, H:i') : '-' }}
                                </p>
                                <a href="{{ route('murid.assignment.submit', $assignment) }}"
                                   class="text-xs font-semibold text-blue-600 dark:text-blue-400 hover:underline inline-flex items-center gap-1">
                                    Kerjakan
                                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                                    </svg>
                                </a>
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                <div class="flex flex-col items-center justify-center py-10">
                    <svg class="w-24 h-24 text-gray-300 dark:text-gray-600 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4"/>
                    </svg>
                    <p class="text-gray-800 dark:text-white font-medium text-base">Selamat! Tidak ada tugas yang perlu dikerjakan saat ini</p>
                    <p class="text-gray-500 dark:text-gray-400 text-sm mt-1">Nikmati waktu belajarmu dan tetap semangat!</p>
                </div>
            @endif
        </div>

        {{-- Notifikasi --}}
        <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-sm border border-gray-200 dark:border-gray-700 p-6"
             x-data="{ notifCount: {{ $importantAnnouncements->count() }} }">
            <div class="flex items-center justify-between mb-5">
                <h2 class="text-lg font-semibold text-gray-800 dark:text-white flex items-center gap-2">
                    <svg class="w-5 h-5 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"/>
                    </svg>
                    Notifikasi
                </h2>
                <span class="text-xs font-semibold px-2.5 py-1 rounded-full bg-red-100 text-red-800 dark:bg-red-900/50 dark:text-red-300"
                      x-text="notifCount">
                    {{ $importantAnnouncements->count() }}
                </span>
            </div>

            @if($importantAnnouncements->count() > 0)
                <div class="space-y-3 max-h-72 overflow-y-auto pr-1 custom-scrollbar">
                    @foreach($importantAnnouncements as $announcement)
                        <div x-data="{ show: true }" x-show="show"
                             class="border border-gray-100 dark:border-gray-700 rounded-xl p-4 hover:bg-gray-50 dark:hover:bg-gray-700/50 transition">
                            <div class="flex items-start gap-3">
                                @if($announcement->is_penting)
                                    <div class="bg-red-100 dark:bg-red-900/30 rounded-lg p-1.5 flex-shrink-0 mt-0.5">
                                        <svg class="w-4 h-4 text-red-500" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-11a1 1 0 10-2 0v2H7a1 1 0 100 2h2v2a1 1 0 102 0v-2h2a1 1 0 100-2h-2V7z" clip-rule="evenodd"/>
                                        </svg>
                                    </div>
                                @else
                                    <div class="bg-blue-100 dark:bg-blue-900/30 rounded-lg p-1.5 flex-shrink-0 mt-0.5">
                                        <svg class="w-4 h-4 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                        </svg>
                                    </div>
                                @endif
                                <div class="flex-1 min-w-0">
                                    <div class="flex items-center gap-2">
                                        <h3 class="font-semibold text-gray-800 dark:text-white text-sm">{{ $announcement->judul_pengumuman }}</h3>
                                        @if($announcement->is_penting)
                                            <span class="text-[10px] font-semibold px-1.5 py-0.5 rounded-full bg-red-100 text-red-700 dark:bg-red-900/50 dark:text-red-300">Penting</span>
                                        @endif
                                    </div>
                                    <p class="text-sm text-gray-600 dark:text-gray-300 mt-1 line-clamp-2">
                                        {{ Str::limit($announcement->isi_pengumuman, 80) }}
                                    </p>
                                    <div class="flex items-center justify-between mt-2">
                                        <div class="text-xs text-gray-500 dark:text-gray-400">
                                            <span class="font-medium">{{ $announcement->guru->nama_lengkap }}</span>
                                            <span class="mx-1.5">•</span>
                                            <span>{{ $announcement->published_at->diffForHumans() }}</span>
                                        </div>
                                        <button @click="
                                            fetch('{{ route('murid.notification.read', $announcement) }}', {
                                                method: 'POST',
                                                headers: { 'X-CSRF-TOKEN': '{{ csrf_token() }}', 'Content-Type': 'application/json' },
                                            }).then(() => {
                                                show = false;
                                                notifCount--;
                                            })
                                        " class="text-xs font-medium text-purple-600 dark:text-purple-400 hover:text-purple-700 dark:hover:text-purple-300 px-2.5 py-1 rounded-full border border-purple-200 dark:border-purple-800 hover:bg-purple-50 dark:hover:bg-purple-900/20 transition flex-shrink-0 ml-2">
                                            Tandai
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
                <div class="mt-4 pt-3 border-t border-gray-100 dark:border-gray-700 text-center">
                    <a href="#" class="text-sm font-medium text-purple-600 dark:text-purple-400 hover:text-purple-700 dark:hover:text-purple-300 transition inline-flex items-center gap-1">
                        Lihat semua notifikasi
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                        </svg>
                    </a>
                </div>
            @else
                <div class="flex flex-col items-center justify-center py-8">
                    <svg class="w-16 h-16 text-gray-300 dark:text-gray-600 mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"/>
                    </svg>
                    <p class="text-gray-500 dark:text-gray-400 text-sm">Tidak ada notifikasi saat ini</p>
                </div>
            @endif
        </div>

    </div>

    {{-- Kelas Aktif Detail --}}
    @if($classes->count() > 0)
        <div>
            <h2 class="text-lg font-semibold text-gray-800 dark:text-white mb-5 flex items-center gap-2">
                <svg class="w-5 h-5 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"/>
                </svg>
                Kelas Aktif
            </h2>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-5">
                @foreach($classes as $class)
                    <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-sm border border-gray-200 dark:border-gray-700 p-5 hover:shadow-md transition">
                        <div class="flex items-center justify-between mb-4">
                            <div class="flex-1 min-w-0">
                                <h3 class="font-bold text-gray-800 dark:text-white truncate">{{ $class->nama_kelas }}</h3>
                                <p class="text-xs text-gray-500 dark:text-gray-400 mt-0.5">{{ $class->periode }}</p>
                            </div>
                            <span class="px-2.5 py-1 rounded-full text-xs font-semibold flex-shrink-0
                                @if($class->status === 'aktif') bg-green-100 text-green-700 dark:bg-green-900/50 dark:text-green-300
                                @else bg-gray-100 text-gray-600 dark:bg-gray-700 dark:text-gray-300
                                @endif">
                                ● {{ ucfirst($class->status) }}
                            </span>
                        </div>

                        <div class="space-y-2 mb-4">
                            <div class="flex items-center text-sm text-gray-600 dark:text-gray-300">
                                <svg class="w-4 h-4 mr-2.5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/>
                                </svg>
                                <span class="truncate">{{ $class->course->nama_bahasa }}</span>
                            </div>
                            <div class="flex items-center text-sm text-gray-600 dark:text-gray-300">
                                <svg class="w-4 h-4 mr-2.5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                                </svg>
                                <span class="truncate">{{ $class->guru->nama_lengkap }}</span>
                            </div>
                        </div>

                        <div class="mb-4">
                            <div class="flex items-center justify-between mb-1.5">
                                <span class="text-xs text-gray-500 dark:text-gray-400">Progress Belajar</span>
                                <span class="text-xs font-bold text-gray-700 dark:text-gray-200">{{ $classProgress[$class->id] ?? 0 }}%</span>
                            </div>
                            <div class="w-full bg-gray-100 dark:bg-gray-700 rounded-full h-2.5">
                                <div class="bg-gradient-to-r from-purple-500 to-purple-600 h-2.5 rounded-full transition-all duration-500"
                                     style="width: {{ $classProgress[$class->id] ?? 0 }}%"></div>
                            </div>
                        </div>

                        <div class="flex gap-2">
                            <a href="{{ route('murid.enrolled-classes.show', $class) }}"
                               class="flex-1 text-center bg-purple-600 hover:bg-purple-700 text-white py-2.5 rounded-xl transition text-sm font-semibold">
                                Masuk Kelas
                            </a>
                            <a href="{{ route('murid.progress-detail', ['class_id' => $class->id]) }}"
                               class="flex-1 text-center bg-gray-100 hover:bg-gray-200 text-gray-700 dark:bg-gray-700 dark:text-gray-200 dark:hover:bg-gray-600 py-2.5 rounded-xl transition text-sm font-semibold">
                                Detail Nilai
                            </a>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    @else
        <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-sm border border-gray-200 dark:border-gray-700 p-8 text-center">
            <svg class="mx-auto h-14 w-14 text-gray-300 dark:text-gray-600 mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/>
            </svg>
            <p class="text-gray-800 dark:text-white font-medium">Anda belum terdaftar di kelas manapun.</p>
            <p class="text-sm text-gray-500 dark:text-gray-400 mt-1">Hubungi admin untuk dimasukkan ke kelas.</p>
        </div>
    @endif
</x-layouts.lms>
