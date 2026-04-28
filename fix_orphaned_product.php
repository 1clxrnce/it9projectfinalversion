<?php

require_once 'vendor/autoload.php';

use App\Models\Brand;
use App\Models\Product;

// Bootstrap Laravel
$app = require_once 'bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

echo "=== FIXING ORPHANED PRODUCT ===\n\n";

// Create ASUS brand
$asus = Brand::create(['brand_name' => 'ASUS']);
echo "✓ Created ASUS brand with ID: {$asus->brand_id}\n";

// Fix the orphaned product
$product = Product::find(44);
if ($product) {
    $product->brand_id = $asus->brand_id;
    $product->save();
    echo "✓ Updated product '{$product->product_name}' to use ASUS brand\n";
} else {
    echo "✗ Product with ID 44 not found\n";
}

// Verify the fix
$orphanedCount = Product::whereNotIn('brand_id', Brand::pluck('brand_id'))->count();
echo "\nOrphaned products remaining: {$orphanedCount}\n";

echo "\n=== FIX COMPLETED ===\n";