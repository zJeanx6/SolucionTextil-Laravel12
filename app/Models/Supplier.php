<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Supplier extends Model
{
    /** @use HasFactory<\Database\Factories\SupplierFactory> */
    use HasFactory;

    public $timestamps = false;
    public $incrementing = false;
    protected $primaryKey = 'nit';
    protected $keyType = 'string';

    protected $fillable = [
        'nit',
        'name',
        'person_type',
        'email',
        'phone',
        'representative_name',
        'representative_email',
        'representative_phone',
        'company_nit',
    ];

    public function machines()
    {
        return $this->hasMany(Machine::class, 'supplier_nit', 'nit');
    }
    
    public function company()
    {
        return $this->belongsTo(Company::class);
    }

    public function shoppings()
    {
        return $this->hasMany(Shopping::class, 'supplier_nit', 'nit');
    }
}
