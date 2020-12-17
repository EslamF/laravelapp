<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class MakeTypeAndNotesNullableInCustomers extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        /*Schema::table('customers', function (Blueprint $table) {
            $table->dropColumn('type');
            $table->enum('type', ['individual','related', 'retailer', 'wholesaler'])->nullable();

            //$table->string('notes')->nullable()->change();
        });*/
        DB::statement("ALTER TABLE customers CHANGE COLUMN type type ENUM('individual', 'related', 'retailer', 'wholesaler')");
        DB::statement('ALTER TABLE customers CHANGE notes notes varchar(255) DEFAULT NULL');
        //DB::statement('ALTER TABLE customers MODIFY type enum;');
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('customers', function (Blueprint $table) {
            //
        });
    }
}
