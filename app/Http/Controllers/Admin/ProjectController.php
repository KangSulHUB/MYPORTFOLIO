<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Project;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class ProjectController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $projects = Project::orderBy('created_at', 'desc')->paginate(10);

        return view('admin.projects.index', compact('projects'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.projects.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'title_id' => ['nullable', 'string', 'max:255'],
            'description' => ['required', 'string'],
            'description_id' => ['nullable', 'string'],
            'category' => ['required', 'string', 'max:100'],
            'category_id' => ['nullable', 'string', 'max:100'],
            'tags' => ['nullable', 'string'],
            'image' => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:4096'],
            'video' => ['nullable', 'file', 'mimetypes:video/mp4,video/webm,video/ogg', 'max:20480'],
            'video_url' => ['nullable', 'url', 'max:255'],
            'attachments' => ['nullable', 'array'],
            'attachments.*' => ['file', 'max:10240', 'mimes:pdf,doc,docx,ppt,pptx,zip,rar,jpg,jpeg,png,webp,mp4,webm,ogg'],
            'github_url' => ['nullable', 'url', 'max:255'],
            'demo_url' => ['nullable', 'url', 'max:255'],
            'is_featured' => ['nullable', 'boolean'],
        ]);

        $project = new Project;
        $project->title = $validated['title'];
        $project->title_en = $validated['title'];
        $project->title_id = $validated['title_id'] ?? $validated['title'];
        $project->slug = Str::slug($validated['title']).'-'.time();
        $project->description = $validated['description'];
        $project->description_en = $validated['description'];
        $project->description_id = $validated['description_id'] ?? $validated['description'];
        $project->category = $validated['category'];
        $project->category_en = $validated['category'];
        $project->category_id = $validated['category_id'] ?? $validated['category'];
        $project->tags = $this->normalizeTags($validated['tags'] ?? null);
        $project->github_url = $validated['github_url'] ?? null;
        $project->demo_url = $validated['demo_url'] ?? null;
        $project->is_featured = $request->boolean('is_featured');
        $project->video_url = $validated['video_url'] ?? null;
        $project->media_type = $this->resolveMediaType($request);

        if ($request->hasFile('image')) {
            $project->image_path = $request->file('image')->store('projects', 'public');
        }

        if ($request->hasFile('video')) {
            $project->video_path = $request->file('video')->store('projects/videos', 'public');
        }

        if ($request->hasFile('attachments')) {
            $project->attachments = $this->storeAttachments($request->file('attachments'));
        }

        $project->save();

        return redirect()->route('admin.projects.index')->with('success', 'Proyek berhasil ditambahkan!');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Project $project)
    {
        $tagsString = is_array($project->tags) ? implode(', ', $project->tags) : '';

        return view('admin.projects.edit', compact('project', 'tagsString'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Project $project)
    {
        $validated = $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'title_id' => ['nullable', 'string', 'max:255'],
            'description' => ['required', 'string'],
            'description_id' => ['nullable', 'string'],
            'category' => ['required', 'string', 'max:100'],
            'category_id' => ['nullable', 'string', 'max:100'],
            'tags' => ['nullable', 'string'],
            'image' => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:4096'],
            'video' => ['nullable', 'file', 'mimetypes:video/mp4,video/webm,video/ogg', 'max:20480'],
            'video_url' => ['nullable', 'url', 'max:255'],
            'attachments' => ['nullable', 'array'],
            'attachments.*' => ['file', 'max:10240', 'mimes:pdf,doc,docx,ppt,pptx,zip,rar,jpg,jpeg,png,webp,mp4,webm,ogg'],
            'github_url' => ['nullable', 'url', 'max:255'],
            'demo_url' => ['nullable', 'url', 'max:255'],
            'is_featured' => ['nullable', 'boolean'],
        ]);

        $project->title = $validated['title'];
        $project->title_en = $validated['title'];
        $project->title_id = $validated['title_id'] ?? $validated['title'];
        if ($project->isDirty('title')) {
            $project->slug = Str::slug($validated['title']).'-'.time();
        }

        $project->description = $validated['description'];
        $project->description_en = $validated['description'];
        $project->description_id = $validated['description_id'] ?? $validated['description'];
        $project->category = $validated['category'];
        $project->category_en = $validated['category'];
        $project->category_id = $validated['category_id'] ?? $validated['category'];
        $project->tags = $this->normalizeTags($validated['tags'] ?? null);
        $project->github_url = $validated['github_url'] ?? null;
        $project->demo_url = $validated['demo_url'] ?? null;
        $project->is_featured = $request->boolean('is_featured');
        $project->video_url = $validated['video_url'] ?? null;
        $project->media_type = $this->resolveMediaType($request, $project);

        if ($request->hasFile('image')) {
            if ($project->image_path) {
                Storage::disk('public')->delete($project->image_path);
            }

            $project->image_path = $request->file('image')->store('projects', 'public');
        }

        if ($request->hasFile('video')) {
            if ($project->video_path) {
                Storage::disk('public')->delete($project->video_path);
            }

            $project->video_path = $request->file('video')->store('projects/videos', 'public');
        }

        if ($request->hasFile('attachments')) {
            if (! empty($project->attachments)) {
                Storage::disk('public')->delete($project->attachments);
            }

            $project->attachments = $this->storeAttachments($request->file('attachments'));
        }

        $project->save();

        return redirect()->route('admin.projects.index')->with('success', 'Proyek berhasil diperbarui!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Project $project)
    {
        if ($project->image_path) {
            Storage::disk('public')->delete($project->image_path);
        }

        if ($project->video_path) {
            Storage::disk('public')->delete($project->video_path);
        }

        if (! empty($project->attachments)) {
            Storage::disk('public')->delete($project->attachments);
        }

        $project->delete();

        return redirect()->route('admin.projects.index')->with('success', 'Proyek berhasil dihapus!');
    }

    protected function normalizeTags(?string $tags): array
    {
        if (empty($tags)) {
            return [];
        }

        return array_values(array_filter(array_map('trim', explode(',', $tags))));
    }

    protected function resolveMediaType(Request $request, ?Project $project = null): string
    {
        if ($request->hasFile('video') || ! empty($request->input('video_url'))) {
            return 'video';
        }

        if ($request->hasFile('image')) {
            return 'image';
        }

        return $project?->media_type ?? 'image';
    }

    protected function storeAttachments(array $attachments): array
    {
        return array_map(fn ($attachment) => $attachment->store('projects/attachments', 'public'), $attachments);
    }
}
