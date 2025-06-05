<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Maintenance extends Model
{
    /** @use HasFactory<\Database\Factories\MaintenanceFactory> */
    use HasFactory;

    protected $fillable = [
        'maintenance_type',
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

    public function state()
    {
        return $this->belongsTo(State::class);
    }

    public function details()
    {
        return $this->hasMany(MaintenanceDetail::class);
    }
}
