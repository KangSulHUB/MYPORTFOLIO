<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Experience;
use Illuminate\Http\Request;

class ExperienceController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $experiences = Experience::orderBy('start_date', 'desc')->get();

        return view('admin.experiences.index', compact('experiences'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.experiences.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'title_id' => ['nullable', 'string', 'max:255'],
            'company_or_institution' => ['required', 'string', 'max:255'],
            'type' => ['required', 'in:experience,education'],
            'description' => ['nullable', 'string'],
            'description_id' => ['nullable', 'string'],
            'start_date' => ['required', 'date'],
            'end_date' => ['nullable', 'date', 'required_without:is_current'],
            'is_current' => ['nullable', 'boolean'],
        ]);

        $experience = new Experience;
        $experience->title = $validated['title'];
        $experience->title_en = $validated['title'];
        $experience->title_id = $validated['title_id'] ?? $validated['title'];
        $experience->company_or_institution = $validated['company_or_institution'];
        $experience->type = $validated['type'];
        $experience->description = $validated['description'] ?? null;
        $experience->description_en = $validated['description'] ?? null;
        $experience->description_id = $validated['description_id'] ?? $validated['description'] ?? null;
        $experience->start_date = $validated['start_date'];

        $isCurrent = $request->boolean('is_current');
        $experience->is_current = $isCurrent;
        $experience->end_date = $isCurrent ? null : $validated['end_date'];

        $experience->save();

        return redirect()->route('admin.experiences.index')->with('success', 'Riwayat berhasil ditambahkan!');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Experience $experience)
    {
        return view('admin.experiences.edit', compact('experience'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Experience $experience)
    {
        $validated = $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'title_id' => ['nullable', 'string', 'max:255'],
            'company_or_institution' => ['required', 'string', 'max:255'],
            'type' => ['required', 'in:experience,education'],
            'description' => ['nullable', 'string'],
            'description_id' => ['nullable', 'string'],
            'start_date' => ['required', 'date'],
            'end_date' => ['nullable', 'date', 'required_without:is_current'],
            'is_current' => ['nullable', 'boolean'],
        ]);

        $experience->title = $validated['title'];
        $experience->title_en = $validated['title'];
        $experience->title_id = $validated['title_id'] ?? $validated['title'];
        $experience->company_or_institution = $validated['company_or_institution'];
        $experience->type = $validated['type'];
        $experience->description = $validated['description'] ?? null;
        $experience->description_en = $validated['description'] ?? null;
        $experience->description_id = $validated['description_id'] ?? $validated['description'] ?? null;
        $experience->start_date = $validated['start_date'];

        $isCurrent = $request->boolean('is_current');
        $experience->is_current = $isCurrent;
        $experience->end_date = $isCurrent ? null : $validated['end_date'];

        $experience->save();

        return redirect()->route('admin.experiences.index')->with('success', 'Riwayat berhasil diperbarui!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Experience $experience)
    {
        $experience->delete();

        return redirect()->route('admin.experiences.index')->with('success', 'Riwayat berhasil dihapus!');
    }
}
