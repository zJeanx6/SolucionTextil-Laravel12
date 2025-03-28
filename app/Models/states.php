<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class states extends Model
{
    /** @use HasFactory<\Database\Factories\StatesFactory> */
    use HasFactory;

    protected $fillable = [
        'name'
    ];
}
