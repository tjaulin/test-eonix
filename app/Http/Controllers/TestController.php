<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Personne;
use Illuminate\Http\Request;

class TestController extends Controller
{
    public function index(Request $request)
    {
        $query = Personne::query();

        // Filtres insensibles à la casse
        if ($request->has('prenom')) {
            $query->where('prenom', 'LIKE', '%' . strtolower($request->prenom) . '%');
        }

        if ($request->has('nom')) {
            $query->where('nom', 'LIKE', '%' . strtolower($request->nom) . '%');
        }

        return response()->json($query->get());
    }

    public function show(string $id)
    {
        $personne = Personne::findOrFail($id);
        return response()->json($personne);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'prenom' => 'required|string',
            'nom' => 'required|string'
        ]);

        $personne = Personne::create($validated);
        return response()->json($personne, 201);
    }

    public function update(Request $request, string $id)
    {
        $personne = Personne::findOrFail($id);

        $validated = $request->validate([
            'prenom' => 'sometimes|string',
            'nom' => 'sometimes|string'
        ]);

        $personne->update($validated);
        return response()->json($personne);
    }

    public function destroy(string $id)
    {
        $personne = Personne::findOrFail($id);
        $personne->delete();
        return response()->json(null, 204);
    }
}
