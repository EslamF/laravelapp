<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBuyOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('buy_orders', function (Blueprint $table) {
            $table->bigIncrements('id');

            $table->unsignedBigInteger('customer_id');
            $table->foreign('customer_id')
                ->references('id')->on('customers')
                ->onDelete('cascade');

            $table->text('description')->nullable();
            $table->enum('confrimation', ['pending', 'canceled', 'confirmed'])->default('pending');
            $table->enum('preparation', ['need_prepare', 'prepared', 'shipped'])->default('need_prepare');
            $table->string('bar_code');
            $table->boolean('status')->default(0);
            $table->date('delivery_date');
            $table->date('pending_date')->nullable();

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
        Schema::dropIfExists('buy_orders');
    }
}
