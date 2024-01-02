<?php

namespace App\Traits;

use App\Models\Report;

trait HasReports
{
    /**
     * Morph to attachment.
     */
    public function reports()
    {
        return $this->morphMany(Report::class, 'report');
    }
}
