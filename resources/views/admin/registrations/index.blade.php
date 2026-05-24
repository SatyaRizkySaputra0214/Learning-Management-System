<x-layouts.lms>
    <x-slot name="sidebar">
        @include('layouts.sidebar-admin')
    </x-slot>

    <div class="mb-6">
        <div class="flex items-center justify-between">
            <div>
                <h1 class="text-2xl font-bold text-gray-800 dark:text-white">Verifikasi Pendaftaran</h1>
                <p class="text-gray-500 dark:text-gray-400 mt-1">Kelola pendaftaran murid baru</p>
            </div>
        </div>
    </div>

    <!-- Search & Filter -->
    <div class="mb-6 bg-white dark:bg-gray-800 rounded-lg shadow-sm border border-gray-200 dark:border-gray-700 p-4">
        <form method="GET" action="{{ route('admin.registrations.index') }}" class="flex flex-wrap items-end gap-3">
            <!-- Search Input -->
            <div class="flex-1 min-w-[200px] relative">
                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                    <svg class="h-4 w-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                    </svg>
                </div>
                <input type="text" name="search" value="{{ request('search') }}" 
                       placeholder="Cari nama atau email..."
                       class="w-full pl-10 pr-3 py-2 text-sm rounded-lg border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-800 dark:text-white focus:ring-2 focus:ring-blue-500 focus:border-transparent">
            </div>
            
            <!-- Status Filter -->
            <div class="w-[150px]">
                <select name="status" class="w-full px-3 py-2 text-sm rounded-lg border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-800 dark:text-white focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                    <option value="">Status</option>
                    <option value="pending" {{ request('status') === 'pending' ? 'selected' : '' }}>Pending</option>
                    <option value="verified" {{ request('status') === 'verified' ? 'selected' : '' }}>Verified</option>
                    <option value="rejected" {{ request('status') === 'rejected' ? 'selected' : '' }}>Rejected</option>
                </select>
            </div>
            
            <!-- Course Filter -->
            <div class="w-[160px]">
                <select name="kursus" class="w-full px-3 py-2 text-sm rounded-lg border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-800 dark:text-white focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                    <option value="">Kursus</option>
                    <option value="eng" {{ request('kursus') === 'eng' ? 'selected' : '' }}>Inggris</option>
                    <option value="kor" {{ request('kursus') === 'kor' ? 'selected' : '' }}>Korea</option>
                    <option value="th" {{ request('kursus') === 'th' ? 'selected' : '' }}>Thailand</option>
                </select>
            </div>
            
            <!-- Action Buttons -->
            <div class="flex gap-2">
                <button type="submit" class="px-4 py-2 text-sm bg-blue-500 text-gray-100 rounded-lg hover:bg-blue-600 transition font-medium !important" style="background-color: #3b82f6 !important; color: #f3f4f6 !important;">
                    Filter
                </button>
                <a href="{{ route('admin.registrations.index') }}" class="px-4 py-2 text-sm bg-red-500 text-gray-100 rounded-lg hover:bg-red-600 transition font-medium !important" style="background-color: #ef4444 !important; color: #f3f4f6 !important;">
                    Reset
                </a>
            </div>
            
            @if(request('search') || request('status') || request('kursus'))
                <span class="text-xs text-gray-500 dark:text-gray-400 flex items-center gap-1">
                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/>
                    </svg>
                    {{ $registrations->total() }} hasil
                </span>
            @endif
        </form>
    </div>

    <div class="bg-white dark:bg-gray-800 rounded-lg shadow-sm border border-gray-200 dark:border-gray-700 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                <thead class="bg-gray-50 dark:bg-gray-700">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Nama</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Email</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">No. Telp</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Kursus</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Tingkat</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Status</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Tanggal</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Aksi</th>
                    </tr>
                </thead>
                <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
                    @forelse($registrations as $registration)
                        <tr class="hover:bg-gray-50 dark:hover:bg-gray-700">
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-800 dark:text-white">{{ $registration->nama }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600 dark:text-gray-300">{{ $registration->email }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600 dark:text-gray-300">{{ $registration->no_telp ?? '-' }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600 dark:text-gray-300">
                                <span class="px-2 py-1 rounded-full text-xs font-medium
                                    @if($registration->kursus_pilihan === 'eng') bg-blue-100 text-blue-800 dark:bg-blue-900 dark:text-blue-200
                                    @elseif($registration->kursus_pilihan === 'kor') bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-200
                                    @else bg-purple-100 text-purple-800 dark:bg-purple-900 dark:text-purple-200
                                    @endif">
                                    {{ $registration->kursus_label }}
                                </span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600 dark:text-gray-300">
                                {{ $registration->tingkat_bahasa ?? '-' }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm">
                                <span class="px-2 py-1 rounded-full text-xs font-medium
                                    @if($registration->status === 'verified') bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-200
                                    @elseif($registration->status === 'rejected') bg-red-100 text-red-800 dark:bg-red-900 dark:text-red-200
                                    @else bg-yellow-100 text-yellow-800 dark:bg-yellow-900 dark:text-yellow-200
                                    @endif">
                                    {{ ucfirst($registration->status) }}
                                </span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600 dark:text-gray-300">{{ $registration->created_at->format('d M Y') }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm flex gap-3">
                                <a href="{{ route('admin.registrations.show', $registration) }}" 
                                   class="text-blue-600 dark:text-blue-400 hover:underline">
                                    Detail
                                </a>
                                <x-confirm-modal
                                    action="{{ route('admin.registrations.delete', $registration) }}"
                                    title="Hapus Pendaftaran"
                                    message="Apakah Anda yakin ingin menghapus pendaftaran <strong>{{ $registration->nama }}</strong>?"
                                >
                                    <x-slot name="trigger">
                                        <button type="button" class="text-red-600 dark:text-red-400 hover:underline">
                                            Hapus
                                        </button>
                                    </x-slot>
                                </x-confirm-modal>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="px-6 py-8 text-center text-gray-500 dark:text-gray-400">
                                Belum ada data pendaftaran
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($registrations->hasPages())
            <div class="px-6 py-4 border-t border-gray-200 dark:border-gray-700">
                {{ $registrations->links() }}
            </div>
        @endif
    </div>
</x-layouts.lms>
