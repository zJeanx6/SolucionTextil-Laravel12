<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Machine extends Model
{
    /** @use HasFactory<\Database\Factories\MachineFactory> */
    use HasFactory;

    public $timestamps = false;
    public $incrementing = false;
    protected $primaryKey = 'serial';
    protected $keyType = 'string';

    protected $fillable = [
        'serial',
        'image',
        'state_id',
        'machine_type_id',
        'brand_id',
        'supplier_nit',
        'last_maintenance',
        'company_nit',
    ];

    public function state()
    {
        return $this->belongsTo(State::class);
    }

    public function machineType()
    {
        return $this->belongsTo(MachineType::class, 'machine_type_id');
    }

    public function company()
    {
        return $this->belongsTo(Company::class);
    }

    public function brand()
    {
        return $this->belongsTo(Brand::class);
    }

    public function supplier()
    {
        return $this->belongsTo(Supplier::class, 'supplier_nit', 'nit');
    }

    public function maintenances()
    {
        return $this->hasMany(Maintenance::class, 'serial_id', 'serial');
    }
}
