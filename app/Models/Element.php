<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Element extends Model
{
    /** @use HasFactory<\Database\Factories\ElementFactory> */
    use HasFactory;

    public $incrementing = false;
    protected $primaryKey = 'code';

    protected $fillable = [
        'code',
        'name',
        'stock',
        'image',
        'color_id',
        'element_type_id',
    ];

    public function color()
    {
        return $this->belongsTo(Color::class);
    }

    public function elementType()
    {
        return $this->belongsTo(ElementType::class, 'element_type_id');
    }

    public function loanDetails()
    {
        return $this->hasMany(LoanDetail::class, 'element_code', 'code');
    }

    public function shoppingDetails()
    {
        return $this->hasMany(ShoppingDetail::class, 'element_code', 'code');
    }
    
    public function rolls()
    {
        return $this->hasMany(Roll::class, 'element_code', 'code');
    }

}
