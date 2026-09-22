@extends('layouts.admin')

@section('header_title', 'Kelola Proyek')

@section('content')
<div class="space-y-6">
    <!-- Header Page -->
    <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4">
        <div>
            <h2 class="text-xl font-bold text-slate-800">Daftar Proyek & Tugas</h2>
            <p class="text-slate-500 text-xs mt-1">Kelola portofolio proyek atau tugas pemrograman yang ingin Anda tampilkan.</p>
        </div>
        <div>
            <a href="{{ route('admin.projects.create') }}" class="px-4 py-2 rounded-xl bg-indigo-600 hover:bg-indigo-700 text-white font-semibold text-sm shadow-md shadow-indigo-500/10 transition-colors inline-flex items-center gap-2">
                <i class="fa-solid fa-plus"></i> Tambah Proyek Baru
            </a>
        </div>
    </div>

    <!-- Table Card -->
    <div class="bg-white border border-slate-200 rounded-2xl overflow-hidden shadow-sm">
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-slate-50 border-b border-slate-200 text-slate-400 text-[10px] font-bold uppercase tracking-wider">
                        <th class="py-4 px-6">Gambar</th>
                        <th class="py-4 px-6">Judul</th>
                        <th class="py-4 px-6">Kategori</th>
                        <th class="py-4 px-6">Tags</th>
                        <th class="py-4 px-6 text-center">Unggulan</th>
                        <th class="py-4 px-6 text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100 text-sm text-slate-700">
                    @forelse($projects as $project)
                        <tr class="hover:bg-slate-50/55 transition-colors">
                            <td class="py-4 px-6">
                                <div class="w-16 h-10 rounded-lg bg-slate-100 border border-slate-200 overflow-hidden flex-shrink-0 flex items-center justify-center">
                                    @if($project->image_path)
                                        <img src="{{ asset('storage/' . $project->image_path) }}" alt="{{ $project->title }}" class="w-full h-full object-cover">
                                    @else
                                        <i class="fa-solid fa-code text-slate-300"></i>
                                    @endif
                                </div>
                            </td>
                            <td class="py-4 px-6 font-semibold text-slate-800">
                                {{ $project->title }}
                            </td>
                            <td class="py-4 px-6">
                                <span class="px-2 py-0.5 rounded text-xs font-semibold bg-slate-100 text-slate-600 border border-slate-200">
                                    {{ $project->category }}
                                </span>
                            </td>
                            <td class="py-4 px-6">
                                <div class="flex flex-wrap gap-1 max-w-xs">
                                    @if(is_array($project->tags))
                                        @foreach($project->tags as $tag)
                                            <span class="px-1.5 py-0.5 rounded bg-slate-50 text-[10px] text-slate-500 border border-slate-150">
                                                {{ $tag }}
                                            </span>
                                        @endforeach
                                    @endif
                                </div>
                            </td>
                            <td class="py-4 px-6 text-center">
                                @if($project->is_featured)
                                    <span class="inline-flex items-center gap-1 text-xs font-semibold text-amber-600 bg-amber-50 border border-amber-200 px-2 py-0.5 rounded-full">
                                        <i class="fa-solid fa-star text-[10px]"></i> Ya
                                    </span>
                                @else
                                    <span class="text-xs text-slate-400">Tidak</span>
                                @endif
                            </td>
                            <td class="py-4 px-6 text-right">
                                <div class="flex items-center justify-end gap-2.5">
                                    <a href="{{ route('admin.projects.edit', $project->id) }}" class="text-slate-500 hover:text-indigo-600 transition-colors text-xs font-semibold" title="Edit">
                                        <i class="fa-solid fa-pen-to-square mr-1"></i> Edit
                                    </a>
                                    
                                    <form action="{{ route('admin.projects.destroy', $project->id) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus proyek ini?')" class="inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-rose-500 hover:text-rose-700 transition-colors text-xs font-semibold" title="Hapus">
                                            <i class="fa-solid fa-trash-can mr-1"></i> Hapus
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="text-center py-12 text-slate-400">
                                <i class="fa-solid fa-folder-open text-3xl mb-2 block"></i>
                                Belum ada proyek yang ditambahkan.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        
        <!-- Pagination Links -->
        @if($projects->hasPages())
            <div class="px-6 py-4 border-t border-slate-100 bg-slate-50/50">
                {{ $projects->links() }}
            </div>
        @endif
    </div>
</div>
@endsection
