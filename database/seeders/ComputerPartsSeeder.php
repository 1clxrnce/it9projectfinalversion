<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Category;
use App\Models\Brand;
use App\Models\Product;
use App\Models\Inventory;

class ComputerPartsSeeder extends Seeder
{
    public function run(): void
    {
        // Computer Parts Categories
        $categories = [
            'Processors (CPU)',
            'Graphics Cards (GPU)',
            'Motherboards',
            'Memory (RAM)',
            'Storage (SSD/HDD)',
            'Power Supply Units',
            'Computer Cases',
            'Cooling Systems',
            'Monitors',
            'Keyboards & Mice',
            'Networking',
        ];

        foreach ($categories as $categoryName) {
            Category::firstOrCreate(['category_name' => $categoryName]);
        }

        // Computer Parts Brands
        $brands = [
            'Intel',
            'AMD',
            'NVIDIA',
            'ASUS',
            'MSI',
            'Gigabyte',
            'ASRock',
            'Corsair',
            'Kingston',
            'Crucial',
            'Samsung',
            'Western Digital',
            'Seagate',
            'Cooler Master',
            'NZXT',
            'Thermaltake',
            'be quiet!',
            'Logitech',
            'Razer',
            'SteelSeries',
            'Dell',
            'LG',
            'ASUS ROG',
            'Acer',
            'BenQ',
            'TP-Link',
            'Asus TUF',
        ];

        foreach ($brands as $brandName) {
            Brand::firstOrCreate(['brand_name' => $brandName]);
        }

        // Computer Parts Products
        $products = [
            // Processors (CPU)
            ['name' => 'Intel Core i9-14900K', 'category' => 'Processors (CPU)', 'brand' => 'Intel', 'price' => 32999, 'description' => '24-Core Desktop Processor, 6.0 GHz Max Turbo', 'stock' => 25],
            ['name' => 'Intel Core i7-14700K', 'category' => 'Processors (CPU)', 'brand' => 'Intel', 'price' => 24999, 'description' => '20-Core Desktop Processor, 5.6 GHz Max Turbo', 'stock' => 35],
            ['name' => 'Intel Core i5-14600K', 'category' => 'Processors (CPU)', 'brand' => 'Intel', 'price' => 16999, 'description' => '14-Core Desktop Processor, 5.3 GHz Max Turbo', 'stock' => 45],
            ['name' => 'AMD Ryzen 9 7950X', 'category' => 'Processors (CPU)', 'brand' => 'AMD', 'price' => 34999, 'description' => '16-Core, 32-Thread Desktop Processor', 'stock' => 20],
            ['name' => 'AMD Ryzen 7 7800X3D', 'category' => 'Processors (CPU)', 'brand' => 'AMD', 'price' => 26999, 'description' => '8-Core Gaming Processor with 3D V-Cache', 'stock' => 30],
            ['name' => 'AMD Ryzen 5 7600X', 'category' => 'Processors (CPU)', 'brand' => 'AMD', 'price' => 14999, 'description' => '6-Core, 12-Thread Desktop Processor', 'stock' => 50],

            // Graphics Cards (GPU)
            ['name' => 'NVIDIA RTX 4090', 'category' => 'Graphics Cards (GPU)', 'brand' => 'NVIDIA', 'price' => 109999, 'description' => '24GB GDDR6X, Flagship Gaming GPU', 'stock' => 10],
            ['name' => 'NVIDIA RTX 4080 Super', 'category' => 'Graphics Cards (GPU)', 'brand' => 'NVIDIA', 'price' => 74999, 'description' => '16GB GDDR6X, High-End Gaming GPU', 'stock' => 15],
            ['name' => 'NVIDIA RTX 4070 Ti Super', 'category' => 'Graphics Cards (GPU)', 'brand' => 'NVIDIA', 'price' => 54999, 'description' => '16GB GDDR6X, Performance Gaming GPU', 'stock' => 25],
            ['name' => 'NVIDIA RTX 4060 Ti', 'category' => 'Graphics Cards (GPU)', 'brand' => 'NVIDIA', 'price' => 28999, 'description' => '8GB GDDR6, Mid-Range Gaming GPU', 'stock' => 40],
            ['name' => 'AMD Radeon RX 7900 XTX', 'category' => 'Graphics Cards (GPU)', 'brand' => 'AMD', 'price' => 64999, 'description' => '24GB GDDR6, High-End Gaming GPU', 'stock' => 18],
            ['name' => 'AMD Radeon RX 7800 XT', 'category' => 'Graphics Cards (GPU)', 'brand' => 'AMD', 'price' => 34999, 'description' => '16GB GDDR6, Performance Gaming GPU', 'stock' => 30],
            ['name' => 'AMD Radeon RX 7600', 'category' => 'Graphics Cards (GPU)', 'brand' => 'AMD', 'price' => 18999, 'description' => '8GB GDDR6, Budget Gaming GPU', 'stock' => 45],

            // Motherboards
            ['name' => 'ASUS ROG Maximus Z790 Hero', 'category' => 'Motherboards', 'brand' => 'ASUS ROG', 'price' => 35999, 'description' => 'Intel Z790 ATX Gaming Motherboard', 'stock' => 20],
            ['name' => 'MSI MPG Z790 Carbon WiFi', 'category' => 'Motherboards', 'brand' => 'MSI', 'price' => 28999, 'description' => 'Intel Z790 ATX Motherboard with WiFi', 'stock' => 25],
            ['name' => 'Gigabyte Z790 AORUS Elite', 'category' => 'Motherboards', 'brand' => 'Gigabyte', 'price' => 18999, 'description' => 'Intel Z790 ATX Motherboard', 'stock' => 35],
            ['name' => 'ASUS TUF Gaming X670E-Plus', 'category' => 'Motherboards', 'brand' => 'Asus TUF', 'price' => 24999, 'description' => 'AMD X670E ATX Gaming Motherboard', 'stock' => 22],
            ['name' => 'MSI MAG B650 Tomahawk WiFi', 'category' => 'Motherboards', 'brand' => 'MSI', 'price' => 16999, 'description' => 'AMD B650 ATX Motherboard with WiFi', 'stock' => 30],
            ['name' => 'ASRock B760M Pro RS', 'category' => 'Motherboards', 'brand' => 'ASRock', 'price' => 8999, 'description' => 'Intel B760 Micro-ATX Motherboard', 'stock' => 40],

            // Memory (RAM)
            ['name' => 'Corsair Vengeance DDR5 32GB (2x16GB) 6000MHz', 'category' => 'Memory (RAM)', 'brand' => 'Corsair', 'price' => 8999, 'description' => 'High-performance DDR5 RAM', 'stock' => 60],
            ['name' => 'Kingston Fury Beast DDR5 32GB (2x16GB) 5600MHz', 'category' => 'Memory (RAM)', 'brand' => 'Kingston', 'price' => 7499, 'description' => 'DDR5 Gaming RAM', 'stock' => 70],
            ['name' => 'Crucial DDR5 32GB (2x16GB) 5200MHz', 'category' => 'Memory (RAM)', 'brand' => 'Crucial', 'price' => 6499, 'description' => 'Reliable DDR5 RAM', 'stock' => 80],
            ['name' => 'Corsair Vengeance RGB DDR4 32GB (2x16GB) 3600MHz', 'category' => 'Memory (RAM)', 'brand' => 'Corsair', 'price' => 5999, 'description' => 'RGB DDR4 RAM', 'stock' => 90],
            ['name' => 'Kingston Fury Beast DDR4 16GB (2x8GB) 3200MHz', 'category' => 'Memory (RAM)', 'brand' => 'Kingston', 'price' => 2999, 'description' => 'Budget DDR4 RAM', 'stock' => 100],

            // Storage (SSD/HDD)
            ['name' => 'Samsung 990 PRO 2TB NVMe SSD', 'category' => 'Storage (SSD/HDD)', 'brand' => 'Samsung', 'price' => 12999, 'description' => 'PCIe 4.0 NVMe M.2 SSD, 7450MB/s Read', 'stock' => 50],
            ['name' => 'Samsung 980 PRO 1TB NVMe SSD', 'category' => 'Storage (SSD/HDD)', 'brand' => 'Samsung', 'price' => 6999, 'description' => 'PCIe 4.0 NVMe M.2 SSD, 7000MB/s Read', 'stock' => 65],
            ['name' => 'Western Digital Black SN850X 2TB', 'category' => 'Storage (SSD/HDD)', 'brand' => 'Western Digital', 'price' => 11999, 'description' => 'PCIe 4.0 Gaming SSD', 'stock' => 45],
            ['name' => 'Crucial P5 Plus 1TB NVMe SSD', 'category' => 'Storage (SSD/HDD)', 'brand' => 'Crucial', 'price' => 5499, 'description' => 'PCIe 4.0 NVMe M.2 SSD', 'stock' => 70],
            ['name' => 'Western Digital Blue 2TB HDD', 'category' => 'Storage (SSD/HDD)', 'brand' => 'Western Digital', 'price' => 3499, 'description' => '7200 RPM SATA Hard Drive', 'stock' => 80],
            ['name' => 'Seagate Barracuda 4TB HDD', 'category' => 'Storage (SSD/HDD)', 'brand' => 'Seagate', 'price' => 5999, 'description' => '5400 RPM SATA Hard Drive', 'stock' => 60],

            // Power Supply Units
            ['name' => 'Corsair RM1000x 1000W 80+ Gold', 'category' => 'Power Supply Units', 'brand' => 'Corsair', 'price' => 10999, 'description' => 'Fully Modular PSU', 'stock' => 35],
            ['name' => 'Corsair RM850e 850W 80+ Gold', 'category' => 'Power Supply Units', 'brand' => 'Corsair', 'price' => 8999, 'description' => 'Fully Modular PSU', 'stock' => 45],
            ['name' => 'be quiet! Straight Power 11 750W', 'category' => 'Power Supply Units', 'brand' => 'be quiet!', 'price' => 7999, 'description' => '80+ Gold Modular PSU', 'stock' => 40],
            ['name' => 'Cooler Master MWE 650W 80+ Bronze', 'category' => 'Power Supply Units', 'brand' => 'Cooler Master', 'price' => 4999, 'description' => 'Semi-Modular PSU', 'stock' => 55],
            ['name' => 'Thermaltake Toughpower 850W 80+ Gold', 'category' => 'Power Supply Units', 'brand' => 'Thermaltake', 'price' => 8499, 'description' => 'Fully Modular RGB PSU', 'stock' => 38],

            // Computer Cases
            ['name' => 'NZXT H7 Flow Mid-Tower', 'category' => 'Computer Cases', 'brand' => 'NZXT', 'price' => 7999, 'description' => 'ATX Mid-Tower with excellent airflow', 'stock' => 30],
            ['name' => 'Corsair 4000D Airflow', 'category' => 'Computer Cases', 'brand' => 'Corsair', 'price' => 6499, 'description' => 'ATX Mid-Tower Case', 'stock' => 40],
            ['name' => 'Cooler Master H500 ARGB', 'category' => 'Computer Cases', 'brand' => 'Cooler Master', 'price' => 5999, 'description' => 'ATX Mid-Tower with RGB', 'stock' => 35],
            ['name' => 'Thermaltake Core P3', 'category' => 'Computer Cases', 'brand' => 'Thermaltake', 'price' => 8999, 'description' => 'Open Frame ATX Case', 'stock' => 20],
            ['name' => 'NZXT H510 Elite', 'category' => 'Computer Cases', 'brand' => 'NZXT', 'price' => 9999, 'description' => 'Premium Mid-Tower with Tempered Glass', 'stock' => 25],

            // Cooling Systems
            ['name' => 'Corsair iCUE H150i Elite LCD', 'category' => 'Cooling Systems', 'brand' => 'Corsair', 'price' => 16999, 'description' => '360mm AIO Liquid Cooler with LCD', 'stock' => 28],
            ['name' => 'NZXT Kraken X63', 'category' => 'Cooling Systems', 'brand' => 'NZXT', 'price' => 9999, 'description' => '280mm AIO Liquid Cooler', 'stock' => 35],
            ['name' => 'Cooler Master MasterLiquid 240', 'category' => 'Cooling Systems', 'brand' => 'Cooler Master', 'price' => 5999, 'description' => '240mm AIO Liquid Cooler', 'stock' => 45],
            ['name' => 'be quiet! Dark Rock Pro 4', 'category' => 'Cooling Systems', 'brand' => 'be quiet!', 'price' => 4999, 'description' => 'Premium Air CPU Cooler', 'stock' => 40],
            ['name' => 'Noctua NH-D15', 'category' => 'Cooling Systems', 'brand' => 'be quiet!', 'price' => 5999, 'description' => 'Dual Tower Air CPU Cooler', 'stock' => 35],

            // Monitors
            ['name' => 'ASUS ROG Swift PG27AQDM 27" OLED', 'category' => 'Monitors', 'brand' => 'ASUS ROG', 'price' => 54999, 'description' => '1440p 240Hz OLED Gaming Monitor', 'stock' => 15],
            ['name' => 'LG UltraGear 27GP950 27" 4K', 'category' => 'Monitors', 'brand' => 'LG', 'price' => 42999, 'description' => '4K 144Hz Nano IPS Gaming Monitor', 'stock' => 20],
            ['name' => 'Dell S2722DGM 27" 1440p', 'category' => 'Monitors', 'brand' => 'Dell', 'price' => 18999, 'description' => '1440p 165Hz Curved Gaming Monitor', 'stock' => 30],
            ['name' => 'Acer Nitro XV272U 27" 1440p', 'category' => 'Monitors', 'brand' => 'Acer', 'price' => 16999, 'description' => '1440p 170Hz IPS Gaming Monitor', 'stock' => 35],
            ['name' => 'BenQ ZOWIE XL2546K 24.5" 1080p', 'category' => 'Monitors', 'brand' => 'BenQ', 'price' => 24999, 'description' => '1080p 240Hz Esports Monitor', 'stock' => 25],

            // Keyboards & Mice
            ['name' => 'Logitech G Pro X Keyboard', 'category' => 'Keyboards & Mice', 'brand' => 'Logitech', 'price' => 7999, 'description' => 'Mechanical Gaming Keyboard', 'stock' => 50],
            ['name' => 'Razer BlackWidow V4 Pro', 'category' => 'Keyboards & Mice', 'brand' => 'Razer', 'price' => 12999, 'description' => 'Premium Mechanical Gaming Keyboard', 'stock' => 35],
            ['name' => 'Corsair K70 RGB Pro', 'category' => 'Keyboards & Mice', 'brand' => 'Corsair', 'price' => 9999, 'description' => 'Mechanical Gaming Keyboard with RGB', 'stock' => 45],
            ['name' => 'Logitech G Pro X Superlight', 'category' => 'Keyboards & Mice', 'brand' => 'Logitech', 'price' => 8999, 'description' => 'Wireless Gaming Mouse, 63g', 'stock' => 60],
            ['name' => 'Razer DeathAdder V3 Pro', 'category' => 'Keyboards & Mice', 'brand' => 'Razer', 'price' => 7999, 'description' => 'Wireless Ergonomic Gaming Mouse', 'stock' => 55],
            ['name' => 'SteelSeries Rival 3', 'category' => 'Keyboards & Mice', 'brand' => 'SteelSeries', 'price' => 1999, 'description' => 'Budget Gaming Mouse', 'stock' => 80],

            // Networking
            ['name' => 'TP-Link Archer AX6000', 'category' => 'Networking', 'brand' => 'TP-Link', 'price' => 14999, 'description' => 'WiFi 6 Gaming Router', 'stock' => 30],
            ['name' => 'ASUS RT-AX86U Pro', 'category' => 'Networking', 'brand' => 'ASUS', 'price' => 16999, 'description' => 'WiFi 6 Gaming Router with AiMesh', 'stock' => 25],
            ['name' => 'TP-Link Archer T6E', 'category' => 'Networking', 'brand' => 'TP-Link', 'price' => 2499, 'description' => 'PCIe WiFi 6 Adapter', 'stock' => 60],
        ];

        foreach ($products as $productData) {
            $category = Category::where('category_name', $productData['category'])->first();
            $brand = Brand::where('brand_name', $productData['brand'])->first();

            if ($category && $brand) {
                $product = Product::firstOrCreate(
                    ['product_name' => $productData['name']],
                    [
                        'description' => $productData['description'],
                        'price' => $productData['price'],
                        'category_id' => $category->category_id,
                        'brand_id' => $brand->brand_id,
                    ]
                );

                // Create inventory for the product
                Inventory::firstOrCreate(
                    ['product_id' => $product->product_id],
                    ['quantity' => $productData['stock']]
                );
            }
        }

        // Delete clothing category and products
        $clothingCategory = Category::where('category_name', 'Clothing')->first();
        if ($clothingCategory) {
            // Delete all products in clothing category
            Product::where('category_id', $clothingCategory->category_id)->delete();
            // Delete the category
            $clothingCategory->delete();
        }
    }
}
