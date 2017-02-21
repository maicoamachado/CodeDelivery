<?php

namespace CodeDelivery\Models;

use Illuminate\Database\Eloquent\Model;
use Prettus\Repository\Contracts\Transformable;
use Prettus\Repository\Traits\TransformableTrait;

class StatusOrders extends Model implements Transformable
{
    use TransformableTrait;

    protected $fillable = ['name'];

    public function order(){
        return $this->belongsTo(\CodeDelivery\Models\Order::class);
    }

}
