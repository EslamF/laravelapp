<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMaterialsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('materials', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('code');
            $table->string('mq_r_code');

            $table->unsignedBigInteger('material_type_id');
            $table->foreign('material_type_id')
                ->references('id')->on('material_types')
                ->onDelete('cascade');

            $table->unsignedBigInteger('user_id');
            $table->foreign('user_id')
                ->references('id')->on('users')
                ->onDelete('cascade');

            $table->unsignedBigInteger('supplier_id');
            $table->foreign('supplier_id')
                ->references('id')->on('suppliers')
                ->onDelete('cascade');

            $table->string('qty')->nullable();
            $table->double('weight')->nullable();
            $table->string('bill_number');
            $table->text('description')->nullable();
            
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
        Schema::dropIfExists('materials');
    }
}