<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateStoreProductOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('store_product_orders', function (Blueprint $table) {
            $table->bigIncrements('id');

            $table->string('code');

            $table->unsignedBigInteger('save_order_id');
            $table->foreign('save_order_id')
                ->references('id')->on('save_orders')
                ->onDelete('cascade');

            $table->unsignedBigInteger('created_by');
            $table->foreign('created_by')
                ->references('id')->on('users')
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
        Schema::dropIfExists('store_product_orders');
    }
}
