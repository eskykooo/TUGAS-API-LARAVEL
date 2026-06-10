@props(['category' => null])
@php
$colors = [
    'pc-gaming' => 'border-brutal-orange text-brutal-orange',
    'console' => 'border-brutal-red text-brutal-red',
    'mobile' => 'border-brutal-yellow text-brutal-yellow',
    'esports' => 'border-brutal-green text-brutal-green',
    'gaming-news' => 'border-brutal-orange text-brutal-orange',
    'reviews' => 'border-brutal-blue text-brutal-blue',
    'guides' => 'border-brutal-purple text-brutal-purple',
];
$color = $colors[$category->slug ?? ''] ?? 'border-gray-500 text-gray-400';
@endphp
@if($category)
<span class="tag-brutal {{ $color }}">{{ $category->name }}</span>
@endif