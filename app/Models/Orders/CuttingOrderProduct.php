<?php

namespace App\Models\Orders;

use App\Models\Products\ProductType;
use Illuminate\Database\Eloquent\Model;
use App\Models\Options\Size;
use App\Models\Products\Product;

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

    public function products()
    {
        return $this->hasMany(Product::class);
    }

    public function buyOrderProducts()
    {
        return $this->hasMany(BuyOrderProduct::class);
    }

    public function unSortedCount()
    {
        $count = (int)$this->products()->where('status', 'available')->where('save_order_id', null)->count() / 100 * 90;
        return intval($count);
    }

    public function unSorted()
    {
        return $this->hasMany(Product::class)->where('status', 'available')->where('sorted', 0)->select('cutting_order_product_id', 'id');
    }
}
