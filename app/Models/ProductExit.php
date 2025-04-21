<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductExit extends Model
{
    /** @use HasFactory<\Database\Factories\ProductExitFactory> */
    use HasFactory;

    protected $table = 'exits';

    protected $fillable = [
        'card_id',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'card_id', 'card');
    }

    public function details()
    {
        return $this->hasMany(ExitDetail::class, 'exit_id');
    }
}
