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
            $table->text('description')->nullable();
            $table->date('sort_date')->nullable();
            $table->enum('damage_type', ['ironing', 'tailoring', 'Dyeing'])->nullable();

            $table->unsignedBigInteger('sort_order_id')->nullable();
            $table->foreign('sort_order_id')
                ->references('id')->on('sort_orders')
                ->onDelete('cascade');

            $table->unsignedBigInteger('receiving_order_id');
            $table->foreign('receiving_order_id')
                ->references('id')->on('receiving_orders')
                ->onDelete('cascade');

            $table->enum('status', ['pending', 'sold', 'available', 'damaged'])->default('available');

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