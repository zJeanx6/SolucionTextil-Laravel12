<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Roll extends Model
{
    /** @use HasFactory<\Database\Factories\RollFactory> */
    use HasFactory;

    public $incrementing = false;
    protected $primaryKey = 'code';

    protected $fillable = [
        'code',
        'broad',
        'long',
        'element_code',
    ];

    public function element()
    {
        return $this->belongsTo(Element::class, 'element_code', 'code');
    }
}
