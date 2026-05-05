<?php

/**
 * Comprehensive Admin Functionality Test Script
 * Tests all admin features including CRUD operations and transactions
 */

require_once 'vendor/autoload.php';

use App\Models\User;
use App\Models\Product;
use App\Models\Category;
use App\Models\Brand;
use App\Models\StockTransaction;
use App\Models\Inventory;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;

// Bootstrap Laravel
$app = require_once 'bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

echo "=== ADMIN FUNCTIONALITY TEST SUITE ===\n\n";

// Test 1: User Management (Admin Only)
echo "1. TESTING USER MANAGEMENT\n";
echo "Current users:\n";
$users = User::all(['user_id', 'firstName', 'lastName', 'email', 'role']);
foreach ($users as $user) {
    echo "  - {$user->firstName} {$user->lastName} ({$user->email}) - {$user->role}\n";
}

// Create a new test user
echo "\nCreating new test user...\n";
try {
    $testUser = User::create([
        'firstName' => 'Test',
        'lastName' => 'Manager',
        'email' => 'test.manager@example.com',
        'password' => Hash::make('password123'),
        'role' => 'staff',
        'mobilePhone' => '+1234567890'
    ]);
    echo "✓ Test user created successfully (ID: {$testUser->user_id})\n";
} catch (Exception $e) {
    echo "✗ Failed to create test user: " . $e->getMessage() . "\n";
}

// Test 2: Category Management
echo "\n2. TESTING CATEGORY MANAGEMENT\n";
echo "Current categories:\n";
$categories = Category::withCount('products')->get();
foreach ($categories as $category) {
    echo "  - {$category->category_name} ({$category->products_count} products)\n";
}

// Create a new test category
echo "\nCreating new test category...\n";
try {
    $testCategory = Category::create([
        'category_name' => 'Test Gaming Accessories'
    ]);
    echo "✓ Test category created successfully (ID: {$testCategory->category_id})\n";
} catch (Exception $e) {
    echo "✗ Failed to create test category: " . $e->getMessage() . "\n";
}

// Test 3: Brand Management
echo "\n3. TESTING BRAND MANAGEMENT\n";
echo "Current brands:\n";
$brands = Brand::withCount('products')->take(5)->get();
foreach ($brands as $brand) {
    echo "  - {$brand->brand_name} ({$brand->products_count} products)\n";
}

// Create a new test brand
echo "\nCreating new test brand...\n";
try {
    $testBrand = Brand::create([
        'brand_name' => 'TestTech Solutions'
    ]);
    echo "✓ Test brand created successfully (ID: {$testBrand->brand_id})\n";
} catch (Exception $e) {
    echo "✗ Failed to create test brand: " . $e->getMessage() . "\n";
}

// Test 4: Product Management
echo "\n4. TESTING PRODUCT MANAGEMENT\n";
echo "Current products (sample):\n";
$products = Product::with(['category', 'brand', 'inventory'])->take(3)->get();
foreach ($products as $product) {
    $stock = $product->inventory ? $product->inventory->quantity : 0;
    echo "  - {$product->product_name} - \${$product->price} - Stock: {$stock}\n";
    echo "    Category: {$product->category->category_name}, Brand: {$product->brand->brand_name}\n";
}

// Create a new test product
echo "\nCreating new test product...\n";
try {
    $testProduct = Product::create([
        'product_name' => 'Test Gaming Mouse Pro',
        'description' => 'High-performance gaming mouse for testing purposes',
        'price' => 79.99,
        'category_id' => $testCategory->category_id,
        'brand_id' => $testBrand->brand_id,
    ]);
    echo "✓ Test product created successfully (ID: {$testProduct->product_id})\n";
} catch (Exception $e) {
    echo "✗ Failed to create test product: " . $e->getMessage() . "\n";
}

// Test 5: Inventory Management & Stock Transactions
echo "\n5. TESTING INVENTORY & STOCK TRANSACTIONS\n";

// Check current inventory status
echo "Current inventory status (sample):\n";
$inventoryItems = Product::with('inventory')->whereHas('inventory')->take(3)->get();
foreach ($inventoryItems as $item) {
    echo "  - {$item->product_name}: {$item->inventory->quantity} units\n";
}

// Test stock transaction - Add stock (IN)
echo "\nTesting stock transactions...\n";
try {
    DB::beginTransaction();
    
    // Get a product to test with
    $productForTest = Product::with('inventory')->first();
    $oldQuantity = $productForTest->inventory ? $productForTest->inventory->quantity : 0;
    
    echo "Testing with product: {$productForTest->product_name}\n";
    echo "Current stock: {$oldQuantity}\n";
    
    // Create stock IN transaction
    $transaction = StockTransaction::create([
        'product_id' => $productForTest->product_id,
        'user_id' => 1, // Admin user
        'transactionType' => 'in',
        'quantity' => 50,
        'transactionDate' => now(),
    ]);
    
    // Update inventory
    $inventory = Inventory::firstOrCreate(
        ['product_id' => $productForTest->product_id],
        ['quantity' => 0]
    );
    $inventory->quantity += 50;
    $inventory->save();
    
    echo "✓ Stock IN transaction created (ID: {$transaction->transaction_id})\n";
    echo "  Added 50 units. New stock: {$inventory->quantity}\n";
    
    // Create stock OUT transaction
    $outTransaction = StockTransaction::create([
        'product_id' => $productForTest->product_id,
        'user_id' => 2, // Staff user
        'transactionType' => 'out',
        'quantity' => 15,
        'transactionDate' => now(),
    ]);
    
    $inventory->quantity -= 15;
    $inventory->save();
    
    echo "✓ Stock OUT transaction created (ID: {$outTransaction->transaction_id})\n";
    echo "  Removed 15 units. New stock: {$inventory->quantity}\n";
    
    // Create stock ADJUSTMENT transaction
    $adjustTransaction = StockTransaction::create([
        'product_id' => $productForTest->product_id,
        'user_id' => 1, // Admin user
        'transactionType' => 'adjustment',
        'quantity' => 100,
        'transactionDate' => now(),
    ]);
    
    $inventory->quantity = 100;
    $inventory->save();
    
    echo "✓ Stock ADJUSTMENT transaction created (ID: {$adjustTransaction->transaction_id})\n";
    echo "  Adjusted stock to: {$inventory->quantity}\n";
    
    DB::commit();
    
} catch (Exception $e) {
    DB::rollBack();
    echo "✗ Failed to create stock transactions: " . $e->getMessage() . "\n";
}

// Test 6: Transaction History
echo "\n6. TESTING TRANSACTION HISTORY\n";
$recentTransactions = StockTransaction::with(['product', 'user'])
    ->orderBy('transactionDate', 'desc')
    ->take(5)
    ->get();

echo "Recent transactions:\n";
foreach ($recentTransactions as $trans) {
    $userName = $trans->user ? "{$trans->user->firstName} {$trans->user->lastName}" : "Unknown";
    echo "  - {$trans->transactionDate->format('Y-m-d H:i')} | {$trans->product->product_name} | {$trans->transactionType} | {$trans->quantity} units | by {$userName}\n";
}

// Test 7: Dashboard Statistics
echo "\n7. TESTING DASHBOARD STATISTICS\n";
$totalProducts = Product::count();
$totalCategories = Category::count();
$totalBrands = Brand::count();
$totalUsers = User::count();
$totalTransactions = StockTransaction::count();

echo "System Statistics:\n";
echo "  - Total Products: {$totalProducts}\n";
echo "  - Total Categories: {$totalCategories}\n";
echo "  - Total Brands: {$totalBrands}\n";
echo "  - Total Users: {$totalUsers}\n";
echo "  - Total Transactions: {$totalTransactions}\n";

// Low stock analysis
$lowStockProducts = Product::with('inventory')
    ->whereHas('inventory', function($query) {
        $query->whereBetween('quantity', [1, 10]);
    })->count();

$outOfStockProducts = Product::with('inventory')
    ->whereHas('inventory', function($query) {
        $query->where('quantity', 0);
    })
    ->orWhereDoesntHave('inventory')
    ->count();

echo "  - Low Stock Products (1-10 units): {$lowStockProducts}\n";
echo "  - Out of Stock Products: {$outOfStockProducts}\n";

// Calculate total inventory value
$totalInventoryValue = Product::with('inventory')
    ->get()
    ->sum(function($product) {
        return $product->price * ($product->inventory ? $product->inventory->quantity : 0);
    });

echo "  - Total Inventory Value: \$" . number_format($totalInventoryValue, 2) . "\n";

// Test 8: Soft Delete Functionality
echo "\n8. TESTING SOFT DELETE FUNCTIONALITY\n";
try {
    // Soft delete the test product
    $testProduct->delete();
    echo "✓ Test product soft deleted successfully\n";
    
    // Check if it's in archived products
    $archivedCount = Product::onlyTrashed()->count();
    echo "  - Total archived products: {$archivedCount}\n";
    
    // Restore the product
    $testProduct->restore();
    echo "✓ Test product restored successfully\n";
    
} catch (Exception $e) {
    echo "✗ Failed to test soft delete: " . $e->getMessage() . "\n";
}

// Test 9: Role-based Access Simulation
echo "\n9. TESTING ROLE-BASED ACCESS\n";
$adminUser = User::where('role', 'admin')->first();
$staffUser = User::where('role', 'staff')->first();
$customerUser = User::where('role', 'customer')->first();

echo "Role permissions:\n";
echo "  - Admin ({$adminUser->email}): " . ($adminUser->isAdmin() ? "✓ Admin access" : "✗ No admin access") . "\n";
echo "  - Staff ({$staffUser->email}): " . ($staffUser->isStaff() ? "✓ Staff access" : "✗ No staff access") . "\n";
echo "  - Customer ({$customerUser->email}): " . ($customerUser->isCustomer() ? "✓ Customer access" : "✗ No customer access") . "\n";

// Cleanup test data
echo "\n10. CLEANING UP TEST DATA\n";
try {
    // Delete test transactions (they reference the test product)
    StockTransaction::where('product_id', $testProduct->product_id)->delete();
    
    // Delete test inventory
    Inventory::where('product_id', $testProduct->product_id)->delete();
    
    // Force delete test product
    $testProduct->forceDelete();
    echo "✓ Test product cleaned up\n";
    
    // Delete test category and brand
    $testCategory->delete();
    $testBrand->delete();
    echo "✓ Test category and brand cleaned up\n";
    
    // Delete test user
    if (isset($testUser)) {
        $testUser->delete();
        echo "✓ Test user cleaned up\n";
    }
    
} catch (Exception $e) {
    echo "✗ Failed to cleanup test data: " . $e->getMessage() . "\n";
}

echo "\n=== TEST SUITE COMPLETED ===\n";
echo "All admin functionality has been tested!\n";
echo "Server is running at: http://127.0.0.1:8000\n";
echo "You can now test the web interface with these credentials:\n";
echo "  - Admin: admin@example.com / password\n";
echo "  - Staff: staff@example.com / password\n";
echo "  - Customer: customer@example.com / password\n";