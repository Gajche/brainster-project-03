<!-- resources/views/components/ui/button.blade.php -->
@props([
'type' => 'button',
'href' => null,
'variant' => 'primary'
])

@php
// We define the standard "Global" size and font here
$standardSize = 'w-[140px] h-[36px] font-[16px]';

$baseClasses = 'inline-flex items-center justify-center font-medium rounded-[10px] transition-all duration-200 no-underline cursor-pointer disabled:opacity-50 ' . $standardSize;

$variants = [
'primary' => 'btn-prijavi-nav text-white hover:opacity-90',
'secondary' => 'bg-gray-300 hover:bg-gray-400 text-ev-dark', // Note: Secondary might need a different size sometimes
];

$classes = $baseClasses . ' ' . ($variants[$variant] ?? $variants['primary']);
@endphp

@if($href)
<a href="{{ $href }}" {{ $attributes->merge(['class' => $classes]) }}>
	{{ $slot }}
</a>
@else
<button type="{{ $type }}" {{ $attributes->merge(['class' => $classes]) }}>
	{{ $slot }}
</button>
@endif