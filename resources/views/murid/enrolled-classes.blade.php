<x-layouts.lms>
    <x-slot name="sidebar">
        @include('layouts.sidebar-murid')
    </x-slot>

    <div class="mb-6">
        <h1 class="text-2xl font-bold text-gray-800 dark:text-white">Kelas yang Sedang Diikuti</h1>
        <p class="text-gray-500 dark:text-gray-400 mt-1">Pilih kelas untuk melihat detail materi, quiz, dan tugas</p>
    </div>

    @if($classes->count() > 0)
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
            @foreach($classes as $class)
                @php
                    $stats = $classStats[$class->id] ?? [];
                @endphp

                <div class="bg-white dark:bg-gray-800 rounded-xl shadow-md border border-gray-200 dark:border-gray-700 p-4 hover:shadow-lg transition">
                    <div class="flex items-center justify-between mb-3">
                        <div class="flex-1 min-w-0">
                            <h3 class="text-base font-bold text-gray-800 dark:text-white truncate">{{ $class->nama_kelas }}</h3>
                            <p class="text-xs text-gray-500 dark:text-gray-400">{{ $class->periode }}</p>
                        </div>
                        <span class="px-2 py-1 rounded-full text-xs font-bold
                            @if($class->status === 'aktif') bg-green-100 text-green-700 dark:bg-green-900 dark:text-green-200
                            @else bg-gray-100 text-gray-700 dark:bg-gray-700 dark:text-gray-200
                            @endif">
                            {{ ucfirst($class->status) }}
                        </span>
                    </div>

                    <div class="space-y-2 mb-3">
                        <div class="flex items-center text-xs text-gray-600 dark:text-gray-300">
                            <svg class="w-4 h-4 mr-2 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/>
                            </svg>
                            <span class="truncate">{{ $class->course->nama_bahasa }}</span>
                        </div>
                        <div class="flex items-center text-xs text-gray-600 dark:text-gray-300">
                            <svg class="w-4 h-4 mr-2 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                            </svg>
                            <span class="truncate">{{ $class->guru->nama_lengkap }}</span>
                        </div>
                    </div>

                    {{-- Progress Bar --}}


                    <a href="{{ route('murid.enrolled-classes.show', $class) }}"
                       class="block text-center bg-blue-600 hover:bg-blue-700 text-white py-2 rounded-lg transition text-sm font-semibold">
                        Masuk Kelas
                    </a>
                </div>
            @endforeach
        </div>
    @else
        <div class="bg-white dark:bg-gray-800 rounded-xl shadow-md border border-gray-200 dark:border-gray-700 p-12 text-center">
            <svg class="mx-auto h-16 w-16 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"/>
            </svg>
            <h3 class="text-lg font-semibold text-gray-700 dark:text-gray-300 mb-2 mt-4">Belum Ada Kelas</h3>
            <p class="text-gray-500 dark:text-gray-400">Anda belum terdaftar di kelas manapun. Silakan hubungi administrator untuk pendaftaran.</p>
        </div>
    @endif
</x-layouts.lms>
