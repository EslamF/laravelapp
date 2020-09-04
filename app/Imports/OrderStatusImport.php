<?php

namespace App\Imports;

use App\Models\Orders\BuyOrder;
use App\Models\Orders\OrderStatus;
use App\Models\Organization\Supplier;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Illuminate\Support\Facades\DB;

class OrderStatusImport implements ToCollection
{
    /**
     * @param Collection $collection
     */
    public function collection(Collection $collection)
    {
        ini_set('max_execution_time', 0);
        foreach ($collection as $key => $value) {
            if ($key == 0) {
                if ((isset($value[39]) && $value[39] == 'id') && (isset($value[4]) && $value[4] == 'System_Result') && (isset($value[5]) && $value[5] == 'System_Status')) {
                    continue;
                } else {
                    break;
                }
            } else {
                if (isset($value[39]) && !empty($value[39])) {
                    $check = BuyOrder::where('id', $value[39])->exists();
                    if ($check) {
                        OrderStatus::updateOrCreate(['buy_order_id' => $value[39]], [
                            'buy_order_id' => $value[39],
                            'status'    => $value[4],
                            'status_message' => $value[5]
                        ]);
                    }
                }
            }
        }
    }
}
