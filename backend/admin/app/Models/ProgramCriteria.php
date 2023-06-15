<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProgramCriteria extends Model
{
    use HasFactory;
    use HasUuids;

    protected $fillable = [
        'program_id',
        'name',
        'input_type',
        'label',
        'meta',
        'pre_validation',
        'validation',
    ];

    protected $casts = [
        'meta' => 'array',
        'pre_validation' => 'array',
        'validation' => 'array',
    ];

    public function program()
    {
        return $this->belongsTo(Program::class);
    }

    public function programCriterias()
    {
        return $this->hasMany(ProgramCriteria::class);
    }

    public function certificateTemplates()
    {
        return $this->hasMany(ProgramCertificateTemplates::class);
    }

    public function certificates()
    {
        return $this->hasMany(ProgramCertificates::class);
    }

    public function programUsers()
    {
        return $this->hasMany(ProgramUser::class);
    }
}
