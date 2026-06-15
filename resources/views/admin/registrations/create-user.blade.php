<x-layouts.lms>
    <x-slot name="sidebar">
        @include('layouts.sidebar-admin')
    </x-slot>

    <div class="mb-6">
        <a href="{{ route('admin.registrations.show', $registration) }}" class="text-blue-600 dark:text-blue-400 hover:underline text-sm mb-4 inline-block">
            ← Kembali ke Detail Pendaftaran
        </a>
        <h1 class="text-2xl font-bold text-gray-800 dark:text-white">Buat Akun User</h1>
        <p class="text-gray-500 dark:text-gray-400 mt-1">Untuk: {{ $registration->nama }}</p>
    </div>

    <div class="max-w-2xl bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700 p-6">
        <form method="POST" action="{{ route('admin.registrations.store-user', $registration) }}" class="space-y-6">
            @csrf

            <div>
                <label for="username" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                    Username *
                </label>
                <input type="text"
                       id="username"
                       name="username"
                       value="{{ old('username') }}"
                       required
                       class="w-full px-4 py-3 rounded-lg border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-800 dark:text-white focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('username') border-red-500 @enderror">
                @error('username')
                    <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                    Role *
                </label>
                <select id="role" name="role" required class="w-full px-4 py-3 rounded-lg border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-800 dark:text-white focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('role') border-red-500 @enderror">
                    <option value="murid" {{ old('role') === 'murid' ? 'selected' : '' }}>Murid (Student)</option>
                    <option value="guru" {{ old('role') === 'guru' ? 'selected' : '' }}>Guru (Teacher)</option>
                    <option value="admin" {{ old('role') === 'admin' ? 'selected' : '' }}>Admin</option>
                </select>
                @error('role')
                    <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                @enderror
            </div>

            <div id="classSelect" style="display: none;">
                <label for="id_class" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                    Pilih Kelas
                </label>
                <div class="bg-blue-50 dark:bg-blue-900/20 border border-blue-200 dark:border-blue-800 rounded-lg p-3 mb-2">
                    <p class="text-xs text-blue-700 dark:text-blue-300">
                        <span class="font-semibold">Info:</span> Murid ini mendaftar untuk kursus 
                        <strong>{{ $registration->kursus_pilihan === 'eng' ? 'Bahasa Inggris' : ($registration->kursus_pilihan === 'kor' ? 'Bahasa Korea' : 'Bahasa Thailand') }}</strong>
                        (Tingkat: <strong>{{ $registration->tingkat_bahasa ?? '-' }}</strong>)
                    </p>
                </div>
                <select id="id_class" name="id_class" class="w-full px-4 py-3 rounded-lg border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-800 dark:text-white focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                    <option value="">-- Pilih Kelas --</option>
                    @php
                        $courseCode = $registration->kursus_pilihan;
                        $filteredClasses = $courses->filter(fn($c) => $c->kode === $courseCode);
                    @endphp
                    @if($filteredClasses->isEmpty())
                        <option value="" disabled>Tidak ada kelas tersedia untuk {{ $registration->kursus_pilihan === 'eng' ? 'Bahasa Inggris' : ($registration->kursus_pilihan === 'kor' ? 'Bahasa Korea' : 'Bahasa Thailand') }}</option>
                    @else
                        @foreach($filteredClasses as $course)
                            @if($course->classes->isNotEmpty())
                                <optgroup label="{{ $course->nama_bahasa }}">
                                    @foreach($course->classes as $class)
                                        <option value="{{ $class->id }}">{{ $class->nama_kelas }} - {{ $class->periode }} ({{ $class->students->count() }} murid)</option>
                                    @endforeach
                                </optgroup>
                            @endif
                        @endforeach
                    @endif
                </select>
                @error('id_class')
                    <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label for="password" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                    Password *
                </label>
                <input type="password"
                       id="password"
                       name="password"
                       required
                       class="w-full px-4 py-3 rounded-lg border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-800 dark:text-white focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('password') border-red-500 @enderror">
                @error('password')
                    <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label for="password_confirmation" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                    Konfirmasi Password *
                </label>
                <input type="password"
                       id="password_confirmation"
                       name="password_confirmation"
                       required
                       class="w-full px-4 py-3 rounded-lg border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-800 dark:text-white focus:ring-2 focus:ring-blue-500 focus:border-transparent">
            </div>

            <div class="flex gap-4 pt-4">
                <button type="submit" class="inline-flex items-center gap-2 px-6 py-3 text-sm font-medium text-white bg-green-600 rounded-lg hover:bg-green-700 transition">
                    ✓ Buat Akun
                </button>
                <a href="{{ route('admin.registrations.show', $registration) }}"
                   class="inline-flex items-center gap-2 px-6 py-3 text-sm font-medium text-gray-700 dark:text-gray-300 bg-white dark:bg-gray-700 border border-gray-300 dark:border-gray-600 rounded-lg hover:bg-gray-50 dark:hover:bg-gray-600 transition">
                    Batal
                </a>
            </div>
        </form>
    </div>
</x-layouts.lms>

<script>
document.getElementById('role').addEventListener('change', function() {
    const classSelect = document.getElementById('classSelect');
    classSelect.style.display = this.value === 'murid' ? 'block' : 'none';
    if (this.value !== 'murid') {
        document.getElementById('id_class').value = '';
    }
});

// Trigger change on load
document.getElementById('role').dispatchEvent(new Event('change'));
</script>
