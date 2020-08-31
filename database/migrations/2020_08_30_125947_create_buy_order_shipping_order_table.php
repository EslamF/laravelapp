<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBuyOrderShippingOrderTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('buy_order_shipping_order', function (Blueprint $table) {
            $table->bigIncrements('id');

            $table->unsignedBigInteger('buy_order_id');
            $table->foreign('buy_order_id')
                ->references('id')->on('buy_orders')
                ->onDelete('cascade');

            $table->unsignedBigInteger('shipping_order_id');
            $table->foreign('shipping_order_id')
                ->references('id')->on('shipping_orders')
                ->onDelete('cascade');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('buy_order_shipping_order');
    }
}
