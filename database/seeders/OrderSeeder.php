<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Product;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\OrderTrackingLog;
use Illuminate\Support\Carbon;

class OrderSeeder extends Seeder
{
    public function run(): void
    {
        $customerRole = \App\Models\Role::where('slug', 'customer')->first();

        // Create additional customers
        $customers = [
            ['name' => 'Budi Santoso',   'email' => 'budi@example.com',   'phone' => '08112345001', 'address' => 'Jl. Sudirman No. 10, Jakarta'],
            ['name' => 'Siti Rahayu',    'email' => 'siti@example.com',   'phone' => '08112345002', 'address' => 'Jl. Diponegoro No. 5, Surabaya'],
            ['name' => 'Ahmad Fauzan',   'email' => 'ahmad@example.com',  'phone' => '08112345003', 'address' => 'Jl. Gajah Mada No. 33, Bandung'],
            ['name' => 'Dewi Permata',   'email' => 'dewi@example.com',   'phone' => '08112345004', 'address' => 'Jl. Raya Kuta No. 22, Bali'],
        ];

        $users = [];
        foreach ($customers as $data) {
            $users[] = User::create([
                'name'     => $data['name'],
                'email'    => $data['email'],
                'password' => \Illuminate\Support\Facades\Hash::make('password'),
                'role_id'  => $customerRole->id,
                'phone'    => $data['phone'],
                'address'  => $data['address'],
            ]);
        }

        // Also include the default customer
        $users[] = User::where('email', 'customer@watchstore.com')->first();

        $products = Product::all();

        $statuses = ['completed', 'completed', 'shipped', 'processing', 'pending_payment', 'pending_shipping_cost'];

        // Create dummy orders
        foreach ($users as $index => $user) {
            for ($i = 1; $i <= 2; $i++) {
                $product1 = $products->random();
                $product2 = $products->random();
                $qty1     = rand(1, 2);
                $qty2     = rand(1, 1);
                $subtotal = ($product1->price * $qty1) + ($product2->price * $qty2);
                $shipping = 20000;
                $status   = $statuses[($index * 2 + $i - 1) % count($statuses)];

                // For non-pending statuses, shipping_cost is set; for pending_shipping_cost it's 0
                $shippingCost = ($status === 'pending_shipping_cost') ? 0 : $shipping;
                $grandTotal   = ($status === 'pending_shipping_cost') ? $subtotal : $subtotal + $shipping;

                $order = Order::create([
                    'user_id'          => $user->id,
                    'order_number'     => 'WS-' . strtoupper(uniqid()),
                    'recipient_name'   => $user->name,
                    'recipient_phone'  => $user->phone,
                    'shipping_address' => $user->address,
                    'subtotal'         => $subtotal,
                    'shipping_cost'    => $shippingCost,
                    'grand_total'      => $grandTotal,
                    'status'           => $status,
                    'created_at'       => Carbon::now()->subDays(rand(1, 30)),
                ]);

                // Order items
                OrderItem::create([
                    'order_id'              => $order->id,
                    'product_id'            => $product1->id,
                    'product_name_snapshot' => $product1->name,
                    'product_price_snapshot'=> $product1->price,
                    'quantity'              => $qty1,
                    'subtotal'              => $product1->price * $qty1,
                ]);
                OrderItem::create([
                    'order_id'              => $order->id,
                    'product_id'            => $product2->id,
                    'product_name_snapshot' => $product2->name,
                    'product_price_snapshot'=> $product2->price,
                    'quantity'              => $qty2,
                    'subtotal'              => $product2->price * $qty2,
                ]);

                // Tracking log
                OrderTrackingLog::create([
                    'order_id'   => $order->id,
                    'status'     => $status,
                    'title'      => 'Order Created',
                    'description'=> 'Order placed successfully by ' . $user->name,
                    'created_by' => $user->id,
                    'created_at' => $order->created_at,
                ]);

                // Additional tracking for further-along statuses
                if (in_array($status, ['processing', 'shipped', 'completed'])) {
                    OrderTrackingLog::create([
                        'order_id'    => $order->id,
                        'status'      => 'processing',
                        'title'       => 'Payment Verified',
                        'description' => 'Payment has been verified. Order is being processed.',
                        'created_by'  => 1,
                        'created_at'  => Carbon::parse($order->created_at)->addDays(1),
                    ]);
                }
                if (in_array($status, ['shipped', 'completed'])) {
                    OrderTrackingLog::create([
                        'order_id'    => $order->id,
                        'status'      => 'shipped',
                        'title'       => 'Package Shipped',
                        'description' => 'Your package has been handed over to the courier. Estimated delivery in 3-5 days.',
                        'created_by'  => 1,
                        'created_at'  => Carbon::parse($order->created_at)->addDays(2),
                    ]);
                }
                if ($status === 'completed') {
                    OrderTrackingLog::create([
                        'order_id'    => $order->id,
                        'status'      => 'completed',
                        'title'       => 'Order Completed',
                        'description' => 'Package received by customer. Thank you for your purchase!',
                        'created_by'  => 1,
                        'created_at'  => Carbon::parse($order->created_at)->addDays(5),
                    ]);
                }
            }
        }
    }
}
