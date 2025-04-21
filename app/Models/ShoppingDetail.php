<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ShoppingDetail extends Model
{
    /** @use HasFactory<\Database\Factories\ShoppingDetailFactory> */
    use HasFactory;

    public $timestamps = false;

    protected $fillable = [
        'amount',
        'shopping_id',
        'element_code',
    ];

    public function shopping()
    {
        return $this->belongsTo(Shopping::class);
    }

    public function element()
    {
        return $this->belongsTo(Element::class, 'element_code', 'code');
    }
}
