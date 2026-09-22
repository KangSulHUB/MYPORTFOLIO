<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\SiteSetting;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class LanguageSettingController extends Controller
{
    public function edit(): View
    {
        return view('admin.settings.language', ['setting' => SiteSetting::current()]);
    }

    public function update(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'portfolio_locale' => ['required', 'in:en,id'],
        ]);

        SiteSetting::current()->update($validated);

        return to_route('admin.settings.language.edit')
            ->with('success', 'Bahasa portfolio publik berhasil diperbarui.');
    }
}
