@extends('layouts.admin')

@section('header_title', 'Edit Riwayat')

@section('content')
<div class="max-w-5xl space-y-6">
    <div class="flex items-center gap-2">
        <a href="{{ route('admin.experiences.index') }}" class="text-slate-400 hover:text-slate-600 transition-colors">
            <i class="fa-solid fa-arrow-left"></i> Kembali
        </a>
    </div>

    <div class="bg-white border border-slate-200 rounded-2xl p-6 md:p-8 shadow-sm">
        <h2 class="text-xl font-bold text-slate-800 border-b border-slate-100 pb-4 mb-6">Form Edit Riwayat</h2>
        
        <form action="{{ route('admin.experiences.update', $experience->id) }}" method="POST" class="space-y-6">
            @csrf
            @method('PUT')

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Title / Position -->
                <div>
                    <label for="title" class="block text-xs font-bold text-slate-400 uppercase tracking-wider mb-2">Posisi / Gelar / Jurusan — English</label>
                    <input type="text" name="title" id="title" value="{{ old('title', $experience->title) }}" required placeholder="Contoh: S1 Teknik Informatika / Data Engineer"
                           class="w-full px-4 py-2.5 rounded-xl border border-slate-200 focus:outline-none focus:border-indigo-500 focus:ring-1 focus:ring-indigo-500 text-sm">
                    @error('title')
                        <span class="text-xs text-rose-500 font-semibold mt-1 block">{{ $message }}</span>
                    @enderror
                </div>
                <div>
                    <label for="title_id" class="block text-xs font-bold text-slate-400 uppercase tracking-wider mb-2">Posisi / Gelar / Jurusan — Indonesia</label>
                    <input type="text" name="title_id" id="title_id" value="{{ old('title_id', $experience->title_id ?: $experience->title) }}" class="w-full px-4 py-2.5 rounded-xl border border-slate-200 focus:outline-none focus:border-indigo-500 focus:ring-1 focus:ring-indigo-500 text-sm">
                </div>

                <!-- Company or Institution -->
                <div>
                    <label for="company_or_institution" class="block text-xs font-bold text-slate-400 uppercase tracking-wider mb-2">Nama Perusahaan / Institusi</label>
                    <input type="text" name="company_or_institution" id="company_or_institution" value="{{ old('company_or_institution', $experience->company_or_institution) }}" required placeholder="Contoh: Universitas Indonesia / PT Telekomunikasi"
                           class="w-full px-4 py-2.5 rounded-xl border border-slate-200 focus:outline-none focus:border-indigo-500 focus:ring-1 focus:ring-indigo-500 text-sm">
                    @error('company_or_institution')
                        <span class="text-xs text-rose-500 font-semibold mt-1 block">{{ $message }}</span>
                    @enderror
                </div>
            </div>

            <!-- Type -->
            <div>
                <label class="block text-xs font-bold text-slate-400 uppercase tracking-wider mb-2">Tipe Riwayat</label>
                <div class="flex gap-4">
                    <label class="inline-flex items-center cursor-pointer">
                        <input type="radio" name="type" value="experience" {{ old('type', $experience->type) == 'experience' ? 'checked' : '' }}
                               class="w-4 h-4 text-indigo-600 bg-slate-50 border-slate-300 focus:ring-indigo-500">
                        <span class="ml-2 text-sm text-slate-700 font-medium">Pekerjaan / Project Pengalaman</span>
                    </label>
                    <label class="inline-flex items-center cursor-pointer">
                        <input type="radio" name="type" value="education" {{ old('type', $experience->type) == 'education' ? 'checked' : '' }}
                               class="w-4 h-4 text-indigo-600 bg-slate-50 border-slate-300 focus:ring-indigo-500">
                        <span class="ml-2 text-sm text-slate-700 font-medium">Pendidikan</span>
                    </label>
                </div>
                @error('type')
                    <span class="text-xs text-rose-500 font-semibold mt-1 block">{{ $message }}</span>
                @enderror
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Start Date -->
                <div>
                    <label for="start_date" class="block text-xs font-bold text-slate-400 uppercase tracking-wider mb-2">Tanggal Mulai</label>
                    <input type="date" name="start_date" id="start_date" value="{{ old('start_date', $experience->start_date ? $experience->start_date->format('Y-m-d') : '') }}" required
                           class="w-full px-4 py-2.5 rounded-xl border border-slate-200 focus:outline-none focus:border-indigo-500 focus:ring-1 focus:ring-indigo-500 text-sm">
                    @error('start_date')
                        <span class="text-xs text-rose-500 font-semibold mt-1 block">{{ $message }}</span>
                    @enderror
                </div>

                <!-- End Date -->
                <div id="end_date_group">
                    <label for="end_date" class="block text-xs font-bold text-slate-400 uppercase tracking-wider mb-2">Tanggal Selesai</label>
                    <input type="date" name="end_date" id="end_date" value="{{ old('end_date', $experience->end_date ? $experience->end_date->format('Y-m-d') : '') }}"
                           class="w-full px-4 py-2.5 rounded-xl border border-slate-200 focus:outline-none focus:border-indigo-500 focus:ring-1 focus:ring-indigo-500 text-sm">
                    @error('end_date')
                        <span class="text-xs text-rose-500 font-semibold mt-1 block">{{ $message }}</span>
                    @enderror
                </div>
            </div>

            <!-- Is Current Status -->
            <div class="flex items-center">
                <input type="checkbox" name="is_current" id="is_current" value="1" {{ old('is_current', $experience->is_current) ? 'checked' : '' }}
                       class="w-4 h-4 rounded bg-slate-50 border border-slate-300 text-indigo-600 focus:ring-indigo-500 focus:ring-2">
                <label for="is_current" class="ml-2 text-sm font-semibold text-slate-700 cursor-pointer">Masih Berlangsung / Masih Aktif di Sini</label>
            </div>

            <!-- Description -->
            <div>
                <label for="description" class="block text-xs font-bold text-slate-400 uppercase tracking-wider mb-2">Deskripsi Detail Kegiatan — English (Opsional)</label>
                <textarea name="description" id="description" rows="5" placeholder="Sebutkan tanggung jawab Anda..."
                          class="w-full px-4 py-2.5 rounded-xl border border-slate-200 focus:outline-none focus:border-indigo-500 focus:ring-1 focus:ring-indigo-500 text-sm">{{ old('description', $experience->description) }}</textarea>
                @error('description')
                    <span class="text-xs text-rose-500 font-semibold mt-1 block">{{ $message }}</span>
                @enderror
            </div>
            <div>
                <label for="description_id" class="block text-xs font-bold text-slate-400 uppercase tracking-wider mb-2">Deskripsi Detail Kegiatan — Indonesia (Opsional)</label>
                <textarea name="description_id" id="description_id" rows="5" class="w-full px-4 py-2.5 rounded-xl border border-slate-200 focus:outline-none focus:border-indigo-500 focus:ring-1 focus:ring-indigo-500 text-sm">{{ old('description_id', $experience->description_id ?: $experience->description) }}</textarea>
            </div>

            <!-- Form Actions -->
            <div class="pt-4 border-t border-slate-100 flex justify-end gap-3">
                <a href="{{ route('admin.experiences.index') }}" class="px-4 py-2.5 rounded-xl border border-slate-200 hover:bg-slate-50 text-slate-600 text-sm font-semibold transition-colors">
                    Batal
                </a>
                <button type="submit" class="px-5 py-2.5 rounded-xl bg-indigo-600 hover:bg-indigo-700 text-white text-sm font-semibold shadow-md shadow-indigo-500/10 transition-colors">
                    Perbarui Riwayat
                </button>
            </div>
        </form>
    </div>
</div>
@endsection

@section('scripts')
<script>
    const isCurrentCheckbox = document.getElementById('is_current');
    const endDateInput = document.getElementById('end_date');
    const endDateGroup = document.getElementById('end_date_group');

    function toggleEndDate() {
        if (isCurrentCheckbox.checked) {
            endDateInput.value = '';
            endDateInput.disabled = true;
            endDateGroup.style.opacity = '0.5';
        } else {
            endDateInput.disabled = false;
            endDateGroup.style.opacity = '1';
        }
    }

    isCurrentCheckbox.addEventListener('change', toggleEndDate);
    
    // Initial check on load
    toggleEndDate();
</script>
@endsection
