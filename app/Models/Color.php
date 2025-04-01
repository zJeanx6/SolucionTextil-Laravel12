<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;  

class Color extends Model
{
    use HasFactory;

    public $timestamps = false;
    protected $fillable = [
        'code', 'name',
    ];

}
