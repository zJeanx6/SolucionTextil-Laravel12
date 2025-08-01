<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MachineType extends Model
{
    /** @use HasFactory<\Database\Factories\MachineTypeFactory> */
    use HasFactory;

    public $timestamps = false;

    protected $fillable = [
        'name',
        'description',
        'company_nit',
    ];

    public function company()
    {
        return $this->belongsTo(Company::class);
    }
    
    public function machines()
    {
        return $this->hasMany(Machine::class, 'machine_type_id');
    }
}
