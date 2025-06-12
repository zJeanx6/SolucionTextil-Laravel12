<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphTo;

class ElementMovement extends Model
{
    protected $fillable = [
        'type', 'movementable_id', 'movementable_type',
        'party', 'user', 'file',
    ];

    public function movementable(): MorphTo
    {
        return $this->morphTo();
    }
}
