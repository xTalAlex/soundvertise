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

    public function report($data, User $reporter): Report
    {
        $report = (new Report())->fill(array_merge($data, [
            'user_id' => $reporter->id,
        ]));

        $this->reports()->save($report);

        return $report;
    }
}
