<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProduceOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('produce_orders', function (Blueprint $table) {
            $table->bigIncrements('id');

            $table->unsignedBigInteger('cutting_order_id');
            $table->foreign('cutting_order_id')
                ->references('id')->on('cutting_orders')
                ->onDelete('cascade');

            $table->unsignedBigInteger('factory_id');
            $table->foreign('factory_id')
                ->references('id')->on('factories')
                ->onDelete('cascade');

            $table->unsignedBigInteger('created_by');
            $table->foreign('created_by')
                ->references('id')->on('users')
                ->onDelete('cascade');


            $table->date('receiving_date');
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
        Schema::dropIfExists('produce_orders');
    }
}
