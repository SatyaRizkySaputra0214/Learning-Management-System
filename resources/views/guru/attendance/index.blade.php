<x-layouts.lms>
    <x-slot name="sidebar">
        @include('layouts.sidebar-guru')
    </x-slot>

    <div class="mb-6">
        <a href="{{ route('guru.classes.show', $meeting->class) }}" class="text-blue-600 dark:text-blue-400 hover:underline text-sm mb-4 inline-block">
            ← Kembali ke Kelas
        </a>
        <h1 class="text-2xl font-bold text-gray-800 dark:text-white">Check Kehadiran</h1>
        <p class="text-gray-500 dark:text-gray-400 mt-1">
            Pertemuan {{ $meeting->urutan_pertemuan }} - {{ $meeting->judul_pertemuan }}
        </p>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-4 gap-6 mb-6">
        <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700 p-4">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm text-gray-500 dark:text-gray-400">Hadir</p>
                    <p class="text-2xl font-bold text-green-600 dark:text-green-400">{{ $attendanceStats['hadir'] }}</p>
                </div>
                <div class="w-12 h-12 bg-green-100 dark:bg-green-900 rounded-lg flex items-center justify-center">
                    <svg class="w-6 h-6 text-green-600 dark:text-green-400" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/>
                    </svg>
                </div>
            </div>
        </div>

        <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700 p-4">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm text-gray-500 dark:text-gray-400">Izin</p>
                    <p class="text-2xl font-bold text-yellow-600 dark:text-yellow-400">{{ $attendanceStats['izin'] }}</p>
                </div>
                <div class="w-12 h-12 bg-yellow-100 dark:bg-yellow-900 rounded-lg flex items-center justify-center">
                    <svg class="w-6 h-6 text-yellow-600 dark:text-yellow-400" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"/>
                    </svg>
                </div>
            </div>
        </div>

        <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700 p-4">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm text-gray-500 dark:text-gray-400">Sakit</p>
                    <p class="text-2xl font-bold text-blue-600 dark:text-blue-400">{{ $attendanceStats['sakit'] }}</p>
                </div>
                <div class="w-12 h-12 bg-blue-100 dark:bg-blue-900 rounded-lg flex items-center justify-center">
                    <svg class="w-6 h-6 text-blue-600 dark:text-blue-400" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"/>
                    </svg>
                </div>
            </div>
        </div>

        <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700 p-4">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm text-gray-500 dark:text-gray-400">Alfa</p>
                    <p class="text-2xl font-bold text-red-600 dark:text-red-400">{{ $attendanceStats['alfa'] }}</p>
                </div>
                <div class="w-12 h-12 bg-red-100 dark:bg-red-900 rounded-lg flex items-center justify-center">
                    <svg class="w-6 h-6 text-red-600 dark:text-red-400" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"/>
                    </svg>
                </div>
            </div>
        </div>
    </div>

    <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700 p-6">
        <form method="POST" action="{{ route('guru.attendance.mark', $meeting) }}">
            @csrf

            <div class="overflow-x-auto">
                <table class="w-full">
                    <thead>
                        <tr class="border-b border-gray-200 dark:border-gray-700">
                            <th class="text-left py-3 px-4 text-sm font-semibold text-gray-700 dark:text-gray-300">No</th>
                            <th class="text-left py-3 px-4 text-sm font-semibold text-gray-700 dark:text-gray-300">Nama Murid</th>
                            <th class="text-center py-3 px-4 text-sm font-semibold text-gray-700 dark:text-gray-300">Status Kehadiran</th>
                            <th class="text-left py-3 px-4 text-sm font-semibold text-gray-700 dark:text-gray-300">Keterangan</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($meeting->class->students as $index => $student)
                            @php
                                $attendance = $meeting->attendances->firstWhere('id_student', $student->id);
                                $currentStatus = $attendance?->status ?? 'hadir';
                                $currentKeterangan = $attendance?->keterangan ?? '';
                            @endphp

                            <tr class="border-b border-gray-100 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-700">
                                <td class="py-4 px-4 text-sm text-gray-700 dark:text-gray-300">{{ $index + 1 }}</td>
                                <td class="py-4 px-4 text-sm text-gray-700 dark:text-gray-300">
                                    <div class="flex items-center gap-3">
                                        <div class="w-8 h-8 bg-purple-500 rounded-full flex items-center justify-center text-white text-sm font-semibold">
                                            {{ strtoupper(substr($student->nama_lengkap, 0, 1)) }}
                                        </div>
                                        {{ $student->nama_lengkap }}
                                    </div>
                                </td>
                                <td class="py-4 px-4">
                                    <input type="hidden" name="attendances[{{ $index }}][id_student]" value="{{ $student->id }}">
                                    <div class="flex items-center justify-center gap-2">
                                        <label class="flex items-center gap-1 cursor-pointer">
                                            <input type="radio" name="attendances[{{ $index }}][status]" value="hadir"
                                                {{ $currentStatus === 'hadir' ? 'checked' : '' }}
                                                class="text-green-600 focus:ring-green-500">
                                            <span class="text-xs text-green-600 dark:text-green-400">H</span>
                                        </label>
                                        <label class="flex items-center gap-1 cursor-pointer">
                                            <input type="radio" name="attendances[{{ $index }}][status]" value="izin"
                                                {{ $currentStatus === 'izin' ? 'checked' : '' }}
                                                class="text-yellow-600 focus:ring-yellow-500">
                                            <span class="text-xs text-yellow-600 dark:text-yellow-400">I</span>
                                        </label>
                                        <label class="flex items-center gap-1 cursor-pointer">
                                            <input type="radio" name="attendances[{{ $index }}][status]" value="sakit"
                                                {{ $currentStatus === 'sakit' ? 'checked' : '' }}
                                                class="text-blue-600 focus:ring-blue-500">
                                            <span class="text-xs text-blue-600 dark:text-blue-400">S</span>
                                        </label>
                                        <label class="flex items-center gap-1 cursor-pointer">
                                            <input type="radio" name="attendances[{{ $index }}][status]" value="alfa"
                                                {{ $currentStatus === 'alfa' ? 'checked' : '' }}
                                                class="text-red-600 focus:ring-red-500">
                                            <span class="text-xs text-red-600 dark:text-red-400">A</span>
                                        </label>
                                    </div>
                                </td>
                                <td class="py-4 px-4">
                                    <input type="text"
                                           name="attendances[{{ $index }}][keterangan]"
                                           value="{{ $currentKeterangan }}"
                                           placeholder="Tambah keterangan..."
                                           class="w-full px-3 py-2 text-sm border border-gray-300 dark:border-gray-600 rounded-lg bg-white dark:bg-gray-700 text-gray-800 dark:text-white focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            @if($meeting->class->students->count() > 0)
                <div class="mt-6 flex items-center justify-between">
                    <button type="button" onclick="setAllStatus('hadir')"
                            class="text-sm text-green-600 dark:text-green-400 hover:underline font-medium">
                        ✓ Tandai Semua Hadir
                    </button>
                    <button type="submit"
                            class="bg-green-600 text-white px-6 py-3 rounded-lg hover:bg-green-700 transition font-medium">
                        ✓ Simpan Kehadiran
                    </button>
                </div>
            @else
                <div class="text-center py-8">
                    <p class="text-gray-500 dark:text-gray-400">Belum ada murid di kelas ini.</p>
                </div>
            @endif
        </form>
    </div>
</x-layouts.lms>

<script>
function setAllStatus(status) {
    const radioButtons = document.querySelectorAll('input[type="radio"][name*="[status]"]');
    radioButtons.forEach(radio => {
        if (radio.value === status) {
            radio.checked = true;
        }
    });
}
</script>
