<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ExitDetail extends Model
{
    /** @use HasFactory<\Database\Factories\ExitDetailFactory> */
    use HasFactory;

    protected $fillable = [
        'amount',
        'exit_id',
        'product_code',
    ];

    public function exit()
    {
        return $this->belongsTo(ProductExit::class, 'exit_id');
    }

    public function product()
    {
        return $this->belongsTo(Product::class, 'product_code', 'code');
    }
}
