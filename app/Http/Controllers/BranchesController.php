<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Branches;

class BranchesController extends Controller
{
    public function index()
    {
        return Branches::all();
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string',
            'location' => 'required|string',
        ]);

        return Branches::create($validated);
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
