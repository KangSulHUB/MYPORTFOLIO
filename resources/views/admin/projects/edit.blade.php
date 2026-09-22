@extends('layouts.admin')

@section('header_title', 'Edit Proyek')

@section('content')
<div class="max-w-5xl space-y-6">
    <div class="flex items-center gap-2">
        <a href="{{ route('admin.projects.index') }}" class="text-slate-400 hover:text-slate-600 transition-colors">
            <i class="fa-solid fa-arrow-left"></i> Kembali
        </a>
    </div>

    <div class="bg-white border border-slate-200 rounded-2xl p-6 md:p-8 shadow-sm">
        <h2 class="text-xl font-bold text-slate-800 border-b border-slate-100 pb-4 mb-6">Form Edit Proyek</h2>
        
        <form action="{{ route('admin.projects.update', $project->id) }}" method="POST" enctype="multipart/form-data" class="space-y-6">
            @csrf
            @method('PUT')

            <!-- Title -->
            <div>
                <label for="title" class="block text-xs font-bold text-slate-400 uppercase tracking-wider mb-2">Judul Proyek / Tugas — English</label>
                <input type="text" name="title" id="title" value="{{ old('title', $project->title) }}" required placeholder="Contoh: Sentiment Analysis Pipeline"
                       class="w-full px-4 py-2.5 rounded-xl border border-slate-200 focus:outline-none focus:border-indigo-500 focus:ring-1 focus:ring-indigo-500 text-sm">
                @error('title')
                    <span class="text-xs text-rose-500 font-semibold mt-1 block">{{ $message }}</span>
                @enderror
            </div>
            <div>
                <label for="title_id" class="block text-xs font-bold text-slate-400 uppercase tracking-wider mb-2">Judul Proyek / Tugas — Indonesia</label>
                <input type="text" name="title_id" id="title_id" value="{{ old('title_id', $project->title_id ?: $project->title) }}" class="w-full px-4 py-2.5 rounded-xl border border-slate-200 focus:outline-none focus:border-indigo-500 focus:ring-1 focus:ring-indigo-500 text-sm">
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Category -->
                <div>
                    <label for="category" class="block text-xs font-bold text-slate-400 uppercase tracking-wider mb-2">Kategori — English</label>
                    <input type="text" name="category" id="category" value="{{ old('category', $project->category) }}" required placeholder="Contoh: Data Engineering, Web Dev"
                           class="w-full px-4 py-2.5 rounded-xl border border-slate-200 focus:outline-none focus:border-indigo-500 focus:ring-1 focus:ring-indigo-500 text-sm">
                    @error('category')
                        <span class="text-xs text-rose-500 font-semibold mt-1 block">{{ $message }}</span>
                    @enderror
                </div>

                <div>
                    <label for="category_id" class="block text-xs font-bold text-slate-400 uppercase tracking-wider mb-2">Kategori — Indonesia</label>
                    <input type="text" name="category_id" id="category_id" value="{{ old('category_id', $project->category_id ?: $project->category) }}" class="w-full px-4 py-2.5 rounded-xl border border-slate-200 focus:outline-none focus:border-indigo-500 focus:ring-1 focus:ring-indigo-500 text-sm">
                </div>

                <!-- Tags -->
                <div>
                    <label for="tags" class="block text-xs font-bold text-slate-400 uppercase tracking-wider mb-2">Tags / Teknologi (Pisahkan dengan koma)</label>
                    <input type="text" name="tags" id="tags" value="{{ old('tags', $tagsString) }}" placeholder="Contoh: Python, PostgreSQL, Airflow, Spark"
                           class="w-full px-4 py-2.5 rounded-xl border border-slate-200 focus:outline-none focus:border-indigo-500 focus:ring-1 focus:ring-indigo-500 text-sm">
                    <span class="text-[10px] text-slate-400 mt-1 block">Tulis beberapa teknologi yang digunakan dipisahkan tanda koma ( , )</span>
                    @error('tags')
                        <span class="text-xs text-rose-500 font-semibold mt-1 block">{{ $message }}</span>
                    @enderror
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label for="image" class="block text-xs font-bold text-slate-400 uppercase tracking-wider mb-2">Gambar Preview Proyek</label>
                    
                    @if($project->image_path)
                        <div class="mb-3 w-48 rounded-xl overflow-hidden border border-slate-200 bg-slate-50">
                            <img src="{{ asset('storage/' . $project->image_path) }}" alt="{{ $project->title }}" class="w-full h-full object-cover">
                        </div>
                    @endif
                    
                    <input type="file" name="image" id="image" accept="image/*"
                           class="w-full text-sm text-slate-500 file:mr-4 file:py-2 file:px-4 file:rounded-xl file:border-0 file:text-xs file:font-semibold file:bg-slate-100 file:text-slate-700 hover:file:bg-slate-200">
                    <span class="text-[10px] text-slate-400 mt-1 block">Pilih file baru jika ingin mengubah gambar preview. Format: JPG, PNG, WEBP. Maks: 4MB.</span>
                    @error('image')
                        <span class="text-xs text-rose-500 font-semibold mt-1 block">{{ $message }}</span>
                    @enderror
                </div>

                <div>
                    <label for="video" class="block text-xs font-bold text-slate-400 uppercase tracking-wider mb-2">Video Proyek (opsional)</label>
                    @if($project->video_path)
                        <div class="mb-3 text-xs text-slate-500">Video saat ini tersimpan. Unggah yang baru jika ingin menggantinya.</div>
                    @endif
                    <input type="file" name="video" id="video" accept="video/*"
                           class="w-full text-sm text-slate-500 file:mr-4 file:py-2 file:px-4 file:rounded-xl file:border-0 file:text-xs file:font-semibold file:bg-slate-100 file:text-slate-700 hover:file:bg-slate-200">
                    <span class="text-[10px] text-slate-400 mt-1 block">Format: MP4, WEBM, OGG. Maksimum: 20MB.</span>
                    @error('video')
                        <span class="text-xs text-rose-500 font-semibold mt-1 block">{{ $message }}</span>
                    @enderror
                </div>
            </div>

            <div>
                <label for="video_url" class="block text-xs font-bold text-slate-400 uppercase tracking-wider mb-2">Tautan Video / Demo Eksternal</label>
                <input type="url" name="video_url" id="video_url" value="{{ old('video_url', $project->video_url) }}" placeholder="https://www.youtube.com/watch?v=..."
                       class="w-full px-4 py-2.5 rounded-xl border border-slate-200 focus:outline-none focus:border-indigo-500 focus:ring-1 focus:ring-indigo-500 text-sm">
                @error('video_url')
                    <span class="text-xs text-rose-500 font-semibold mt-1 block">{{ $message }}</span>
                @enderror
            </div>

            <div>
                <label for="attachments" class="block text-xs font-bold text-slate-400 uppercase tracking-wider mb-2">Lampiran Proyek (file, PDF, dokumen, zip)</label>
                <input type="file" name="attachments[]" id="attachments" multiple accept=".pdf,.doc,.docx,.ppt,.pptx,.zip,.rar,.jpg,.jpeg,.png,.webp,.mp4,.webm,.ogg"
                       class="w-full text-sm text-slate-500 file:mr-4 file:py-2 file:px-4 file:rounded-xl file:border-0 file:text-xs file:font-semibold file:bg-slate-100 file:text-slate-700 hover:file:bg-slate-200">
                <span class="text-[10px] text-slate-400 mt-1 block">Unggah file baru untuk menggantikan lampiran lama. Maksimal 10MB per file.</span>
                @error('attachments')
                    <span class="text-xs text-rose-500 font-semibold mt-1 block">{{ $message }}</span>
                @enderror
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- GitHub URL -->
                <div>
                    <label for="github_url" class="block text-xs font-bold text-slate-400 uppercase tracking-wider mb-2">Link Repository GitHub</label>
                    <input type="url" name="github_url" id="github_url" value="{{ old('github_url', $project->github_url) }}" placeholder="https://github.com/username/project"
                           class="w-full px-4 py-2.5 rounded-xl border border-slate-200 focus:outline-none focus:border-indigo-500 focus:ring-1 focus:ring-indigo-500 text-sm">
                    @error('github_url')
                        <span class="text-xs text-rose-500 font-semibold mt-1 block">{{ $message }}</span>
                    @enderror
                </div>

                <!-- Demo URL -->
                <div>
                    <label for="demo_url" class="block text-xs font-bold text-slate-400 uppercase tracking-wider mb-2">Link Demo / Live Web</label>
                    <input type="url" name="demo_url" id="demo_url" value="{{ old('demo_url', $project->demo_url) }}" placeholder="https://myproject.demo"
                           class="w-full px-4 py-2.5 rounded-xl border border-slate-200 focus:outline-none focus:border-indigo-500 focus:ring-1 focus:ring-indigo-500 text-sm">
                    @error('demo_url')
                        <span class="text-xs text-rose-500 font-semibold mt-1 block">{{ $message }}</span>
                    @enderror
                </div>
            </div>

            <!-- Featured Status -->
            <div class="flex items-center">
                <input type="checkbox" name="is_featured" id="is_featured" value="1" {{ old('is_featured', $project->is_featured) ? 'checked' : '' }}
                       class="w-4 h-4 rounded bg-slate-50 border border-slate-300 text-indigo-600 focus:ring-indigo-500 focus:ring-2">
                <label for="is_featured" class="ml-2 text-sm font-semibold text-slate-700 cursor-pointer">Tampilkan sebagai Proyek Unggulan (Akan diprioritaskan di halaman depan)</label>
            </div>

            <!-- Description -->
            <div>
                <label for="description" class="block text-xs font-bold text-slate-400 uppercase tracking-wider mb-2">Deskripsi Proyek — English</label>
                <textarea name="description" id="description" rows="6" required placeholder="Jelaskan tentang proyek ini secara detail..."
                          class="w-full px-4 py-2.5 rounded-xl border border-slate-200 focus:outline-none focus:border-indigo-500 focus:ring-1 focus:ring-indigo-500 text-sm">{{ old('description', $project->description) }}</textarea>
                @error('description')
                    <span class="text-xs text-rose-500 font-semibold mt-1 block">{{ $message }}</span>
                @enderror
            </div>
            <div>
                <label for="description_id" class="block text-xs font-bold text-slate-400 uppercase tracking-wider mb-2">Deskripsi Proyek — Indonesia</label>
                <textarea name="description_id" id="description_id" rows="6" class="w-full px-4 py-2.5 rounded-xl border border-slate-200 focus:outline-none focus:border-indigo-500 focus:ring-1 focus:ring-indigo-500 text-sm">{{ old('description_id', $project->description_id ?: $project->description) }}</textarea>
            </div>

            <!-- Form Actions -->
            <div class="pt-4 border-t border-slate-100 flex justify-end gap-3">
                <a href="{{ route('admin.projects.index') }}" class="px-4 py-2.5 rounded-xl border border-slate-200 hover:bg-slate-50 text-slate-600 text-sm font-semibold transition-colors">
                    Batal
                </a>
                <button type="submit" class="px-5 py-2.5 rounded-xl bg-indigo-600 hover:bg-indigo-700 text-white text-sm font-semibold shadow-md shadow-indigo-500/10 transition-colors">
                    Perbarui Proyek
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
