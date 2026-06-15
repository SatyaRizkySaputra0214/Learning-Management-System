@props(['type' => 'info', 'message' => null])

@php
$colors = [
    'success' => ['bg' => 'bg-green-50 dark:bg-green-900/30', 'border' => 'border-green-500', 'text' => 'text-green-700 dark:text-green-300', 'icon' => 'text-green-500'],
    'error' => ['bg' => 'bg-red-50 dark:bg-red-900/30', 'border' => 'border-red-500', 'text' => 'text-red-700 dark:text-red-300', 'icon' => 'text-red-500'],
    'warning' => ['bg' => 'bg-yellow-50 dark:bg-yellow-900/30', 'border' => 'border-yellow-500', 'text' => 'text-yellow-700 dark:text-yellow-300', 'icon' => 'text-yellow-500'],
    'info' => ['bg' => 'bg-blue-50 dark:bg-blue-900/30', 'border' => 'border-blue-500', 'text' => 'text-blue-700 dark:text-blue-300', 'icon' => 'text-blue-500'],
];

$autoDismiss = in_array($type, ['success', 'info']);
$c = $colors[$type];
@endphp

<div x-data="{
    show: true,
    init() {
        @if($autoDismiss)
            setTimeout(() => { this.show = false }, 4000);
        @endif
    }
}"
     x-show="show"
     x-transition:enter="transition ease-out duration-300"
     x-transition:enter-start="opacity-0 transform -translate-y-2"
     x-transition:enter-end="opacity-100 transform translate-y-0"
     x-transition:leave="transition ease-in duration-300"
     x-transition:leave-start="opacity-100 transform translate-y-0"
     x-transition:leave-end="opacity-0 transform -translate-y-2"
     class="mb-6 {{ $c['bg'] }} border-l-4 {{ $c['border'] }} p-3 rounded-xl flex items-start gap-3 shadow-sm">

    <div class="flex-shrink-0 mt-0.5 {{ $c['icon'] }}">
        @if($type === 'success')
            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
            </svg>
        @elseif($type === 'error')
            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"/>
            </svg>
        @elseif($type === 'warning')
            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                <path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/>
            </svg>
        @else
            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"/>
            </svg>
        @endif
    </div>

    <div class="flex-1 {{ $c['text'] }} text-sm font-medium">
        @if($message)
            {{ $message }}
        @else
            {{ $slot }}
        @endif
    </div>

    <button @click="show = false" class="flex-shrink-0 {{ $c['text'] }} hover:opacity-70 transition-opacity">
        <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
            <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"/>
        </svg>
    </button>
</div>
