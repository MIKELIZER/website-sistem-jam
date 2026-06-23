<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\Product;
use App\Models\User;

class DashboardController extends Controller
{
    public function index()
    {
        $totalProducts = Product::count();
        $totalCustomers = User::whereHas('role', function($q) {
            $q->where('name', 'customer');
        })->count();
        $totalOrders = Order::count();
        $totalRevenue = Order::whereIn('status', ['processing', 'shipped', 'completed'])->sum('grand_total');

        $recentOrders = Order::with('user')->latest()->take(5)->get();

        return view('admin.dashboard', compact(
            'totalProducts', 'totalCustomers', 'totalOrders', 'totalRevenue', 'recentOrders'
        ));
    }
}
