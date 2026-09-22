<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Profile;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ProfileController extends Controller
{
    /**
     * Show the form for editing the profile.
     */
    public function edit()
    {
        $profile = Profile::firstOrCreate(
            ['id' => 1],
            [
                'name' => 'Nama Anda',
                'title' => 'Data Analyst & Engineer',
                'title_en' => 'Data Analyst & Engineer',
                'title_id' => 'Analis Data & Engineer',
                'bio' => 'I am an enthusiastic learner in the field of data, with a strong interest in data analysis, visualization, and turning raw information into meaningful insights. I also have hands-on experience building interactive web applications using Laravel, which allows me to present data, projects, and information in a clear and user-friendly way.',
                'bio_en' => 'I am an enthusiastic learner in the field of data, with a strong interest in data analysis, visualization, and turning raw information into meaningful insights.',
                'bio_id' => 'Saya adalah pembelajar yang antusias di bidang data, dengan minat kuat pada analisis, visualisasi, dan mengubah data mentah menjadi insight yang bermakna.',
                'email' => 'admin@portfolio.com',
                'skills' => ['Python', 'SQL', 'Laravel'],
            ]
        );

        $skillsString = is_array($profile->skills) ? implode(', ', $profile->skills) : '';

        return view('admin.profile.edit', compact('profile', 'skillsString'));
    }

    /**
     * Update the profile in storage.
     */
    public function update(Request $request)
    {
        $profile = Profile::firstOrCreate(['id' => 1]);

        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'title_en' => ['required', 'string', 'max:255'],
            'title_id' => ['required', 'string', 'max:255'],
            'bio_en' => ['required', 'string'],
            'bio_id' => ['required', 'string'],
            'email' => ['required', 'email', 'max:255'],
            'github_url' => ['nullable', 'url', 'max:255'],
            'linkedin_url' => ['nullable', 'url', 'max:255'],
            'skills' => ['nullable', 'string'], // Comma separated
            'photo' => ['nullable', 'image', 'max:2048'], // Max 2MB
            'resume' => ['nullable', 'mimes:pdf,doc,docx', 'max:5120'], // Max 5MB PDF/Word
        ]);

        $profile->name = $validated['name'];
        $profile->title_en = $validated['title_en'];
        $profile->title_id = $validated['title_id'];
        $profile->bio_en = $validated['bio_en'];
        $profile->bio_id = $validated['bio_id'];
        // Keep legacy fields populated for backward compatibility with prior data.
        $profile->title = $validated['title_en'];
        $profile->bio = $validated['bio_en'];
        $profile->email = $validated['email'];
        $profile->github_url = $validated['github_url'] ?? null;
        $profile->linkedin_url = $validated['linkedin_url'] ?? null;

        $skillsArray = [];
        if (! empty($validated['skills'])) {
            $skillsArray = array_map('trim', explode(',', $validated['skills']));
        }
        $profile->skills = $skillsArray;

        // Photo upload
        if ($request->hasFile('photo')) {
            if ($profile->photo_path) {
                Storage::disk('public')->delete($profile->photo_path);
            }
            $path = $request->file('photo')->store('profile', 'public');
            $profile->photo_path = $path;
        }

        // Resume upload
        if ($request->hasFile('resume')) {
            if ($profile->resume_path) {
                Storage::disk('public')->delete($profile->resume_path);
            }
            $path = $request->file('resume')->store('resumes', 'public');
            $profile->resume_path = $path;
        }

        $profile->save();

        return redirect()->route('admin.profile.edit')->with('success', 'Profil berhasil diperbarui!');
    }
}
