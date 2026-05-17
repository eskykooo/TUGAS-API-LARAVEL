@extends('layouts.app')
@section('title', 'Edit Artikel - BlogCMS')
@section('meta_description', 'Edit artikel.')

@section('content')
<section class="min-h-screen bg-slate-50 dark:bg-slate-900 py-16 sm:py-20">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex items-center gap-3 mb-8">
            <a href="/dashboard" class="p-2 rounded-xl hover:bg-slate-200 dark:hover:bg-slate-700 transition flex-shrink-0"><i class="fas fa-arrow-left text-slate-600 dark:text-slate-400"></i></a>
            <div>
                <h1 class="text-2xl sm:text-3xl font-bold text-slate-800 dark:text-white">Edit Artikel</h1>
                <p class="text-slate-500 dark:text-slate-400 text-sm">Perbarui konten artikel</p>
            </div>
        </div>

        <form method="POST" action="/dashboard/articles/{{ $article->id }}" enctype="multipart/form-data" class="space-y-6" x-data="{ title: '{{ str_replace("'", "\\'", $article->title) }}', content: `{{ str_replace("`", "\\`", $article->content) }}`, status: '{{ $article->status }}', preview: false }">
            @csrf
            @method('PUT')

            <div class="bg-white dark:bg-slate-800 rounded-2xl p-5 sm:p-6 shadow-sm border border-slate-100 dark:border-slate-700 space-y-5">
                <div>
                    <label class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-1.5">Judul Artikel</label>
                    <input type="text" name="title" value="{{ old('title', $article->title) }}" x-model="title" class="w-full px-4 py-3 bg-slate-50 dark:bg-slate-900 border-2 border-slate-200 dark:border-slate-700 rounded-xl outline-none focus:border-sky-500 focus:ring-2 focus:ring-sky-500/20 transition text-lg font-semibold @error('title') border-red-500 @enderror" placeholder="Judul artikel..." required>
                    @error('title')<p class="text-red-500 text-sm mt-1">{{ $message }}</p>@enderror
                </div>

                <div>
                    <label class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-1.5">Konten</label>
                    <textarea name="content" rows="15" x-model="content" class="w-full px-4 py-3 bg-slate-50 dark:bg-slate-900 border-2 border-slate-200 dark:border-slate-700 rounded-xl outline-none focus:border-sky-500 focus:ring-2 focus:ring-sky-500/20 transition font-mono text-sm @error('content') border-red-500 @enderror" placeholder="Tulis konten artikel di sini..." required>{{ old('content', $article->content) }}</textarea>
                    @error('content')<p class="text-red-500 text-sm mt-1">{{ $message }}</p>@enderror
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
                    <div>
                        <label class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-1.5">Excerpt</label>
                        <textarea name="excerpt" rows="3" class="w-full px-4 py-3 bg-slate-50 dark:bg-slate-900 border-2 border-slate-200 dark:border-slate-700 rounded-xl outline-none focus:border-sky-500 focus:ring-2 focus:ring-sky-500/20 transition text-sm" placeholder="Ringkasan singkat artikel...">{{ old('excerpt', $article->excerpt) }}</textarea>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-1.5">Thumbnail</label>
                        @if($article->thumbnail)
                        <div class="mb-2">
                            <img src="https://picsum.photos/seed/{{ $article->slug }}/400/200" class="w-full h-32 object-cover rounded-xl">
                        </div>
                        @endif
                        <div class="border-2 border-dashed border-slate-200 dark:border-slate-700 rounded-xl p-4 sm:p-6 text-center hover:border-sky-500 transition cursor-pointer" x-data="{ thumbnailName: '' }">
                            <input type="file" name="thumbnail" accept="image/*" class="hidden" id="thumbnailInput" @change="thumbnailName = $event.target.files[0]?.name || ''">
                            <label for="thumbnailInput" class="cursor-pointer block">
                                <i class="fas fa-cloud-upload-alt text-3xl text-slate-300 dark:text-slate-600 mb-2"></i>
                                <p class="text-sm text-slate-500 dark:text-slate-400" x-show="!thumbnailName">Klik untuk ganti gambar</p>
                                <p class="text-sm text-sky-500 font-medium" x-show="thumbnailName" x-text="thumbnailName"></p>
                            </label>
                        </div>
                    </div>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
                    <div>
                        <label class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-1.5">Kategori</label>
                        <select name="category_id" class="w-full px-4 py-3 bg-slate-50 dark:bg-slate-900 border-2 border-slate-200 dark:border-slate-700 rounded-xl outline-none focus:border-sky-500 focus:ring-2 focus:ring-sky-500/20 transition text-sm" required>
                            <option value="">Pilih kategori</option>
                            @foreach($categories as $cat)
                            <option value="{{ $cat->id }}" {{ old('category_id', $article->category_id) == $cat->id ? 'selected' : '' }}>{{ $cat->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-1.5">Status</label>
                        <div class="flex gap-3">
                            <label class="flex-1 flex items-center justify-center gap-2 px-4 py-3 rounded-xl border-2 cursor-pointer transition" :class="status === 'draft' ? 'border-sky-500 bg-sky-50 dark:bg-sky-900/20 text-sky-600' : 'border-slate-200 dark:border-slate-700 text-slate-500'">
                                <input type="radio" name="status" value="draft" x-model="status" class="hidden">
                                <i class="fas fa-pen"></i>
                                <span class="font-medium text-sm">Draf</span>
                            </label>
                            <label class="flex-1 flex items-center justify-center gap-2 px-4 py-3 rounded-xl border-2 cursor-pointer transition" :class="status === 'published' ? 'border-green-500 bg-green-50 dark:bg-green-900/20 text-green-600' : 'border-slate-200 dark:border-slate-700 text-slate-500'">
                                <input type="radio" name="status" value="published" x-model="status" class="hidden">
                                <i class="fas fa-globe"></i>
                                <span class="font-medium text-sm">Terbit</span>
                            </label>
                        </div>
                    </div>
                </div>

                <div>
                    <label class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-2">Tag</label>
                    <div class="flex flex-wrap gap-2">
                        @foreach($tags as $tag)
                        @php $checked = $article->tags->contains($tag->id); @endphp
                        <label class="cursor-pointer">
                            <input type="checkbox" name="tags[]" value="{{ $tag->id }}" class="hidden peer" {{ $checked ? 'checked' : '' }}>
                            <span class="inline-block px-3 py-1.5 rounded-lg border-2 border-slate-200 dark:border-slate-700 text-sm font-medium text-slate-600 dark:text-slate-400 peer-checked:bg-sky-500 peer-checked:text-white peer-checked:border-sky-500 transition">{{ $checked ? '#'.$tag->name : $tag->name }}</span>
                        </label>
                        @endforeach
                    </div>
                </div>
            </div>

            <div class="flex flex-col sm:flex-row items-center justify-between gap-4">
                <button type="button" @click="preview = !preview" class="w-full sm:w-auto px-5 py-3 border-2 border-slate-200 dark:border-slate-700 rounded-xl text-sm font-medium text-slate-600 dark:text-slate-400 hover:border-sky-500 hover:text-sky-500 transition">
                    <i class="fas fa-eye mr-2"></i> <span x-text="preview ? 'Tutup Pratinjau' : 'Pratinjau'"></span>
                </button>
                <div class="flex gap-3 w-full sm:w-auto">
                    <a href="/dashboard" class="flex-1 sm:flex-none text-center px-5 py-3 rounded-xl border-2 border-slate-200 dark:border-slate-700 text-sm font-medium text-slate-600 dark:text-slate-400 hover:border-red-400 hover:text-red-500 transition">Batal</a>
                    <button type="submit" class="flex-1 sm:flex-none px-6 py-3 bg-sky-500 hover:bg-sky-600 text-white rounded-xl font-semibold text-sm transition shadow-md min-h-[44px]">
                        <i class="fas fa-save mr-2"></i> Perbarui Artikel
                    </button>
                </div>
            </div>

            <div x-show="preview" x-cloak x-transition class="bg-white dark:bg-slate-800 rounded-2xl p-5 sm:p-6 shadow-sm border border-slate-100 dark:border-slate-700">
                <h3 class="font-bold text-slate-800 dark:text-white mb-2">Preview</h3>
                <h2 class="text-2xl font-bold text-slate-800 dark:text-white" x-html="title || 'Judul Artikel'"></h2>
                <hr class="my-4 border-slate-200 dark:border-slate-700">
                <div class="text-slate-800 dark:text-slate-200 whitespace-pre-wrap" x-html="content || 'Konten artikel akan tampil di sini...'"></div>
            </div>
        </form>
    </div>
</section>
@endsection