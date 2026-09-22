@extends('layouts.admin')

@section('header_title', 'Bahasa Portfolio')

@section('content')
<div class="max-w-3xl">
    <div class="bg-white border border-slate-200 rounded-2xl p-6 md:p-8 shadow-sm">
        <h2 class="text-xl font-bold text-slate-800">Bahasa tampilan publik</h2>
        <p class="mt-2 text-sm leading-relaxed text-slate-500">Pilihan ini berlaku untuk seluruh pengunjung website. Tampilan dan URL tidak berubah; hanya teks portfolio yang ditampilkan dalam bahasa pilihan.</p>

        <form action="{{ route('admin.settings.language.update') }}" method="POST" class="mt-8 space-y-4">
            @csrf
            @method('PUT')

            <label class="flex cursor-pointer items-start gap-3 rounded-xl border p-4 {{ old('portfolio_locale', $setting->portfolio_locale) === 'en' ? 'border-indigo-500 bg-indigo-50/50' : 'border-slate-200' }}">
                <input type="radio" name="portfolio_locale" value="en" {{ old('portfolio_locale', $setting->portfolio_locale) === 'en' ? 'checked' : '' }} class="mt-1 text-indigo-600 focus:ring-indigo-500">
                <span><span class="block text-sm font-bold text-slate-800">English</span><span class="block mt-1 text-xs text-slate-500">Gunakan saat membagikan portfolio ke perusahaan atau rekruter internasional.</span></span>
            </label>

            <label class="flex cursor-pointer items-start gap-3 rounded-xl border p-4 {{ old('portfolio_locale', $setting->portfolio_locale) === 'id' ? 'border-indigo-500 bg-indigo-50/50' : 'border-slate-200' }}">
                <input type="radio" name="portfolio_locale" value="id" {{ old('portfolio_locale', $setting->portfolio_locale) === 'id' ? 'checked' : '' }} class="mt-1 text-indigo-600 focus:ring-indigo-500">
                <span><span class="block text-sm font-bold text-slate-800">Bahasa Indonesia</span><span class="block mt-1 text-xs text-slate-500">Gunakan saat membagikan portfolio ke perusahaan atau rekruter di Indonesia.</span></span>
            </label>

            @error('portfolio_locale')<p class="text-xs font-semibold text-rose-500">{{ $message }}</p>@enderror

            <div class="pt-4 border-t border-slate-100 flex justify-end">
                <button type="submit" class="px-5 py-2.5 rounded-xl bg-indigo-600 hover:bg-indigo-700 text-white text-sm font-semibold shadow-md shadow-indigo-500/10 transition-colors">Simpan Bahasa Aktif</button>
            </div>
        </form>
    </div>
</div>
@endsection
