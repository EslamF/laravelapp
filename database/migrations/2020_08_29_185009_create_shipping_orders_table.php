<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateShippingOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('shipping_orders', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('shipping_code');
            $table->date('shipping_date');

            $table->unsignedBigInteger('shipping_company_id');
            $table->foreign('shipping_company_id')
                ->references('id')->on('shipping_companies')
                ->onDelete('cascade');

            $table->unsignedBigInteger('created_by');
            $table->foreign('created_by')
                ->references('id')->on('users')
                ->onDelete('cascade');

            $table->boolean('status')->default(0);

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
        Schema::dropIfExists('shipping_orders');
    }
}
