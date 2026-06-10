@extends('layouts.app')
@section('title', 'Edit Profil - Nexus Gaming')
@section('meta_description', 'Edit profil pengguna.')

@push('styles')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.6.2/cropper.min.css">
<style>
.cropper-container { max-height: 400px; }
.cropper-view-box { border-radius: 50%; outline-color: #FF6B35; }
.cropper-point { background-color: #FF6B35; }
.cropper-line { border-color: #FF6B35; }
.cropper-modal { opacity: 0.6; }
</style>
@endpush

@section('content')
<section class="min-h-screen bg-dark-bg py-16 sm:py-20">
    <div class="max-w-2xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex items-center gap-3 mb-8">
            <a href="/dashboard" class="p-2 bg-dark-card border-2 border-dark-border hover:border-brutal-orange transition flex-shrink-0"><i class="fas fa-arrow-left text-gray-500"></i></a>
            <div>
                <h1 class="font-orbitron text-2xl sm:text-3xl font-black text-white uppercase tracking-wide">Edit Profil</h1>
                <p class="text-gray-500 text-sm mt-1 font-bold uppercase tracking-wider">Perbarui informasi akun kamu</p>
            </div>
        </div>
        <div class="glass-card p-6 sm:p-8">
            @if(session('success'))
            <div class="bg-brutal-black border-2 border-brutal-green text-brutal-green px-4 sm:px-5 py-3 mb-4 sm:mb-6 text-sm flex items-center gap-2 font-bold uppercase tracking-wider">
                <i class="fas fa-check-circle"></i> {{ session('success') }}
            </div>
            @endif

            <form method="POST" action="/profile" class="space-y-5">
                @csrf
                @method('PUT')

                <div>
                    <label class="block text-sm font-bold text-gray-400 mb-2 uppercase tracking-wider">Foto Profil</label>
                    <div class="flex items-center gap-4 sm:gap-6">
                        <div class="flex-shrink-0 relative">
                            <img src="{{ auth()->user()->avatarUrl(120) }}" id="avatarPreview" class="w-20 h-20 sm:w-24 sm:h-24 rounded border-2 border-brutal-orange object-cover">
                        </div>
                        <div class="flex-1 space-y-2">
                            <button type="button" id="chooseAvatarBtn" class="btn-outline text-xs px-3 py-1.5">
                                <i class="fas fa-camera mr-1"></i> Pilih Foto
                            </button>
                            <input type="file" id="avatarInput" accept="image/jpeg,image/png,image/jpg,image/gif,image.webp" class="hidden">
                            <input type="hidden" name="avatar" id="avatarData">
                            <p class="text-xs text-gray-600 font-bold uppercase tracking-wider">Klik untuk upload, lalu atur zoom &amp; rotasi sebelum menyimpan</p>
                            @error('avatar')<p class="text-brutal-red text-sm mt-1 font-bold">{{ $message }}</p>@enderror
                        </div>
                    </div>
                </div>

                <div>
                    <label class="block text-sm font-bold text-gray-400 mb-1.5 uppercase tracking-wider">Nama</label>
                    <input type="text" name="name" value="{{ old('name', auth()->user()->name) }}" class="input-brutal @error('name') border-brutal-red @enderror" required>
                    @error('name')<p class="text-brutal-red text-sm mt-1 font-bold">{{ $message }}</p>@enderror
                </div>
                <div>
                    <label class="block text-sm font-bold text-gray-400 mb-1.5 uppercase tracking-wider">Email</label>
                    <input type="email" name="email" value="{{ old('email', auth()->user()->email) }}" class="input-brutal @error('email') border-brutal-red @enderror" required>
                    @error('email')<p class="text-brutal-red text-sm mt-1 font-bold">{{ $message }}</p>@enderror
                </div>

                <div>
                    <label class="block text-sm font-bold text-gray-400 mb-1.5 uppercase tracking-wider">Bio / Tentang</label>
                    <textarea name="bio" rows="3" class="input-brutal resize-none @error('bio') border-brutal-red @enderror" placeholder="Tulis biodata singkat kamu...">{{ old('bio', auth()->user()->bio) }}</textarea>
                    @error('bio')<p class="text-brutal-red text-sm mt-1 font-bold">{{ $message }}</p>@enderror
                </div>

                <div class="flex gap-3 pt-2 justify-end">
                    <a href="/dashboard" class="btn-ghost text-sm hover:border-brutal-red hover:text-brutal-red">Batal</a>
                    <button type="submit" class="btn-primary text-sm">Simpan Perubahan</button>
                </div>
            </form>
        </div>
    </div>
</section>

{{-- Cropper Modal --}}
<div id="cropperModal" class="fixed inset-0 z-[60] flex items-center justify-center bg-black/80 hidden" x-data>
    <div class="bg-dark-card border-2 border-brutal-orange w-full max-w-lg mx-4 p-4 sm:p-6">
        <div class="flex items-center justify-between mb-4">
            <h3 class="font-orbitron font-bold text-white uppercase tracking-wider text-sm">Atur Foto Profil</h3>
            <button type="button" id="closeCropper" class="text-gray-500 hover:text-brutal-red transition p-1"><i class="fas fa-times"></i></button>
        </div>
        <div class="bg-black rounded overflow-hidden mb-4">
            <img id="cropImage" class="max-w-full">
        </div>
        <div class="flex items-center justify-center gap-3 mb-4">
            <button type="button" id="zoomIn" class="p-2 bg-dark-bg border-2 border-dark-border hover:border-brutal-orange text-white transition" title="Perbesar"><i class="fas fa-search-plus"></i></button>
            <button type="button" id="zoomOut" class="p-2 bg-dark-bg border-2 border-dark-border hover:border-brutal-orange text-white transition" title="Perkecil"><i class="fas fa-search-minus"></i></button>
            <button type="button" id="rotateLeft" class="p-2 bg-dark-bg border-2 border-dark-border hover:border-brutal-orange text-white transition" title="Putar Kiri"><i class="fas fa-undo-alt"></i></button>
            <button type="button" id="rotateRight" class="p-2 bg-dark-bg border-2 border-dark-border hover:border-brutal-orange text-white transition" title="Putar Kanan"><i class="fas fa-redo-alt"></i></button>
            <button type="button" id="resetCropper" class="p-2 bg-dark-bg border-2 border-dark-border hover:border-brutal-red text-white transition" title="Reset"><i class="fas fa-undo"></i></button>
        </div>
        <div class="flex gap-3 justify-end">
            <button type="button" id="cancelCrop" class="btn-ghost text-sm hover:border-brutal-red hover:text-brutal-red">Batal</button>
            <button type="button" id="applyCrop" class="btn-primary text-sm">Simpan Foto</button>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script src="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.6.2/cropper.min.js">
</script>
<script>
    const avatarInput = document.getElementById('avatarInput');
    const chooseBtn = document.getElementById('chooseAvatarBtn');
    const cropperModal = document.getElementById('cropperModal');
    const cropImage = document.getElementById('cropImage');
    const avatarPreview = document.getElementById('avatarPreview');
    const avatarData = document.getElementById('avatarData');
    const closeCropper = document.getElementById('closeCropper');
    const cancelCrop = document.getElementById('cancelCrop');
    const applyCrop = document.getElementById('applyCrop');
    const zoomIn = document.getElementById('zoomIn');
    const zoomOut = document.getElementById('zoomOut');
    const rotateLeft = document.getElementById('rotateLeft');
    const rotateRight = document.getElementById('rotateRight');
    const resetCropper = document.getElementById('resetCropper');

    let cropper = null;
    let currentFile = null;

    chooseBtn.addEventListener('click', () => avatarInput.click());

    avatarInput.addEventListener('change', function(e) {
        const file = e.target.files[0];
        if (!file) return;

        if (!file.type.startsWith('image/')) return;

        currentFile = file;
        const reader = new FileReader();
        reader.onload = function(ev) {
            cropImage.src = ev.target.result;
            cropperModal.classList.remove('hidden');
            document.body.style.overflow = 'hidden';

            if (cropper) cropper.destroy();
            cropper = new Cropper(cropImage, {
                aspectRatio: 1 / 1,
                viewMode: 1,
                dragMode: 'move',
                autoCropArea: 1,
                cropBoxResizable: true,
                cropBoxMovable: true,
                rotatable: true,
                zoomable: true,
                zoomOnTouch: true,
                zoomOnWheel: true,
                minCropBoxWidth: 80,
                minCropBoxHeight: 80,
            });
        };
        reader.readAsDataURL(file);
        avatarInput.value = '';
    });

    function closeModal() {
        cropperModal.classList.add('hidden');
        document.body.style.overflow = '';
        if (cropper) {
            cropper.destroy();
            cropper = null;
        }
        currentFile = null;
    }

    closeCropper.addEventListener('click', closeModal);
    cancelCrop.addEventListener('click', closeModal);

    applyCrop.addEventListener('click', function() {
        if (!cropper) return;

        const canvas = cropper.getCroppedCanvas({
            width: 400,
            height: 400,
            imageSmoothingEnabled: true,
            imageSmoothingQuality: 'high',
        });

        const dataUrl = canvas.toDataURL('image/webp', 0.8);
        avatarData.value = dataUrl;
        avatarPreview.src = dataUrl;
        closeModal();
    });

    zoomIn.addEventListener('click', () => cropper?.zoom(0.1));
    zoomOut.addEventListener('click', () => cropper?.zoom(-0.1));
    rotateLeft.addEventListener('click', () => cropper?.rotate(-90));
    rotateRight.addEventListener('click', () => cropper?.rotate(90));
    resetCropper.addEventListener('click', () => cropper?.reset());
</script>
@endpush
