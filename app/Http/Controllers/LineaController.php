<?php

namespace App\Http\Controllers;

use App\Http\Resources\LineaResource;
use App\Models\Linea;
use Illuminate\Http\Request;

class LineaController extends Controller
{
    public function index()
    {
        return LineaResource::collection(Linea::all());
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nombre' => 'required|string|max:100',
        ]);

        $linea = Linea::create($validated);
        return new LineaResource($linea);
    }

    public function show(Linea $linea)
    {
        return new LineaResource($linea);
    }

    public function update(Request $request, Linea $linea)
    {
        $validated = $request->validate([
            'nombre' => 'required|string|max:100',
        ]);

        $linea->update($validated);
        return new LineaResource($linea);
    }

    public function destroy(Linea $linea)
    {
        $linea->delete();
        return response()->noContent();
    }
}
