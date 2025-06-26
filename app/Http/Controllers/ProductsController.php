<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
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
        $validated = $request->validated();
        $validated['current_stock'] = $validated['opening_stock'];

        $product = Product::create($validated);

        return response()->json($product, 201);
    }

    // Show a single product
    public function show($id)
    {
        $product = Product::findOrFail($id);
        return response()->json($product);
    }

    // Update a product
    public function update(StoreProductRequest $request, $id)
    {
        $product = Product::findOrFail($id);
        $validated = $request->validated();

        // Only update current_stock if opening_stock changes
        if ($validated['opening_stock'] != $product->opening_stock) {
            $validated['current_stock'] = $validated['opening_stock'];
        }

        $product->update($validated);

        return response()->json($product);
    }

    // Delete a product
    public function destroy($id)
    {
        Product::findOrFail($id)->delete();
        return response()->json(['message' => 'Product deleted']);
    }
}
