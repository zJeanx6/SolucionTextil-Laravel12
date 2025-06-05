<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MaintenanceDetail extends Model
{
    /** @use HasFactory<\Database\Factories\MaintenanceDetailFactory> */
    use HasFactory;

    public $timestamps = false;

    protected $fillable = [
        'description',
        'maintenance_date', 
        'next_maintenance_date',
        'maintenance_id',
        'maintenance_type_id'
    ];

    public function maintenance()
    {
        return $this->belongsTo(Maintenance::class);
    }

    public function type()
    {
        return $this->belongsTo(MaintenanceType::class, 'maintenance_type_id');
    }
}
