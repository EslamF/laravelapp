<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Models\Orders\SortOrder;

class DropUserIdFromSortOrders extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $orders = SortOrder::get();
        foreach($orders as $order)
        {
            $order->users()->syncWithoutDetaching($order->user_id);
        }
        //DB::statement('ALTER TABLE sort_orders DROP INDEX sort_orders_user_id_foreign;');

        Schema::table('sort_orders', function (Blueprint $table) {
            
            $table->dropForeign('sort_orders_user_id_foreign');
            $table->dropColumn('user_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('sort_orders', function (Blueprint $table) {
            //
        });
    }
}
