<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class State extends Model
{
    /** @use HasFactory<\Database\Factories\StatesFactory> */
    use HasFactory;

    public $timestamps = false;
    protected $fillable = [
        'name',
        'description',
    ];
}
