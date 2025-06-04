<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LoanReturn extends Model
{
    protected $table = 'loan_returns';

    protected $fillable = [
        'loan_detail_id',
        'returned_by',
        'return_date',
    ];

    /**
     * El detalle de préstamo que se está devolviendo.
     */
    public function loanDetail()
    {
        return $this->belongsTo(LoanDetail::class, 'loan_detail_id', 'id');
    }

    /**
     * Usuario que recibe la devolución.
     */
    public function returnedByUser()
    {
        return $this->belongsTo(User::class, 'returned_by', 'card');
    }
}
