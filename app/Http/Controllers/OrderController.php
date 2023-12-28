<?php

namespace App\Http\Controllers;

use App\Models\Med;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Resources\MedsResource;
use App\Http\Resources\OrderResource;

class OrderController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        if ($request->user()->cannot('create', Order::class)) {
            abort(403);
        }
        $orders = Order::join('meds','orders.med_id','=','meds.id')->select('meds.commercial_name','orders.quantity_required','orders.status','orders.paid')->where('orders.user_id', auth()->id())
              ->get(['meds.commercial_name','orders.*']);

        return response()->json(['orders' => $orders]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {

        if ($request->user()->cannot('create', Order::class)) {
            abort(403);
        }
        $orders=$request['orders'];
        

        foreach($orders as $orderData){
           
            $order = new Order;
            $order->med_id = $orderData['med_id'];
            $order->user_id = auth()->id();
            $order->quantity_required = $orderData['quantity_required'];
            $order->status = "Received!";
            $order->paid = "No!";
            $order->save();    
         }

        // where should I redirect???
        return true;

    }

    /**
     * Display the specified resource.
     */
    public function show(string $id,Request $request)//must have string in url, my mistake
    {
        if ($request->user()->cannot('viewAny', Order::class)) {
            abort(403);
        }

        $orders = $orders = Order::join('meds','orders.med_id','=','meds.id')->select('meds.commercial_name','orders.*')->get(['meds.commercial_name','orders.*']);
        return response()->json(['orders' => $orders]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        if ($request->user()->cannot('update', Order::class)) {
            abort(403);
        }
        if($request->status==='Sent!'){
            $order=Order::findOrFail($id);
            $med=Med::findOrFail($order->med_id);
            $med->quantity_available -= $order->quantity_required;
            $med->save();
        }

        $order=Order::findOrFail($id);
        $order->update($request->all());

        return true;
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
