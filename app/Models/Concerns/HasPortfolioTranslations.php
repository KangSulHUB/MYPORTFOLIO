<?php

namespace App\Models\Concerns;

use App\Models\SiteSetting;

trait HasPortfolioTranslations
{
    /**
     * Get a localized attribute, falling back to the legacy value when needed.
     */
    public function translation(string $attribute, ?string $locale = null): mixed
    {
        $locale ??= app()->getLocale();
        $translatedValue = $this->getAttribute("{$attribute}_{$locale}");

        if (filled($translatedValue)) {
            return $translatedValue;
        }

        $fallbackLocale = $locale === SiteSetting::ENGLISH
            ? SiteSetting::INDONESIAN
            : SiteSetting::ENGLISH;

        return $this->getAttribute("{$attribute}_{$fallbackLocale}")
            ?: $this->getAttribute($attribute);
    }
}
