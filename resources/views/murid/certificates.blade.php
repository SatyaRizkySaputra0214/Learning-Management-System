<x-layouts.lms>
    <x-slot name="sidebar">
        @include('layouts.sidebar-murid')
    </x-slot>

    <div class="mb-6">
        <h1 class="text-2xl font-bold text-gray-800 dark:text-white">Sertifikat Saya</h1>
        <p class="text-gray-500 dark:text-gray-400 mt-1">Sertifikat kelulusan Anda</p>
    </div>

    @if($certificates->count() > 0)
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
            @foreach($certificates as $certificate)
                <div class="bg-white dark:bg-gray-800 rounded-xl shadow-md border border-gray-200 dark:border-gray-700 p-4 hover:shadow-lg transition">
                    <div class="flex items-center justify-between mb-3">
                        <div class="flex-1 min-w-0">
                            <h3 class="text-base font-semibold text-gray-800 dark:text-white truncate">{{ $certificate->class->nama_kelas }}</h3>
                            <p class="text-xs text-gray-500 dark:text-gray-400">{{ $certificate->class->course->nama_bahasa }}</p>
                        </div>
                        <svg class="w-8 h-8 text-yellow-500 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M6.267 3.455a3.066 3.066 0 001.745-.723 3.066 3.066 0 013.976 0 3.066 3.066 0 001.745.723 3.066 3.066 0 012.812 2.812c.051.643.304 1.254.723 1.745a3.066 3.066 0 010 3.976 3.066 3.066 0 00-.723 1.745 3.066 3.066 0 01-2.812 2.812 3.066 3.066 0 00-1.745.723 3.066 3.066 0 01-3.976 0 3.066 3.066 0 00-1.745-.723 3.066 3.066 0 01-2.812-2.812 3.066 3.066 0 00-.723-1.745 3.066 3.066 0 010-3.976 3.066 3.066 0 00.723-1.745 3.066 3.066 0 012.812-2.812zm7.44 5.252a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                        </svg>
                    </div>

                    <div class="space-y-2 mb-4">
                        <div class="flex items-center justify-between text-xs">
                            <span class="text-gray-500 dark:text-gray-400">Nomor:</span>
                            <span class="text-gray-800 dark:text-white font-mono">{{ $certificate->nomor_sertifikat }}</span>
                        </div>
                        <div class="flex items-center justify-between text-xs">
                            <span class="text-gray-500 dark:text-gray-400">Tanggal:</span>
                            <span class="text-gray-800 dark:text-white">{{ $certificate->tgl_terbit->format('d M Y') }}</span>
                        </div>
                    </div>

                    <a href="{{ route('murid.certificate.download', $certificate) }}"
                       class="block text-center bg-blue-600 hover:bg-blue-700 text-white py-2 rounded-lg transition text-sm font-medium">
                        📄 Download Sertifikat
                    </a>
                </div>
            @endforeach
        </div>
    @else
        <div class="bg-white dark:bg-gray-800 rounded-xl shadow-md border border-gray-200 dark:border-gray-700 p-12 text-center">
            <svg class="mx-auto h-16 w-16 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
            </svg>
            <h3 class="text-lg font-semibold text-gray-700 dark:text-gray-300 mb-2 mt-4">Belum Ada Sertifikat</h3>
            <p class="text-gray-500 dark:text-gray-400">Anda belum memiliki sertifikat. Selesaikan kelas untuk mendapatkan sertifikat!</p>
        </div>
    @endif
</x-layouts.lms>
