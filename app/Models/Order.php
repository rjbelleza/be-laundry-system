<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'service_id', 
        'product_id',
        'baskets', 
        'address',
        'postal_code', 
        'courier_id',
        'notes', 
        'payment_mode', 
        'total_price',
        'status',
        'out_date',
        'return_date',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function service()
    {
        return $this->belongsTo(Service::class);
    }

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    public function courier()
    {
        return $this->belongsTo(User::class, 'courier_id');
    }

}
