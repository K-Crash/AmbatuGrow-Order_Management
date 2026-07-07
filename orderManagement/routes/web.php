<?php

use App\Http\Controllers\ProcurementController;
use Illuminate\Support\Facades\Route;

Route::get('/', [ProcurementController::class, 'index'])->name('procurement.home');
Route::get('/purchase', [ProcurementController::class, 'index'])->name('procurement.purchase');
Route::get('/createpo', [ProcurementController::class, 'create'])->name('procurement.create');
Route::get('/sidenotif', [ProcurementController::class, 'notifications'])->name('procurement.notifications');


