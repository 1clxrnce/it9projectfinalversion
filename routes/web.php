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
    $brands = \App\Models\Brand::all();
    $categories = \App\Models\Category::withCount('products')->get();
    $totalProducts = \App\Models\Product::count();
    
    return view('welcome', compact('brands', 'categories', 'totalProducts'));
})->name('home');

// Public product browsing (for customers and guests)
Route::get('/products', [ProductController::class, 'index'])->name('products.index');
Route::get('/products/{product}', [ProductController::class, 'show'])->name('products.show');

Route::get('/dashboard', function () {
    // Redirect customers to homepage
    if (Auth::check() && Auth::user()->isCustomer()) {
        return redirect()->route('home');
    }
    
    $totalProducts = \App\Models\Product::count();
    $totalCategories = \App\Models\Category::count();
    $totalBrands = \App\Models\Brand::count();
    $totalUsers = \App\Models\User::count();
    
    // Stock statistics
    $lowStockProducts = \App\Models\Product::with('inventory')
        ->whereHas('inventory', function($query) {
            $query->whereBetween('quantity', [1, 10]);
        })->count();
    
    $outOfStockProducts = \App\Models\Product::with('inventory')
        ->whereHas('inventory', function($query) {
            $query->where('quantity', 0);
        })
        ->orWhereDoesntHave('inventory')
        ->count();
    
    $totalInventoryValue = \App\Models\Product::with('inventory')
        ->get()
        ->sum(function($product) {
            return $product->price * ($product->inventory ? $product->inventory->quantity : 0);
        });
    
    // Recent transactions
    $recentTransactions = \App\Models\StockTransaction::with(['product', 'user'])
        ->latest()
        ->take(5)
        ->get();
    
    // Low stock products - fixed query
    $lowStockItems = \App\Models\Product::with(['inventory', 'category', 'brand'])
        ->whereHas('inventory', function($query) {
            $query->where('quantity', '<=', 10)->where('quantity', '>', 0);
        })
        ->get()
        ->sortBy(function($product) {
            return $product->inventory ? $product->inventory->quantity : 0;
        })
        ->take(5);
    
    // Stock by category
    $stockByCategory = \App\Models\Category::withCount('products')
        ->with(['products.inventory'])
        ->get()
        ->map(function($category) {
            $totalStock = $category->products->sum(function($product) {
                return $product->inventory ? $product->inventory->quantity : 0;
            });
            return [
                'name' => $category->category_name,
                'stock' => $totalStock,
                'products' => $category->products_count
            ];
        });
    
    return view('dashboard', compact(
        'totalProducts',
        'totalCategories', 
        'totalBrands',
        'totalUsers',
        'lowStockProducts',
        'outOfStockProducts',
        'totalInventoryValue',
        'recentTransactions',
        'lowStockItems',
        'stockByCategory'
    ));
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

// Staff and Admin routes - Products, Categories, Brands management
Route::middleware(['auth', 'role:staff,admin'])->prefix('admin')->name('admin.')->group(function () {
    // Category management
    Route::resource('categories', CategoryController::class);
    Route::get('categories/archived/list', [CategoryController::class, 'archived'])->name('categories.archived');
    Route::post('categories/{id}/restore', [CategoryController::class, 'restore'])->name('categories.restore');
    Route::delete('categories/{id}/force-delete', [CategoryController::class, 'forceDelete'])->name('categories.forceDelete');
    
    // Brand management
    Route::resource('brands', BrandController::class);
    Route::get('brands/archived/list', [BrandController::class, 'archived'])->name('brands.archived');
    Route::post('brands/{id}/restore', [BrandController::class, 'restore'])->name('brands.restore');
    Route::delete('brands/{id}/force-delete', [BrandController::class, 'forceDelete'])->name('brands.forceDelete');
    
    // Product management (full CRUD)
    Route::resource('products', AdminProductController::class);
    Route::get('products/archived/list', [AdminProductController::class, 'archived'])->name('products.archived');
    Route::post('products/{id}/restore', [AdminProductController::class, 'restore'])->name('products.restore');
    Route::delete('products/{id}/force-delete', [AdminProductController::class, 'forceDelete'])->name('products.forceDelete');
});

// Admin only routes - User management
Route::middleware(['auth', 'role:admin'])->prefix('admin')->name('admin.')->group(function () {
    // User management (admin only)
    Route::resource('users', UserController::class);
    Route::get('users/archived/list', [UserController::class, 'archived'])->name('users.archived');
    Route::post('users/{id}/restore', [UserController::class, 'restore'])->name('users.restore');
    Route::delete('users/{id}/force-delete', [UserController::class, 'forceDelete'])->name('users.forceDelete');
});

require __DIR__.'/auth.php';
