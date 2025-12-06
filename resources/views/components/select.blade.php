@props(['disabled' => false, 'options' => []])

@php
    $options = $options ?? [];
@endphp

<select {{ $disabled ? 'disabled' : '' }} {!! $attributes->merge(['class' => 'border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm w-full']) !!}>
    @if(!empty($options))
        @foreach($options as $option)
            <option value="{{ $option['value'] ?? $option }}">{{ $option['label'] ?? $option }}</option>
        @endforeach
    @endif
    {{ $slot }}
</select>
