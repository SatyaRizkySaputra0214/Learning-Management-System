@props([
    'type' => 'primary',
    'buttonType' => 'submit',
    'tag' => 'button',
    'size' => 'md',
])

@php
    $sizeClasses = match ($size) {
        'sm' => 'px-3 py-1.5 text-xs',
        'md' => 'px-6 py-3 text-sm',
        'lg' => 'px-8 py-3 text-base',
        default => 'px-6 py-3 text-sm',
    };

    $styleClasses = \Illuminate\Support\Arr::toCssClasses([
        'inline-flex items-center gap-2 font-medium rounded-lg focus:outline-none focus:ring-2 focus:ring-offset-2 dark:focus:ring-offset-gray-800 transition-all duration-200 cursor-pointer',
        $sizeClasses,
        match ($type) {
            'primary' => 'text-white bg-blue-600 hover:bg-blue-700 focus:ring-blue-500',
            'secondary' => 'text-gray-700 dark:text-gray-300 bg-white dark:bg-gray-700 border border-gray-300 dark:border-gray-600 hover:bg-gray-50 dark:hover:bg-gray-600 focus:ring-gray-300 dark:focus:ring-gray-500',
            'danger' => 'text-white bg-red-600 hover:bg-red-700 focus:ring-red-500',
            'success' => 'text-white bg-green-600 hover:bg-green-700 focus:ring-green-500',
            default => 'text-white bg-blue-600 hover:bg-blue-700 focus:ring-blue-500',
        },
    ]);
@endphp

<{{ $tag }} type="{{ $tag === 'button' ? $buttonType : '' }}" {{ $attributes->merge(['class' => $styleClasses]) }}>
    {{ $slot }}
</{{ $tag }}>
