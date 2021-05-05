<?php

use Illuminate\Database\Seeder;
use App\Models\Orders\BuyOrder;

class change_barcode_of_buy_orders extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        foreach(BuyOrder::get() as $buy_order)
        {
            $buy_order->bar_code = generate_buy_order_barcode();
            $buy_order->save();
        }
    }
}
