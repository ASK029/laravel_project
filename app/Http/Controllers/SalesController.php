<?php

namespace App\Http\Controllers;

use App\Models\Med;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SalesController extends Controller
{
    public function getSales(Request $request){
        $from=$request->from;
        $to=$request->to;
        $sales=Order::where('status','Sent!')->whereBetween('updated_at',[$from,$to])->get();
        return $sales;
    }

    public function mostPopular(){
        $totalQuantities = Med::withSum('orders', 'quantity_required')->orderByDesc('orders_sum_quantity_required')
            ->get()
            ->mapWithKeys(function ($item) {
        return [$item['commercial_name'] => $item['orders_sum_quantity_required']];
            });
        return $totalQuantities;
    }

}
