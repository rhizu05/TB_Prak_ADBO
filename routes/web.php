<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;

Route::get('/', function () {
    return redirect()->route('login');
});

Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [AuthController::class, 'login']);
});

Route::post('/logout', [AuthController::class, 'logout'])->name('logout')->middleware('auth');

Route::middleware(['auth', 'role:admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'admin'])->name('dashboard');
    Route::resource('categories', \App\Http\Controllers\Admin\CategoryController::class);
    Route::resource('products', \App\Http\Controllers\Admin\ProductController::class);
    Route::resource('tables', \App\Http\Controllers\Admin\TableController::class);
    Route::get('/reports', [\App\Http\Controllers\Admin\ReportController::class, 'index'])->name('reports.index');
    Route::get('/reports/export', [\App\Http\Controllers\Admin\ReportController::class, 'export'])->name('reports.export');
});

Route::middleware(['auth', 'role:kasir'])->group(function () {
    Route::get('/kasir/dashboard', [DashboardController::class, 'kasir'])->name('kasir.dashboard');
    Route::get('/kasir/orders', [\App\Http\Controllers\Kasir\OrderController::class, 'index'])->name('kasir.orders.index');
    Route::get('/kasir/payments', [\App\Http\Controllers\Kasir\PaymentController::class, 'index'])->name('kasir.payments.index');
    Route::post('/kasir/payment/{order}/confirm', [\App\Http\Controllers\PaymentController::class, 'confirm'])->name('kasir.payment.confirm');
});

Route::middleware(['auth', 'role:koki'])->group(function () {
    Route::get('/koki/dashboard', [DashboardController::class, 'koki'])->name('koki.dashboard');
    Route::get('/koki/kds', [\App\Http\Controllers\Koki\KitchenController::class, 'index'])->name('koki.kds.index');
    Route::post('/koki/order/{order}/ready', [\App\Http\Controllers\OrderController::class, 'markReady'])->name('koki.order.ready');
});

// Public Routes
use App\Http\Controllers\OrderController;
Route::get('/order/{table}', [OrderController::class, 'show'])->name('order.menu');
Route::post('/cart/add', [OrderController::class, 'addToCart'])->name('cart.add');
Route::get('/cart', [OrderController::class, 'cart'])->name('cart.view');
Route::post('/checkout', [OrderController::class, 'checkout'])->name('checkout');
Route::get('/status/{order}', [OrderController::class, 'status'])->name('order.status');

use App\Http\Controllers\PaymentController;
Route::get('/payment/{order}', [PaymentController::class, 'show'])->name('payment.show');
Route::post('/payment/{order}', [PaymentController::class, 'pay'])->name('payment.pay');
Route::get('/payment/{order}/qris', [PaymentController::class, 'showQris'])->name('payment.qris');
Route::get('/payment/{order}/cash', [PaymentController::class, 'showCash'])->name('payment.cash');
Route::get('/payment/{order}/check-status', [PaymentController::class, 'checkStatus'])->name('payment.check');

// Midtrans Webhook (no CSRF)
Route::post('/midtrans/notification', [PaymentController::class, 'notification'])->name('midtrans.notification');
