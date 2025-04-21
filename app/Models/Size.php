<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Size extends Model
{
    /** @use HasFactory<\Database\Factories\SizesFactory> */
    use HasFactory;

    public $timestamps = false;
    protected $fillable = [
        'name',
        'abbreviation',
    ];

    public function products()
    {
        return $this->hasMany(Product::class, 'size_id');
    }
}
