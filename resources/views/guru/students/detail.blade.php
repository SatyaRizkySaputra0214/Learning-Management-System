<x-layouts.lms>
    <x-slot name="sidebar">
        @include('layouts.sidebar-guru')
    </x-slot>

    <div class="mb-6">
        <a href="{{ route('guru.classes.show', $class) }}" class="text-blue-600 dark:text-blue-400 hover:underline text-sm mb-4 inline-block">
            ← Kembali ke Detail Kelas
        </a>
        <h1 class="text-2xl font-bold text-gray-800 dark:text-white">Data Murid</h1>
        <p class="text-gray-500 dark:text-gray-400 mt-1">{{ $student->nama_lengkap }}</p>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        <!-- Informasi Akun -->
        <div class="bg-white dark:bg-gray-800 rounded-lg shadow-sm border border-gray-200 dark:border-gray-700 p-6">
            <h2 class="text-lg font-semibold text-gray-800 dark:text-white mb-4">Informasi Akun</h2>

            <dl class="space-y-4">
                <div>
                    <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Nama Lengkap</dt>
                    <dd class="mt-1 text-lg text-gray-800 dark:text-white">{{ $student->nama_lengkap }}</dd>
                </div>
                <div>
                    <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Username</dt>
                    <dd class="mt-1 text-lg text-gray-800 dark:text-white">{{ $student->username }}</dd>
                </div>
                <div>
                    <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Email</dt>
                    <dd class="mt-1 text-lg text-gray-800 dark:text-white">{{ $student->email }}</dd>
                </div>
                <div>
                    <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Role</dt>
                    <dd class="mt-1">
                        <span class="px-3 py-1 rounded-full text-sm font-medium bg-purple-100 text-purple-800 dark:bg-purple-900 dark:text-purple-200">
                            {{ ucfirst($student->role) }}
                        </span>
                    </dd>
                </div>
            </dl>
        </div>

        <!-- Informasi Pendaftaran -->
        <div class="bg-white dark:bg-gray-800 rounded-lg shadow-sm border border-gray-200 dark:border-gray-700 p-6">
            <h2 class="text-lg font-semibold text-gray-800 dark:text-white mb-4">Informasi Pendaftaran</h2>

            @if($registration)
                <dl class="space-y-4">
                    <div>
                        <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">No. Telepon</dt>
                        <dd class="mt-1 text-lg text-gray-800 dark:text-white">{{ $registration->no_telp ?? '-' }}</dd>
                    </div>
                    <div>
                        <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Email (saat daftar)</dt>
                        <dd class="mt-1 text-lg text-gray-800 dark:text-white">{{ $registration->email }}</dd>
                    </div>
                    <div>
                        <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Kursus Pilihan</dt>
                        <dd class="mt-1">
                            <span class="px-3 py-1 rounded-full text-sm font-medium
                                @if($registration->kursus_pilihan === 'eng') bg-blue-100 text-blue-800 dark:bg-blue-900 dark:text-blue-200
                                @elseif($registration->kursus_pilihan === 'kor') bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-200
                                @else bg-purple-100 text-purple-800 dark:bg-purple-900 dark:text-purple-200
                                @endif">
                                {{ $registration->kursus_label }}
                            </span>
                        </dd>
                    </div>
                    <div>
                        <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Tanggal Daftar</dt>
                        <dd class="mt-1 text-gray-800 dark:text-white">{{ $registration->created_at->format('d M Y, H:i') }}</dd>
                    </div>
                    <div>
                        <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Status Pendaftaran</dt>
                        <dd class="mt-1">
                            <span class="px-3 py-1 rounded-full text-sm font-medium
                                @if($registration->status === 'verified') bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-200
                                @elseif($registration->status === 'rejected') bg-red-100 text-red-800 dark:bg-red-900 dark:text-red-200
                                @else bg-yellow-100 text-yellow-800 dark:bg-yellow-900 dark:text-yellow-200
                                @endif">
                                {{ ucfirst($registration->status) }}
                            </span>
                        </dd>
                    </div>
                    @if($registration->admin_notes)
                        <div>
                            <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Catatan Admin</dt>
                            <dd class="mt-1 text-gray-800 dark:text-white">{{ $registration->admin_notes }}</dd>
                        </div>
                    @endif
                </dl>
            @else
                <p class="text-gray-500 dark:text-gray-400 text-sm">Data pendaftaran tidak ditemukan. Murid mungkin dibuat langsung oleh admin.</p>
            @endif
        </div>
    </div>

    <!-- Informasi Kelas -->
    <div class="mt-6 bg-white dark:bg-gray-800 rounded-lg shadow-sm border border-gray-200 dark:border-gray-700 p-6">
        <h2 class="text-lg font-semibold text-gray-800 dark:text-white mb-4">Informasi Kelas Saat Ini</h2>

        <dl class="space-y-4">
            <div>
                <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Nama Kelas</dt>
                <dd class="mt-1 text-gray-800 dark:text-white">{{ $class->nama_kelas }}</dd>
            </div>
            <div>
                <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Kursus</dt>
                <dd class="mt-1 text-gray-800 dark:text-white">{{ $class->course->nama_bahasa }}</dd>
            </div>
            <div>
                <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Periode</dt>
                <dd class="mt-1 text-gray-800 dark:text-white">{{ $class->periode }}</dd>
            </div>
            <div>
                <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Status Kelas</dt>
                <dd class="mt-1">
                    <span class="px-3 py-1 rounded-full text-sm font-medium
                        @if($class->status === 'aktif') bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-200
                        @else bg-gray-100 text-gray-800 dark:bg-gray-700 dark:text-gray-200
                        @endif">
                        {{ ucfirst($class->status) }}
                    </span>
                </dd>
            </div>
        </dl>
    </div>

</x-layouts.lms>
