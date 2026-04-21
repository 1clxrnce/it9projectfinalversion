<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    /**
     * Display a listing of products (for customers - browsing only)
     */
    public function index()
    {
        $products = Product::with(['category', 'brand', 'inventory'])->paginate(15);
        return view('products.index', compact('products'));
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
