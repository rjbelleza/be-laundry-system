<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    public function service()
    {
        return $this->belongsT0(Service::class);
    }
}
