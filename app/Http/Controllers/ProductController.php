<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return Product::all();
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            "name"=>"required",
            "description"=>"required",
            "price"=>"required"
        ]);

        return Product::create($request->all());
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        return Product::find($id);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        // Find the product by ID
        $product = Product::find($id);    
    
        // Validate the incoming request
        $request->validate([
            "name" => "required|string|max:255",
            "description" => "required|string",
            "price" => "required|numeric|min:0"
        ]);
    
        if ($product) {
            // Update the product with the validated data
            $product->update($request->all());
            // Return a successful response with the updated product
            return response()->json($product, 200);
        } else {
            // Return a not found response if the product doesn't exist
            return response()->json(['message' => 'Product not found'], 404);
        }
    }
    

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $product=Product::find($id);
        return $product->delete();
    }
}