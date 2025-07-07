<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class License extends Model
{
    use HasFactory;

    public $incrementing = false;
    protected $primaryKey = 'license';
    
    protected $fillable = [
        'license',
        'company_nit',
        'purchase_date',
        'end_date',
        'state_id',
        'license_type_id',
    ];

    public function company()
    {
        return $this->belongsTo(Company::class, 'company_nit', 'nit');
    }

    public function state()
    {
        return $this->belongsTo(State::class, 'state_id', 'id');
    }

    public function licenseType()
    {
        return $this->belongsTo(LicenseType::class, 'license_type_id', 'id');
    }
}
