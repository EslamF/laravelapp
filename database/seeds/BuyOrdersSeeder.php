<?php

use Illuminate\Database\Seeder;
use Maatwebsite\Excel\Facades\Excel;
use App\Imports\BuyOrdersImport;

class BuyOrdersSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Excel::import(new BuyOrdersImport("2021-01-09"), public_path('sales1.xlsx'));
        Excel::import(new BuyOrdersImport("2021-01-10"), public_path('sales2.xlsx'));
    }
}
