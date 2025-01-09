<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Branches;
use App\Models\Product;

class BranchesController extends Controller
{
    public function index()
    {
        $branches = Branches::all();

        // Kirim data branches ke view
        return view('branches.index', compact('branches'));
    }

    public function create()
    {
        $products = Product::all();

        // Kirim data ke view
        return view('branches.create', compact('products'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string',
            'location' => 'required|string',
        ]);

        // Buat data branch baru
        Branches::create($validated);

        // Redirect ke halaman branches.index dengan pesan sukses
        return redirect()->route('branches.index')->with('success', 'Branch created successfully.');
    }

    public function show($id)
    {
        return Branches::findOrFail($id);
    }

    public function update(Request $request, $id)
    {
        $branch = Branches::findOrFail($id);
        $validated = $request->validate([
            'name' => 'sometimes|required|string',
            'location' => 'sometimes|required|string',
        ]);

        $branch->update($validated);
        return $branch;
    }

    public function destroy($id)
    {
        $branch = Branches::findOrFail($id);
        $branch->delete();
        return response(null, 204);
    }
}
