<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\People;
use Illuminate\Http\Request;

class PeopleController extends Controller
{
    public function index(Request $request)
    {
        $query = People::query();

        if ($request->has('first_name')) {
            $query->where('first_name', 'LIKE', '%' . $request->first_name . '%');
        }

        if ($request->has('last_name')) {
            $query->where('last_name', 'LIKE', '%' . $request->last_name . '%');
        }

        return response()->json([
            'data' => $query->get()
        ]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'first_name' => 'required|string',
            'last_name' => 'required|string'
        ]);

        $people = People::create($validated);
        return response()->json($people, 201);
    }

    public function show(string $id)
    {
        $people = People::findOrFail($id);
        return response()->json($people);
    }

    public function update(Request $request, string $id)
    {
        $people = People::findOrFail($id);

        $validated = $request->validate([
            'first_name' => 'sometimes|string',
            'last_name' => 'sometimes|string'
        ]);

        $people->update($validated);
        return response()->json($people);
    }

    public function destroy(string $id)
    {
        $people = People::findOrFail($id);
        $people->delete();
        return response()->json(null, 204);
    }
}
