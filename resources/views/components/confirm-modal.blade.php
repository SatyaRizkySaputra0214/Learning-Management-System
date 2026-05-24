@props([
    'action',
    'title' => 'Konfirmasi Hapus',
    'message' => 'Apakah Anda yakin ingin menghapus data ini?',
    'confirmText' => 'Hapus',
    'method' => 'DELETE',
])

<div x-data="{ open: false }" class="inline">
    <span @click.stop="open = true" class="cursor-pointer">
        {{ $trigger }}
    </span>

    <div x-show="open"
         @click.away="open = false"
         class="fixed inset-0 z-50 flex items-center justify-center"
         style="display: none;">
        <div class="fixed inset-0 bg-black bg-opacity-50 transition-opacity"></div>
        <div class="relative bg-white dark:bg-gray-800 rounded-lg shadow-xl max-w-md w-full mx-4 p-6">
            <div class="flex items-center gap-3 mb-4">
                <div class="w-10 h-10 rounded-full bg-red-100 dark:bg-red-900/30 flex items-center justify-center">
                    <svg class="w-5 h-5 text-red-600 dark:text-red-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>
                    </svg>
                </div>
                <h3 class="text-lg font-semibold text-gray-900 dark:text-white">{{ $title }}</h3>
            </div>
            <p class="text-gray-600 dark:text-gray-300 mb-6">
                {!! $message !!}
                <br>
                <span class="text-sm text-gray-500 dark:text-gray-400">Tindakan ini tidak dapat dibatalkan.</span>
            </p>
            <div class="flex gap-3 justify-end">
                <button @click="open = false"
                        class="px-4 py-2 text-sm font-medium text-gray-700 dark:text-gray-300 bg-gray-100 dark:bg-gray-700 rounded-md hover:bg-gray-200 dark:hover:bg-gray-600 transition">
                    Batal
                </button>
                <form method="POST" action="{{ $action }}" class="inline">
                    @csrf
                    @method($method)
                    <button type="submit"
                            class="inline-flex items-center gap-2 px-4 py-2 text-sm font-medium text-white bg-red-600 rounded-md hover:bg-red-700 transition">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                        </svg>
                        {{ $confirmText }}
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>
