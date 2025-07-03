<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Maintenance extends Model
{
    use HasFactory;

    protected $fillable = [
        'type',
        'description',
        'maintenance_date',
        'next_maintenance_date',
        'serial_id',
        'card_id',
        'state_id',
    ];

    public function machine()
    {
        return $this->belongsTo(Machine::class, 'serial_id', 'serial');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'card_id', 'card');
    }

    public function type()
    {
        return $this->belongsTo(MaintenanceType::class, 'type', 'name'); // Ajuste de relación
    }

    public function state()
    {
        return $this->belongsTo(State::class);
    }

    public function details()
    {
        return $this->hasMany(MaintenanceDetail::class);
    }
}
