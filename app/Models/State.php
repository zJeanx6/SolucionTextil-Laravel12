<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class State extends Model
{
    /** @use HasFactory<\Database\Factories\StatesFactory> */
    use HasFactory;

    public $timestamps = false;
    protected $fillable = [
        'name',
        'description',
    ];

    public function users()
    {
        return $this->hasMany(User::class, 'state_id');
    }

    public function machines()
    {
        return $this->hasMany(Machine::class, 'state_id');
    }

    public function maintenances()
    {
        return $this->hasMany(Maintenance::class, 'state_id');
    }
}
