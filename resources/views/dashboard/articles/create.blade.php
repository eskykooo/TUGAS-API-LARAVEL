@extends('layouts.app')
@section('title', 'Buat Artikel - Nexus Gaming')
@section('meta_description', 'Buat artikel baru.')

@section('content')
<section class="min-h-screen bg-dark-bg py-16 sm:py-20">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex items-center gap-3 mb-8">
            <a href="/dashboard" class="p-2 bg-dark-card border-2 border-dark-border hover:border-brutal-orange transition flex-shrink-0"><i class="fas fa-arrow-left text-gray-500"></i></a>
            <div>
                <h1 class="font-orbitron text-2xl sm:text-3xl font-black text-white uppercase tracking-wide">Buat Artikel Baru</h1>
                <p class="text-gray-500 text-sm font-bold uppercase tracking-wider">Tulis konten gaming menarik</p>
            </div>
        </div>

        <form method="POST" action="/dashboard/articles" enctype="multipart/form-data" class="space-y-6" x-data="{ title: '', slug: '', content: '', status: 'draft', preview: false }">
            @csrf

            <div class="bg-dark-card border-2 border-dark-border p-5 sm:p-6 space-y-5">
                <div>
                    <label class="block text-sm font-bold text-gray-400 mb-1.5 uppercase tracking-wider">Judul Artikel</label>
                    <input type="text" name="title" value="{{ old('title') }}" x-model="title" @input="slug = title.toLowerCase().replace(/[^a-z0-9]+/g, '-').replace(/(^-|-$)/g, '')" class="input-brutal text-lg font-bold @error('title') border-brutal-red @enderror" placeholder="Judul artikel..." required>
                    @error('title')<p class="text-brutal-red text-sm mt-1 font-bold">{{ $message }}</p>@enderror
                    <p class="text-xs text-gray-500 mt-1.5 font-bold" x-show="slug">Slug: <span x-text="slug" class="text-brutal-orange"></span></p>
                </div>

                <div>
                    <label class="block text-sm font-bold text-gray-400 mb-1.5 uppercase tracking-wider">Konten</label>
                    <textarea name="content" id="content" class="hidden">{{ old('content') }}</textarea>
                    <trix-editor input="content" @trix-change="content = document.getElementById('content').value" @trix-initialize="content = document.getElementById('content').value" class="trix-content"></trix-editor>
                    @error('content')<p class="text-brutal-red text-sm mt-1 font-bold">{{ $message }}</p>@enderror
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
                    <div>
                        <label class="block text-sm font-bold text-gray-400 mb-1.5 uppercase tracking-wider">Excerpt</label>
                        <textarea name="excerpt" rows="3" class="input-brutal text-sm @error('excerpt') border-brutal-red @enderror" placeholder="Ringkasan singkat artikel...">{{ old('excerpt') }}</textarea>
                    </div>
                    <div>
                        <label class="block text-sm font-bold text-gray-400 mb-1.5 uppercase tracking-wider">Thumbnail</label>
                        <div class="border-2 border-dashed border-dark-border p-4 sm:p-6 text-center hover:border-brutal-orange transition cursor-pointer" x-data="{ thumbnailName: '' }">
                            <input type="file" name="thumbnail" accept="image/*" class="hidden" id="thumbnailInput" @change="thumbnailName = ($event.target.files[0]?.name.length > 20 ? $event.target.files[0]?.name.substring(0, 20) + '...' : $event.target.files[0]?.name) || ''">
                            <label for="thumbnailInput" class="cursor-pointer block">
                                <i class="fas fa-cloud-upload-alt text-3xl text-gray-600 mb-2"></i>
                                <p class="text-sm text-gray-500 font-bold uppercase tracking-wider" x-show="!thumbnailName">Klik untuk upload</p>
                                <p class="text-sm text-brutal-orange font-bold uppercase tracking-wider truncate max-w-full" x-show="thumbnailName" x-text="thumbnailName"></p>
                            </label>
                        </div>
                    </div>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
                    <div>
                        <label class="block text-sm font-bold text-gray-400 mb-1.5 uppercase tracking-wider">Kategori</label>
                        <select name="category_id" class="select-brutal text-sm @error('category_id') border-brutal-red @enderror" required>
                            <option value="">Pilih kategori</option>
                            @foreach($categories as $cat)
                            <option value="{{ $cat->id }}" {{ old('category_id') == $cat->id ? 'selected' : '' }}>{{ $cat->name }}</option>
                            @endforeach
                        </select>
                        @error('category_id')<p class="text-brutal-red text-sm mt-1 font-bold">{{ $message }}</p>@enderror
                    </div>
                    <div>
                        <label class="block text-sm font-bold text-gray-400 mb-1.5 uppercase tracking-wider">Status</label>
                        <div class="flex gap-3">
                            <label class="flex-1 flex items-center justify-center gap-2 px-4 py-3 border-2 cursor-pointer transition font-bold uppercase tracking-wider text-sm" :class="status === 'draft' ? 'border-brutal-orange bg-dark-card text-brutal-orange' : 'border-dark-border text-gray-500'">
                                <input type="radio" name="status" value="draft" x-model="status" class="hidden">
                                <i class="fas fa-pen"></i>
                                <span>Draf</span>
                            </label>
                            <label class="flex-1 flex items-center justify-center gap-2 px-4 py-3 border-2 cursor-pointer transition font-bold uppercase tracking-wider text-sm" :class="status === 'published' ? 'border-brutal-yellow bg-dark-card text-brutal-yellow' : 'border-dark-border text-gray-500'">
                                <input type="radio" name="status" value="published" x-model="status" class="hidden">
                                <i class="fas fa-clock"></i>
                                <span>Kirim (Pending)</span>
                            </label>
                        </div>
                    </div>
                </div>

                <div>
                    <label class="block text-sm font-bold text-gray-400 mb-2 uppercase tracking-wider">Tag</label>
                    <div class="flex flex-wrap gap-2">
                        @foreach($tags as $tag)
                        <label class="cursor-pointer">
                            <input type="checkbox" name="tags[]" value="{{ $tag->id }}" class="hidden peer" {{ in_array($tag->id, old('tags', [])) ? 'checked' : '' }}>
                            <span class="inline-block px-3 py-1.5 border-2 border-dark-border text-sm font-bold text-gray-500 peer-checked:bg-brutal-orange peer-checked:text-brutal-black peer-checked:border-brutal-black uppercase tracking-wider transition">#{{ $tag->name }}</span>
                        </label>
                        @endforeach
                    </div>
                </div>
            </div>

            <div class="flex flex-col sm:flex-row items-center justify-between gap-4">
                <button type="button" @click="preview = !preview" class="btn-ghost text-sm">
                    <i class="fas fa-eye mr-2"></i> <span x-text="preview ? 'Tutup Pratinjau' : 'Pratinjau'"></span>
                </button>
                <div class="flex gap-3 w-full sm:w-auto">
                    <a href="/dashboard" class="btn-ghost text-sm hover:border-brutal-red hover:text-brutal-red">Batal</a>
                    <button type="submit" class="btn-primary text-sm">
                        <i class="fas fa-paper-plane mr-2"></i> Simpan Artikel
                    </button>
                </div>
            </div>

            <div x-show="preview" x-cloak x-transition class="bg-dark-card border-2 border-dark-border p-5 sm:p-6">
                <h3 class="font-orbitron font-bold text-white mb-2 uppercase tracking-wider text-sm">Preview</h3>
                <h2 class="font-orbitron text-2xl font-bold text-white" x-html="title || 'Judul Artikel'"></h2>
                <hr class="my-4 border-dark-border">
                <div class="article-content" x-html="content || 'Konten artikel akan tampil di sini...'"></div>
            </div>
        </form>
    </div>
</section>
@endsection