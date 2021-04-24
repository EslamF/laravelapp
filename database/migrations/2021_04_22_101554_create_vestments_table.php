<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateVestmentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('vestments', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('material_id');
            $table->string('name')->nullable();
            $table->double('weight');
            $table->string('barcode');
            $table->enum('status' , ['pending' , 'done'])->default('pending');
            $table->unsignedBigInteger('spreading_out_material_order_id')->nullable();
            
           
            $table->timestamps();

            $table->foreign('material_id')
                    ->references('id')->on('materials')
                    ->onDelete('cascade');

            $table->foreign('spreading_out_material_order_id')
                ->references('id')->on('spreading_out_material_orders')
                ->onDelete('cascade');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('vestments');
    }
}
