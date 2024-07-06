<?php

namespace App\Traits;

use App\Models\Report;
use App\Models\User;
use Illuminate\Database\Eloquent\Relations\MorphMany;

trait Reportable
{
    public function reports(): MorphMany
    {
        return $this->morphMany(Report::class, 'reportable');
    }

    /**
     * @param  array  $data  Include a 'reason' as a string
     *                       and an optional 'meta' array of strings
     */
    public function report(array $data, User $reporter): Report
    {
        $report = (new Report())->fill(array_merge($data, [
            'user_id' => $reporter->id,
        ]));

        $this->reports()->save($report);

        return $report;
    }
}
