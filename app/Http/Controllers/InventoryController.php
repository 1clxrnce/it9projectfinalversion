<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class InventoryController extends Controller
{
    /**
     * Display inventory overview
     */
    public function index()
    {
        $products = Product::with(['category', 'brand', 'inventory'])
            ->orderBy('product_name')
            ->paginate(20);
        
        return view('inventory.index', compact('products'));
    }
}
