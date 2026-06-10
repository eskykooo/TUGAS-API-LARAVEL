@props(['user' => null, 'date' => null, 'size' => 'sm', 'showRole' => false])
@php
$sizes = ['sm' => ['avatar' => 32, 'text' => 'text-xs'], 'md' => ['avatar' => 48, 'text' => 'text-sm'], 'lg' => ['avatar' => 64, 'text' => 'text-base']];
$s = $sizes[$size] ?? $sizes['sm'];
@endphp
<div class="flex items-center gap-2.5">
    <img src="{{ $user->avatarUrl($s['avatar']) }}"
         class="w-{{ $s['avatar']/4 }} h-{{ $s['avatar']/4 }} rounded border-2 border-brutal-orange/30 flex-shrink-0">
    <div class="min-w-0">
        <span class="{{ $s['text'] }} font-bold text-white uppercase tracking-wider truncate block leading-tight">{{ $user->name ?? '-' }}</span>
        @if($showRole)
        @if($user->isAdmin())
        <span class="role-badge admin text-[9px] mt-0.5 inline-flex"><i class="fas fa-crown"></i> Admin</span>
        @elseif($user->role === 'editor')
        <span class="role-badge editor text-[9px] mt-0.5 inline-flex"><i class="fas fa-edit"></i> Editor</span>
        @elseif($user->role === 'author')
        <span class="role-badge author text-[9px] mt-0.5 inline-flex"><i class="fas fa-pen-fancy"></i> Author</span>
        @endif
        @endif
        @if($date)
        <span class="text-[10px] text-gray-500 font-bold uppercase tracking-wider block mt-0.5">{{ \Carbon\Carbon::parse($date)->format('d M Y') }}</span>
        @endif
    </div>
</div>