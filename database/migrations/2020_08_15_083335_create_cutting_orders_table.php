<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCuttingOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cutting_orders', function (Blueprint $table) {
            $table->bigIncrements('id');
            
            $table->unsignedBigInteger('spreading_out_material_order_id');
            $table->foreign('spreading_out_material_order_id')
                ->references('id')->on('spreading_out_material_orders')
                ->onDelete('cascade');

            $table->unsignedBigInteger('user_id');
            $table->foreign('user_id')
                ->references('id')->on('users')
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

            $table->string('layers');
            $table->string('extra_returns_weight');
                
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
        Schema::dropIfExists('cutting_orders');
    }
}