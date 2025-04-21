<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Loan extends Model
{
    /** @use HasFactory<\Database\Factories\LoanFactory> */
    use HasFactory;

    protected $fillable = [
        'document',
        'name',
        'file',
        'card_id',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'card_id', 'card');
    }
    
    public function details()
    {
        return $this->hasMany(LoanDetail::class, 'loan_id');
    }
}
