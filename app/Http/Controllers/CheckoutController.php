<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Cart;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\OrderTrackingLog;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class CheckoutController extends Controller
{
    public function index()
    {
        $cart = Cart::with('items.product')->where('user_id', Auth::id())->first();
        
        if (!$cart || $cart->items->count() === 0) {
            return redirect()->route('cart.index')->with('error', 'Your cart is empty.');
        }

        $user = Auth::user();
        return view('checkout.index', compact('cart', 'user'));
    }

    public function process(Request $request)
    {
        $request->validate([
            'recipient_name' => 'required|string|max:255',
            'recipient_phone' => 'required|string|max:20',
            'shipping_address' => 'required|string',
            'notes' => 'nullable|string'
        ]);

        $cart = Cart::with('items.product')->where('user_id', Auth::id())->first();
        
        if (!$cart || $cart->items->count() === 0) {
            return redirect()->route('cart.index')->with('error', 'Your cart is empty.');
        }

        DB::beginTransaction();

        try {
            $subtotal = 0;
            $shipping_cost = 0; // Will be set by Admin later
            
            foreach ($cart->items as $item) {
                if ($item->product->stock < $item->quantity) {
                    throw new \Exception('Product ' . $item->product->name . ' does not have enough stock.');
                }
                $subtotal += ($item->product->price * $item->quantity);
            }

            $grand_total = $subtotal; // Will be updated after shipping cost is set

            $order = Order::create([
                'user_id' => Auth::id(),
                'order_number' => 'ORD-' . strtoupper(Str::random(10)),
                'recipient_name' => $request->recipient_name,
                'recipient_phone' => $request->recipient_phone,
                'shipping_address' => $request->shipping_address,
                'subtotal' => $subtotal,
                'shipping_cost' => $shipping_cost,
                'grand_total' => $grand_total,
                'status' => 'pending_shipping_cost',
                'notes' => $request->notes
            ]);

            foreach ($cart->items as $item) {
                $itemSubtotal = $item->product->price * $item->quantity;
                
                OrderItem::create([
                    'order_id' => $order->id,
                    'product_id' => $item->product_id,
                    'product_name_snapshot' => $item->product->name,
                    'product_price_snapshot' => $item->product->price,
                    'quantity' => $item->quantity,
                    'subtotal' => $itemSubtotal
                ]);

                $item->product->decrement('stock', $item->quantity);
            }

            OrderTrackingLog::create([
                'order_id' => $order->id,
                'status' => 'pending_shipping_cost',
                'title' => 'Order Placed',
                'description' => 'Your order has been successfully placed. Waiting for Admin to calculate shipping cost.'
            ]);

            $cart->items()->delete();

            DB::commit();

            return redirect()->route('customer.orders.show', $order->id)->with('success', 'Order placed successfully! Please complete your payment.');

        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', $e->getMessage());
        }
    }
}
