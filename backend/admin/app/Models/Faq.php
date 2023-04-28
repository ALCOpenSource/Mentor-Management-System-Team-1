<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Faq extends Model
{
    use HasFactory;

    protected $fillable = [
        'question',
        'answer',
        'category',
        'status',
        'slug',
        'meta_title',
        'meta_description',
        'meta_keywords',
        'meta_robots',
        'meta_canonical',
        'meta_image',
    ];

    protected $hidden = [
        'created_at',
        'updated_at',
    ];
}
