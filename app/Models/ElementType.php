<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ElementType extends Model
{
    /** @use HasFactory<\Database\Factories\ElementTypeFactory> */
    use HasFactory;

    public $incrementing = false;
    public $timestamps = false;

    protected $fillable = [
        'id',
        'name',
        'description',
        'company_nit',
    ];

    public function company()
    {
        return $this->belongsTo(Company::class);
    }

    public function elements()
    {
        return $this->hasMany(Element::class, 'element_type_id', 'id');
    }
}
