<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Category;
use App\Models\Product;

class CleanupCategoriesSeeder extends Seeder
{
    public function run(): void
    {
        // Define the correct categories we want to keep
        $correctCategories = [
            'CPU' => 'CPU',
            'GPU' => 'GPU',
            'RAM' => 'RAM',
            'Motherboard' => 'Motherboard',
            'Storage' => 'Storage',
            'Power Supply' => 'Power Supply',
            'Case' => 'Case',
            'Cooling' => 'Cooling',
        ];

        // Mapping of incorrect names to correct names
        $categoryMapping = [
            'Processors (CPU)' => 'CPU',
            'Graphics Cards (GPU)' => 'GPU',
            'Memory (RAM)' => 'RAM',
            'Motherboards' => 'Motherboard',
            'Storage (SSD/HDD)' => 'Storage',
            'Power Supply Units' => 'Power Supply',
            'Computer Cases' => 'Case',
            'Cooling Systems' => 'Cooling',
            'Electronics' => 'Case', // Reassign to Case
            'Home & Kitchen' => 'Case', // Reassign to Case
            'Monitors' => 'Case', // Reassign to Case
            'Keyboards & Mice' => 'Case', // Reassign to Case
            'Networking' => 'Case', // Reassign to Case
        ];

        // First, create or get the correct categories
        $correctCategoryIds = [];
        foreach ($correctCategories as $name) {
            $category = Category::firstOrCreate(['category_name' => $name]);
            $correctCategoryIds[$name] = $category->category_id;
        }

        // Get all existing categories
        $allCategories = Category::all();

        foreach ($allCategories as $category) {
            $categoryName = $category->category_name;
            
            // If this category needs to be mapped to a correct one
            if (isset($categoryMapping[$categoryName])) {
                $correctName = $categoryMapping[$categoryName];
                $correctId = $correctCategoryIds[$correctName];
                
                // Update all products using this category to use the correct one
                Product::where('category_id', $category->category_id)
                    ->update(['category_id' => $correctId]);
                
                // Delete the incorrect category
                $category->delete();
            }
        }

        $this->command->info('Categories cleaned up successfully!');
    }
}
