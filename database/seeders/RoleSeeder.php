<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Category;
use App\Models\Brand;
use App\Models\Product;
use App\Models\Inventory;
use Illuminate\Support\Facades\Hash;

class RoleSeeder extends Seeder
{
    public function run(): void
    {
        // Create users with different roles
        $admin = User::create([
            'firstName' => 'Admin',
            'lastName' => 'User',
            'email' => 'admin@example.com',
            'password' => Hash::make('password'),
            'role' => 'admin',
            'mobilePhone' => '1234567890',
        ]);

        $staff = User::create([
            'firstName' => 'Staff',
            'lastName' => 'User',
            'email' => 'staff@example.com',
            'password' => Hash::make('password'),
            'role' => 'staff',
            'mobilePhone' => '0987654321',
        ]);

        $customer = User::create([
            'firstName' => 'Customer',
            'lastName' => 'User',
            'email' => 'customer@example.com',
            'password' => Hash::make('password'),
            'role' => 'customer',
            'mobilePhone' => '5555555555',
        ]);

        // Create sample categories
        $categories = [
            'CPU',
            'GPU',
            'RAM',
            'Motherboard',
            'Storage',
            'Power Supply',
            'Case',
            'Cooling',
        ];

        foreach ($categories as $categoryName) {
            Category::create(['category_name' => $categoryName]);
        }

        // Create sample brands
        $brands = [
            'Intel',
            'AMD',
            'NVIDIA',
            'Corsair',
            'ASUS',
            'MSI',
            'Gigabyte',
            'Samsung',
            'Western Digital',
        ];

        foreach ($brands as $brandName) {
            Brand::create(['brand_name' => $brandName]);
        }

        // Create sample products
        $products = [
            ['name' => 'Intel Core i9-13900K', 'category' => 'CPU', 'brand' => 'Intel', 'price' => 32999.00],
            ['name' => 'AMD Ryzen 9 7950X', 'category' => 'CPU', 'brand' => 'AMD', 'price' => 39999.00],
            ['name' => 'NVIDIA RTX 4090', 'category' => 'GPU', 'brand' => 'NVIDIA', 'price' => 89999.00],
            ['name' => 'Corsair Vengeance 32GB DDR5', 'category' => 'RAM', 'brand' => 'Corsair', 'price' => 8499.00],
            ['name' => 'ASUS ROG Strix Z790', 'category' => 'Motherboard', 'brand' => 'ASUS', 'price' => 22499.00],
            ['name' => 'Samsung 990 PRO 2TB', 'category' => 'Storage', 'brand' => 'Samsung', 'price' => 11299.00],
        ];

        foreach ($products as $productData) {
            $category = Category::where('category_name', $productData['category'])->first();
            $brand = Brand::where('brand_name', $productData['brand'])->first();

            $product = Product::create([
                'product_name' => $productData['name'],
                'description' => 'High-performance computer component',
                'price' => $productData['price'],
                'category_id' => $category->category_id,
                'brand_id' => $brand->brand_id,
            ]);

            // Create inventory with random quantity
            Inventory::create([
                'product_id' => $product->product_id,
                'quantity' => rand(5, 50),
            ]);
        }
    }
}
