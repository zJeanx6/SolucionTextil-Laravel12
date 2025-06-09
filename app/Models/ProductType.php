<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductType extends Model
{
    /** @use HasFactory<\Database\Factories\ProductTypeFactory> */
    use HasFactory;

    public $timestamps = false;

    protected $fillable = [
        'name'
    ];

    public function products()
    {
        return $this->hasMany(Product::class, 'product_type_id');
    }
}
