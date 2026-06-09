@props(['type' => 'card', 'count' => 1])

@if($type === 'card')
@for($i = 0; $i < $count; $i++)
<div class="bg-dark-card border-2 border-dark-border overflow-hidden">
    <div class="h-48 bg-dark-bg"></div>
    <div class="p-5 space-y-3">
        <div class="h-4 bg-dark-bg w-1/3"></div>
        <div class="h-5 bg-dark-bg w-full"></div>
        <div class="h-5 bg-dark-bg w-2/3"></div>
        <div class="h-4 bg-dark-bg w-full"></div>
        <div class="flex items-center gap-2 pt-4 border-t-2 border-dark-border mt-auto">
            <div class="w-7 h-7 rounded bg-dark-bg"></div>
            <div class="h-4 bg-dark-bg w-20"></div>
            <div class="h-4 bg-dark-bg w-12 ml-auto"></div>
        </div>
    </div>
</div>
@endfor
@endif