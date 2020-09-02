<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSaveOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('save_orders', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('code')->unique();
            $table->boolean('stored')->default(0);

            $table->unsignedBigInteger('created_by');
            $table->foreign('created_by')
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
        Schema::dropIfExists('save_orders');
    }
}
