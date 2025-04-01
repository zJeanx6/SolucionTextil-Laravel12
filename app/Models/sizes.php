<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class sizes extends Model
{
    /** @use HasFactory<\Database\Factories\SizesFactory> */
    use HasFactory;

    public $timestamps = false;
    protected $fillable = [
        'name',
        'last_name',
        'email',
        'password',
    ];
}
