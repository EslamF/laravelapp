<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCuttingOrderProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cutting_order_products', function (Blueprint $table) {
            $table->bigIncrements('id');

            $table->unsignedBigInteger('cutting_order_id');
            $table->foreign('cutting_order_id')
                ->references('id')->on('cutting_orders')
                ->onDelete('cascade');

            $table->unsignedBigInteger('product_type_id');
            $table->foreign('product_type_id')
                ->references('id')->on('product_types')
                ->onDelete('cascade');

            $table->unsignedBigInteger('size_id');
            $table->foreign('size_id')
                ->references('id')->on('sizes')
                ->onDelete('cascade');

            $table->string('qty');

            $table->boolean('received')->default(0);

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
        Schema::dropIfExists('cutting_order_products');
    }
}
