@props(['user' => null, 'date' => null])
<div class="flex items-center gap-2">
    <img src="https://ui-avatars.com/api/?name={{ urlencode($user->name ?? 'A') }}&background=0ea5e9&color=fff&size=32"
         class="w-7 h-7 rounded-full">
    <span class="text-xs text-slate-500">{{ $user->name ?? '-' }}</span>
    @if($date)
    <span class="text-xs text-slate-400">{{ \Carbon\Carbon::parse($date)->format('d M Y') }}</span>
    @endif
</div>
