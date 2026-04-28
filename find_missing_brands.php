<?php

require_once 'vendor/autoload.php';

$app = require_once 'bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

use App\Models\Brand;

echo "Finding brands that are not recorded in the database...\n\n";

// Get all existing brands from database
$existingBrands = Brand::pluck('brand_name')->toArray();
echo "Existing brands in database:\n";
foreach ($existingBrands as $brand) {
    echo "- {$brand}\n";
}

echo "\nAnalyzing brand image files to find missing brands...\n";

// Check brand image files for potential missing brands
$brandImagesDir = storage_path('app/public/brands');
$potentialBrands = [];

if (is_dir($brandImagesDir)) {
    $files = scandir($brandImagesDir);
    
    echo "\nBrand image files found:\n";
    foreach ($files as $file) {
        if ($file !== '.' && $file !== '..' && !is_dir($brandImagesDir . '/' . $file)) {
            echo "- {$file}\n";
            
            // Try to extract brand names from filenames
            $filename = strtolower(pathinfo($file, PATHINFO_FILENAME));
            
            // Common brand patterns in filenames
            $brandPatterns = [
                'gigabyte' => 'Gigabyte',
                'samsung' => 'Samsung', 
                'western' => 'Western Digital',
                'wd' => 'Western Digital',
                'apple' => 'Apple',
                'sony' => 'Sony',
                'lg' => 'LG',
                'dell' => 'Dell',
                'kingston' => 'Kingston',
                'cooler' => 'Cooler Master',
                'nzxt' => 'NZXT',
                'logitech' => 'Logitech',
                'asus' => 'ASUS',
                'msi' => 'MSI',
                'nvidia' => 'NVIDIA',
                'amd' => 'AMD',
                'intel' => 'Intel',
                'corsair' => 'Corsair',
                'evga' => 'EVGA',
                'seasonic' => 'Seasonic',
                'thermaltake' => 'Thermaltake',
                'fractal' => 'Fractal Design',
                'be quiet' => 'be quiet!',
                'noctua' => 'Noctua',
                'razer' => 'Razer',
                'steelseries' => 'SteelSeries',
                'hyperx' => 'HyperX',
                'crucial' => 'Crucial',
                'seagate' => 'Seagate',
                'toshiba' => 'Toshiba',
                'hitachi' => 'Hitachi',
                'sandisk' => 'SanDisk',
                'zotac' => 'ZOTAC',
                'palit' => 'Palit',
                'galax' => 'GALAX',
                'powercolor' => 'PowerColor',
                'sapphire' => 'Sapphire',
                'xfx' => 'XFX',
            ];
            
            foreach ($brandPatterns as $pattern => $brandName) {
                if (strpos($filename, $pattern) !== false && !in_array($brandName, $existingBrands)) {
                    if (!isset($potentialBrands[$brandName])) {
                        $potentialBrands[$brandName] = [];
                    }
                    $potentialBrands[$brandName][] = $file;
                }
            }
        }
    }
}

echo "\n" . str_repeat("=", 50) . "\n";
echo "POTENTIAL MISSING BRANDS DETECTED:\n";
echo str_repeat("=", 50) . "\n";

if (empty($potentialBrands)) {
    echo "No obvious missing brands detected from filenames.\n";
    echo "You may need to manually review the image files and add brands as needed.\n";
} else {
    foreach ($potentialBrands as $brandName => $files) {
        echo "\n🔍 BRAND: {$brandName}\n";
        echo "   Potential image files:\n";
        foreach ($files as $file) {
            echo "   - {$file}\n";
        }
    }
    
    echo "\n" . str_repeat("-", 50) . "\n";
    echo "RECOMMENDATIONS:\n";
    echo str_repeat("-", 50) . "\n";
    
    foreach ($potentialBrands as $brandName => $files) {
        echo "• Add '{$brandName}' brand and assign image: {$files[0]}\n";
    }
}

echo "\nTo add missing brands:\n";
echo "1. Go to Admin Dashboard > Brands\n";
echo "2. Click 'Add Brand' button\n";
echo "3. Enter the brand name\n";
echo "4. Upload the appropriate logo image\n";
echo "5. Save the brand\n";

echo "\nOr you can add them through the admin interface at: " . url('/admin/brands') . "\n";