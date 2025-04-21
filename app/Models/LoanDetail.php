<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LoanDetail extends Model
{
    /** @use HasFactory<\Database\Factories\LoanDetailFactory> */
    use HasFactory;

    public $timestamps = false;

    protected $fillable = [
        'amount',
        'loan_id',
        'element_code',
    ];

    public function loan()
    {
        return $this->belongsTo(Loan::class);
    }

    public function element()
    {
        return $this->belongsTo(Element::class, 'element_code', 'code');
    }
}
