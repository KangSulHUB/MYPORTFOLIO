@extends('layouts.admin')

@section('header_title', 'Kelola Penghargaan')

@section('content')
<div class="space-y-6">
    <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4">
        <div>
            <h2 class="text-xl font-bold text-slate-800">Daftar Penghargaan & Sertifikat</h2>
            <p class="text-slate-500 text-xs mt-1">Kelola penghargaan, sertifikat, atau pencapaian yang ingin ditampilkan.</p>
        </div>
        <a href="{{ route('admin.awards.create') }}" class="px-4 py-2 rounded-xl bg-indigo-600 hover:bg-indigo-700 text-white font-semibold text-sm shadow-md shadow-indigo-500/10 transition-colors inline-flex items-center gap-2">
            <i class="fa-solid fa-plus"></i> Tambah Penghargaan
        </a>
    </div>

    <div class="bg-white border border-slate-200 rounded-2xl overflow-hidden shadow-sm">
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-slate-50 border-b border-slate-200 text-slate-400 text-[10px] font-bold uppercase tracking-wider">
                        <th class="py-4 px-6">Preview</th>
                        <th class="py-4 px-6">Judul</th>
                        <th class="py-4 px-6">Penerbit</th>
                        <th class="py-4 px-6">Tanggal</th>
                        <th class="py-4 px-6 text-center">Unggulan</th>
                        <th class="py-4 px-6 text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100 text-sm text-slate-700">
                    @forelse($awards as $award)
                        <tr class="hover:bg-slate-50/55 transition-colors">
                            <td class="py-4 px-6">
                                <div class="w-16 h-12 rounded-lg bg-slate-100 border border-slate-200 overflow-hidden flex items-center justify-center">
                                    @if($award->image_path)
                                        <img src="{{ asset('storage/' . $award->image_path) }}" alt="{{ $award->title }}" class="w-full h-full object-cover">
                                    @else
                                        <i class="fa-solid fa-trophy text-slate-300"></i>
                                    @endif
                                </div>
                            </td>
                            <td class="py-4 px-6 font-semibold text-slate-800">{{ $award->title }}</td>
                            <td class="py-4 px-6">{{ $award->issuer ?: '-' }}</td>
                            <td class="py-4 px-6">{{ $award->award_date ? $award->award_date->format('M Y') : '-' }}</td>
                            <td class="py-4 px-6 text-center">
                                @if($award->is_featured)
                                    <span class="inline-flex items-center gap-1 text-xs font-semibold text-amber-600 bg-amber-50 border border-amber-200 px-2 py-0.5 rounded-full">
                                        <i class="fa-solid fa-star text-[10px]"></i> Ya
                                    </span>
                                @else
                                    <span class="text-xs text-slate-400">Tidak</span>
                                @endif
                            </td>
                            <td class="py-4 px-6 text-right">
                                <div class="flex items-center justify-end gap-2.5">
                                    @if($award->certificate_path)
                                        <a href="{{ asset('storage/' . $award->certificate_path) }}" target="_blank" class="text-slate-500 hover:text-amber-600 transition-colors text-xs font-semibold">
                                            <i class="fa-solid fa-file-lines mr-1"></i> File
                                        </a>
                                    @endif
                                    <a href="{{ route('admin.awards.edit', $award->id) }}" class="text-slate-500 hover:text-indigo-600 transition-colors text-xs font-semibold">
                                        <i class="fa-solid fa-pen-to-square mr-1"></i> Edit
                                    </a>
                                    <form action="{{ route('admin.awards.destroy', $award->id) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus penghargaan ini?')" class="inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-rose-500 hover:text-rose-700 transition-colors text-xs font-semibold">
                                            <i class="fa-solid fa-trash-can mr-1"></i> Hapus
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="text-center py-12 text-slate-400">
                                <i class="fa-solid fa-award text-3xl mb-2 block"></i>
                                Belum ada penghargaan yang ditambahkan.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($awards->hasPages())
            <div class="px-6 py-4 border-t border-slate-100 bg-slate-50/50">
                {{ $awards->links() }}
            </div>
        @endif
    </div>
</div>
@endsection
