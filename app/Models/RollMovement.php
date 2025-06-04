<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RollMovement extends Model
{
    protected $table = 'roll_movements';

    protected $fillable = [
        'roll_code',
        'used_length',
        'instructor_id',
        'user_id',
        'loan_id',
    ];

    /**
     * Cada RollMovement pertenece a un Roll.
     */
    public function roll()
    {
        return $this->belongsTo(Roll::class, 'roll_code', 'code');
    }

    /**
     * Instructor que recibe el metraje.
     */
    public function instructor()
    {
        return $this->belongsTo(User::class, 'instructor_id', 'card');
    }

    /**
     * Usuario que registra el corte.
     */
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'card');
    }

    /**
     * (Opcional) préstamo parent, si se desea agrupar en loans.
     */
    public function loan()
    {
        return $this->belongsTo(Loan::class);
    }
}
