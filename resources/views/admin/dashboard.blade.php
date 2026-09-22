@extends('layouts.admin')

@section('header_title', 'Dashboard')

@section('content')
<div class="space-y-8">
    <!-- Welcome Header -->
    <div class="bg-white rounded-2xl border border-slate-200 p-6 md:p-8 flex flex-col md:flex-row items-center justify-between gap-6 shadow-sm">
        <div class="space-y-2 text-center md:text-left">
            <h2 class="text-2xl font-extrabold text-slate-800">Selamat Datang, Admin!</h2>
            <p class="text-slate-500 text-sm max-w-md">Di sini Anda dapat mengontrol isi website portfolio Anda seperti proyek, tugas, pengalaman kerja, pendidikan, dan biografi pribadi.</p>
        </div>
        <div class="flex-shrink-0">
            <a href="{{ route('home') }}" target="_blank" class="px-5 py-2.5 font-semibold text-sm rounded-xl bg-indigo-600 hover:bg-indigo-700 text-white shadow-md shadow-indigo-500/10 hover:shadow-indigo-500/20 transition-all inline-flex items-center gap-2">
                <i class="fa-solid fa-eye"></i> Lihat Portfolio
            </a>
        </div>
    </div>

    <!-- Quick Stats Grid -->
    <div class="grid grid-cols-1 sm:grid-cols-2 xl:grid-cols-4 gap-6">
        <!-- Projects Stat -->
        <div class="bg-white border border-slate-200 rounded-2xl p-6 flex items-center justify-between shadow-sm">
            <div class="space-y-1">
                <span class="text-slate-400 text-xs font-semibold uppercase tracking-wider">Total Proyek</span>
                <h3 class="text-3xl font-extrabold text-slate-800">{{ $projectCount }}</h3>
            </div>
            <div class="w-12 h-12 rounded-xl bg-indigo-50 border border-indigo-100 flex items-center justify-center text-indigo-500 text-xl">
                <i class="fa-solid fa-diagram-project"></i>
            </div>
        </div>

        <!-- Experiences Stat -->
        <div class="bg-white border border-slate-200 rounded-2xl p-6 flex items-center justify-between shadow-sm">
            <div class="space-y-1">
                <span class="text-slate-400 text-xs font-semibold uppercase tracking-wider">Total Pengalaman</span>
                <h3 class="text-3xl font-extrabold text-slate-800">{{ $experienceCount }}</h3>
            </div>
            <div class="w-12 h-12 rounded-xl bg-cyan-50 border border-cyan-100 flex items-center justify-center text-cyan-500 text-xl">
                <i class="fa-solid fa-graduation-cap"></i>
            </div>
        </div>

        <!-- Awards Stat -->
        <div class="bg-white border border-slate-200 rounded-2xl p-6 flex items-center justify-between shadow-sm">
            <div class="space-y-1">
                <span class="text-slate-400 text-xs font-semibold uppercase tracking-wider">Total Penghargaan</span>
                <h3 class="text-3xl font-extrabold text-slate-800">{{ $awardCount }}</h3>
            </div>
            <div class="w-12 h-12 rounded-xl bg-amber-50 border border-amber-100 flex items-center justify-center text-amber-500 text-xl">
                <i class="fa-solid fa-trophy"></i>
            </div>
        </div>

        <!-- Profile Stat/Status -->
        <div class="bg-white border border-slate-200 rounded-2xl p-6 flex items-center justify-between shadow-sm">
            <div class="space-y-1">
                <span class="text-slate-400 text-xs font-semibold uppercase tracking-wider">Status Profil</span>
                <h3 class="text-sm font-bold text-slate-700 truncate max-w-[200px]">
                    {{ $profile->name ?? 'Belum Diatur' }}
                </h3>
                <span class="text-xs text-slate-400 block">
                    {{ $profile ? ($profile->photo_path ? 'Foto Profil: Ada' : 'Foto Profil: Belum ada') : '' }}
                </span>
            </div>
            <div class="w-12 h-12 rounded-xl bg-emerald-50 border border-emerald-100 flex items-center justify-center text-emerald-500 text-xl">
                <i class="fa-solid fa-user-check"></i>
            </div>
        </div>
    </div>

    <!-- Quick Actions & Profile Preview -->
    <div class="grid grid-cols-1 xl:grid-cols-3 gap-6">
        <!-- Actions Card -->
        <div class="bg-white border border-slate-200 rounded-2xl p-6 shadow-sm xl:col-span-1 space-y-4">
            <h3 class="font-extrabold text-slate-800 text-lg border-b border-slate-100 pb-3">Aksi Cepat</h3>
            <div class="flex flex-col gap-2.5">
                <a href="{{ route('admin.projects.create') }}" class="w-full py-2.5 px-4 rounded-lg bg-slate-50 hover:bg-slate-100 border border-slate-200 text-sm font-semibold text-slate-700 flex items-center justify-between transition-colors">
                    <span><i class="fa-solid fa-plus mr-2 text-indigo-500"></i> Tambah Proyek</span>
                    <i class="fa-solid fa-chevron-right text-xs text-slate-400"></i>
                </a>
                
                <a href="{{ route('admin.experiences.create') }}" class="w-full py-2.5 px-4 rounded-lg bg-slate-50 hover:bg-slate-100 border border-slate-200 text-sm font-semibold text-slate-700 flex items-center justify-between transition-colors">
                    <span><i class="fa-solid fa-plus mr-2 text-cyan-500"></i> Tambah Pengalaman</span>
                    <i class="fa-solid fa-chevron-right text-xs text-slate-400"></i>
                </a>

                <a href="{{ route('admin.awards.create') }}" class="w-full py-2.5 px-4 rounded-lg bg-slate-50 hover:bg-slate-100 border border-slate-200 text-sm font-semibold text-slate-700 flex items-center justify-between transition-colors">
                    <span><i class="fa-solid fa-plus mr-2 text-amber-500"></i> Tambah Penghargaan</span>
                    <i class="fa-solid fa-chevron-right text-xs text-slate-400"></i>
                </a>
                
                <a href="{{ route('admin.profile.edit') }}" class="w-full py-2.5 px-4 rounded-lg bg-indigo-50 hover:bg-indigo-100/55 border border-indigo-100 text-sm font-semibold text-indigo-700 flex items-center justify-between transition-colors">
                    <span><i class="fa-solid fa-user-pen mr-2"></i> Edit Profil & Bio</span>
                    <i class="fa-solid fa-chevron-right text-xs text-indigo-400"></i>
                </a>
            </div>
        </div>

        <!-- Profile Detail Preview -->
        <div class="bg-white border border-slate-200 rounded-2xl p-6 shadow-sm xl:col-span-2 space-y-4">
            <h3 class="font-extrabold text-slate-800 text-lg border-b border-slate-100 pb-3">Ringkasan Profil</h3>
            @if($profile)
                <div class="flex flex-col sm:flex-row gap-6">
                    <div class="w-24 h-24 bg-slate-100 rounded-xl overflow-hidden flex-shrink-0 border border-slate-200 flex items-center justify-center mx-auto sm:mx-0">
                        @if($profile->photo_path)
                            <img src="{{ asset('storage/' . $profile->photo_path) }}" alt="{{ $profile->name }}" class="w-full h-full object-cover">
                        @else
                            <i class="fa-solid fa-user-tie text-4xl text-slate-300"></i>
                        @endif
                    </div>
                    <div class="space-y-3 flex-grow text-center sm:text-left">
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-3 text-sm">
                            <div>
                                <span class="text-slate-400 text-xs font-semibold block uppercase">Nama Lengkap</span>
                                <span class="font-bold text-slate-700">{{ $profile->name }}</span>
                            </div>
                            <div>
                                <span class="text-slate-400 text-xs font-semibold block uppercase">Pekerjaan/Gelar</span>
                                <span class="font-bold text-slate-700">{{ $profile->title }}</span>
                            </div>
                            <div>
                                <span class="text-slate-400 text-xs font-semibold block uppercase">Email Kontak</span>
                                <span class="font-semibold text-slate-700">{{ $profile->email }}</span>
                            </div>
                            <div>
                                <span class="text-slate-400 text-xs font-semibold block uppercase">CV / Resume</span>
                                @if($profile->resume_path)
                                    <a href="{{ asset('storage/' . $profile->resume_path) }}" target="_blank" class="text-indigo-600 hover:underline font-semibold flex items-center justify-center sm:justify-start gap-1">
                                        <i class="fa-solid fa-file-pdf"></i> Lihat Dokumen
                                    </a>
                                @else
                                    <span class="text-slate-400">Belum diunggah</span>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            @else
                <div class="text-center py-6 text-slate-400 text-sm">
                    Data profil belum diatur. <a href="{{ route('admin.profile.edit') }}" class="text-indigo-600 hover:underline">Atur sekarang</a>.
                </div>
            @endif
        </div>
    </div>
</div>
@endsection
