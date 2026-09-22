<?php

namespace App\Models;

use App\Models\Concerns\HasPortfolioTranslations;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
    use HasFactory;
    use HasPortfolioTranslations;

    protected $fillable = [
        'title',
        'title_en',
        'title_id',
        'slug',
        'description',
        'description_en',
        'description_id',
        'category',
        'category_en',
        'category_id',
        'tags',
        'image_path',
        'video_path',
        'video_url',
        'attachments',
        'media_type',
        'github_url',
        'demo_url',
        'is_featured',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'is_featured' => 'boolean',
            'tags' => 'array',
            'attachments' => 'array',
        ];
    }
}
