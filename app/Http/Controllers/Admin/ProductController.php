<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Category;
use App\Models\Brand;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function index()
    {
        $products = Product::with(['category', 'brand', 'inventory'])->get();
        $categories = Category::all();
        $brands = Brand::all();
        return view('admin.products.index', compact('products', 'categories', 'brands'));
    }

    public function archived()
    {
        $products = Product::onlyTrashed()->with(['category', 'brand', 'inventory'])->get();
        $categories = Category::all();
        $brands = Brand::all();
        return view('admin.products.archived', compact('products', 'categories', 'brands'));
    }

    public function restore($id)
    {
        $product = Product::onlyTrashed()->findOrFail($id);
        $product->restore();
        
        return redirect()->route('admin.products.archived')
            ->with('success', 'Product restored successfully');
    }

    public function forceDelete($id)
    {
        $product = Product::onlyTrashed()->findOrFail($id);
        
        // Delete image if exists
        if ($product->image && \Storage::disk('public')->exists($product->image)) {
            \Storage::disk('public')->delete($product->image);
        }
        
        $product->forceDelete();
        
        return redirect()->route('admin.products.archived')
            ->with('success', 'Product permanently deleted');
    }

    public function create()
    {
        $categories = Category::all();
        $brands = Brand::all();
        return view('admin.products.create', compact('categories', 'brands'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'product_name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'price' => 'required|numeric|min:0',
            'category_id' => 'required|exists:categories,category_id',
            'brand_id' => 'required|exists:brands,brand_id',
        ]);

        if ($request->hasFile('image')) {
            $validated['image'] = $request->file('image')->store('products', 'public');
            
            // Automatically copy to public directory
            $this->copyStorageToPublic();
        }

        Product::create($validated);

        return redirect()->route('admin.products.index')
            ->with('success', 'Product created successfully');
    }

    public function edit(Product $product)
    {
        $categories = Category::all();
        $brands = Brand::all();
        return view('admin.products.edit', compact('product', 'categories', 'brands'));
    }

    public function update(Request $request, Product $product)
    {
        $validated = $request->validate([
            'product_name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'price' => 'required|numeric|min:0',
            'category_id' => 'required|exists:categories,category_id',
            'brand_id' => 'required|exists:brands,brand_id',
        ]);

        if ($request->hasFile('image')) {
            // Delete old image if exists
            if ($product->image && \Storage::disk('public')->exists($product->image)) {
                \Storage::disk('public')->delete($product->image);
            }
            $validated['image'] = $request->file('image')->store('products', 'public');
            
            // Automatically copy to public directory
            $this->copyStorageToPublic();
        }

        $product->update($validated);

        return redirect()->route('admin.products.index')
            ->with('success', 'Product updated successfully');
    }

    public function destroy(Product $product)
    {
        $product->delete(); // Soft delete
        return redirect()->route('admin.products.index')
            ->with('success', 'Product moved to archive');
    }

    /**
     * Copy storage files to public directory for web access
     */
    private function copyStorageToPublic()
    {
        $sourceDir = storage_path('app/public');
        $destDir = public_path('storage');

        // Ensure destination directory exists
        if (!is_dir($destDir)) {
            mkdir($destDir, 0755, true);
        }

        // Copy all files from storage to public
        $this->recursiveCopy($sourceDir, $destDir);
    }

    /**
     * Recursively copy directory contents
     */
    private function recursiveCopy($source, $dest)
    {
        if (!is_dir($dest)) {
            mkdir($dest, 0755, true);
        }

        $iterator = new \RecursiveIteratorIterator(
            new \RecursiveDirectoryIterator($source, \RecursiveDirectoryIterator::SKIP_DOTS),
            \RecursiveIteratorIterator::SELF_FIRST
        );

        foreach ($iterator as $item) {
            $destPath = $dest . DIRECTORY_SEPARATOR . $iterator->getSubPathName();
            if ($item->isDir()) {
                if (!is_dir($destPath)) {
                    mkdir($destPath, 0755, true);
                }
            } else {
                copy($item, $destPath);
            }
        }
    }
}
