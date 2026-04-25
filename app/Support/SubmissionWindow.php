<?php

namespace App\Support;

use Carbon\Carbon;
use Illuminate\Validation\ValidationException;

class SubmissionWindow
{
    public static function today(): Carbon
    {
        return Carbon::today();
    }

    public static function earliestAllowedDate(): Carbon
    {
        return static::today()->copy()->subDay();
    }

    public static function latestAllowedDate(): Carbon
    {
        return static::today();
    }

    public static function assertDateWithinAllowedWindow(string $date, string $label = 'Date'): void
    {
        $submittedDate = Carbon::parse($date)->startOfDay();
        $earliest = static::earliestAllowedDate()->startOfDay();
        $latest = static::latestAllowedDate()->startOfDay();

        if ($submittedDate->lt($earliest) || $submittedDate->gt($latest)) {
            throw ValidationException::withMessages([
                'date' => sprintf(
                    '%s must be today or yesterday only (%s to %s).',
                    $label,
                    $earliest->toDateString(),
                    $latest->toDateString()
                ),
            ]);
        }
    }

    public static function bounds(): array
    {
        return [
            'min' => static::earliestAllowedDate()->toDateString(),
            'max' => static::latestAllowedDate()->toDateString(),
        ];
    }
}
