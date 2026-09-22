@extends('layouts.admin')

@section('header_title', 'Pengaturan Profil')

@section('content')
<div class="max-w-5xl space-y-6">
    <div class="bg-white border border-slate-200 rounded-2xl p-6 md:p-8 shadow-sm">
        <h2 class="text-xl font-bold text-slate-800 border-b border-slate-100 pb-4 mb-6">Edit Informasi Profil & Bio</h2>
        
        <form action="{{ route('admin.profile.update') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
            @csrf
            @method('PUT')

            <!-- Name -->
            <div>
                <div>
                    <label for="name" class="block text-xs font-bold text-slate-400 uppercase tracking-wider mb-2">Nama Lengkap</label>
                    <input type="text" name="name" id="name" value="{{ old('name', $profile->name) }}" required placeholder="Nama Anda"
                           class="w-full px-4 py-2.5 rounded-xl border border-slate-200 focus:outline-none focus:border-indigo-500 focus:ring-1 focus:ring-indigo-500 text-sm">
                    @error('name')
                        <span class="text-xs text-rose-500 font-semibold mt-1 block">{{ $message }}</span>
                    @enderror
                </div>

            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label for="title_en" class="block text-xs font-bold text-slate-400 uppercase tracking-wider mb-2">Gelar Profesional — English</label>
                    <input type="text" name="title_en" id="title_en" value="{{ old('title_en', $profile->title_en ?: $profile->title) }}" required placeholder="Data Analyst & Engineer" class="w-full px-4 py-2.5 rounded-xl border border-slate-200 focus:outline-none focus:border-indigo-500 focus:ring-1 focus:ring-indigo-500 text-sm">
                    @error('title_en')<span class="text-xs text-rose-500 font-semibold mt-1 block">{{ $message }}</span>@enderror
                </div>
                <div>
                    <label for="title_id" class="block text-xs font-bold text-slate-400 uppercase tracking-wider mb-2">Gelar Profesional — Indonesia</label>
                    <input type="text" name="title_id" id="title_id" value="{{ old('title_id', $profile->title_id ?: $profile->title) }}" required placeholder="Analis Data & Engineer" class="w-full px-4 py-2.5 rounded-xl border border-slate-200 focus:outline-none focus:border-indigo-500 focus:ring-1 focus:ring-indigo-500 text-sm">
                    @error('title_id')<span class="text-xs text-rose-500 font-semibold mt-1 block">{{ $message }}</span>@enderror
                </div>
            </div>

            <!-- Email & Skills -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label for="email" class="block text-xs font-bold text-slate-400 uppercase tracking-wider mb-2">Email Kontak</label>
                    <input type="email" name="email" id="email" value="{{ old('email', $profile->email) }}" required placeholder="email@contoh.com"
                           class="w-full px-4 py-2.5 rounded-xl border border-slate-200 focus:outline-none focus:border-indigo-500 focus:ring-1 focus:ring-indigo-500 text-sm">
                    @error('email')
                        <span class="text-xs text-rose-500 font-semibold mt-1 block">{{ $message }}</span>
                    @enderror
                </div>

                <div>
                    <label for="skills" class="block text-xs font-bold text-slate-400 uppercase tracking-wider mb-2">Daftar Keahlian (Pisahkan dengan koma)</label>
                    <input type="text" name="skills" id="skills" value="{{ old('skills', $skillsString) }}" placeholder="Contoh: Python, SQL, Tableau, Laravel"
                           class="w-full px-4 py-2.5 rounded-xl border border-slate-200 focus:outline-none focus:border-indigo-500 focus:ring-1 focus:ring-indigo-500 text-sm">
                    @error('skills')
                        <span class="text-xs text-rose-500 font-semibold mt-1 block">{{ $message }}</span>
                    @enderror
                </div>
            </div>

            <!-- GitHub & LinkedIn -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label for="github_url" class="block text-xs font-bold text-slate-400 uppercase tracking-wider mb-2">URL Profil GitHub</label>
                    <input type="url" name="github_url" id="github_url" value="{{ old('github_url', $profile->github_url) }}" placeholder="https://github.com/username"
                           class="w-full px-4 py-2.5 rounded-xl border border-slate-200 focus:outline-none focus:border-indigo-500 focus:ring-1 focus:ring-indigo-500 text-sm">
                    @error('github_url')
                        <span class="text-xs text-rose-500 font-semibold mt-1 block">{{ $message }}</span>
                    @enderror
                </div>

                <div>
                    <label for="linkedin_url" class="block text-xs font-bold text-slate-400 uppercase tracking-wider mb-2">URL Profil LinkedIn</label>
                    <input type="url" name="linkedin_url" id="linkedin_url" value="{{ old('linkedin_url', $profile->linkedin_url) }}" placeholder="https://linkedin.com/in/username"
                           class="w-full px-4 py-2.5 rounded-xl border border-slate-200 focus:outline-none focus:border-indigo-500 focus:ring-1 focus:ring-indigo-500 text-sm">
                    @error('linkedin_url')
                        <span class="text-xs text-rose-500 font-semibold mt-1 block">{{ $message }}</span>
                    @enderror
                </div>
            </div>

            <!-- Profile Photo & CV Resume -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Photo -->
                <div>
                    <label for="photo" class="block text-xs font-bold text-slate-400 uppercase tracking-wider mb-2">Foto Profil (Rasio 1:1 disarankan)</label>
                    @if($profile->photo_path)
                        <div class="mb-3 w-24 h-24 rounded-xl overflow-hidden border border-slate-200 bg-slate-50">
                            <img src="{{ asset('storage/' . $profile->photo_path) }}" alt="{{ $profile->name }}" class="w-full h-full object-cover">
                        </div>
                    @endif
                    <input type="file" name="photo" id="photo" accept="image/*"
                           class="w-full text-sm text-slate-500 file:mr-4 file:py-2 file:px-4 file:rounded-xl file:border-0 file:text-xs file:font-semibold file:bg-slate-100 file:text-slate-700 hover:file:bg-slate-200">
                    <span class="text-[10px] text-slate-400 mt-1 block">Format: JPG, PNG, WEBP. Maks: 2MB.</span>
                    @error('photo')
                        <span class="text-xs text-rose-500 font-semibold mt-1 block">{{ $message }}</span>
                    @enderror
                </div>

                <!-- CV Document -->
                <div>
                    <label for="resume" class="block text-xs font-bold text-slate-400 uppercase tracking-wider mb-2">Berkas CV / Resume (PDF)</label>
                    @if($profile->resume_path)
                        <div class="mb-3 p-3 rounded-xl border border-indigo-100 bg-indigo-50/50 flex items-center gap-2">
                            <i class="fa-solid fa-file-pdf text-indigo-500 text-lg"></i>
                            <a href="{{ asset('storage/' . $profile->resume_path) }}" target="_blank" class="text-xs font-semibold text-indigo-700 hover:underline">
                                Lihat CV Terunggah
                            </a>
                        </div>
                    @endif
                    <input type="file" name="resume" id="resume" accept=".pdf,.doc,.docx"
                           class="w-full text-sm text-slate-500 file:mr-4 file:py-2 file:px-4 file:rounded-xl file:border-0 file:text-xs file:font-semibold file:bg-slate-100 file:text-slate-700 hover:file:bg-slate-200">
                    <span class="text-[10px] text-slate-400 mt-1 block">Format: PDF (sangat disarankan), Word. Maks: 5MB.</span>
                    @error('resume')
                        <span class="text-xs text-rose-500 font-semibold mt-1 block">{{ $message }}</span>
                    @enderror
                </div>
            </div>

            <!-- Biography / Summary -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label for="bio_en" class="block text-xs font-bold text-slate-400 uppercase tracking-wider mb-2">Biografi — English</label>
                    <textarea name="bio_en" id="bio_en" rows="7" required class="w-full px-4 py-2.5 rounded-xl border border-slate-200 focus:outline-none focus:border-indigo-500 focus:ring-1 focus:ring-indigo-500 text-sm">{{ old('bio_en', $profile->bio_en ?: $profile->bio) }}</textarea>
                    @error('bio_en')<span class="text-xs text-rose-500 font-semibold mt-1 block">{{ $message }}</span>@enderror
                </div>
                <div>
                    <label for="bio_id" class="block text-xs font-bold text-slate-400 uppercase tracking-wider mb-2">Biografi — Indonesia</label>
                    <textarea name="bio_id" id="bio_id" rows="7" required class="w-full px-4 py-2.5 rounded-xl border border-slate-200 focus:outline-none focus:border-indigo-500 focus:ring-1 focus:ring-indigo-500 text-sm">{{ old('bio_id', $profile->bio_id ?: $profile->bio) }}</textarea>
                    @error('bio_id')<span class="text-xs text-rose-500 font-semibold mt-1 block">{{ $message }}</span>@enderror
                </div>
            </div>

            <!-- Form Actions -->
            <div class="pt-4 border-t border-slate-100 flex justify-end">
                <button type="submit" class="px-5 py-2.5 rounded-xl bg-indigo-600 hover:bg-indigo-700 text-white text-sm font-semibold shadow-md shadow-indigo-500/10 transition-colors">
                    Perbarui Profil
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
