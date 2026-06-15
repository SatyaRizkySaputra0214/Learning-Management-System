<x-layouts.lms>
    <x-slot name="sidebar">
        @include('layouts.sidebar-admin')
    </x-slot>

    <div class="mb-6">
        <a href="{{ route('admin.classes.index') }}" class="text-blue-600 dark:text-blue-400 hover:underline text-sm mb-4 inline-block">← Kembali ke Daftar Kelas</a>
        <h1 class="text-2xl font-bold text-gray-800 dark:text-white">{{ $class->nama_kelas }}</h1>
        <p class="text-gray-500 dark:text-gray-400 mt-1">{{ $class->course->nama_bahasa }} - {{ $class->periode }}</p>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <div class="lg:col-span-2">
            <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700 p-6">
                <h2 class="text-lg font-semibold text-gray-800 dark:text-white mb-4">Daftar Murid</h2>
                
                @if($class->students->count() > 0)
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                            <thead class="bg-gray-50 dark:bg-gray-700">
                                <tr>
                                    <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase">Nama</th>
                                    <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase">Username</th>
                                    <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase">Email</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-200 dark:divide-gray-700">
                                @foreach($class->students as $student)
                                    <tr>
                                        <td class="px-4 py-3 text-sm text-gray-800 dark:text-white">{{ $student->nama_lengkap }}</td>
                                        <td class="px-4 py-3 text-sm text-gray-600 dark:text-gray-300">{{ $student->username }}</td>
                                        <td class="px-4 py-3 text-sm text-gray-600 dark:text-gray-300">{{ $student->email }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @else
                    <p class="text-gray-500 dark:text-gray-400 text-center py-8">Belum ada murid di kelas ini.</p>
                @endif
            </div>
        </div>

        <div class="space-y-6">
            <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700 p-6">
                <h3 class="font-semibold text-gray-800 dark:text-white mb-4">Informasi Kelas</h3>
                <dl class="space-y-3">
                    <div>
                        <dt class="text-sm text-gray-500 dark:text-gray-400">Guru Pengampu</dt>
                        <dd class="text-gray-800 dark:text-white">{{ $class->guru->nama_lengkap }}</dd>
                    </div>
                    <div>
                        <dt class="text-sm text-gray-500 dark:text-gray-400">Kursus</dt>
                        <dd class="text-gray-800 dark:text-white">{{ $class->course->nama_bahasa }}</dd>
                    </div>
                    <div>
                        <dt class="text-sm text-gray-500 dark:text-gray-400">Periode</dt>
                        <dd class="text-gray-800 dark:text-white">{{ $class->periode }}</dd>
                    </div>
                    <div>
                        <dt class="text-sm text-gray-500 dark:text-gray-400">Status</dt>
                        <dd>
                            <span class="px-2 py-1 rounded-full text-xs font-medium
                                @if($class->status === 'aktif') bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-200
                                @else bg-gray-100 text-gray-800 dark:bg-gray-700 dark:text-gray-200
                                @endif">
                                {{ ucfirst($class->status) }}
                            </span>
                        </dd>
                    </div>
                    <div>
                        <dt class="text-sm text-gray-500 dark:text-gray-400">Total Murid</dt>
                        <dd class="text-gray-800 dark:text-white">{{ $class->students->count() }}</dd>
                    </div>
                </dl>
            </div>

            @if($class->status === 'aktif')
            <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700 p-6">
                <h3 class="font-semibold text-gray-800 dark:text-white mb-4">Enroll ke Kelas</h3>
                
                @if($availableStudents->count() > 0)
                    <form method="POST" action="{{ route('admin.classes.enroll') }}" class="space-y-4">
                        @csrf
                        <input type="hidden" name="id_class" value="{{ $class->id }}">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                Pilih Murid ({{ $availableStudents->count() }} tersedia)
                            </label>
                            <div class="max-h-64 overflow-y-auto border border-gray-300 dark:border-gray-600 rounded-lg p-2 bg-white dark:bg-gray-700">
                                @foreach($availableStudents as $student)
                                    <label class="flex items-center gap-2 p-2 hover:bg-gray-100 dark:hover:bg-gray-600 rounded cursor-pointer">
                                        <input type="checkbox" name="student_ids[]" value="{{ $student->id }}"
                                               class="w-4 h-4 text-blue-600 rounded focus:ring-blue-500">
                                        <span class="text-sm text-gray-800 dark:text-white">{{ $student->nama_lengkap }}</span>
                                        <span class="text-xs text-gray-500 dark:text-gray-400">({{ $student->username }})</span>
                                    </label>
                                @endforeach
                            </div>
                            <p class="mt-1 text-xs text-gray-500 dark:text-gray-400">✓ Centang beberapa murid untuk menambahkan sekaligus</p>
                        </div>
                        <button type="submit" class="w-full px-4 py-2.5 text-sm font-medium text-white bg-blue-600 rounded-lg hover:bg-blue-700 transition">
                            Enroll {{ $availableStudents->count() > 1 ? 'Murid Terpilih' : 'Murid' }} ke Kelas
                        </button>
                    </form>
                @else
                    <div class="text-center py-4">
                        <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/>
                        </svg>
                        <p class="mt-2 text-sm text-gray-500 dark:text-gray-400">Tidak ada murid tersedia</p>
                        <p class="text-xs text-gray-400 dark:text-gray-500 mt-1">
                            Hanya murid yang mendaftar {{ $class->course->nama_bahasa }} yang muncul di sini
                        </p>
                    </div>
                @endif
            </div>
            @endif
        </div>
    </div>
</x-layouts.lms>
