<?php

namespace App\Http\Controllers;

use App\Models\StockTransaction;
use App\Models\Product;
use App\Models\Inventory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class StockTransactionController extends Controller
{
    /**
     * Display a listing of transactions
     */
    public function index()
    {
        $transactions = StockTransaction::with(['product', 'user'])
            ->orderBy('transactionDate', 'desc')
            ->paginate(20);
        return view('transactions.index', compact('transactions'));
    }

    /**
     * Show the form for creating a new transaction
     */
    public function create()
    {
        $products = Product::with('inventory')->get();
        return view('transactions.create', compact('products'));
    }

    /**
     * Store a newly created transaction
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'product_id' => 'required|exists:products,product_id',
            'transactionType' => 'required|in:in,out,adjustment',
            'quantity' => 'required|integer|min:1',
        ]);

        DB::beginTransaction();
        try {
            // Get product and old inventory
            $product = Product::with('inventory')->findOrFail($validated['product_id']);
            $oldQuantity = $product->inventory ? $product->inventory->quantity : 0;

            // Create transaction
            $transaction = StockTransaction::create([
                'product_id' => $validated['product_id'],
                'user_id' => auth()->user()->user_id,
                'transactionType' => $validated['transactionType'],
                'quantity' => $validated['quantity'],
                'transactionDate' => now(),
            ]);

            // Update inventory
            $inventory = Inventory::firstOrCreate(
                ['product_id' => $validated['product_id']],
                ['quantity' => 0]
            );

            if ($validated['transactionType'] === 'in') {
                $inventory->quantity += $validated['quantity'];
            } elseif ($validated['transactionType'] === 'out') {
                if ($inventory->quantity < $validated['quantity']) {
                    throw new \Exception('Insufficient stock');
                }
                $inventory->quantity -= $validated['quantity'];
            } else { // adjustment
                $inventory->quantity = $validated['quantity'];
            }

            $newQuantity = $inventory->quantity;
            $inventory->save();
            DB::commit();

            return redirect()->route('transactions.show', $transaction->transaction_id)
                ->with([
                    'success' => 'Transaction created successfully',
                    'oldQuantity' => $oldQuantity,
                    'newQuantity' => $newQuantity,
                    'product' => $product
                ]);
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->withErrors(['error' => $e->getMessage()])->withInput();
        }
    }

    /**
     * Display the specified transaction with confirmation
     */
    public function show(StockTransaction $transaction)
    {
        $transaction->load(['product.category', 'product.brand', 'product.inventory', 'user']);
        return view('transactions.show', compact('transaction'));
    }
}
