@props(['secondary' => false, 'primary' => false, 'type' => 'submit'])

@php
    $baseClasses = 'inline-flex items-center px-4 py-2 rounded-md font-semibold text-xs uppercase tracking-widest focus:outline-none focus:ring-2 focus:ring-offset-2 disabled:opacity-50 transition ease-in-out duration-150';
    
    if ($attributes->has('secondary') || $secondary) {
        $classes = $baseClasses . ' bg-white border border-gray-300 text-gray-700 shadow-sm hover:bg-gray-50 focus:ring-indigo-500';
    } elseif ($attributes->has('primary') || $primary) {
        $classes = $baseClasses . ' bg-indigo-600 border border-transparent text-white hover:bg-indigo-700 focus:bg-indigo-700 active:bg-indigo-900 focus:ring-indigo-500';
    } else {
        $classes = $baseClasses . ' bg-gray-800 border border-transparent text-white hover:bg-gray-700 focus:bg-gray-700 active:bg-gray-900 focus:ring-indigo-500';
    }
@endphp

<button {{ $attributes->merge(['type' => $type, 'class' => $classes]) }}>
    {{ $slot }}
</button>
