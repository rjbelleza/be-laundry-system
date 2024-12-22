<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    public function services()
    {
        return $this->belongsToMany(Service::class, 'product_service');
    }
    
}
