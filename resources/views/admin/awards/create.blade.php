@extends('layouts.admin')

@section('header_title', 'Tambah Penghargaan')

@section('content')
<div class="max-w-5xl space-y-6">
    <div class="flex items-center gap-2">
        <a href="{{ route('admin.awards.index') }}" class="text-slate-400 hover:text-slate-600 transition-colors">
            <i class="fa-solid fa-arrow-left"></i> Kembali
        </a>
    </div>

    <div class="bg-white border border-slate-200 rounded-2xl p-6 md:p-8 shadow-sm">
        <h2 class="text-xl font-bold text-slate-800 border-b border-slate-100 pb-4 mb-6">Form Tambah Penghargaan</h2>

        <form action="{{ route('admin.awards.store') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
            @csrf

            <div>
                <label for="title" class="block text-xs font-bold text-slate-400 uppercase tracking-wider mb-2">Judul Penghargaan / Sertifikat — English</label>
                <input type="text" name="title" id="title" value="{{ old('title') }}" required placeholder="Contoh: Juara 1 Lomba Data Analysis"
                       class="w-full px-4 py-2.5 rounded-xl border border-slate-200 focus:outline-none focus:border-indigo-500 focus:ring-1 focus:ring-indigo-500 text-sm">
                @error('title')
                    <span class="text-xs text-rose-500 font-semibold mt-1 block">{{ $message }}</span>
                @enderror
            </div>
            <div>
                <label for="title_id" class="block text-xs font-bold text-slate-400 uppercase tracking-wider mb-2">Judul Penghargaan / Sertifikat — Indonesia</label>
                <input type="text" name="title_id" id="title_id" value="{{ old('title_id') }}" class="w-full px-4 py-2.5 rounded-xl border border-slate-200 focus:outline-none focus:border-indigo-500 focus:ring-1 focus:ring-indigo-500 text-sm">
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label for="issuer" class="block text-xs font-bold text-slate-400 uppercase tracking-wider mb-2">Penerbit / Penyelenggara</label>
                    <input type="text" name="issuer" id="issuer" value="{{ old('issuer') }}" placeholder="Contoh: Dicoding, Kampus, Google"
                           class="w-full px-4 py-2.5 rounded-xl border border-slate-200 focus:outline-none focus:border-indigo-500 focus:ring-1 focus:ring-indigo-500 text-sm">
                    @error('issuer')
                        <span class="text-xs text-rose-500 font-semibold mt-1 block">{{ $message }}</span>
                    @enderror
                </div>

                <div>
                    <label for="award_date" class="block text-xs font-bold text-slate-400 uppercase tracking-wider mb-2">Tanggal Penghargaan</label>
                    <input type="date" name="award_date" id="award_date" value="{{ old('award_date') }}"
                           class="w-full px-4 py-2.5 rounded-xl border border-slate-200 focus:outline-none focus:border-indigo-500 focus:ring-1 focus:ring-indigo-500 text-sm">
                    @error('award_date')
                        <span class="text-xs text-rose-500 font-semibold mt-1 block">{{ $message }}</span>
                    @enderror
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label for="image" class="block text-xs font-bold text-slate-400 uppercase tracking-wider mb-2">Gambar Preview Penghargaan</label>
                    <input type="file" name="image" id="image" accept="image/*"
                           class="w-full text-sm text-slate-500 file:mr-4 file:py-2 file:px-4 file:rounded-xl file:border-0 file:text-xs file:font-semibold file:bg-slate-100 file:text-slate-700 hover:file:bg-slate-200">
                    <span class="text-[10px] text-slate-400 mt-1 block">Format: JPG, PNG, WEBP. Maksimum: 4MB.</span>
                    @error('image')
                        <span class="text-xs text-rose-500 font-semibold mt-1 block">{{ $message }}</span>
                    @enderror
                </div>

                <div>
                    <label for="certificate" class="block text-xs font-bold text-slate-400 uppercase tracking-wider mb-2">File Sertifikat / Bukti</label>
                    <input type="file" name="certificate" id="certificate" accept=".pdf,.jpg,.jpeg,.png,.webp"
                           class="w-full text-sm text-slate-500 file:mr-4 file:py-2 file:px-4 file:rounded-xl file:border-0 file:text-xs file:font-semibold file:bg-slate-100 file:text-slate-700 hover:file:bg-slate-200">
                    <span class="text-[10px] text-slate-400 mt-1 block">Format: PDF, JPG, PNG, WEBP. Maksimum: 5MB.</span>
                    @error('certificate')
                        <span class="text-xs text-rose-500 font-semibold mt-1 block">{{ $message }}</span>
                    @enderror
                </div>
            </div>

            <div>
                <label for="external_url" class="block text-xs font-bold text-slate-400 uppercase tracking-wider mb-2">Link Verifikasi / Credential</label>
                <input type="url" name="external_url" id="external_url" value="{{ old('external_url') }}" placeholder="https://..."
                       class="w-full px-4 py-2.5 rounded-xl border border-slate-200 focus:outline-none focus:border-indigo-500 focus:ring-1 focus:ring-indigo-500 text-sm">
                @error('external_url')
                    <span class="text-xs text-rose-500 font-semibold mt-1 block">{{ $message }}</span>
                @enderror
            </div>

            <div class="flex items-center">
                <input type="checkbox" name="is_featured" id="is_featured" value="1" {{ old('is_featured') ? 'checked' : '' }}
                       class="w-4 h-4 rounded bg-slate-50 border border-slate-300 text-indigo-600 focus:ring-indigo-500 focus:ring-2">
                <label for="is_featured" class="ml-2 text-sm font-semibold text-slate-700 cursor-pointer">Tampilkan sebagai penghargaan unggulan</label>
            </div>

            <div>
                <label for="description" class="block text-xs font-bold text-slate-400 uppercase tracking-wider mb-2">Deskripsi Singkat — English</label>
                <textarea name="description" id="description" rows="5" placeholder="Jelaskan pencapaian, konteks lomba, pelatihan, atau sertifikasi..."
                          class="w-full px-4 py-2.5 rounded-xl border border-slate-200 focus:outline-none focus:border-indigo-500 focus:ring-1 focus:ring-indigo-500 text-sm">{{ old('description') }}</textarea>
                @error('description')
                    <span class="text-xs text-rose-500 font-semibold mt-1 block">{{ $message }}</span>
                @enderror
            </div>
            <div>
                <label for="description_id" class="block text-xs font-bold text-slate-400 uppercase tracking-wider mb-2">Deskripsi Singkat — Indonesia</label>
                <textarea name="description_id" id="description_id" rows="5" class="w-full px-4 py-2.5 rounded-xl border border-slate-200 focus:outline-none focus:border-indigo-500 focus:ring-1 focus:ring-indigo-500 text-sm">{{ old('description_id') }}</textarea>
            </div>

            <div class="pt-4 border-t border-slate-100 flex justify-end gap-3">
                <a href="{{ route('admin.awards.index') }}" class="px-4 py-2.5 rounded-xl border border-slate-200 hover:bg-slate-50 text-slate-600 text-sm font-semibold transition-colors">
                    Batal
                </a>
                <button type="submit" class="px-5 py-2.5 rounded-xl bg-indigo-600 hover:bg-indigo-700 text-white text-sm font-semibold shadow-md shadow-indigo-500/10 transition-colors">
                    Simpan Penghargaan
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
