<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\StoreProductRequest;

class ProductsController extends Controller
{
    // List all products
    public function index()
    {
        return response()->json(Product::all());
    }

    // Create a new product
    public function store(StoreProductRequest $request)
    {
        try {
            $validated = $request->validated();
            $validated['current_stock'] = $validated['opening_stock'];

            $product = Product::create($validated);

            return response()->json($product, 201);
        } catch (\Throwable $th) {
            return response()->json(['error' => $th->getMessage()], 500);
        }

    }

    // Show a single product
    public function show(Product $product)
    {
        return response()->json($product);
    }

    // Update a product
    public function update(StoreProductRequest $request, Product $product)
    {
        $validated = $request->validated();
        try {
            // Only update current_stock if opening_stock changes
            if ($validated['opening_stock'] != $product->opening_stock) {
                $validated['current_stock'] = $validated['opening_stock'];
            }

            $product->update($validated);

            return response()->json($product);
        } catch (\Throwable $th) {
            return response()->json(['error' => $th->getMessage()], 500);
        }


    }

    // Delete a product
    public function destroy(Product $product)
    {
        try {
            $product->delete();
            return response()->json(['message' => 'Product deleted']);
        } catch (\Throwable $th) {
            return response()->json(['error' => $th->getMessage()], 500);
        }

    }
}
