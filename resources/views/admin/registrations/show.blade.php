<x-layouts.lms>
    <x-slot name="sidebar">
        @include('layouts.sidebar-admin')
    </x-slot>

    <div class="mb-6">
        <a href="{{ route('admin.registrations.index') }}" class="text-blue-600 dark:text-blue-400 hover:underline text-sm mb-4 inline-block">
            ← Kembali ke Daftar Pendaftaran
        </a>
        <h1 class="text-2xl font-bold text-gray-800 dark:text-white">Detail Pendaftaran</h1>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700 p-6">
            <h2 class="text-lg font-semibold text-gray-800 dark:text-white mb-4">Informasi Pendaftar</h2>
            
            <dl class="space-y-4">
                <div>
                    <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Nama Lengkap</dt>
                    <dd class="mt-1 text-lg text-gray-800 dark:text-white">{{ $registration->nama }}</dd>
                </div>
                <div>
                    <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Email</dt>
                    <dd class="mt-1 text-lg text-gray-800 dark:text-white">{{ $registration->email }}</dd>
                </div>
                <div>
                    <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">No. Telepon</dt>
                    <dd class="mt-1 text-lg text-gray-800 dark:text-white">{{ $registration->no_telp ?? '-' }}</dd>
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
                    <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Tingkat Bahasa</dt>
                    <dd class="mt-1 text-lg text-gray-800 dark:text-white">{{ $registration->tingkat_bahasa ?? '-' }}</dd>
                </div>
                <div>
                    <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Status</dt>
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
        </div>

        <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700 p-6">
            <h2 class="text-lg font-semibold text-gray-800 dark:text-white mb-4">Bukti Pembayaran</h2>
            
            @if(str_starts_with($registration->bukti_bayar_url, 'http'))
                <img src="{{ $registration->bukti_bayar_url }}" alt="Bukti Pembayaran" class="w-full rounded-lg border border-gray-200 dark:border-gray-700">
            @else
                <img src="/storage/{{ $registration->bukti_bayar_url }}" alt="Bukti Pembayaran" class="w-full rounded-lg border border-gray-200 dark:border-gray-700">
            @endif
        </div>
    </div>

    <div class="mt-6 bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700 p-6">
        <h2 class="text-lg font-semibold text-gray-800 dark:text-white mb-4">Bukti Kemampuan Dasar</h2>

        @php $wajib = $registration->isBuktiKemampuanRequired(); @endphp

        @if($wajib)
            @if($registration->bukti_kemampuan_dasar)
                @php
                    $buktiUrl = str_starts_with($registration->bukti_kemampuan_dasar, 'http')
                        ? $registration->bukti_kemampuan_dasar
                        : '/storage/' . $registration->bukti_kemampuan_dasar;
                @endphp
                <img src="{{ $buktiUrl }}" alt="Bukti Kemampuan Dasar" class="w-full max-w-md rounded-lg border border-gray-200 dark:border-gray-700">
                <div class="mt-3 flex flex-wrap gap-2">
                    <a href="{{ $buktiUrl }}" target="_blank" class="inline-flex items-center gap-1 px-3 py-1.5 text-xs font-medium text-blue-700 bg-blue-50 rounded-lg hover:bg-blue-100 transition">
                        Lihat Gambar
                    </a>
                    <a href="{{ $buktiUrl }}" target="_blank" class="inline-flex items-center gap-1 px-3 py-1.5 text-xs font-medium text-green-700 bg-green-50 rounded-lg hover:bg-green-100 transition">
                        Perbesar Gambar
                    </a>
                    <a href="{{ $buktiUrl }}" download class="inline-flex items-center gap-1 px-3 py-1.5 text-xs font-medium text-purple-700 bg-purple-50 rounded-lg hover:bg-purple-100 transition">
                        Download
                    </a>
                </div>
            @else
                <p class="text-yellow-600 dark:text-yellow-400">Bukti kemampuan dasar belum diunggah</p>
            @endif
        @else
            <p class="text-gray-500 dark:text-gray-400">Tidak diperlukan (Level Dasar)</p>
        @endif
    </div>

    @if(in_array($registration->status, ['pending', 'rejected']))
        <div class="mt-6 bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700 p-6"
             x-data="{ status: '{{ old('status', $registration->status) }}' }">
            <h2 class="text-lg font-semibold text-gray-800 dark:text-white mb-4">Verifikasi Pendaftaran</h2>
            
            <form method="POST" action="{{ route('admin.registrations.verify', $registration) }}" class="space-y-4">
                @csrf
                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Status Verifikasi</label>
                    <div class="flex gap-4">
                        <label class="flex items-center">
                            <input type="radio" name="status" value="verified" x-model="status" class="w-4 h-4 text-green-600 border-gray-300 focus:ring-green-500" required>
                            <span class="ml-2 text-gray-700 dark:text-gray-300">Terima (Verified)</span>
                        </label>
                        <label class="flex items-center">
                            <input type="radio" name="status" value="rejected" x-model="status" class="w-4 h-4 text-red-600 border-gray-300 focus:ring-red-500" required>
                            <span class="ml-2 text-gray-700 dark:text-gray-300">Tolak (Rejected)</span>
                        </label>
                    </div>
                </div>
                <div x-show="status === 'rejected'"
                     x-transition:enter="transition ease-out duration-300"
                     x-transition:enter-start="opacity-0 transform -translate-y-2"
                     x-transition:enter-end="opacity-100 transform translate-y-0"
                     x-transition:leave="transition ease-in duration-200"
                     x-transition:leave-start="opacity-100 transform translate-y-0"
                     x-transition:leave-end="opacity-0 transform -translate-y-2">
                    <label for="admin_notes" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                        Catatan Admin <span class="text-red-500">*</span>
                    </label>
                    <textarea id="admin_notes" name="admin_notes" rows="3" x-bind:required="status === 'rejected'"
                              class="w-full px-4 py-3 rounded-lg border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-800 dark:text-white focus:ring-2 focus:ring-blue-500 focus:border-transparent">{{ old('admin_notes', $registration->admin_notes) }}</textarea>
                    @error('admin_notes')
                        <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                    @enderror
                </div>
                <button type="submit" class="inline-flex items-center gap-2 px-6 py-2.5 text-sm font-medium text-white bg-blue-600 rounded-lg hover:bg-blue-700 transition">
                    Simpan Verifikasi
                </button>
            </form>
        </div>
    @endif

    @if($registration->status === 'verified' && !$registration->user_id)
        <div class="mt-6 bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700 p-6">
            <h2 class="text-lg font-semibold text-gray-800 dark:text-white mb-4">Buat Akun User</h2>
            <a href="{{ route('admin.registrations.create-user', $registration) }}" 
               class="inline-flex items-center gap-2 px-6 py-2.5 text-sm font-medium text-white bg-green-600 rounded-lg hover:bg-green-700 transition">
                Buat Akun untuk {{ $registration->nama }}
            </a>
        </div>
    @endif
</x-layouts.lms>
