<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSortOrderUserTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sort_order_user', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('sort_order_id');
            $table->unsignedBigInteger('user_id');

            $table->foreign('sort_order_id')
                ->references('id')->on('sort_orders')
                ->onDelete('cascade');

            $table->foreign('user_id')
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
        Schema::dropIfExists('sort_order_user');
    }
}
