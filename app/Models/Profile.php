<?php

namespace App\Models;

use App\Models\Concerns\HasPortfolioTranslations;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Profile extends Model
{
    use HasFactory;
    use HasPortfolioTranslations;

    protected $fillable = [
        'name',
        'title',
        'title_en',
        'title_id',
        'bio',
        'bio_en',
        'bio_id',
        'photo_path',
        'resume_path',
        'email',
        'github_url',
        'linkedin_url',
        'skills',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'skills' => 'array',
        ];
    }
}
