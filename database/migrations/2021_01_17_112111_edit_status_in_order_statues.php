<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class EditStatusInOrderStatues extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::statement("ALTER TABLE order_statuses CHANGE COLUMN status status varchar(255)");
        DB::statement("ALTER TABLE order_statuses CHANGE COLUMN status_message status_message text");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('order_statues', function (Blueprint $table) {
            //
        });
    }
}
