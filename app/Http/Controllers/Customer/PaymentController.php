<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Order;
use App\Models\Payment;
use App\Models\OrderTrackingLog;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class PaymentController extends Controller
{
    public function create($orderId)
    {
        $order = Order::where('user_id', Auth::id())->findOrFail($orderId);
        
        if ($order->status !== 'pending_payment') {
            return redirect()->route('customer.orders.show', $order->id)->with('error', 'Payment cannot be uploaded for this order.');
        }

        return view('customer.payments.create', compact('order'));
    }

    public function store(Request $request, $orderId)
    {
        $request->validate([
            'payment_method' => 'required|string|max:50',
            'proof_of_payment' => 'required|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        $order = Order::where('user_id', Auth::id())->findOrFail($orderId);

        if ($order->status !== 'pending_payment') {
            return redirect()->route('customer.orders.show', $order->id)->with('error', 'Payment cannot be uploaded for this order.');
        }

        DB::beginTransaction();

        try {
            $path = $request->file('proof_of_payment')->store('payments', 'public');

            Payment::create([
                'order_id' => $order->id,
                'payment_method' => $request->payment_method,
                'proof_image' => $path,
                'payment_status' => 'pending'
            ]);

            $order->update(['status' => 'pending_verification']);

            OrderTrackingLog::create([
                'order_id' => $order->id,
                'status' => 'pending_verification',
                'title' => 'Payment Uploaded',
                'description' => 'Your payment proof has been successfully uploaded and is waiting for Admin verification.'
            ]);

            DB::commit();

            return redirect()->route('customer.orders.show', $order->id)->with('success', 'Payment proof uploaded successfully.');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', $e->getMessage());
        }
    }
}
