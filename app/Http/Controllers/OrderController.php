<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;

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
        $orders = Order::where('user_id', auth()->id())->get();
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
            $order->status = "Sent!";
            $order->paid = "No!";
            $order->save();    
         }

        // where should I redirect???
        return true;

    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
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
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
