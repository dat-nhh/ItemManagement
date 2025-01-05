<?php

use App\Http\Controllers\ItemController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\ExportController;
use App\Http\Controllers\ImportController;
use App\Http\Controllers\TransferController;
use App\Http\Controllers\VendorController;
use App\Http\Controllers\WarehouseController;
use Illuminate\Support\Facades\Route;

Route::get('/', [ItemController::class, 'index']);

Route::resource('/category', CategoryController::class);

Route::resource('/warehouse', WarehouseController::class);

Route::get('/item/search', [ItemController::class, 'search'])->name('item.search');
Route::resource('/item',ItemController::class);

Route::resource('/vendor', VendorController::class);

Route::resource('/customer', CustomerController::class);

Route::resource('/import', ImportController::class);
Route::post('/import/stockstore', [ImportController::class, 'stockStore'])->name('import.stockstore');
Route::get('/import/create/{import}', [ImportController::class, 'create'])->name('import.create');

Route::resource('/export', ExportController::class);
Route::post('/export/stockstore', [ExportController::class, 'stockStore'])->name('export.stockstore');
Route::get('/expport/create/{export}', [ExportController::class, 'create'])->name('export.create');

Route::resource('/transfer', TransferController::class);
Route::post('/transfer/stockstore', [TransferController::class, 'stockStore'])->name('transfer.stockstore');
Route::get('/transfer/create/{transfer}', [TransferController::class, 'create'])->name('transfer.create');

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
