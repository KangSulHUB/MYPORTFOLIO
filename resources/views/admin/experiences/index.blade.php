@extends('layouts.admin')

@section('header_title', 'Kelola Riwayat')

@section('content')
<div class="space-y-6">
    <!-- Header Page -->
    <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4">
        <div>
            <h2 class="text-xl font-bold text-slate-800">Daftar Pengalaman Kerja & Pendidikan</h2>
            <p class="text-slate-500 text-xs mt-1">Kelola riwayat pekerjaan, organisasi, atau riwayat pendidikan Anda.</p>
        </div>
        <div>
            <a href="{{ route('admin.experiences.create') }}" class="px-4 py-2 rounded-xl bg-indigo-600 hover:bg-indigo-700 text-white font-semibold text-sm shadow-md shadow-indigo-500/10 transition-colors inline-flex items-center gap-2">
                <i class="fa-solid fa-plus"></i> Tambah Riwayat Baru
            </a>
        </div>
    </div>

    <!-- Table Card -->
    <div class="bg-white border border-slate-200 rounded-2xl overflow-hidden shadow-sm">
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-slate-50 border-b border-slate-200 text-slate-400 text-[10px] font-bold uppercase tracking-wider">
                        <th class="py-4 px-6">Tipe</th>
                        <th class="py-4 px-6">Gelar / Posisi</th>
                        <th class="py-4 px-6">Instansi / Perusahaan</th>
                        <th class="py-4 px-6">Periode</th>
                        <th class="py-4 px-6 text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100 text-sm text-slate-700">
                    @forelse($experiences as $exp)
                        <tr class="hover:bg-slate-50/55 transition-colors">
                            <td class="py-4 px-6">
                                @if($exp->type == 'education')
                                    <span class="inline-flex items-center gap-1.5 text-xs font-semibold text-indigo-600 bg-indigo-50 border border-indigo-150 px-2 py-0.5 rounded-full">
                                        <i class="fa-solid fa-graduation-cap text-[10px]"></i> Pendidikan
                                    </span>
                                @else
                                    <span class="inline-flex items-center gap-1.5 text-xs font-semibold text-cyan-600 bg-cyan-50 border border-cyan-150 px-2 py-0.5 rounded-full">
                                        <i class="fa-solid fa-briefcase text-[10px]"></i> Pekerjaan
                                    </span>
                                @endif
                            </td>
                            <td class="py-4 px-6 font-semibold text-slate-800">
                                {{ $exp->title }}
                            </td>
                            <td class="py-4 px-6 text-slate-600">
                                {{ $exp->company_or_institution }}
                            </td>
                            <td class="py-4 px-6 text-slate-500 font-medium">
                                {{ $exp->start_date->format('M Y') }} - 
                                @if($exp->is_current)
                                    <span class="text-emerald-600 font-bold">Sekarang</span>
                                @else
                                    {{ $exp->end_date ? $exp->end_date->format('M Y') : '-' }}
                                @endif
                            </td>
                            <td class="py-4 px-6 text-right">
                                <div class="flex items-center justify-end gap-2.5">
                                    <a href="{{ route('admin.experiences.edit', $exp->id) }}" class="text-slate-500 hover:text-indigo-600 transition-colors text-xs font-semibold" title="Edit">
                                        <i class="fa-solid fa-pen-to-square mr-1"></i> Edit
                                    </a>
                                    
                                    <form action="{{ route('admin.experiences.destroy', $exp->id) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus riwayat ini?')" class="inline">
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
                            <td colspan="5" class="text-center py-12 text-slate-400">
                                <i class="fa-regular fa-clock text-3xl mb-2 block"></i>
                                Belum ada riwayat pengalaman atau pendidikan yang ditambahkan.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
