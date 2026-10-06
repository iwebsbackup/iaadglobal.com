<?php

namespace App\Support;

use Illuminate\Support\Carbon;

class RegistrationPricing
{
    public const CATEGORIES = ['Participants', 'SAARC AAD Member', 'Post Graduate Student'];

    public static function currentTier(): string
    {
        $tiers = config('registration.tiers');
        $now = now('Asia/Kolkata');

        foreach ($tiers as $key => $tier) {
            if (! $tier['ends'] || $now->lte(Carbon::parse($tier['ends'], 'Asia/Kolkata')->endOfDay())) {
                return $key;
            }
        }

        return array_key_last($tiers);
    }

    public static function fee(string $category, ?string $tier = null): int
    {
        $tier ??= self::currentTier();

        $row = collect(config('registration.packages.non_residential.rows'))
            ->firstWhere('category', $category);

        return (int) $row['prices'][$tier];
    }
}
