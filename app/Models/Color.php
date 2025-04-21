<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Color extends Model
{
    use HasFactory;

    public $timestamps = false;
    
    protected $fillable = [
        'code',
        'name',
    ];

    public function elements()
    {
        return $this->hasMany(Element::class, 'color_id', 'id');
    }

    public function products()
    {
        return $this->hasMany(Product::class, 'color_id', 'id');
    }
}
