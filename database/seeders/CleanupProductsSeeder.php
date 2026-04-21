<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Product;
use App\Models\Category;
use App\Models\Brand;

class CleanupProductsSeeder extends Seeder
{
    public function run(): void
    {
        // Keep only these 30 products
        $keepProducts = [
            // CPUs (4)
            'Intel Core i9-14900K',
            'Intel Core i5-14600K',
            'AMD Ryzen 9 7950X',
            'AMD Ryzen 5 7600X',
            
            // GPUs (4)
            'NVIDIA RTX 4090',
            'NVIDIA RTX 4070 Ti Super',
            'AMD Radeon RX 7900 XTX',
            'AMD Radeon RX 7600',
            
            // Motherboards (3)
            'ASUS ROG Maximus Z790 Hero',
            'MSI MPG Z790 Carbon WiFi',
            'ASUS TUF Gaming X670E-Plus',
            
            // RAM (3)
            'Corsair Vengeance DDR5 32GB (2x16GB) 6000MHz',
            'Kingston Fury Beast DDR5 32GB (2x16GB) 5600MHz',
            'Kingston Fury Beast DDR4 16GB (2x8GB) 3200MHz',
            
            // Storage (4)
            'Samsung 990 PRO 2TB NVMe SSD',
            'Samsung 980 PRO 1TB NVMe SSD',
            'Western Digital Black SN850X 2TB',
            'Western Digital Blue 2TB HDD',
            
            // Power Supply (3)
            'Corsair RM1000x 1000W 80+ Gold',
            'Corsair RM850e 850W 80+ Gold',
            'Cooler Master MWE 650W 80+ Bronze',
            
            // Cases (2)
            'NZXT H7 Flow Mid-Tower',
            'Corsair 4000D Airflow',
            
            // Cooling (2)
            'Corsair iCUE H150i Elite LCD',
            'NZXT Kraken X63',
            
            // Monitors (3)
            'ASUS ROG Swift PG27AQDM 27" OLED',
            'LG UltraGear 27GP950 27" 4K',
            'Dell S2722DGM 27" 1440p',
            
            // Peripherals (2)
            'Logitech G Pro X Keyboard',
            'Logitech G Pro X Superlight',
        ];

        // Delete all products not in the keep list
        Product::whereNotIn('product_name', $keepProducts)->delete();

        // Delete unused categories
        $unusedCategories = [
            'Books',
            'Toys & Games',
            'Beauty & Personal Care',
            'Automotive',
            'Office Supplies',
            'Sports & Outdoors',
            'Food & Beverages',
        ];

        Category::whereIn('category_name', $unusedCategories)->delete();

        // Delete unused brands
        $unusedBrands = [
            'Nike',
            'Adidas',
            'Levi\'s',
            'Zara',
            'H&M',
            'Uniqlo',
            'Puma',
            'Reebok',
            'Philips',
            'Panasonic',
            'Nestle',
            'Coca-Cola',
            'HP',
            'Canon',
            'Nikon',
            'Seagate',
            'Thermaltake',
            'be quiet!',
            'Razer',
            'SteelSeries',
            'Acer',
            'BenQ',
            'TP-Link',
            'Asus TUF',
            'ASRock',
            'Crucial',
        ];

        Brand::whereIn('brand_name', $unusedBrands)->delete();

        $this->command->info('Cleanup complete! Now you have exactly 30 products.');
    }
}
