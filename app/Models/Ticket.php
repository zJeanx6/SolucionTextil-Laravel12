<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ticket extends Model
{
    /** @use HasFactory<\Database\Factories\TicketFactory> */
    use HasFactory;

    protected $fillable = [
        'card_id',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'card_id', 'card');
    }

    public function details()
    {
        return $this->hasMany(TicketDetail::class, 'ticket_id');
    }
}
