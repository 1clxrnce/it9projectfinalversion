<?php

require_once 'vendor/autoload.php';

use App\Models\Product;

// Bootstrap Laravel
$app = require_once 'bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

echo "=== TESTING BRAND RELATIONSHIPS ===\n\n";

// Test that all products have valid brand relationships
$products = Product::with('brand')->take(5)->get();

echo "Testing product-brand relationships:\n";
foreach ($products as $product) {
    $brandName = $product->brand ? $product->brand->brand_name : 'No Brand';
    echo "✓ {$product->product_name} - Brand: {$brandName}\n";
}

// Check for any remaining orphaned products
$orphanedCount = Product::whereNotIn('brand_id', \App\Models\Brand::pluck('brand_id'))->count();
echo "\nOrphaned products: {$orphanedCount}\n";

if ($orphanedCount === 0) {
    echo "✅ All products have valid brand relationships!\n";
} else {
    echo "❌ There are still orphaned products that need fixing.\n";
}

echo "\n=== TEST COMPLETED ===\n";