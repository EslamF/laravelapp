<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateReceivingOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('receiving_orders', function (Blueprint $table) {
            $table->bigIncrements('id');

            $table->unsignedBigInteger('produce_order_id');
            $table->foreign('produce_order_id')
                ->references('id')->on('produce_orders')
                ->onDelete('cascade');

            $table->unsignedBigInteger('product_type_id');
            $table->foreign('product_type_id')
                ->references('id')->on('product_types')
                ->onDelete('cascade');

            $table->unsignedBigInteger('size_id');
            $table->foreign('size_id')
                ->references('id')->on('sizes')
                ->onDelete('cascade');
            $table->date('receiving_date');
            $table->string('qty');
            $table->boolean('status');
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
        Schema::dropIfExists('receiving_orders');
    }
}