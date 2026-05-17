@props(['category' => null])
@php
$colors = [
    'teknologi' => 'bg-blue-100 text-blue-700 dark:bg-blue-900 dark:text-blue-300',
    'politik'   => 'bg-red-100 text-red-700 dark:bg-red-900 dark:text-red-300',
    'olahraga'  => 'bg-green-100 text-green-700 dark:bg-green-900 dark:text-green-300',
    'hiburan'   => 'bg-purple-100 text-purple-700 dark:bg-purple-900 dark:text-purple-300',
    'bisnis'    => 'bg-yellow-100 text-yellow-700 dark:bg-yellow-900 dark:text-yellow-300',
];
$color = $colors[$category->slug ?? ''] ?? 'bg-slate-100 text-slate-700 dark:bg-slate-700 dark:text-slate-300';
@endphp
@if($category)
<span class="inline-block px-2 py-1 {{ $color }} text-xs font-semibold rounded-lg">{{ $category->name }}</span>
@endif
