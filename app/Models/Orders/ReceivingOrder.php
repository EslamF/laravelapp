<?php

namespace App\Models\Orders;

use Illuminate\Database\Eloquent\Model;
use App\Models\Orders\produceOrder;
use App\Models\Products\ProductType;
use App\Models\Options\Size;
use App\Models\Products\Product;

class ReceivingOrder extends Model
{
    protected $fillable = ['produce_order_id', 'status',];

    public function produceOrder()
    {
        return $this->belongsTo(ProduceOrder::class);
    }

    public function productType()
    {
        return $this->belongsTo(ProductType::class);
    }

    public function size()
    {
        return $this->belongsTo(Size::class);
    }

    public function products()
    {
        return $this->hasMany(Product::class);
    }
}
