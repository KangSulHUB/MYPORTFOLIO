<?php

namespace Tests\Feature;

use App\Models\Project;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class ProjectManagementTest extends TestCase
{
    use RefreshDatabase;

    public function test_admin_can_create_project_with_media_and_attachment(): void
    {
        Storage::fake('public');

        $user = User::factory()->create();
        $attachment = UploadedFile::fake()->create('case-study.pdf', 1024, 'application/pdf');

        $response = $this->actingAs($user)->post(route('admin.projects.store'), [
            'title' => 'Portfolio Platform',
            'description' => 'A polished portfolio site with media support.',
            'category' => 'Web Development',
            'tags' => 'Laravel, Tailwind, PHP',
            'image' => UploadedFile::fake()->create('cover.jpg', 1024, 'image/jpeg'),
            'video' => UploadedFile::fake()->create('demo.mp4', 2048, 'video/mp4'),
            'video_url' => 'https://www.youtube.com/watch?v=dQw4w9WgXcQ',
            'attachments' => [$attachment],
            'github_url' => 'https://github.com/example/portfolio',
            'demo_url' => 'https://example.com/demo',
            'is_featured' => true,
        ]);

        $response->assertRedirect(route('admin.projects.index'));

        $project = Project::latest()->first();

        $this->assertNotNull($project);
        $this->assertNotNull($project->video_url);
        $this->assertNotEmpty($project->attachments);
        $this->assertNotNull($project->video_path);
    }
}
