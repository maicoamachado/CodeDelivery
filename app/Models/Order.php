<?php

namespace CodeDelivery\Models;

use Illuminate\Database\Eloquent\Model;
use Prettus\Repository\Contracts\Transformable;
use Prettus\Repository\Traits\TransformableTrait;

class Order extends Model implements Transformable
{
    use TransformableTrait;

    protected $fillable = ['client_id', 'user_deliveryman_id', 'total', 'status_id'];

    public function items(){
        return $this->hasMany(\CodeDelivery\Models\OrderItem::class);   
    }

    public function client(){
        return $this->belongsTo(\CodeDelivery\Models\Client::class);
    }

    public function deliveryman(){
        return $this->belongsTo(\CodeDelivery\Models\User::class, 'user_deliveryman_id', 'id');
    }

    public function status(){
        return $this->belongsTo(\CodeDelivery\Models\StatusOrders::class);
    }

    public function products(){
        return $this->hasMany(\CodeDelivery\Models\Product::class);   
    }

    public function cupom(){
        return $this->belongsTo(\CodeDelivery\Models\Cupom::class);
    }

}
