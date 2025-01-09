<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;

class ProductController extends Controller
{
    public function index()
    {
        $products = Product::all();

        // Kirim data branches ke view
        return view('products.index', compact('products'));
    }

    public function create()
    {
        $products = Product::all();

        // Kirim data ke view
        return view('products.create', compact('products'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string',
            'description' => 'nullable|string',
            'price' => 'required|numeric',
            'category' => 'nullable|string',
        ]);

        Product::create($validated);

        // Redirect ke halaman branches.index dengan pesan sukses
        return redirect()->route('products.index')->with('success', 'Products created successfully.');
    }

    public function show($id)
    {
        return Product::findOrFail($id);
    }

    public function update(Request $request, $id)
    {
        $product = Product::findOrFail($id);
        $validated = $request->validate([
            'name' => 'sometimes|required|string',
            'description' => 'nullable|string',
            'price' => 'sometimes|required|numeric',
            'category' => 'nullable|string',
        ]);

        $product->update($validated);
        return $product;
    }

    public function destroy($id)
    {
        $product = Product::findOrFail($id);
        $product->delete();
        return response(null, 204);
    }
}
