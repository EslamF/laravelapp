<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class MakeUserIdNullableInSpreadingOrders extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //DB::statement("ALTER TABLE spreading_out_material_orders CHANGE user_id user_id bigInt DEFAULT NULL");
        Schema::table('spreading_out_material_orders', function (Blueprint $table) {
            $table->dropForeign('spreading_out_material_orders_user_id_foreign');
            //$table->bigInteger('user_id')->nullable()->change();
        });

        DB::statement("ALTER TABLE spreading_out_material_orders CHANGE user_id user_id bigInt UNSIGNED DEFAULT NULL ");

        Schema::table('spreading_out_material_orders', function (Blueprint $table) {
            
            $table->foreign('user_id')
                    ->references('id')->on('users')
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
        Schema::table('spreading_orders', function (Blueprint $table) {
            //
        });
    }
}
