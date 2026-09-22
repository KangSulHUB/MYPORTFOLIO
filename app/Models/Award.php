<?php

namespace App\Models;

use App\Models\Concerns\HasPortfolioTranslations;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Award extends Model
{
    use HasFactory;
    use HasPortfolioTranslations;

    protected $fillable = [
        'title',
        'title_en',
        'title_id',
        'issuer',
        'description',
        'description_en',
        'description_id',
        'award_date',
        'image_path',
        'certificate_path',
        'external_url',
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
            'award_date' => 'date',
            'is_featured' => 'boolean',
        ];
    }
}
