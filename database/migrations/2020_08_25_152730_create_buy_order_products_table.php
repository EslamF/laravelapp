<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBuyOrderProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('buy_order_products', function (Blueprint $table) {
            $table->bigIncrements('id');

            $table->unsignedBigInteger('buy_order_id');
            $table->foreign('buy_order_id')
                ->references('id')->on('buy_orders')
                ->onDelete('cascade');

            $table->string('produce_code');
            $table->string('factory_qty');
            $table->string('company_qty');
            $table->double('price');

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
        Schema::dropIfExists('buy_order_products');
    }
}
