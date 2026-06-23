<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Admin\DashboardController as AdminDashboardController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\ProductController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CatalogController;

Route::get('/', [CatalogController::class, 'index'])->name('home');
Route::get('/product/{slug}', [CatalogController::class, 'show'])->name('product.show');

Route::get('/dashboard', function () {
    if (auth()->user()->role->slug === 'admin') {
        return redirect()->route('admin.dashboard');
    }
    return redirect()->route('home');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware(['auth', 'role:admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [AdminDashboardController::class, 'index'])->name('dashboard');
    Route::resource('categories', CategoryController::class);
    Route::resource('products', ProductController::class);
    Route::resource('orders', App\Http\Controllers\Admin\OrderController::class)->only(['index', 'show']);
    Route::post('orders/{order}/shipping-cost', [App\Http\Controllers\Admin\OrderController::class, 'updateShippingCost'])->name('orders.update-shipping');
    Route::post('orders/{order}/verify-payment', [App\Http\Controllers\Admin\OrderController::class, 'verifyPayment'])->name('orders.verify-payment');
    Route::post('orders/{order}/status', [App\Http\Controllers\Admin\OrderController::class, 'updateStatus'])->name('orders.update-status');
});

Route::middleware('auth')->group(function () {
    Route::get('/cart', [App\Http\Controllers\CartController::class, 'index'])->name('cart.index');
    Route::post('/cart/add', [App\Http\Controllers\CartController::class, 'add'])->name('cart.add');
    Route::put('/cart/{id}', [App\Http\Controllers\CartController::class, 'update'])->name('cart.update');
    Route::delete('/cart/{id}', [App\Http\Controllers\CartController::class, 'destroy'])->name('cart.destroy');

    Route::get('/checkout', [App\Http\Controllers\CheckoutController::class, 'index'])->name('checkout.index');
    Route::post('/checkout', [App\Http\Controllers\CheckoutController::class, 'process'])->name('checkout.process');

    Route::get('/orders', [App\Http\Controllers\Customer\OrderController::class, 'index'])->name('customer.orders.index');
    Route::get('/orders/{id}', [App\Http\Controllers\Customer\OrderController::class, 'show'])->name('customer.orders.show');
    
    Route::get('/orders/{order}/payment', [App\Http\Controllers\Customer\PaymentController::class, 'create'])->name('customer.payments.create');
    Route::post('/orders/{order}/payment', [App\Http\Controllers\Customer\PaymentController::class, 'store'])->name('customer.payments.store');

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
