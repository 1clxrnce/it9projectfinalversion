<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\StockTransactionController;
use App\Http\Controllers\InventoryController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\BrandController;
use App\Http\Controllers\Admin\ProductController as AdminProductController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// Public routes - Customer access (browsing only) - REMOVED, use Admin Products instead
// Route::middleware(['auth', 'role:customer,staff,admin'])->group(function () {
//     Route::get('/products', [ProductController::class, 'index'])->name('products.index');
//     Route::get('/products/{product}', [ProductController::class, 'show'])->name('products.show');
// });

// Staff routes - Can add transactions
Route::middleware(['auth', 'role:staff,admin'])->group(function () {
    Route::get('/inventory', [InventoryController::class, 'index'])->name('inventory.index');
    Route::get('/transactions', [StockTransactionController::class, 'index'])->name('transactions.index');
    Route::get('/transactions/create', [StockTransactionController::class, 'create'])->name('transactions.create');
    Route::post('/transactions', [StockTransactionController::class, 'store'])->name('transactions.store');
    Route::get('/transactions/{transaction}', [StockTransactionController::class, 'show'])->name('transactions.show');
});

// Admin routes - Full access
Route::middleware(['auth', 'role:admin'])->prefix('admin')->name('admin.')->group(function () {
    // User management
    Route::resource('users', UserController::class);
    
    // Category management
    Route::resource('categories', CategoryController::class);
    
    // Brand management
    Route::resource('brands', BrandController::class);
    
    // Product management (full CRUD)
    Route::resource('products', AdminProductController::class);
});

require __DIR__.'/auth.php';
