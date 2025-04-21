<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Shopping extends Model
{
    /** @use HasFactory<\Database\Factories\ShoppingFactory> */
    use HasFactory;

    protected $fillable = [
        'card_id',
        'supplier_nit',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'card_id', 'card');
    }

    public function supplier()
    {
        return $this->belongsTo(Supplier::class, 'supplier_nit', 'nit');
    }

    public function details()
    {
        return $this->hasMany(ShoppingDetail::class, 'shopping_id');
    }
}
