<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SiteSetting extends Model
{
    public const ENGLISH = 'en';

    public const INDONESIAN = 'id';

    protected $fillable = [
        'portfolio_locale',
    ];

    /**
     * Return the singleton record that controls the public portfolio.
     */
    public static function current(): self
    {
        return static::query()->firstOrCreate(
            ['id' => 1],
            ['portfolio_locale' => self::ENGLISH],
        );
    }
}
