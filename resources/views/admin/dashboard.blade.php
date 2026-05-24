<x-layouts.lms>
    <x-slot name="sidebar">
        @include('layouts.sidebar-admin')
    </x-slot>

    <div class="mb-6">
        <h1 class="text-2xl font-bold text-gray-800 dark:text-white">Dashboard Admin</h1>
        <p class="text-gray-500 dark:text-gray-400 mt-1">Kelola sistem LMS Bahasa</p>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-6">
        <div class="bg-white dark:bg-gray-800 rounded-lg shadow-sm p-6 border border-gray-200 dark:border-gray-700">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-gray-500 dark:text-gray-400">Menunggu Verifikasi</p>
                    <p class="text-3xl font-bold text-blue-600 dark:text-blue-400 mt-1">{{ $pendingCount }}</p>
                </div>
                <div class="bg-blue-100 dark:bg-blue-900 p-4 rounded-full">
                    <svg class="w-8 h-8 text-blue-500 dark:text-blue-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                    </svg>
                </div>
            </div>
            <a href="{{ route('admin.registrations.index') }}" class="mt-4 block text-sm text-blue-600 dark:text-blue-400 hover:underline">
                Lihat semua →
            </a>
        </div>

        <div class="bg-white dark:bg-gray-800 rounded-lg shadow-sm p-6 border border-gray-200 dark:border-gray-700">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-gray-500 dark:text-gray-400">Total Murid</p>
                    <p class="text-3xl font-bold text-green-600 dark:text-green-400 mt-1">{{ $totalStudents }}</p>
                </div>
                <div class="bg-green-100 dark:bg-green-900 p-4 rounded-full">
                    <svg class="w-8 h-8 text-green-500 dark:text-green-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"/>
                    </svg>
                </div>
            </div>
        </div>

        <div class="bg-white dark:bg-gray-800 rounded-lg shadow-sm p-6 border border-gray-200 dark:border-gray-700">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-gray-500 dark:text-gray-400">Total Guru</p>
                    <p class="text-3xl font-bold text-purple-600 dark:text-purple-400 mt-1">{{ $totalGurus }}</p>
                </div>
                <div class="bg-purple-100 dark:bg-purple-900 p-4 rounded-full">
                    <svg class="w-8 h-8 text-purple-500 dark:text-purple-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                    </svg>
                </div>
            </div>
        </div>

        <div class="bg-white dark:bg-gray-800 rounded-lg shadow-sm p-6 border border-gray-200 dark:border-gray-700">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-gray-500 dark:text-gray-400">Total Kelas</p>
                    <p class="text-3xl font-bold text-orange-600 dark:text-orange-400 mt-1">{{ $totalClasses }}</p>
                </div>
                <div class="bg-orange-100 dark:bg-orange-900 p-4 rounded-full">
                    <svg class="w-8 h-8 text-orange-500 dark:text-orange-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/>
                    </svg>
                </div>
            </div>
            <a href="{{ route('admin.classes.index') }}" class="mt-4 block text-sm text-orange-600 dark:text-orange-400 hover:underline">
                Kelola kelas →
            </a>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 mb-6">
        <!-- Distribution by Course -->
        <div class="lg:col-span-1 bg-white dark:bg-gray-800 rounded-lg shadow-sm p-6 border border-gray-200 dark:border-gray-700">
            <h2 class="text-lg font-bold text-gray-800 dark:text-white mb-4">Peminatan Kursus</h2>
            <div class="space-y-4">
                @php
                    $colors = ['English' => 'blue', 'Korean' => 'red', 'Thai' => 'yellow'];
                    $total = array_sum($courseStats);
                @endphp
                @foreach($courseStats as $course => $count)
                    @php
                        $percentage = $total > 0 ? ($count / $total) * 100 : 0;
                        $color = $colors[$course] ?? 'gray';
                    @endphp
                    <div>
                        <div class="flex items-center justify-between mb-1">
                            <span class="text-sm font-medium text-gray-700 dark:text-gray-300">{{ $course }}</span>
                            <span class="text-sm font-bold text-gray-900 dark:text-white">{{ $count }}</span>
                        </div>
                        <div class="w-full bg-gray-200 dark:bg-gray-700 rounded-full h-2">
                            <div class="bg-{{ $color }}-500 h-2 rounded-full" style="width: {{ $percentage }}%"></div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>

        <!-- Recent Registrations -->
        <div class="lg:col-span-2 bg-white dark:bg-gray-800 rounded-lg shadow-sm border border-gray-200 dark:border-gray-700">
            <div class="p-6 border-b border-gray-200 dark:border-gray-700 flex justify-between items-center">
                <h2 class="text-lg font-bold text-gray-800 dark:text-white">Registrasi Terbaru</h2>
                <a href="{{ route('admin.registrations.index') }}" class="text-sm text-blue-600 hover:underline">Lihat Semua</a>
            </div>
            <div class="overflow-x-auto">
                <table class="w-full text-left">
                    <thead>
                        <tr class="bg-gray-50 dark:bg-gray-700/50 text-xs uppercase text-gray-500">
                            <th class="px-6 py-3 font-semibold">Nama</th>
                            <th class="px-6 py-3 font-semibold">Kursus</th>
                            <th class="px-6 py-3 font-semibold">Status</th>
                            <th class="px-6 py-3 font-semibold text-right">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200 dark:divide-gray-700 text-sm">
                        @forelse($recentRegistrations as $reg)
                            <tr class="hover:bg-gray-50 dark:hover:bg-gray-700/30">
                                <td class="px-6 py-4 font-medium text-gray-900 dark:text-white">{{ $reg->nama }}</td>
                                <td class="px-6 py-4 text-gray-600 dark:text-gray-400">{{ $reg->kursus_label }}</td>
                                <td class="px-6 py-4">
                                    <span class="px-2 py-1 text-xs rounded-full 
                                        {{ $reg->status === 'verified' ? 'bg-green-100 text-green-800' : 
                                           ($reg->status === 'pending' ? 'bg-yellow-100 text-yellow-800' : 'bg-red-100 text-red-800') }}">
                                        {{ ucfirst($reg->status) }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 text-right">
                                    <a href="{{ route('admin.registrations.show', $reg) }}" class="text-blue-600 hover:text-blue-800">Detail</a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="px-6 py-8 text-center text-gray-500">Belum ada registrasi.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        <!-- Active Classes -->
        <div class="bg-white dark:bg-gray-800 rounded-lg shadow-sm border border-gray-200 dark:border-gray-700">
            <div class="p-6 border-b border-gray-200 dark:border-gray-700 flex justify-between items-center">
                <h2 class="text-lg font-bold text-gray-800 dark:text-white">Kelas Aktif Terbaru</h2>
                <a href="{{ route('admin.classes.index') }}" class="text-sm text-blue-600 hover:underline">Semua Kelas</a>
            </div>
            <div class="p-6 space-y-4">
                @forelse($activeClasses as $class)
                    <div class="flex items-center justify-between p-4 bg-gray-50 dark:bg-gray-700/50 rounded-lg">
                        <div>
                            <p class="font-bold text-gray-900 dark:text-white">{{ $class->nama_kelas }}</p>
                            <p class="text-sm text-gray-500">{{ $class->course->nama_bahasa }} • Guru: {{ $class->guru->nama_lengkap }}</p>
                        </div>
                        <a href="{{ route('admin.classes.show', $class) }}" class="p-2 text-gray-400 hover:text-blue-600">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                            </svg>
                        </a>
                    </div>
                @empty
                    <p class="text-center py-4 text-gray-500">Tidak ada kelas aktif.</p>
                @endforelse
            </div>
        </div>

        <!-- Recent Users -->
        <div class="bg-white dark:bg-gray-800 rounded-lg shadow-sm border border-gray-200 dark:border-gray-700">
            <div class="p-6 border-b border-gray-200 dark:border-gray-700 flex justify-between items-center">
                <h2 class="text-lg font-bold text-gray-800 dark:text-white">User Baru</h2>
                <a href="{{ route('admin.users.index') }}" class="text-sm text-blue-600 hover:underline">Kelola User</a>
            </div>
            <div class="p-6">
                <div class="space-y-4">
                    @foreach($recentUsers as $user)
                        <div class="flex items-center space-x-4">
                            <div class="flex-shrink-0">
                                <div class="w-10 h-10 rounded-full bg-gray-200 dark:bg-gray-700 flex items-center justify-center text-gray-500 font-bold">
                                    {{ substr($user->nama_lengkap, 0, 1) }}
                                </div>
                            </div>
                            <div class="flex-1 min-w-0">
                                <p class="text-sm font-medium text-gray-900 dark:text-white truncate">
                                    {{ $user->nama_lengkap }}
                                </p>
                                <p class="text-xs text-gray-500 dark:text-gray-400 truncate">
                                    {{ ucfirst($user->role) }} • {{ $user->created_at->diffForHumans() }}
                                </p>
                            </div>
                            <div>
                                <a href="{{ route('admin.users.edit', $user) }}" class="text-xs text-blue-600 hover:underline">Edit</a>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</x-layouts.lms>
