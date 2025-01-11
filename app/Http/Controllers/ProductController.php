<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use Barryvdh\DomPDF\Facade\Pdf;

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

    public function edit($id)
    {
        $products = Product::findOrFail($id);

        // Kirim data products ke view untuk diedit
        return view('products.edit', compact('products'));
    }

    public function update(Request $request, $id)
    {
        $products = Product::findOrFail($id);
        $validated = $request->validate([
            'name' => 'sometimes|required|string',
            'description' => 'sometimes|nullable|string',
            'price' => 'sometimes|required|numeric',
            'category' => 'sometimes|nullable|string',
        ]);

        $products->update($validated);

        // Redirect ke halaman branches.index dengan pesan sukses
        return redirect()->route('products.index')->with('success', 'Products updated successfully.');
    }

    public function destroy($id)
    {
        // Cari Products berdasarkan ID
        $products = Product::find($id);

        // Jika Products tidak ditemukan, kembalikan respons error
        if (!$products) {
            return redirect()->route('products.index')->with('error', 'Products not found.');
        }

        // Hapus Products
        $products->delete();

        // Redirect ke halaman Productses.index dengan pesan sukses
        return redirect()->route('products.index')->with('success', 'Products deleted successfully.');
    }

    public function generateReport()
    {
        $products = Product::all();

        // Generate PDF
        $pdf = Pdf::loadView('products.report', compact('products'));

        // Return PDF as download
        return $pdf->download('product-report.pdf');
    }
}
