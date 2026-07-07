<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\PurchaseOrderController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect()->route('procurement.home');
});

Route::get('/procurement', [PurchaseOrderController::class, 'index'])->name('procurement.home');
Route::get('/purchase', [PurchaseOrderController::class, 'index'])->name('procurement.purchase');
Route::get('/createpo', [PurchaseOrderController::class, 'create'])->name('procurement.create');
Route::post('/purchase-orders', [PurchaseOrderController::class, 'store'])->name('purchase_orders.store');
Route::post('/purchase-orders/{purchaseOrder}/send', [PurchaseOrderController::class, 'send'])->name('purchase_orders.send');
Route::post('/purchase-orders/{purchaseOrder}/status', [PurchaseOrderController::class, 'updateStatus'])->name('purchase_orders.status');
Route::post('/match-invoice', [PurchaseOrderController::class, 'matchInvoice'])->name('purchase_orders.match_invoice');

Route::middleware(['auth'])->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::get('/dashboard', function () {
    return redirect()->route('procurement.home');
})->middleware(['auth', 'verified'])->name('dashboard');

require __DIR__.'/auth.php';
