<?php

namespace App\Models;

use App\Models\Concerns\HasPortfolioTranslations;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Experience extends Model
{
    use HasFactory;
    use HasPortfolioTranslations;

    protected $fillable = [
        'title',
        'title_en',
        'title_id',
        'company_or_institution',
        'type',
        'description',
        'description_en',
        'description_id',
        'start_date',
        'end_date',
        'is_current',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'is_current' => 'boolean',
            'start_date' => 'date',
            'end_date' => 'date',
        ];
    }
}
