<?php

namespace App\Models;

use App\Traits\HasUuidAttachments;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserAttachments extends Model
{
    use HasFactory;
    use HasUuids;
    use HasUuidAttachments;

    protected $primaryKey = 'uuid';

    protected $fillable = [
        'user_id',
        'attachment',
    ];

    protected $appends = [
        'attachments',
    ];

    /**
     * Get the user that owns the attachment.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
