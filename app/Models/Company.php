<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Company extends Model
{
    use HasFactory;

    public $incrementing = false;
    protected $primaryKey = 'nit';

    protected $fillable = [
        'nit',
        'name',
        'email',
    ];

    public function licenses()
    {
        return $this->hasMany(License::class, 'company_nit', 'nit');
    }

    public function users()
    {
        return $this->hasMany(User::class, 'company_nit', 'nit');
    }
}
