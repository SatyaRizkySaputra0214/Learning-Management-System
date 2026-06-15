<x-layouts.lms>
    <x-slot name="sidebar">
        @include('layouts.sidebar-murid')
    </x-slot>

    <div class="mb-6">
        <a href="{{ route('murid.certificates') }}" class="text-blue-600 dark:text-blue-400 hover:underline text-sm mb-4 inline-block">← Kembali ke Daftar Sertifikat</a>
        <h1 class="text-2xl font-bold text-gray-800 dark:text-white">Sertifikat Saya</h1>
    </div>

    <div class="max-w-4xl mx-auto">
        <!-- Preview Halaman 1 (Depan) -->
        <div class="mb-8 bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700 p-8">
            <h2 class="text-lg font-semibold text-gray-800 dark:text-white mb-4 flex items-center gap-2">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                </svg>
                Halaman 1 - Depan (Kelulusan)
            </h2>

            <div class="border-4 border-double border-blue-500 rounded-lg p-8 text-center bg-gradient-to-br from-blue-50 to-purple-50 dark:from-gray-700 dark:to-gray-800">
                <div class="mb-4">
                    <img src="{{ asset('Logo.png') }}" alt="" class="w-24 h-24 mx-auto object-contain">
                </div>
                <h3 class="text-2xl font-bold text-gray-800 dark:text-white mb-6">SERTIFIKAT KELULUSAN</h3>
                <div class="my-6 border-t-2 border-gray-300 dark:border-gray-600"></div>
                <p class="text-gray-700 dark:text-gray-300 mb-4">Diberikan kepada:</p>
                <p class="text-3xl font-bold text-blue-600 dark:text-blue-400 mb-4">{{ $certificate->student->nama_lengkap }}</p>
                <p class="text-gray-700 dark:text-gray-300">Telah menyelesaikan kursus</p>
                <p class="text-xl font-semibold text-gray-800 dark:text-white mt-2">{{ $certificate->class->course->nama_bahasa }}</p>
                <p class="text-sm text-gray-500 dark:text-gray-400 mt-4">{{ $certificate->class->periode }}</p>
                <div class="mt-8 pt-8 border-t border-gray-300 dark:border-gray-600">
                    <p class="text-sm text-gray-500 dark:text-gray-400">Tanggal Terbit:</p>
                    <p class="text-gray-800 dark:text-white font-semibold">{{ $certificate->tgl_terbit->format('d F Y') }}</p>
                </div>
            </div>
        </div>

        <!-- Preview Halaman 2 (Belakang) -->
        <div class="mb-8 bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700 p-8">
            <h2 class="text-lg font-semibold text-gray-800 dark:text-white mb-4 flex items-center gap-2">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/>
                </svg>
                Halaman 2 - Rincian Nilai
            </h2>

            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                    <thead class="bg-gray-50 dark:bg-gray-700">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Element</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Nilai Angka</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Predikat</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
                        @php
                            $skills = [
                                'nilai_reading' => 'Reading',
                                'nilai_writing' => 'Writing',
                                'nilai_listening' => 'Listening',
                                'nilai_speaking' => 'Speaking',
                                'nilai_grammar' => 'Grammar'
                            ];
                        @endphp
                        @foreach($skills as $field => $name)
                            <tr>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-800 dark:text-white">{{ $name }}</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-800 dark:text-white">
                                    {{ $certificate->$field ?? '-' }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm">
                                    @if($certificate->$field)
                                        @php
                                            $grade = match(true) {
                                                $certificate->$field >= 90 => ['A', 'bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-200'],
                                                $certificate->$field >= 80 => ['B', 'bg-blue-100 text-blue-800 dark:bg-blue-900 dark:text-blue-200'],
                                                $certificate->$field >= 70 => ['C', 'bg-yellow-100 text-yellow-800 dark:bg-yellow-900 dark:text-yellow-200'],
                                                $certificate->$field >= 60 => ['D', 'bg-orange-100 text-orange-800 dark:bg-orange-900 dark:text-orange-200'],
                                                default => ['E', 'bg-red-100 text-red-800 dark:bg-red-900 dark:text-red-200'],
                                            };
                                        @endphp
                                        <span class="px-2 py-1 rounded-full text-xs font-semibold {{ $grade[1] }}">
                                            {{ $grade[0] }}
                                        </span>
                                    @else
                                        <span class="text-gray-400">-</span>
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                    <tfoot class="bg-gray-50 dark:bg-gray-700">
                        <tr>
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-semibold text-gray-800 dark:text-white">Rata-rata Total</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-bold text-blue-600 dark:text-blue-400">{{ $certificate->rata_rata_total ?? '-' }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm">
                                @if($certificate->rata_rata_total)
                                    @php
                                        $finalGrade = match(true) {
                                            $certificate->rata_rata_total >= 90 => ['A', 'bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-200'],
                                            $certificate->rata_rata_total >= 80 => ['B', 'bg-blue-100 text-blue-800 dark:bg-blue-900 dark:text-blue-200'],
                                            $certificate->rata_rata_total >= 70 => ['C', 'bg-yellow-100 text-yellow-800 dark:bg-yellow-900 dark:text-yellow-200'],
                                            $certificate->rata_rata_total >= 60 => ['D', 'bg-orange-100 text-orange-800 dark:bg-orange-900 dark:text-orange-200'],
                                            default => ['E', 'bg-red-100 text-red-800 dark:bg-red-900 dark:text-red-200'],
                                        };
                                    @endphp
                                    <span class="px-3 py-1 rounded-full text-sm font-bold {{ $finalGrade[1] }}">
                                        {{ $finalGrade[0] }}
                                    </span>
                                @endif
                            </td>
                        </tr>
                    </tfoot>
                </table>
            </div>
        </div>

        <!-- Action Buttons -->
        <div class="flex gap-4">
            <button onclick="window.print()" class="flex-1 bg-blue-600 text-white px-6 py-3 rounded-lg hover:bg-blue-700 transition font-medium flex items-center justify-center gap-2">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"/>
                </svg>
                Cetak Sertifikat
            </button>
            <a href="{{ route('murid.certificates') }}" class="flex-1 bg-red-500 text-white px-6 py-3 rounded-lg hover:bg-red-600 transition font-medium text-center">
                ← Kembali
            </a>
        </div>
    </div>
</x-layouts.lms>

<style>
@media print {
    body * {
        visibility: hidden;
    }
    .mb-8:first-child, .mb-8:first-child * {
        visibility: visible;
    }
    .mb-8:first-child {
        position: absolute;
        left: 0;
        top: 0;
        width: 100%;
    }
}
</style>
