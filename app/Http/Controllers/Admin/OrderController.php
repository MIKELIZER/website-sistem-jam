<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Order;
use App\Models\OrderTrackingLog;
use Illuminate\Support\Facades\DB;

class OrderController extends Controller
{
    public function index()
    {
        $orders = Order::latest()->paginate(15);
        return view('admin.orders.index', compact('orders'));
    }

    public function show($id)
    {
        $order = Order::with('items', 'trackingLogs', 'user', 'payment')->findOrFail($id);
        return view('admin.orders.show', compact('order'));
    }

    public function updateShippingCost(Request $request, $id)
    {
        $request->validate([
            'shipping_cost' => 'required|numeric|min:0'
        ]);

        $order = Order::findOrFail($id);

        if ($order->status !== 'pending_shipping_cost') {
            return back()->with('error', 'Shipping cost can only be updated when order status is pending_shipping_cost.');
        }

        DB::beginTransaction();

        try {
            $order->shipping_cost = $request->shipping_cost;
            $order->grand_total = $order->subtotal + $request->shipping_cost;
            $order->status = 'pending_payment';
            $order->save();

            OrderTrackingLog::create([
                'order_id' => $order->id,
                'status' => 'pending_payment',
                'title' => 'Shipping Cost Updated',
                'description' => 'Admin has set the shipping cost to Rp ' . number_format($request->shipping_cost, 0, ',', '.') . '. Please proceed to payment.'
            ]);

            DB::commit();

            return back()->with('success', 'Shipping cost updated successfully. Customer can now make payment.');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', $e->getMessage());
        }
    }

    public function verifyPayment(Request $request, $id)
    {
        $request->validate([
            'action' => 'required|in:approve,reject'
        ]);

        $order = Order::with('payment', 'items.product')->findOrFail($id);

        if ($order->status !== 'pending_verification' || !$order->payment) {
            return back()->with('error', 'Invalid order status for verification.');
        }

        DB::beginTransaction();

        try {
            if ($request->action === 'approve') {
                $order->payment->update([
                    'status' => 'verified',
                    'verified_by' => \Illuminate\Support\Facades\Auth::id(),
                    'verified_at' => now()
                ]);

                $order->update(['status' => 'processing']);

                OrderTrackingLog::create([
                    'order_id' => $order->id,
                    'status' => 'processing',
                    'title' => 'Payment Verified',
                    'description' => 'Payment has been verified. Order is now being processed.'
                ]);
            } else {
                $order->payment->update([
                    'status' => 'rejected',
                    'verified_by' => \Illuminate\Support\Facades\Auth::id(),
                    'verified_at' => now()
                ]);

                $order->update(['status' => 'payment_failed']);

                foreach ($order->items as $item) {
                    if ($item->product) {
                        $item->product->increment('stock', $item->quantity);
                    }
                }

                OrderTrackingLog::create([
                    'order_id' => $order->id,
                    'status' => 'payment_failed',
                    'title' => 'Payment Rejected',
                    'description' => 'Payment proof was rejected. Order has been cancelled.'
                ]);
            }

            DB::commit();

            return back()->with('success', 'Payment verification processed.');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', $e->getMessage());
        }
    }

    public function updateStatus(Request $request, $id)
    {
        $request->validate([
            'status' => 'required|in:shipped,completed'
        ]);

        $order = Order::findOrFail($id);

        if ($request->status === 'shipped' && $order->status !== 'processing') {
            return back()->with('error', 'Order must be in processing status to be shipped.');
        }

        if ($request->status === 'completed' && $order->status !== 'shipped') {
            return back()->with('error', 'Order must be shipped before marking as completed.');
        }

        DB::beginTransaction();

        try {
            $order->update(['status' => $request->status]);

            $title = $request->status === 'shipped' ? 'Order Shipped' : 'Order Completed';
            $desc = $request->status === 'shipped' ? 'Your order has been shipped and is on its way.' : 'Order has been delivered and completed successfully.';

            OrderTrackingLog::create([
                'order_id' => $order->id,
                'status' => $request->status,
                'title' => $title,
                'description' => $desc
            ]);

            DB::commit();

            return back()->with('success', 'Order status updated to ' . $request->status . '.');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', $e->getMessage());
        }
    }
}
