<?php

namespace App\Models\Products;

use App\Models\Materials\Material;
use App\Models\Options\Size;
use App\Models\Orders\BuyOrder;
use App\Models\Orders\CuttingOrderProduct;
use App\Models\Orders\ReceivingOrder;
use App\Models\Orders\SaveOrder;
use App\User;
use App\Models\Orders\SortOrder;
use App\Models\Products\ProductType;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $fillable = [
        'prod_code',
        'receiving_order_id',
        'sorted',
        'damage_type',
        'description',
        'product_type_id',
        'size_id',
        'material_id',
        'status',
        'sort_order_id',
        'sort_date',
        'save_order_id',
        'created_by',
        'stored',
        'cutting_order_product_id',
        'cutting_order_id',
        'produce_code',
        'received',
        'produce_order_id',
        'product_material_code',
        'factory_id'
    ];


    public function sortOrder()
    {
        return $this->belongsTo(SortOrder::class, 'sort_order_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function receivingOrder()
    {
        return $this->belongsTo(ReceivingOrder::class);
    }

    public function cuttingOrderProducts()
    {
        return $this->belongsTo(CuttingOrderProduct::class);
    }

    public function buyOrderProducts()
    {
        return $this->cuttingOrderProducts();
    }

    public function productType()
    {
        return $this->belongsTo(ProductType::class);
    }

    public function size()
    {
        return $this->belongsTo(Size::class);
    }

    public function saveOrder()
    {
        return $this->belongsTo(SaveOrder::class);
    }

    public function material()
    {
        return $this->belongsTo(Material::class);
    }

    public function buyOrders()
    {
        return $this->belongsToMany(BuyOrder::class);
    }

    public function buyOrder()
    {
        return $this->buyOrders()->first();
    }

    public function produce_orders()
    {
        return $this->belongsTo('App\Models\Orders\ProduceOrder');
    }

    public function factory()
    {
        return $this->belongsTo('App\Models\Organization\Factory');
    }
}
