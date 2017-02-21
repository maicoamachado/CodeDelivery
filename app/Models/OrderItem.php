<?php

namespace CodeDelivery\Models;

use Illuminate\Database\Eloquent\Model;
use Prettus\Repository\Contracts\Transformable;
use Prettus\Repository\Traits\TransformableTrait;

class OrderItem extends Model implements Transformable
{
    use TransformableTrait;

    protected $fillable = ['product_id', 'order_id', 'price', 'qtd'];

    public function order(){
        return $this->BelongsTo(\CodeDelivery\Models\Order::class);   
    }

    public function product(){
        return $this->BelongsTo(\CodeDelivery\Models\Product::class);   
    }

}
