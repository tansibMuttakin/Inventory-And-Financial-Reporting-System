<?php

namespace App\Http\Controllers;

use App\Models\Sale;
use App\Models\Product;
use Illuminate\Http\Request;
use App\Services\SaleService;
use App\Http\Requests\StoreSaleRequest;

class SaleController extends Controller
{
    public function index()
    {
        try {
            return Sale::with('product')->latest()->get();
        } catch (\Throwable $th) {
            return response()->json(['error' => $th->getMessage()], 500);
        }

    }

    public function store(StoreSaleRequest $request)
    {
        $validated = $request->validated();

        $product = Product::findOrFail($validated['product_id']);

        if ($validated['quantity'] > $product->current_stock) {
            return response()->json(['error' => 'Not enough stock'], 400);
        }
        try {
            $unitPrice = $product->sell_price;
            $subTotal = ($unitPrice * $validated['quantity']) - ($validated['discount'] ?? 0);
            $vat = $subTotal * ($validated['vat'] / 100);


            $total = $subTotal + $vat;
            $due = $total - $validated['paid_amount'];

            $sale = Sale::create([
                'product_id' => $product->id,
                'quantity' => $validated['quantity'],
                'discount' => $validated['discount'] ?? 0,
                'vat' => $validated['vat'] ?? 0,
                'vat_amount' => $vat,
                'total' => $total,
                'paid_amount' => $validated['paid_amount'],
                'due_amount' => $due,
            ]);

            // Create journal entries for sale
            SaleService::createJournalOnSale($sale->id, $subTotal, $vat, $validated, $due);

            // Reduce product stock
            $product->decrement('current_stock', $validated['quantity']);

            return response()->json($sale->load('product'), 201);
        } catch (\Throwable $th) {
            return response()->json(['error' => $th->getMessage()], 500);
        }


    }

    public function show(Sale $sale)
    {
        return $sale->load('product');
    }

    public function update(StoreSaleRequest $request, Sale $sale)
    {
        return response()->json(['message' => 'Sale update not implemented.'], 501);
    }

    public function destroy(Sale $sale)
    {
        try {
            // Restore stock
            $sale->product->increment('current_stock', $sale->quantity);

            $sale->delete();

            return response()->json(['message' => 'Sale deleted and stock restored.']);
        } catch (\Throwable $th) {
            return response()->json(['error' => $th->getMessage()], 500);
        }

    }
}
