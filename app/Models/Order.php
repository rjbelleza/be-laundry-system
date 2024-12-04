<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    protected $fillable = ['service_id', 'baskets', 'address','postal_code', 'notes', 'payment_mode', 'total_price'];

    public function service()
    {
        return $this->belongsTo(Service::class);
    }
}
