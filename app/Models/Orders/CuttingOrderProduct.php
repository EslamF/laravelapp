<?php

namespace App\Models\Orders;

use App\Models\Products\ProductType;
use Illuminate\Database\Eloquent\Model;
use App\Models\Options\Size;

class CuttingOrderProduct extends Model
{
    protected $fillable = ['cutting_order_id', 'product_type_id', 'size_id', 'qty', 'received'];

    public function productType()
    {
        return $this->belongsTo(ProductType::class);
    }

    public function size()
    {
        return $this->belongsTo(Size::class);
    }
}
