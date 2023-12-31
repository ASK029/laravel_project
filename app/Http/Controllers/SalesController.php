<?php

namespace App\Http\Controllers;

use App\Models\Med;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Resources\MedsResource;

class SalesController extends Controller
{
    public function getSales(Request $request){
        if ($request->user()->cannot('viewAny', Order::class)) {
            abort(403);
        }
        $from=$request->from;
        $to=$request->to;
        $sales=Order::where('paid','Yes!')->whereBetween('updated_at',[$from,$to])->get();
        
        return $sales;
    }

    public function mostPopular(Request $request){
        // $totalQuantities = Med::withSum('orders', 'quantity_required')->orderByDesc('orders_sum_quantity_required')
        //     ->get()
        //     ->mapWithKeys(function ($item) {
        // return [$item['commercial_name'] => $item['orders_sum_quantity_required']];
        //     });
            
        // return response()->json(['popular'=>$totalQuantities]);
        if ($request->user()->cannot('viewAny', Order::class)) {
            abort(403);
        }
    
            $totalQuantities=Med::join('orders','meds.id','=','orders.med_id')->select('meds.commercial_name', DB::raw('SUM(orders.quantity_required) as total_quantity'))
            ->groupBy('meds.commercial_name')->orderByDesc('total_quantity')
            ->get();
            return $totalQuantities;

    }

}
