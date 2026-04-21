<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Category;
use App\Models\Brand;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    /**
     * Display a listing of products (for customers - browsing only)
     */
    public function index(Request $request)
    {
        $query = Product::with(['category', 'brand', 'inventory']);
        
        // Filter by category
        if ($request->has('category') && $request->category != '') {
            $query->where('category_id', $request->category);
        }
        
        // Filter by brand
        if ($request->has('brand') && $request->brand != '') {
            $query->where('brand_id', $request->brand);
        }
        
        // Search
        if ($request->has('search') && $request->search != '') {
            $query->where('product_name', 'like', '%' . $request->search . '%');
        }
        
        $products = $query->paginate(12);
        $categories = Category::all();
        $brands = Brand::all();
        
        return view('products.index', compact('products', 'categories', 'brands'));
    }

    /**
     * Display the specified product
     */
    public function show(Product $product)
    {
        $product->load(['category', 'brand', 'inventory']);
        return view('products.show', compact('product'));
    }
}
