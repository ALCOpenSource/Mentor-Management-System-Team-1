<?php

namespace App\Models;

use App\Traits\HasUuidAttachments;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProgramCertificateTemplates extends Model
{
    use HasFactory;
    use HasUuidAttachments;

    protected $fillable = [
        'program_id',
    ];

    public function program()
    {
        return $this->belongsTo(Program::class);
    }
}
