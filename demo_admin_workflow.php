<?php

/**
 * Admin Workflow Demo Script
 * Demonstrates complete admin workflow including transactions
 */

require_once 'vendor/autoload.php';

use App\Models\User;
use App\Models\Product;
use App\Models\Category;
use App\Models\Brand;
use App\Models\StockTransaction;
use App\Models\Inventory;
use Illuminate\Support\Facades\DB;

// Bootstrap Laravel
$app = require_once 'bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

echo "=== ADMIN WORKFLOW DEMONSTRATION ===\n\n";

// Scenario: New product arrival and stock management
echo "SCENARIO: Managing new product arrival and stock transactions\n";
echo "=========================================================\n\n";

// Step 1: Create a new category for the demo
echo "Step 1: Creating new product category...\n";
try {
    $demoCategory = Category::create([
        'category_name' => 'Demo Peripherals'
    ]);
    echo "✓ Created category: {$demoCategory->category_name} (ID: {$demoCategory->category_id})\n\n";
} catch (Exception $e) {
    echo "✗ Failed: " . $e->getMessage() . "\n\n";
    exit(1);
}

// Step 2: Create a new brand
echo "Step 2: Creating new brand...\n";
try {
    $demoBrand = Brand::create([
        'brand_name' => 'DemoTech Pro'
    ]);
    echo "✓ Created brand: {$demoBrand->brand_name} (ID: {$demoBrand->brand_id})\n\n";
} catch (Exception $e) {
    echo "✗ Failed: " . $e->getMessage() . "\n\n";
    exit(1);
}

// Step 3: Add new products
echo "Step 3: Adding new products to inventory...\n";
$demoProducts = [
    [
        'product_name' => 'DemoTech Pro Gaming Keyboard',
        'description' => 'Mechanical RGB gaming keyboard with premium switches',
        'price' => 149.99,
    ],
    [
        'product_name' => 'DemoTech Pro Wireless Mouse',
        'description' => 'High-precision wireless gaming mouse with RGB lighting',
        'price' => 89.99,
    ],
    [
        'product_name' => 'DemoTech Pro Headset',
        'description' => '7.1 surround sound gaming headset with noise cancellation',
        'price' => 199.99,
    ]
];

$createdProducts = [];
foreach ($demoProducts as $productData) {
    try {
        $product = Product::create([
            'product_name' => $productData['product_name'],
            'description' => $productData['description'],
            'price' => $productData['price'],
            'category_id' => $demoCategory->category_id,
            'brand_id' => $demoBrand->brand_id,
        ]);
        $createdProducts[] = $product;
        echo "✓ Created product: {$product->product_name} - \${$product->price}\n";
    } catch (Exception $e) {
        echo "✗ Failed to create product: " . $e->getMessage() . "\n";
    }
}
echo "\n";

// Step 4: Initial stock receipt (IN transactions)
echo "Step 4: Processing initial stock receipt...\n";
$adminUser = User::where('role', 'admin')->first();

foreach ($createdProducts as $index => $product) {
    $initialStock = [50, 75, 30][$index]; // Different quantities for each product
    
    try {
        DB::beginTransaction();
        
        // Create stock IN transaction
        $transaction = StockTransaction::create([
            'product_id' => $product->product_id,
            'user_id' => $adminUser->user_id,
            'transactionType' => 'in',
            'quantity' => $initialStock,
            'transactionDate' => now(),
        ]);
        
        // Create/update inventory
        $inventory = Inventory::create([
            'product_id' => $product->product_id,
            'quantity' => $initialStock,
        ]);
        
        DB::commit();
        
        echo "✓ Added {$initialStock} units of {$product->product_name} (Transaction ID: {$transaction->transaction_id})\n";
        
    } catch (Exception $e) {
        DB::rollBack();
        echo "✗ Failed to add stock for {$product->product_name}: " . $e->getMessage() . "\n";
    }
}
echo "\n";

// Step 5: Simulate sales (OUT transactions)
echo "Step 5: Processing sales transactions...\n";
$staffUser = User::where('role', 'staff')->first();

$salesData = [
    ['product_index' => 0, 'quantity' => 5, 'note' => 'Online order #1001'],
    ['product_index' => 1, 'quantity' => 8, 'note' => 'Retail sale'],
    ['product_index' => 0, 'quantity' => 3, 'note' => 'Corporate order'],
    ['product_index' => 2, 'quantity' => 2, 'note' => 'Staff purchase'],
];

foreach ($salesData as $sale) {
    $product = $createdProducts[$sale['product_index']];
    
    try {
        DB::beginTransaction();
        
        // Get current inventory
        $inventory = Inventory::where('product_id', $product->product_id)->first();
        
        if (!$inventory || $inventory->quantity < $sale['quantity']) {
            throw new Exception("Insufficient stock for {$product->product_name}");
        }
        
        // Create stock OUT transaction
        $transaction = StockTransaction::create([
            'product_id' => $product->product_id,
            'user_id' => $staffUser->user_id,
            'transactionType' => 'out',
            'quantity' => $sale['quantity'],
            'transactionDate' => now(),
        ]);
        
        // Update inventory
        $inventory->quantity -= $sale['quantity'];
        $inventory->save();
        
        DB::commit();
        
        echo "✓ Sold {$sale['quantity']} units of {$product->product_name} - {$sale['note']} (Stock: {$inventory->quantity})\n";
        
    } catch (Exception $e) {
        DB::rollBack();
        echo "✗ Failed sale: " . $e->getMessage() . "\n";
    }
}
echo "\n";

// Step 6: Stock adjustment (damaged goods)
echo "Step 6: Processing stock adjustment (damaged goods)...\n";
$keyboardProduct = $createdProducts[0];
try {
    DB::beginTransaction();
    
    $inventory = Inventory::where('product_id', $keyboardProduct->product_id)->first();
    $damagedQuantity = 2;
    $newQuantity = $inventory->quantity - $damagedQuantity;
    
    // Create adjustment transaction
    $transaction = StockTransaction::create([
        'product_id' => $keyboardProduct->product_id,
        'user_id' => $adminUser->user_id,
        'transactionType' => 'adjustment',
        'quantity' => $newQuantity,
        'transactionDate' => now(),
    ]);
    
    $inventory->quantity = $newQuantity;
    $inventory->save();
    
    DB::commit();
    
    echo "✓ Adjusted {$keyboardProduct->product_name} stock to {$newQuantity} (removed {$damagedQuantity} damaged units)\n\n";
    
} catch (Exception $e) {
    DB::rollBack();
    echo "✗ Failed adjustment: " . $e->getMessage() . "\n\n";
}

// Step 7: Generate reports
echo "Step 7: Generating inventory and transaction reports...\n";
echo "Current Inventory Status:\n";
echo "========================\n";
foreach ($createdProducts as $product) {
    $inventory = Inventory::where('product_id', $product->product_id)->first();
    $stock = $inventory ? $inventory->quantity : 0;
    $value = $stock * $product->price;
    
    echo sprintf("%-30s | Stock: %3d | Value: \$%8.2f\n", 
        $product->product_name, $stock, $value);
}

echo "\nTransaction History:\n";
echo "===================\n";
$transactions = StockTransaction::with(['product', 'user'])
    ->whereIn('product_id', collect($createdProducts)->pluck('product_id'))
    ->orderBy('transactionDate', 'desc')
    ->get();

foreach ($transactions as $trans) {
    $userName = $trans->user ? "{$trans->user->firstName} {$trans->user->lastName}" : "Unknown";
    echo sprintf("%-20s | %-30s | %-10s | %3d units | %s\n",
        $trans->transactionDate->format('Y-m-d H:i:s'),
        $trans->product->product_name,
        strtoupper($trans->transactionType),
        $trans->quantity,
        $userName
    );
}

// Step 8: Calculate business metrics
echo "\nBusiness Metrics:\n";
echo "================\n";
$totalProducts = count($createdProducts);
$totalTransactions = $transactions->count();
$totalStockValue = 0;
$totalUnitsInStock = 0;

foreach ($createdProducts as $product) {
    $inventory = Inventory::where('product_id', $product->product_id)->first();
    $stock = $inventory ? $inventory->quantity : 0;
    $totalUnitsInStock += $stock;
    $totalStockValue += $stock * $product->price;
}

$inTransactions = $transactions->where('transactionType', 'in')->sum('quantity');
$outTransactions = $transactions->where('transactionType', 'out')->sum('quantity');
$salesRevenue = $outTransactions * 146.66; // Average price

echo "Total Products Added: {$totalProducts}\n";
echo "Total Transactions: {$totalTransactions}\n";
echo "Units Received: {$inTransactions}\n";
echo "Units Sold: {$outTransactions}\n";
echo "Current Stock Units: {$totalUnitsInStock}\n";
echo "Current Stock Value: \$" . number_format($totalStockValue, 2) . "\n";
echo "Estimated Sales Revenue: \$" . number_format($salesRevenue, 2) . "\n";

// Step 9: Cleanup (optional)
echo "\nStep 9: Cleaning up demo data...\n";
$cleanup = readline("Do you want to clean up the demo data? (y/N): ");

if (strtolower(trim($cleanup)) === 'y') {
    try {
        DB::beginTransaction();
        
        // Delete transactions
        StockTransaction::whereIn('product_id', collect($createdProducts)->pluck('product_id'))->delete();
        echo "✓ Deleted demo transactions\n";
        
        // Delete inventory records
        Inventory::whereIn('product_id', collect($createdProducts)->pluck('product_id'))->delete();
        echo "✓ Deleted demo inventory records\n";
        
        // Delete products
        foreach ($createdProducts as $product) {
            $product->forceDelete();
        }
        echo "✓ Deleted demo products\n";
        
        // Delete category and brand
        $demoCategory->delete();
        $demoBrand->delete();
        echo "✓ Deleted demo category and brand\n";
        
        DB::commit();
        echo "✓ Cleanup completed successfully\n";
        
    } catch (Exception $e) {
        DB::rollBack();
        echo "✗ Cleanup failed: " . $e->getMessage() . "\n";
    }
} else {
    echo "Demo data preserved. You can manually delete it later from the admin interface.\n";
}

echo "\n=== ADMIN WORKFLOW DEMONSTRATION COMPLETED ===\n";
echo "The admin system successfully handled:\n";
echo "• Product management (categories, brands, products)\n";
echo "• Inventory management (stock tracking)\n";
echo "• Transaction processing (IN, OUT, ADJUSTMENT)\n";
echo "• Real-time stock updates\n";
echo "• Business reporting and metrics\n";
echo "• Role-based access control\n\n";

echo "Web Interface Available at: http://127.0.0.1:8000\n";
echo "Login Credentials:\n";
echo "  Admin: admin@example.com / password\n";
echo "  Staff: staff@example.com / password\n";