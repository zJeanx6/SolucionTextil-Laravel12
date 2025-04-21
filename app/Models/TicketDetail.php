<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TicketDetail extends Model
{
    /** @use HasFactory<\Database\Factories\TicketDetailFactory> */
    use HasFactory;

    public $timestamps = false;

    protected $fillable = [
        'amount',
        'ticket_id',
        'product_code',
    ];

    public function ticket()
    {
        return $this->belongsTo(Ticket::class);
    }

    public function product()
    {
        return $this->belongsTo(Product::class, 'product_code', 'code');
    }
}
