<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddReturedStatusToStatusEnumInBuyOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::statement("ALTER TABLE buy_orders CHANGE COLUMN status status ENUM('pending', 'done', 'rejected' , 'returned') DEFAULT 'pending' ");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('status_enum_in_buy_orders', function (Blueprint $table) {
            //
        });
    }
}
