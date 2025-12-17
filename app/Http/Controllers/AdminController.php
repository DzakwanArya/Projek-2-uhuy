<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;

class AdminController extends Controller
{
    public function dashboard()
    {
        $totalOrders = Order::count();
        $recent = Order::orderBy('created_at','desc')->limit(5)->get();
        return view('admin.dashboard', compact('totalOrders','recent'));
    }

    public function orders()
    {
        $orders = Order::orderBy('created_at','desc')->paginate(20);
        return view('admin.orders.index', compact('orders'));
    }

    public function orderDetail($id)
    {
        $order = Order::with('items.product')->findOrFail($id);
        return view('admin.orders.show', compact('order'));
    }

    public function updateStatus(Request $request, $id)
    {
        $order = Order::findOrFail($id);
        $order->status = $request->input('status', $order->status);
        $order->save();
        return redirect()->back()->with('success','Status pesanan diperbarui');
    }
}
