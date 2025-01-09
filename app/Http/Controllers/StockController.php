<?php

namespace App\Http\Controllers;

use App\Models\Branches;
use App\Models\Product;
use Illuminate\Http\Request;
use App\Models\Stock;

class StockController extends Controller
{
    public function index()
    {
        // Ambil semua data stocks dengan relasi product dan branch
        $stocks = Stock::with(['product', 'branch'])->get();

        // Kirim data ke view stocks.index
        return view('stocks.index', compact('stocks'));
    }

    public function create()
    {
        $stocks = Stock::all();
        $branches = Branches::all();
        $products = Product::all();

        // Kirim data ke view
        return view('stocks.create', compact('stocks', 'branches', 'products'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'product_id' => 'required|exists:products,id',
            'branch_id' => 'required|exists:branches,id',
            'quantity' => 'required|integer',
        ]);

        Stock::create($validated);

        // Redirect ke halaman branches.index dengan pesan sukses
        return redirect()->route('stocks.index')->with('success', 'Stokcs created successfully.');
    }

    public function show($id)
    {
        return Stock::with(['product', 'branch'])->findOrFail($id);
    }

    public function update(Request $request, $id)
    {
        $stock = Stock::findOrFail($id);
        $validated = $request->validate([
            'product_id' => 'sometimes|required|exists:products,id',
            'branch_id' => 'sometimes|required|exists:branches,id',
            'quantity' => 'sometimes|required|integer',
        ]);

        $stock->update($validated);
        return $stock;
    }

    public function destroy($id)
    {
        $stock = Stock::findOrFail($id);
        $stock->delete();
        return response(null, 204);
    }
}
