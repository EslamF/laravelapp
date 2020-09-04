<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('products', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('prod_code');
            $table->boolean('sorted')->default(0);
            $table->boolean('received')->default(0);
            $table->text('description')->nullable();
            $table->date('sort_date')->nullable();
            $table->string('produce_code');

            $table->enum('damage_type', ['ironing', 'tailoring', 'dyeing'])->nullable();

            $table->unsignedBigInteger('sort_order_id')->nullable();
            $table->foreign('sort_order_id')
                ->references('id')->on('sort_orders')
                ->onDelete('cascade');

            $table->unsignedBigInteger('save_order_id')->nullable();
            $table->foreign('save_order_id')
                ->references('id')->on('save_orders')
                ->onDelete('cascade');

            $table->unsignedBigInteger('material_id')->nullable();
            $table->foreign('material_id')
                ->references('id')->on('materials')
                ->onDelete('cascade');

            $table->unsignedBigInteger('product_type_id')->nullable();
            $table->foreign('product_type_id')
                ->references('id')->on('product_types')
                ->onDelete('cascade');

            $table->unsignedBigInteger('size_id')->nullable();
            $table->foreign('size_id')
                ->references('id')->on('sizes')
                ->onDelete('cascade');

            $table->unsignedBigInteger('user_id')->nullable();
            $table->foreign('user_id')
                ->references('id')->on('users')
                ->onDelete('cascade');

            $table->unsignedBigInteger('cutting_order_id')->nullable();
            $table->foreign('cutting_order_id')
                ->references('id')->on('cutting_orders')
                ->onDelete('cascade');


            $table->unsignedBigInteger('receiving_order_id')->nullable();
            $table->foreign('receiving_order_id')
                ->references('id')->on('receiving_orders')
                ->onDelete('cascade');

            $table->enum('status', ['pending', 'sold', 'available', 'damaged', 'reserved'])->default('available');

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
        Schema::dropIfExists('products');
    }
}
