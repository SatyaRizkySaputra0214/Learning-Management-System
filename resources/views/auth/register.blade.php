@extends('components.layouts.auth-simple')

@section('title', 'Daftar - LMS Bahasa')

@section('content')
<div class="w-full max-w-md">
    <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-xl p-8 border border-gray-200 dark:border-gray-700">
        <div class="text-center mb-8">
            <div class="flex items-center justify-center mx-auto mb-4">
                <img src="{{ asset('Logo.png') }}" alt="Logo" class="w-20 h-20 object-contain">
            </div>
            <h1 class="text-2xl font-bold text-gray-800 dark:text-white">Pendaftaran</h1>
            <p class="text-gray-500 dark:text-gray-400 mt-2">Isi formulir untuk mendaftar</p>
        </div>

        <form method="POST" action="{{ route('registration.store') }}" enctype="multipart/form-data" class="space-y-6">
            @csrf
            
            <div>
                <label for="nama" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                    Nama Lengkap
                </label>
                <input type="text" 
                       id="nama" 
                       name="nama" 
                       value="{{ old('nama') }}"
                       required 
                       autofocus
                       class="w-full px-4 py-3 rounded-lg border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-800 dark:text-white focus:ring-2 focus:ring-blue-500 focus:border-transparent transition @error('nama') border-red-500 @enderror">
                @error('nama')
                    <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label for="email" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                    Email
                </label>
                <input type="email"
                       id="email"
                       name="email"
                       value="{{ old('email') }}"
                       required
                       class="w-full px-4 py-3 rounded-lg border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-800 dark:text-white focus:ring-2 focus:ring-blue-500 focus:border-transparent transition @error('email') border-red-500 @enderror">
                @error('email')
                    <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label for="no_telp" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                    No. Telepon
                </label>
                <input type="text"
                       id="no_telp"
                       name="no_telp"
                       value="{{ old('no_telp') }}"
                       required
                       placeholder="Contoh: 081234567890"
                       class="w-full px-4 py-3 rounded-lg border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-800 dark:text-white focus:ring-2 focus:ring-blue-500 focus:border-transparent transition @error('no_telp') border-red-500 @enderror">
                @error('no_telp')
                    <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label for="kursus_pilihan" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                    Kursus Bahasa
                </label>
                <select id="kursus_pilihan" 
                        name="kursus_pilihan" 
                        required
                        class="w-full px-4 py-3 rounded-lg border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-800 dark:text-white focus:ring-2 focus:ring-blue-500 focus:border-transparent transition @error('kursus_pilihan') border-red-500 @enderror">
                    <option value="">Pilih Kursus</option>
                    <option value="eng" {{ old('kursus_pilihan') === 'eng' ? 'selected' : '' }}>English</option>
                    <option value="kor" {{ old('kursus_pilihan') === 'kor' ? 'selected' : '' }}>Korean</option>
                    <option value="th" {{ old('kursus_pilihan') === 'th' ? 'selected' : '' }}>Thai</option>
                </select>
                @error('kursus_pilihan')
                    <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label for="tingkat_bahasa" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                    Tingkat Bahasa
                </label>
                <select id="tingkat_bahasa" 
                        name="tingkat_bahasa" 
                        required
                        class="w-full px-4 py-3 rounded-lg border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-800 dark:text-white focus:ring-2 focus:ring-blue-500 focus:border-transparent transition @error('tingkat_bahasa') border-red-500 @enderror">
                    <option value="">Pilih Tingkat</option>
                </select>
                @error('tingkat_bahasa')
                    <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                @enderror
            </div>

            <script>
                document.addEventListener('DOMContentLoaded', function() {
                    const kursusSelect = document.getElementById('kursus_pilihan');
                    const tingkatSelect = document.getElementById('tingkat_bahasa');
                    
                    const levels = {
                        'eng': [
                            { value: 'A1', label: 'A1' },
                            { value: 'A2', label: 'A2' },
                            { value: 'B1', label: 'B1' }
                        ],
                        'kor': [
                            { value: 'Beginner', label: 'Beginner' },
                            { value: 'Intermediate', label: 'Intermediate' }
                        ],
                        'th': [
                            { value: 'Beginner', label: 'Beginner' },
                            { value: 'Intermediate', label: 'Intermediate' }
                        ]
                    };

                    function updateLevels() {
                        const selectedKursus = kursusSelect.value;
                        const currentLevel = "{{ old('tingkat_bahasa') }}";
                        
                        // Clear current options except the first one
                        tingkatSelect.innerHTML = '<option value="">Pilih Tingkat</option>';
                        
                        if (selectedKursus && levels[selectedKursus]) {
                            levels[selectedKursus].forEach(level => {
                                const option = document.createElement('option');
                                option.value = level.value;
                                option.textContent = level.label;
                                if (level.value === currentLevel) {
                                    option.selected = true;
                                }
                                tingkatSelect.appendChild(option);
                            });
                        }
                    }

                    kursusSelect.addEventListener('change', updateLevels);
                    
                    // Initial update if old value exists
                    if (kursusSelect.value) {
                        updateLevels();
                    }
                });
            </script>

            <div>
                <label for="bukti_bayar" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                    Bukti Pembayaran
                </label>
                <input type="file" 
                       id="bukti_bayar" 
                       name="bukti_bayar" 
                       accept="image/*"
                       required 
                       class="w-full px-4 py-3 rounded-lg border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-800 dark:text-white focus:ring-2 focus:ring-blue-500 focus:border-transparent transition @error('bukti_bayar') border-red-500 @enderror">
                <p class="mt-1 text-xs text-gray-500 dark:text-gray-400">Format: JPG, PNG (Max. 2MB)</p>
                @error('bukti_bayar')
                    <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                @enderror
            </div>

            <button type="submit" 
                    class="w-full bg-gradient-to-r from-blue-500 to-purple-600 text-white font-semibold py-3 rounded-lg hover:from-blue-600 hover:to-purple-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 transition duration-200">
                Daftar
            </button>
        </form>

        <div class="mt-6 text-center">
            <p class="text-sm text-gray-600 dark:text-gray-400">
                Sudah punya akun?
                <a href="{{ route('login') }}" class="text-blue-600 dark:text-blue-400 hover:underline font-medium">
                    Login
                </a>
            </p>
        </div>
    </div>
</div>
@endsection
