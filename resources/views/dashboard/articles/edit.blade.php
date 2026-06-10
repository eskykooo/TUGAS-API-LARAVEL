@extends('layouts.app')
@section('title', 'Edit Artikel - Nexus Gaming')
@section('meta_description', 'Edit artikel gaming.')

@push('styles')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.6.2/cropper.min.css">
<style>
.editor-height trix-editor {
    min-height: 480px !important;
    max-height: 600px !important;
    overflow-y: auto !important;
}
.editor-height trix-editor:empty:not(:focus)::before {
    color: #555;
}
trix-toolbar {
    position: sticky;
    top: 0;
    z-index: 10;
    background: #141414;
    padding: 0.5rem 0;
}
trix-toolbar .trix-button-row {
    display: flex;
    flex-wrap: wrap;
    gap: 0.125rem;
}
trix-toolbar .trix-button-group {
    margin-bottom: 0 !important;
}
trix-toolbar .trix-button {
    height: 1.75rem !important;
    font-size: 0.75rem !important;
    padding: 0 0.5rem !important;
}
trix-editor {
    border: none !important;
    border-radius: 0 !important;
    outline: none !important;
    padding: 0.75rem 0 !important;
    line-height: 1.75 !important;
    font-size: 1rem !important;
    color: #e0e0e0 !important;
}
trix-editor:focus {
    border: none !important;
    box-shadow: none !important;
}
.thumbnail-drop-zone.drag-over {
    border-color: #FF6B35 !important;
    background: rgba(255, 107, 53, 0.08) !important;
}
.tag-scroll::-webkit-scrollbar {
    width: 4px;
}
.tag-scroll::-webkit-scrollbar-track {
    background: #0A0A0A;
}
.tag-scroll::-webkit-scrollbar-thumb {
    background: #333;
    border-radius: 2px;
}
.tag-scroll::-webkit-scrollbar-thumb:hover {
    background: #FF6B35;
}
.btn-pulse {
    position: relative;
}
.btn-pulse::after {
    content: '';
    position: absolute;
    inset: -3px;
    border: 2px solid #FF6B35;
    border-radius: 0.5rem;
    opacity: 0;
    animation: btnPulse 2s ease-in-out infinite;
}
@keyframes btnPulse {
    0%, 100% { opacity: 0; transform: scale(1); }
    50% { opacity: 0.4; transform: scale(1.04); }
}
.glass-panel {
    background: rgba(20, 20, 20, 0.85);
    backdrop-filter: blur(12px);
    -webkit-backdrop-filter: blur(12px);
}
.cropper-view-box { border-radius: 0; outline-color: #FF6B35; }
.cropper-point { background-color: #FF6B35; }
.cropper-line { background-color: #FF6B35; }
.cropper-modal { background: rgba(0,0,0,0.75); }
</style>
@endpush

@section('content')
<div class="min-h-screen bg-dark-bg py-6 sm:py-8">
    <div class="max-w-7xl mx-auto px-3 sm:px-6 lg:px-8">

        <div class="flex items-center justify-between mb-6">
            <div class="flex items-center gap-3">
                <a href="/dashboard" class="group p-2.5 bg-dark-card border-2 border-dark-border hover:border-brutal-orange transition-all duration-200 flex-shrink-0 rounded">
                    <i class="fas fa-arrow-left text-gray-500 group-hover:text-brutal-orange transition-colors"></i>
                </a>
                <div>
                    <h1 class="font-orbitron text-xl sm:text-2xl font-black text-white uppercase tracking-wide">Edit Artikel</h1>
                    <p class="text-gray-500 text-xs font-bold uppercase tracking-wider mt-0.5">Perbarui konten artikel kamu</p>
                </div>
            </div>
            <div class="hidden sm:flex items-center gap-2.5 bg-dark-card border border-dark-border px-3 py-1.5 rounded">
                <img src="{{ auth()->user()->avatarUrl(28) }}" class="w-7 h-7 rounded border border-dark-border flex-shrink-0">
                <span class="text-xs font-bold text-gray-400 uppercase tracking-wider">{{ auth()->user()->name }}</span>
            </div>
        </div>

        <form method="POST" action="/dashboard/articles/{{ $article->id }}" enctype="multipart/form-data"
              x-data="articleForm()"
              class="relative">
            @csrf
            @method('PUT')

            <div class="grid grid-cols-1 lg:grid-cols-5 gap-5 lg:gap-6">

                <div class="lg:col-span-3 space-y-5">

                    <div class="glass-panel border border-brutal-orange/20 hover:border-brutal-orange/40 transition-colors p-5 sm:p-6 rounded">
                        <div class="flex items-center justify-between mb-2.5">
                            <label class="text-[11px] font-bold text-gray-400 uppercase tracking-widest">Judul Artikel</label>
                            <span class="text-[11px] font-bold font-mono tabular-nums"
                                  :class="title.length > 150 ? 'text-brutal-red' : (title.length > 50 ? 'text-brutal-green' : 'text-gray-500')"
                                  x-text="title.length + '/200'"></span>
                        </div>
                        <input type="text" name="title" value="{{ old('title', $article->title) }}"
                               x-model="title"
                               @input="updateSeo()"
                               class="w-full bg-dark-bg text-white border-2 border-dark-border focus:border-brutal-orange px-4 py-3.5 text-lg sm:text-xl font-bold placeholder-gray-600 transition-colors outline-none rounded"
                               placeholder="Judul artikel..."
                               maxlength="200"
                               required autofocus>
                        @error('title')<p class="text-brutal-red text-xs font-bold mt-1.5">{{ $message }}</p>@enderror
                        <div class="flex items-center justify-between mt-2">
                            <p class="text-xs text-gray-500 font-bold">
                                <span class="text-gray-600">Slug:</span>
                                <span class="text-brutal-orange">{{ $article->slug }}</span>
                            </p>
                        </div>
                    </div>

                    <div class="glass-panel border border-brutal-orange/20 hover:border-brutal-orange/40 transition-colors p-5 sm:p-6 rounded">
                        <div class="flex items-center justify-between mb-3">
                            <label class="text-[11px] font-bold text-gray-400 uppercase tracking-widest">Konten</label>
                            <div class="flex items-center gap-4 text-[11px] font-bold">
                                <span class="text-gray-500">
                                    <i class="fas fa-file-alt mr-1 text-brutal-orange"></i>
                                    <span x-text="wordCount"></span> kata
                                </span>
                                <span class="text-gray-500">
                                    <i class="fas fa-clock mr-1 text-brutal-orange"></i>
                                    <span x-text="readingTime"></span> mnt baca
                                </span>
                            </div>
                        </div>
                        <textarea name="content" id="content" class="hidden">{{ old('content', $article->content) }}</textarea>
                        <div class="editor-height bg-dark-bg border border-dark-border focus-within:border-brutal-orange/40 transition-colors px-4 sm:px-5 rounded">
                            <trix-editor input="content"
                                         @trix-change="onContentChange()"
                                         @trix-initialize="onContentInit()"
                                         x-ref="trix"></trix-editor>
                        </div>
                        @error('content')<p class="text-brutal-red text-xs font-bold mt-1.5">{{ $message }}</p>@enderror
                    </div>

                    <div class="glass-panel border border-brutal-orange/20 hover:border-brutal-orange/40 transition-colors p-5 sm:p-6 rounded">
                        <div class="flex items-center justify-between mb-2.5">
                            <label class="text-[11px] font-bold text-gray-400 uppercase tracking-widest">Excerpt <span class="text-gray-600 font-normal normal-case tracking-normal">(ringkasan)</span></label>
                            <span class="text-[11px] font-bold font-mono tabular-nums"
                                  :class="excerpt.length > 160 ? 'text-brutal-red' : (excerpt.length > 110 ? 'text-brutal-green' : 'text-gray-500')"
                                  x-text="excerpt.length + '/200'"></span>
                        </div>
                        <textarea name="excerpt" rows="3"
                                  x-model="excerpt"
                                  @input="updateSeo()"
                                  class="w-full bg-dark-bg text-gray-200 border-2 border-dark-border focus:border-brutal-orange px-4 py-3 text-sm placeholder-gray-600 transition-colors outline-none rounded resize-none"
                                  placeholder="Tulis ringkasan singkat..."
                                  maxlength="200">{{ old('excerpt', $article->excerpt) }}</textarea>
                    </div>

                    <div x-show="showPreview" x-cloak x-transition:enter="transition ease-out duration-200" x-transition:enter-start="opacity-0 translate-y-2" x-transition:enter-end="opacity-100 translate-y-0"
                         class="glass-panel border border-brutal-orange/20 p-5 sm:p-6 rounded">
                        <div class="flex items-center gap-2 mb-4">
                            <i class="fas fa-eye text-brutal-orange text-xs"></i>
                            <span class="text-[11px] font-bold text-gray-400 uppercase tracking-widest">Pratinjau</span>
                            <button type="button" @click="showPreview = false" class="ml-auto text-gray-500 hover:text-white transition-colors text-xs">
                                <i class="fas fa-times"></i>
                            </button>
                        </div>
                        <div class="border-l-4 border-brutal-orange pl-4">
                            <div class="flex items-center gap-2 text-[10px] text-gray-500 font-bold uppercase tracking-wider mb-2">
                                <span class="px-2 py-0.5 border text-[10px] font-bold" style="border-color: #FF6B35; color: #FF6B35;">{{ $article->category?->name ?? 'Kategori' }}</span>
                                <span><i class="far fa-clock mr-1"></i> <span x-text="readingTime"></span> menit baca</span>
                            </div>
                            <h2 class="font-orbitron text-xl sm:text-2xl font-bold text-white leading-tight" x-html="title || 'Judul Artikel'"></h2>
                        </div>
                        <hr class="my-4 border-dark-border">
                        <div class="article-content text-sm" x-html="content || '<p class=\'text-gray-600 italic\'>Belum ada konten...</p>'"></div>
                    </div>

                </div>

                <div class="lg:col-span-2 space-y-4">

                    <div class="glass-panel border border-brutal-orange/20 hover:border-brutal-orange/40 transition-colors p-5 rounded">
                        <div class="flex items-center gap-2 mb-3">
                            <i class="fas fa-image text-brutal-orange text-xs"></i>
                            <span class="text-[11px] font-bold text-gray-400 uppercase tracking-widest">Thumbnail</span>
                        </div>
                        <input type="hidden" name="thumbnail_data" x-model="thumbnailData">
                        @if($article->thumbnail_url)
                        <div class="mb-3 relative group" x-show="!thumbnailPreview">
                            <img src="{{ $article->thumbnail_url }}" class="w-full h-36 object-cover border border-dark-border rounded">
                            <div class="absolute inset-0 bg-black/50 opacity-0 group-hover:opacity-100 transition-opacity flex items-center justify-center rounded">
                                <span class="text-xs font-bold text-white uppercase tracking-wider">Thumbnail saat ini</span>
                            </div>
                        </div>
                        @endif
                        <div class="border-2 border-dashed border-dark-border hover:border-brutal-orange/60 transition-colors p-4 text-center cursor-pointer rounded relative group thumbnail-drop-zone"
                             x-data="{ dragging: false }"
                             @dragover.prevent="dragging = true"
                             @dragleave.prevent="dragging = false"
                             @drop.prevent="openCropper($event.dataTransfer.files[0]); dragging = false"
                             @click="document.getElementById('thumbnail-input').click()"
                             :class="dragging ? 'border-brutal-orange bg-brutal-orange/5' : ''">
                            <input type="file" name="thumbnail" accept="image/jpeg,image/png,image/webp" class="hidden" id="thumbnail-input"
                                   @change="openCropper($event.target.files[0])">
                            <template x-if="!thumbnailPreview">
                                <div>
                                    <div class="w-10 h-10 mx-auto mb-2 bg-dark-bg border-2 border-dark-border rounded flex items-center justify-center group-hover:border-brutal-orange group-hover:text-brutal-orange transition-colors">
                                        <i class="fas fa-cloud-upload-alt text-lg text-gray-500 group-hover:text-brutal-orange transition-colors"></i>
                                    </div>
                                    <p class="text-xs text-gray-500 font-bold uppercase tracking-wider">{{ $article->thumbnail_url ? 'Klik untuk ganti' : 'Klik atau seret gambar' }}</p>
                                    <p class="text-[10px] text-gray-600 font-bold mt-1">PNG, JPG, WebP &bull; Maks 5MB</p>
                                </div>
                            </template>
                            <template x-if="thumbnailPreview">
                                <div class="relative">
                                    <img :src="thumbnailPreview" class="w-full h-40 object-cover border border-dark-border rounded">
                                    <button type="button" @click.stop="thumbnailPreview = null; thumbnailData = ''; document.getElementById('thumbnail-input').value = ''"
                                            class="absolute top-2 right-2 w-7 h-7 bg-brutal-red text-white text-xs flex items-center justify-center hover:bg-white hover:text-brutal-red transition-colors rounded border border-brutal-black shadow-brutal">
                                        <i class="fas fa-times"></i>
                                    </button>
                                </div>
                            </template>
                        </div>
                        @error('thumbnail')<p class="text-brutal-red text-xs font-bold mt-1.5">{{ $message }}</p>@enderror
                    </div>

                    <div x-show="cropperOpen" x-cloak x-transition:enter="transition ease-out duration-200" x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100"
                         class="fixed inset-0 z-[60] flex items-center justify-center bg-black/80 p-4"
                         @click.away="closeCropper()">
                        <div class="bg-dark-card border-2 border-brutal-orange rounded max-w-2xl w-full">
                            <div class="flex items-center justify-between px-5 py-3 border-b border-dark-border">
                                <span class="text-sm font-bold text-white uppercase tracking-wider">Crop Thumbnail</span>
                                <button type="button" @click="closeCropper()" class="text-gray-500 hover:text-white transition-colors">
                                    <i class="fas fa-times"></i>
                                </button>
                            </div>
                            <div class="p-5">
                                <img id="cropImage" class="max-w-full">
                            </div>
                            <div class="flex items-center justify-between px-5 py-3 border-t border-dark-border bg-dark-bg">
                                <div class="flex items-center gap-2">
                                    <button type="button" @click="cropper.zoom(0.1)" class="px-3 py-1.5 bg-dark-card border border-dark-border text-gray-400 hover:text-white text-xs font-bold rounded transition-colors">
                                        <i class="fas fa-search-plus mr-1"></i> Zoom In
                                    </button>
                                    <button type="button" @click="cropper.zoom(-0.1)" class="px-3 py-1.5 bg-dark-card border border-dark-border text-gray-400 hover:text-white text-xs font-bold rounded transition-colors">
                                        <i class="fas fa-search-minus mr-1"></i> Zoom Out
                                    </button>
                                    <button type="button" @click="cropper.rotate(-90)" class="px-3 py-1.5 bg-dark-card border border-dark-border text-gray-400 hover:text-white text-xs font-bold rounded transition-colors">
                                        <i class="fas fa-undo mr-1"></i> Rotate
                                    </button>
                                </div>
                                <div class="flex items-center gap-2">
                                    <button type="button" @click="closeCropper()" class="px-4 py-1.5 bg-dark-bg border border-dark-border text-gray-400 hover:text-white text-xs font-bold rounded transition-colors">
                                        Batal
                                    </button>
                                    <button type="button" @click="applyCrop()" class="px-4 py-1.5 bg-brutal-orange text-brutal-black text-xs font-black border border-brutal-black rounded hover:shadow-brutal transition-all">
                                        <i class="fas fa-check mr-1"></i> Simpan
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="glass-panel border border-brutal-orange/20 hover:border-brutal-orange/40 transition-colors p-5 rounded"
                         x-data="{ catOpen: false, selected: '{{ old('category_id', $article->category_id) }}', selectedName: '' }"
                         :class="catOpen && 'z-30 relative'">
                        <div class="flex items-center gap-2 mb-3">
                            <i class="fas fa-folder text-brutal-orange text-xs"></i>
                            <span class="text-[11px] font-bold text-gray-400 uppercase tracking-widest">Kategori</span>
                        </div>
                        <div class="relative" @keydown.escape="catOpen = false">
                            <button type="button" @click="catOpen = !catOpen"
                                    class="w-full bg-dark-bg border-2 border-dark-border focus:border-brutal-orange px-4 py-3 text-sm text-left font-bold flex items-center justify-between transition-colors outline-none rounded">
                                <span x-text="selectedName || '{{ $article->category?->name ?? 'Pilih kategori' }}'" :class="!selectedName && !'{{ $article->category_id }}' ? 'text-gray-500' : 'text-white'"></span>
                                <i class="fas fa-chevron-down text-xs text-gray-500 transition-transform" :class="catOpen && 'rotate-180'"></i>
                            </button>
                            <input type="hidden" name="category_id" :value="selected">
                            <div x-show="catOpen" x-cloak @click.away="catOpen = false"
                                 class="absolute top-full left-0 right-0 mt-1.5 bg-dark-bg border-2 border-brutal-orange z-20 max-h-52 overflow-y-auto rounded">
                                @foreach($categories as $cat)
                                @php
                                $catColor = match($cat->slug) {
                                    'pc-gaming', 'gaming-news' => '#FF6B35',
                                    'console' => '#FF1744',
                                    'mobile' => '#FFD600',
                                    'esports' => '#00E676',
                                    'reviews' => '#3B82F6',
                                    'guides' => '#A855F7',
                                    default => '#FF6B35',
                                };
                                @endphp
                                <button type="button"
                                        @click="selected = '{{ $cat->id }}'; selectedName = '{{ $cat->name }}'; open = false"
                                        class="w-full text-left px-4 py-2.5 text-sm font-bold text-gray-300 hover:bg-dark-card transition-colors flex items-center gap-2.5 border-b border-dark-border last:border-0"
                                        :class="selected == '{{ $cat->id }}' && 'text-brutal-orange bg-brutal-orange/5'">
                                    <span class="w-2.5 h-2.5 rounded-full flex-shrink-0" style="background: {{ $catColor }}"></span>
                                    {{ $cat->name }}
                                </button>
                                @endforeach
                            </div>
                        </div>
                        @error('category_id')<p class="text-brutal-red text-xs font-bold mt-1.5">{{ $message }}</p>@enderror
                    </div>

                    <div class="glass-panel border border-brutal-orange/20 hover:border-brutal-orange/40 transition-colors p-5 rounded">
                        <div class="flex items-center gap-2 mb-3">
                            <i class="fas fa-flag text-brutal-orange text-xs"></i>
                            <span class="text-[11px] font-bold text-gray-400 uppercase tracking-widest">Status</span>
                        </div>
                        <div class="space-y-2.5">
                            <label class="flex items-center gap-3 px-4 py-3 border-2 cursor-pointer transition-all duration-200 font-bold text-sm rounded"
                                   :class="status == 'draft' ? 'border-brutal-orange bg-brutal-orange/5 text-brutal-orange' : 'border-dark-border text-gray-500 hover:border-gray-500'">
                                <input type="radio" name="status" value="draft" x-model="status" class="hidden">
                                <div class="w-4 h-4 rounded-full border-2 flex items-center justify-center flex-shrink-0 transition-colors"
                                     :class="status == 'draft' ? 'border-brutal-orange' : 'border-gray-600'">
                                    <div x-show="status == 'draft'" class="w-2 h-2 rounded-full bg-brutal-orange"></div>
                                </div>
                                <div class="flex-1 min-w-0">
                                    <p class="text-sm font-bold">Draf</p>
                                    <p class="text-[10px] text-gray-500 font-bold uppercase tracking-wider mt-0.5">Hanya kamu yang bisa melihat</p>
                                </div>
                                <i class="fas fa-pen-fancy text-xs" :class="status == 'draft' ? 'text-brutal-orange' : 'text-gray-600'"></i>
                            </label>
                            @if($article->status === 'pending')
                            <label class="flex items-center gap-3 px-4 py-3 border-2 border-brutal-yellow bg-brutal-yellow/5 text-brutal-yellow font-bold text-sm rounded cursor-not-allowed opacity-70">
                                <div class="w-4 h-4 rounded-full border-2 border-brutal-yellow flex items-center justify-center flex-shrink-0">
                                    <div class="w-2 h-2 rounded-full bg-brutal-yellow"></div>
                                </div>
                                <div class="flex-1 min-w-0">
                                    <p class="text-sm font-bold">Menunggu Review</p>
                                    <p class="text-[10px] text-gray-500 font-bold uppercase tracking-wider mt-0.5">Sedang ditinjau admin</p>
                                </div>
                                <i class="fas fa-clock text-xs text-brutal-yellow"></i>
                            </label>
                            @elseif($article->status === 'published')
                            <label class="flex items-center gap-3 px-4 py-3 border-2 border-brutal-green bg-brutal-green/5 text-brutal-green font-bold text-sm rounded cursor-not-allowed opacity-70">
                                <div class="w-4 h-4 rounded-full border-2 border-brutal-green flex items-center justify-center flex-shrink-0">
                                    <div class="w-2 h-2 rounded-full bg-brutal-green"></div>
                                </div>
                                <div class="flex-1 min-w-0">
                                    <p class="text-sm font-bold">Published</p>
                                    <p class="text-[10px] text-gray-500 font-bold uppercase tracking-wider mt-0.5">Artikel sudah tayang</p>
                                </div>
                                <i class="fas fa-check-circle text-xs text-brutal-green"></i>
                            </label>
                            @else
                            <label class="flex items-center gap-3 px-4 py-3 border-2 cursor-pointer transition-all duration-200 font-bold text-sm rounded"
                                   :class="status == 'published' ? 'border-brutal-yellow bg-brutal-yellow/5 text-brutal-yellow' : 'border-dark-border text-gray-500 hover:border-gray-500'">
                                <input type="radio" name="status" value="published" x-model="status" class="hidden">
                                <div class="w-4 h-4 rounded-full border-2 flex items-center justify-center flex-shrink-0 transition-colors"
                                     :class="status == 'published' ? 'border-brutal-yellow' : 'border-gray-600'">
                                    <div x-show="status == 'published'" class="w-2 h-2 rounded-full bg-brutal-yellow"></div>
                                </div>
                                <div class="flex-1 min-w-0">
                                    <p class="text-sm font-bold">Publikasikan</p>
                                    <p class="text-[10px] text-gray-500 font-bold uppercase tracking-wider mt-0.5">Admin akan meninjau sebelum tayang</p>
                                </div>
                                <i class="fas fa-globe-asia text-xs" :class="status == 'published' ? 'text-brutal-yellow' : 'text-gray-600'"></i>
                            </label>
                            @endif
                        </div>
                        <div class="mt-3 pt-3 border-t border-dark-border">
                            <p class="text-[10px] text-gray-600 font-bold uppercase tracking-wider flex items-center gap-1.5">
                                <i class="fas fa-info-circle text-brutal-orange"></i>
                                <span x-text="statusMsg"></span>
                            </p>
                        </div>
                    </div>

                    <div class="glass-panel border border-brutal-orange/20 hover:border-brutal-orange/40 transition-colors p-5 rounded">
                        <div class="flex items-center gap-2 mb-3">
                            <i class="fas fa-tags text-brutal-orange text-xs"></i>
                            <span class="text-[11px] font-bold text-gray-400 uppercase tracking-widest">Tag</span>
                        </div>
                        <template x-if="selectedTags.length > 0">
                            <div class="flex flex-wrap gap-1.5 mb-3">
                                <template x-for="tag in selectedTags" :key="tag.id">
                                    <span class="inline-flex items-center gap-1.5 px-2.5 py-1 text-[11px] font-bold uppercase tracking-wider bg-brutal-orange/10 text-brutal-orange border border-brutal-orange/30 rounded">
                                        #<span x-text="tag.name"></span>
                                        <button type="button" @click="toggleTag(tag.id)" class="hover:text-white transition-colors">
                                            <i class="fas fa-times text-[9px]"></i>
                                        </button>
                                    </span>
                                </template>
                            </div>
                        </template>
                        <div class="relative mb-2">
                            <i class="fas fa-search absolute left-3 top-1/2 -translate-y-1/2 text-gray-600 text-xs"></i>
                            <input type="text" x-model="tagSearch"
                                   class="w-full bg-dark-bg border border-dark-border text-white text-xs pl-8 pr-3 py-2 outline-none focus:border-brutal-orange transition-colors placeholder-gray-600 rounded"
                                   placeholder="Cari tag...">
                        </div>
                        <div class="max-h-36 overflow-y-auto space-y-0.5 tag-scroll" x-show="filteredTags.length > 0">
                            <template x-for="tag in filteredTags" :key="tag.id">
                                <label class="flex items-center gap-2.5 px-2.5 py-2 cursor-pointer hover:bg-dark-bg transition-colors rounded"
                                       :class="isTagSelected(tag.id) ? 'bg-brutal-orange/5' : ''">
                                    <input type="checkbox" :value="tag.id" name="tags[]"
                                           :checked="isTagSelected(tag.id)"
                                           @change="toggleTag(tag.id)"
                                           class="hidden peer">
                                    <div class="w-3.5 h-3.5 border-2 flex items-center justify-center flex-shrink-0 transition-colors rounded"
                                         :class="isTagSelected(tag.id) ? 'bg-brutal-orange border-brutal-orange' : 'border-gray-600'">
                                        <i x-show="isTagSelected(tag.id)" class="fas fa-check text-[7px] text-brutal-black"></i>
                                    </div>
                                    <span class="text-xs font-bold" :class="isTagSelected(tag.id) ? 'text-brutal-orange' : 'text-gray-400'" x-text="'#' + tag.name"></span>
                                </label>
                            </template>
                        </div>
                        <p x-show="filteredTags.length === 0" class="text-xs text-gray-600 font-bold text-center py-3">Tidak ada tag yang cocok</p>
                    </div>

                    <div class="glass-panel border border-brutal-orange/20 hover:border-brutal-orange/40 transition-colors p-5 rounded">
                        <div class="flex items-center gap-2 mb-3">
                            <i class="fas fa-chart-line text-brutal-orange text-xs"></i>
                            <span class="text-[11px] font-bold text-gray-400 uppercase tracking-widest">SEO</span>
                        </div>
                        <div class="space-y-3">
                            <div>
                                <div class="flex items-center justify-between mb-1">
                                    <span class="text-[10px] text-gray-500 font-bold uppercase tracking-wider">Judul</span>
                                    <span class="text-[10px] font-bold font-mono" x-text="seoTitleMsg" :class="seoTitleColor"></span>
                                </div>
                                <div class="h-1.5 bg-dark-bg rounded-full overflow-hidden">
                                    <div class="h-full w-0 rounded-full transition-all duration-500 ease-out" :style="'width: ' + seoTitlePercent + '%'" :class="seoTitleBar"></div>
                                </div>
                                <p class="text-[10px] text-gray-600 mt-1 leading-relaxed">Ideal <span class="text-gray-500 font-bold">50–60</span> karakter untuk hasil pencarian optimal</p>
                            </div>
                            <div>
                                <div class="flex items-center justify-between mb-1">
                                    <span class="text-[10px] text-gray-500 font-bold uppercase tracking-wider">Deskripsi</span>
                                    <span class="text-[10px] font-bold font-mono" x-text="seoDescMsg" :class="seoDescColor"></span>
                                </div>
                                <div class="h-1.5 bg-dark-bg rounded-full overflow-hidden">
                                    <div class="h-full w-0 rounded-full transition-all duration-500 ease-out" :style="'width: ' + seoDescPercent + '%'" :class="seoDescBar"></div>
                                </div>
                                <p class="text-[10px] text-gray-600 mt-1 leading-relaxed">Ideal <span class="text-gray-500 font-bold">120–160</span> karakter untuk cuplikan pencarian</p>
                            </div>
                            <div class="pt-2.5 border-t border-dark-border">
                                <div class="flex items-center justify-between">
                                    <span class="text-xs font-bold text-gray-400 uppercase tracking-wider">Skor SEO</span>
                                    <span class="text-base font-black font-orbitron tabular-nums" x-text="seoScore + '/100'" :class="seoScoreClass"></span>
                                </div>
                                <div class="mt-2 h-2 bg-dark-bg rounded-full overflow-hidden">
                                    <div class="h-full w-0 rounded-full transition-all duration-700 ease-out" :style="'width: ' + seoScore + '%'" :class="seoScoreBar"></div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="space-y-2.5 pt-1">
                        <button type="submit" class="w-full flex items-center justify-center gap-2.5 px-5 py-3.5 bg-brutal-orange text-brutal-black font-black text-sm uppercase tracking-wider border-2 border-brutal-black hover:shadow-brutal-lg hover:-translate-y-0.5 active:translate-y-0.5 transition-all duration-200 rounded btn-pulse">
                            <i class="fas fa-save"></i>
                            Perbarui Artikel
                        </button>
                        <a href="/dashboard" class="block w-full text-center px-5 py-2.5 text-xs font-bold text-gray-500 uppercase tracking-wider hover:text-brutal-red transition-colors">
                            Batal
                        </a>
                    </div>

                    <div class="glass-panel border border-dark-border p-4 rounded">
                        <div class="grid grid-cols-3 gap-2 text-center">
                            <div class="border-r border-dark-border pr-2">
                                <p class="text-xl font-black font-orbitron text-brutal-orange tabular-nums" x-text="wordCount">0</p>
                                <p class="text-[9px] text-gray-500 font-bold uppercase tracking-widest mt-0.5">Kata</p>
                            </div>
                            <div class="border-r border-dark-border pr-2">
                                <p class="text-xl font-black font-orbitron text-brutal-orange tabular-nums" x-text="readingTime">0</p>
                                <p class="text-[9px] text-gray-500 font-bold uppercase tracking-widest mt-0.5">Menit</p>
                            </div>
                            <div>
                                <p class="text-xl font-black font-orbitron text-brutal-orange tabular-nums" x-text="charCount">0</p>
                                <p class="text-[9px] text-gray-500 font-bold uppercase tracking-widest mt-0.5">Karakter</p>
                            </div>
                        </div>
                    </div>

                    <div class="flex items-center gap-2 py-2">
                        <button type="button" @click="showPreview = !showPreview"
                                class="flex items-center gap-2 px-4 py-2 text-xs font-bold text-gray-500 uppercase tracking-wider hover:text-brutal-orange transition-colors">
                            <i class="fas" :class="showPreview ? 'fa-eye-slash' : 'fa-eye'"></i>
                            <span x-text="showPreview ? 'Tutup Pratinjau' : 'Pratinjau'"></span>
                        </button>
                    </div>

                </div>
            </div>
        </form>
    </div>
</div>
@endsection

@push('scripts')
<script src="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.6.2/cropper.min.js"></script>
<script>
const ALL_TAGS = @json($tags);
const ARTICLE_TAG_IDS = @json($article->tags->pluck('id'));

function articleForm() {
    return {
        title: @json(old('title', $article->title)),
        content: '',
        status: @json(old('status', $article->status)),
        showPreview: false,
        tagSearch: '',
        selectedTags: [],
        thumbnailPreview: null,
        thumbnailData: '',
        cropperOpen: false,
        cropper: null,
        excerpt: @json(old('excerpt', $article->excerpt ?? '')),

        openCropper(file) {
            if (!file || !file.type.startsWith('image/')) return;
            if (file.size > 5 * 1024 * 1024) { alert('Maksimal 5MB'); return; }
            const reader = new FileReader();
            reader.onload = (e) => {
                this.cropperOpen = true;
                this.$nextTick(() => {
                    const img = document.getElementById('cropImage');
                    img.src = e.target.result;
                    if (this.cropper) this.cropper.destroy();
                    this.cropper = new Cropper(img, {
                        aspectRatio: 16 / 9,
                        viewMode: 0,
                        dragMode: 'move',
                        background: false,
                        autoCropArea: 1,
                        responsive: true,
                        highlight: true,
                    });
                });
            };
            reader.readAsDataURL(file);
        },

        closeCropper() {
            this.cropperOpen = false;
            if (this.cropper) { this.cropper.destroy(); this.cropper = null; }
            document.getElementById('thumbnail-input').value = '';
        },

        applyCrop() {
            if (!this.cropper) return;
            const canvas = this.cropper.getCroppedCanvas({ width: 1200, height: 675 });
            this.thumbnailData = canvas.toDataURL('image/webp', 0.8);
            this.thumbnailPreview = canvas.toDataURL('image/webp', 0.8);
            this.cropperOpen = false;
            this.cropper.destroy();
            this.cropper = null;
        },

        init() {
            this.selectedTags = ALL_TAGS.filter(t => ARTICLE_TAG_IDS.includes(t.id));
        },

        get wordCount() {
            const text = this.content || '';
            const stripped = text.replace(/<[^>]*>/g, ' ').replace(/&[^;]+;/g, ' ');
            const words = stripped.trim().split(/\s+/).filter(w => w.length > 0);
            return words.length;
        },

        get readingTime() {
            const wpm = 200;
            const minutes = Math.ceil(this.wordCount / wpm);
            return Math.max(1, minutes);
        },

        get charCount() {
            return (this.content || '').replace(/<[^>]*>/g, '').length;
        },

        get filteredTags() {
            const query = this.tagSearch.toLowerCase().trim();
            if (!query) return ALL_TAGS;
            return ALL_TAGS.filter(t => t.name.toLowerCase().includes(query));
        },

        get statusMsg() {
            if (this.status === 'draft') return 'Artikel akan disimpan sebagai draf.';
            if (this.status === 'published') return 'Artikel akan dikirim ke admin untuk ditinjau.';
            if (this.status === 'pending') return 'Artikel sedang menunggu review admin.';
            return '';
        },

        isTagSelected(id) {
            return this.selectedTags.some(t => t.id === id);
        },

        toggleTag(id) {
            const idx = this.selectedTags.findIndex(t => t.id === id);
            if (idx > -1) {
                this.selectedTags.splice(idx, 1);
            } else {
                const tag = ALL_TAGS.find(t => t.id === id);
                if (tag) this.selectedTags.push(tag);
            }
        },

        onContentChange() {
            this.content = document.getElementById('content').value;
        },

        onContentInit() {
            this.content = document.getElementById('content').value;
        },

        updateSeo() { },

        get seoTitlePercent() {
            const len = this.title.length;
            if (len === 0) return 0;
            if (len >= 50 && len <= 60) return 100;
            if (len >= 40 && len <= 70) return 80;
            if (len >= 30 && len <= 80) return 60;
            if (len >= 20 && len <= 100) return 40;
            return 20;
        },

        get seoTitleMsg() {
            const len = this.title.length;
            if (len === 0) return 'Kosong';
            if (len >= 50 && len <= 60) return 'Sempurna';
            if (len >= 40 && len <= 70) return 'Baik';
            if (len >= 30 && len <= 80) return 'Cukup';
            if (len >= 20 && len <= 100) return 'Kurang';
            return len > 100 ? 'Terlalu panjang' : 'Terlalu pendek';
        },

        get seoTitleColor() {
            const len = this.title.length;
            if (len === 0) return 'text-gray-500';
            if (len >= 50 && len <= 60) return 'text-brutal-green';
            if (len >= 40 && len <= 70) return 'text-brutal-blue';
            if (len >= 30 && len <= 80) return 'text-brutal-yellow';
            return 'text-brutal-red';
        },

        get seoTitleBar() {
            const len = this.title.length;
            if (len === 0) return 'bg-gray-600';
            if (len >= 50 && len <= 60) return 'bg-brutal-green';
            if (len >= 40 && len <= 70) return 'bg-brutal-blue';
            if (len >= 30 && len <= 80) return 'bg-brutal-yellow';
            return 'bg-brutal-red';
        },

        get seoDescPercent() {
            const len = this.excerpt.length;
            if (len === 0) return 0;
            if (len >= 120 && len <= 160) return 100;
            if (len >= 90 && len <= 180) return 80;
            if (len >= 60 && len <= 200) return 60;
            return 30;
        },

        get seoDescMsg() {
            const len = this.excerpt.length;
            if (len === 0) return 'Kosong';
            if (len >= 120 && len <= 160) return 'Sempurna';
            if (len >= 90 && len <= 180) return 'Baik';
            if (len >= 60 && len <= 200) return 'Cukup';
            return len > 200 ? 'Terlalu panjang' : 'Terlalu pendek';
        },

        get seoDescColor() {
            const len = this.excerpt.length;
            if (len === 0) return 'text-gray-500';
            if (len >= 120 && len <= 160) return 'text-brutal-green';
            if (len >= 90 && len <= 180) return 'text-brutal-blue';
            if (len >= 60 && len <= 200) return 'text-brutal-yellow';
            return 'text-brutal-red';
        },

        get seoDescBar() {
            const len = this.excerpt.length;
            if (len === 0) return 'bg-gray-600';
            if (len >= 120 && len <= 160) return 'bg-brutal-green';
            if (len >= 90 && len <= 180) return 'bg-brutal-blue';
            if (len >= 60 && len <= 200) return 'bg-brutal-yellow';
            return 'bg-brutal-red';
        },

        get seoScore() {
            let score = 0;
            if (this.title.length >= 10) score += 25;
            if (this.title.length >= 50 && this.title.length <= 60) score += 15;
            else if (this.title.length >= 40) score += 10;
            else if (this.title.length >= 20) score += 5;
            if (this.excerpt.length >= 50) score += 20;
            if (this.excerpt.length >= 120 && this.excerpt.length <= 160) score += 10;
            else if (this.excerpt.length >= 60) score += 5;
            if (this.wordCount >= 100) score += 10;
            if (this.wordCount >= 300) score += 10;
            if (this.selectedTags.length > 0) score += 5;
            if (this.selectedTags.length >= 2) score += 5;
            if (this.thumbnailPreview) score += 10;
            return Math.min(100, Math.round(score));
        },

        get seoScoreClass() {
            const s = this.seoScore;
            if (s >= 80) return 'text-brutal-green';
            if (s >= 60) return 'text-brutal-blue';
            if (s >= 40) return 'text-brutal-yellow';
            return 'text-brutal-red';
        },

        get seoScoreBar() {
            const s = this.seoScore;
            if (s >= 80) return 'bg-brutal-green';
            if (s >= 60) return 'bg-brutal-blue';
            if (s >= 40) return 'bg-brutal-yellow';
            return 'bg-brutal-red';
        }
    };
}
</script>
@endpush
