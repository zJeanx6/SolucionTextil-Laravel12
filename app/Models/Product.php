<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    /** @use HasFactory<\Database\Factories\ProductFactory> */
    use HasFactory;

    public $incrementing = false;
    protected $primaryKey = 'code';

    protected $fillable = [
        'code',
        'name',
        'stock',
        'image',
        'color_id',
        'size_id',
        'product_type_id',
        'company_nit',
    ];

    public function color()
    {
        return $this->belongsTo(Color::class);
    }

    public function size()
    {
        return $this->belongsTo(Size::class);
    }

    public function company()
    {
        return $this->belongsTo(ProductType::class);
    }

    public function productType()
    {
        return $this->belongsTo(ProductType::class, 'product_type_id');
    }

    public function exitDetails()
    {
        return $this->hasMany(ExitDetail::class, 'product_code', 'code');
    }

    public function ticketDetails()
    {
        return $this->hasMany(TicketDetail::class, 'product_code', 'code');
    }
}
