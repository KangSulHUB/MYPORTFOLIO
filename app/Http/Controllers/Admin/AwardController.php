<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Award;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class AwardController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $awards = Award::orderBy('is_featured', 'desc')
            ->orderBy('award_date', 'desc')
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        return view('admin.awards.index', compact('awards'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.awards.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'title_id' => ['nullable', 'string', 'max:255'],
            'issuer' => ['nullable', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
            'description_id' => ['nullable', 'string'],
            'award_date' => ['nullable', 'date'],
            'image' => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:4096'],
            'certificate' => ['nullable', 'file', 'mimes:pdf,jpg,jpeg,png,webp', 'max:5120'],
            'external_url' => ['nullable', 'url', 'max:255'],
            'is_featured' => ['nullable', 'boolean'],
        ]);

        unset($validated['image'], $validated['certificate']);

        $award = new Award($validated);
        $award->title_en = $validated['title'];
        $award->title_id = $validated['title_id'] ?? $validated['title'];
        $award->description_en = $validated['description'] ?? null;
        $award->description_id = $validated['description_id'] ?? $validated['description'] ?? null;
        $award->is_featured = $request->boolean('is_featured');

        if ($request->hasFile('image')) {
            $award->image_path = $request->file('image')->store('awards/images', 'public');
        }

        if ($request->hasFile('certificate')) {
            $award->certificate_path = $request->file('certificate')->store('awards/certificates', 'public');
        }

        $award->save();

        return redirect()->route('admin.awards.index')->with('success', 'Penghargaan berhasil ditambahkan!');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Award $award)
    {
        return view('admin.awards.edit', compact('award'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Award $award)
    {
        $validated = $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'title_id' => ['nullable', 'string', 'max:255'],
            'issuer' => ['nullable', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
            'description_id' => ['nullable', 'string'],
            'award_date' => ['nullable', 'date'],
            'image' => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:4096'],
            'certificate' => ['nullable', 'file', 'mimes:pdf,jpg,jpeg,png,webp', 'max:5120'],
            'external_url' => ['nullable', 'url', 'max:255'],
            'is_featured' => ['nullable', 'boolean'],
        ]);

        unset($validated['image'], $validated['certificate']);

        $award->fill($validated);
        $award->title_en = $validated['title'];
        $award->title_id = $validated['title_id'] ?? $validated['title'];
        $award->description_en = $validated['description'] ?? null;
        $award->description_id = $validated['description_id'] ?? $validated['description'] ?? null;
        $award->is_featured = $request->boolean('is_featured');

        if ($request->hasFile('image')) {
            if ($award->image_path) {
                Storage::disk('public')->delete($award->image_path);
            }

            $award->image_path = $request->file('image')->store('awards/images', 'public');
        }

        if ($request->hasFile('certificate')) {
            if ($award->certificate_path) {
                Storage::disk('public')->delete($award->certificate_path);
            }

            $award->certificate_path = $request->file('certificate')->store('awards/certificates', 'public');
        }

        $award->save();

        return redirect()->route('admin.awards.index')->with('success', 'Penghargaan berhasil diperbarui!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Award $award)
    {
        if ($award->image_path) {
            Storage::disk('public')->delete($award->image_path);
        }

        if ($award->certificate_path) {
            Storage::disk('public')->delete($award->certificate_path);
        }

        $award->delete();

        return redirect()->route('admin.awards.index')->with('success', 'Penghargaan berhasil dihapus!');
    }
}
