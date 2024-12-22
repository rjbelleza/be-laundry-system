<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Service extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'description', 'price'];

    protected $casts = [ 'price' => 'float', ];

    public function products()
    {
        return $this->belongsToMany(Product::class, 'product_service');
    }
}
