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

            if($key ==0 || $key == 1)
            {
                continue;
            }
            else 
            {
                $awb                = $value[1]; //AWB
                $status             = $value[4] ;//status
                $main_status        = '';
                $status_description = $value[5]; //status description
                $order = BuyOrder::where('order_number' , $awb)->first();
                if($order)
                {
                    if($status == 'تم التحصيل')
                    {
                        $main_status = 'paid';
                    }

                    else if($status == 'تم التسليم')
                    {
                        $main_status = 'done';
                    }

                    else if($status == 'تحت التسليم')
                    {
                        $main_status = 'pending';
                    }

                    else if($status == 'مرتجع')
                    {
                        $main_status = 'rejected';
                    }


                    if($main_status)
                    {   
                        $order->status = $main_status;
                        $order->save();

                        OrderStatus::updateOrCreate(['buy_order_id' => $order->id], [
                            'buy_order_id' => $order->id,
                            'status'    => $main_status,
                            'status_message' => $status_description
                        ]);
                    }


                }
                
               
            }

            $value[1]; //AWB
            $value[4] ;//status
            $value[5]; //status description


            //dd($value);
            //return response()->json($value[0]);
            /*if ($key == 0) {
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
            }*/
        }
    }
}
