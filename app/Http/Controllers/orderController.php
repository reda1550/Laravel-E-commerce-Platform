<?php

namespace App\Http\Controllers;

use App\Models\order;
use App\Models\User;
use Illuminate\Http\Request;

class orderController extends Controller
{
    public function index()
    {
        $users=User::all()->where('role','=','user') ; 
        // $sum=order::sum('total');
        //hado
        $orders=order::orderBy('user_id')->get();
        $totalOrders=order::count();
        $paidOrders = order::where('paid', true)->count();
        $deliveredOrders = Order::where('delivered', true)->count();
        //tanrj3lihom
        return view('orders.index',compact('orders','users','totalOrders','paidOrders','deliveredOrders'));
    }

   
    public function updateDelivered(Request $request, order $order)
    {
        //
        $order->update([
            "delivered" => 1
        ]);
        
        return redirect()->back()->withSuccess("Order updated");
    }

    public function updatePaid(Request $request, order $order)
    {
        
        $order->update([
            "paid" => 1
        ]);
        return redirect()->back()->withSuccess("Order paid");
    }

    
    public function destroy(order $order)
    {
        //
        $order->delete();
        return redirect()->back()->withSuccess("Order deleted");
    }
}
