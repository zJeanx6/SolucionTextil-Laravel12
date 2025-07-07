<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LicenseType extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'duration',
    ];

    public function licenses()
    {
        return $this->hasMany(License::class, 'license_type_id', 'id');
    }
}
