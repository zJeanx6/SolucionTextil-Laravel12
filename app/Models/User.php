<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Str;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $primaryKey = 'card';
    protected $keyType = 'int';
    public $incrementing = false;

    protected $fillable = [
        'card',
        'name',
        'last_name',
        'email',
        'phone',
        'password',
        'role_id',
        'state_id',
        'company_nit'
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    public function role()
    {
        return $this->belongsTo(Role::class);
    }

    public function state()
    {
        return $this->belongsTo(State::class);
    }

    public function company()
    {
        return $this->belongsTo(Company::class);
    }

    public function maintenances()
    {
        return $this->hasMany(Maintenance::class, 'card_id', 'card');
    }

    public function loansUser()
    {
        return $this->hasMany(Loan::class, 'card_id', 'card');
    }

    public function loansInstructor()
    {
        return $this->hasMany(Loan::class, 'instructor_id', 'card');
    }

    public function exits()
    {
        return $this->hasMany(ProductExit::class, 'card_id', 'card');
    }

    public function shoppings()
    {
        return $this->hasMany(Shopping::class, 'card_id', 'card');
    }

    public function tickets()
    {
        return $this->hasMany(Ticket::class, 'card_id', 'card');
    }

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    public function initials(): string
    {
        return Str::of($this->name)
            ->explode(' ')
            ->map(fn(string $name) => Str::of($name)->substr(0, 1))
            ->implode('');
    }
}
