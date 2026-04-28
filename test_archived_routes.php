<?php

require_once 'vendor/autoload.php';

use App\Models\Brand;
use App\Models\Category;
use App\Models\Product;
use App\Models\User;

// Bootstrap Laravel
$app = require_once 'bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

echo "=== TESTING ARCHIVED FUNCTIONALITY ===\n\n";

// Test 1: Check if models have SoftDeletes
echo "1. Checking SoftDeletes trait:\n";
echo "   Brand uses SoftDeletes: " . (in_array('Illuminate\Database\Eloquent\SoftDeletes', class_uses(Brand::class)) ? "✓ Yes" : "✗ No") . "\n";
echo "   Category uses SoftDeletes: " . (in_array('Illuminate\Database\Eloquent\SoftDeletes', class_uses(Category::class)) ? "✓ Yes" : "✗ No") . "\n";
echo "   Product uses SoftDeletes: " . (in_array('Illuminate\Database\Eloquent\SoftDeletes', class_uses(Product::class)) ? "✓ Yes" : "✗ No") . "\n";
echo "   User uses SoftDeletes: " . (in_array('Illuminate\Database\Eloquent\SoftDeletes', class_uses(User::class)) ? "✓ Yes" : "✗ No") . "\n\n";

// Test 2: Check if deleted_at column exists
echo "2. Checking deleted_at columns in database:\n";
try {
    $brands = \DB::select("PRAGMA table_info(brands)");
    $hasDeletedAt = false;
    foreach ($brands as $column) {
        if ($column->name === 'deleted_at') {
            $hasDeletedAt = true;
            break;
        }
    }
    echo "   Brands table has deleted_at: " . ($hasDeletedAt ? "✓ Yes" : "✗ No") . "\n";
} catch (Exception $e) {
    echo "   Error checking brands table: " . $e->getMessage() . "\n";
}

// Test 3: Try to get archived items
echo "\n3. Testing archived queries:\n";
try {
    $archivedBrands = Brand::onlyTrashed()->count();
    echo "   Archived brands count: {$archivedBrands}\n";
} catch (Exception $e) {
    echo "   ✗ Error getting archived brands: " . $e->getMessage() . "\n";
}

try {
    $archivedCategories = Category::onlyTrashed()->count();
    echo "   Archived categories count: {$archivedCategories}\n";
} catch (Exception $e) {
    echo "   ✗ Error getting archived categories: " . $e->getMessage() . "\n";
}

try {
    $archivedProducts = Product::onlyTrashed()->count();
    echo "   Archived products count: {$archivedProducts}\n";
} catch (Exception $e) {
    echo "   ✗ Error getting archived products: " . $e->getMessage() . "\n";
}

try {
    $archivedUsers = User::onlyTrashed()->count();
    echo "   Archived users count: {$archivedUsers}\n";
} catch (Exception $e) {
    echo "   ✗ Error getting archived users: " . $e->getMessage() . "\n";
}

// Test 4: Test soft delete
echo "\n4. Testing soft delete functionality:\n";
try {
    // Create a test brand
    $testBrand = Brand::create(['brand_name' => 'Test Archive Brand']);
    echo "   ✓ Created test brand (ID: {$testBrand->brand_id})\n";
    
    // Soft delete it
    $testBrand->delete();
    echo "   ✓ Soft deleted test brand\n";
    
    // Check if it's in archived
    $archived = Brand::onlyTrashed()->where('brand_id', $testBrand->brand_id)->first();
    if ($archived) {
        echo "   ✓ Brand found in archived list\n";
        
        // Restore it
        $archived->restore();
        echo "   ✓ Brand restored successfully\n";
        
        // Delete permanently
        $testBrand->forceDelete();
        echo "   ✓ Brand permanently deleted\n";
    } else {
        echo "   ✗ Brand NOT found in archived list\n";
    }
} catch (Exception $e) {
    echo "   ✗ Error: " . $e->getMessage() . "\n";
}

echo "\n=== TEST COMPLETED ===\n";