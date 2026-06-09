@props(['user' => null, 'date' => null])
<div class="flex items-center gap-2">
    <img src="{{ $user->avatarUrl(32) }}"
         class="w-7 h-7 rounded border-2 border-brutal-orange">
    <span class="text-xs text-gray-500 font-bold uppercase tracking-wider">{{ $user->name ?? '-' }}</span>
    @if($date)
    <span class="text-xs text-gray-500 font-bold uppercase tracking-wider">{{ \Carbon\Carbon::parse($date)->format('d M Y') }}</span>
    @endif
</div>