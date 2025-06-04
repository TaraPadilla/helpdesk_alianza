<?php

namespace App\Http\Controllers;

use App\Http\Resources\ModeloResource;
use App\Models\Modelo;
use Illuminate\Http\Request;

class ModeloController extends Controller
{
    public function index()
    {
        return ModeloResource::collection(Modelo::with(['producto', 'origen'])->get());
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nombre' => 'required|string|max:100',
            'producto_id' => 'required|exists:productos,id',
            'origen_id' => 'required|exists:origenes,id',
        ]);

        $modelo = Modelo::create($validated);
        return new ModeloResource($modelo->load(['producto', 'origen']));
    }

    public function show(Modelo $modelo)
    {
        return new ModeloResource($modelo->load(['producto', 'origen']));
    }

    public function update(Request $request, Modelo $modelo)
    {
        $validated = $request->validate([
            'nombre' => 'required|string|max:100',
            'producto_id' => 'required|exists:productos,id',
            'origen_id' => 'required|exists:origenes,id',
        ]);

        $modelo->update($validated);
        return new ModeloResource($modelo->load(['producto', 'origen']));
    }

    public function destroy(Modelo $modelo)
    {
        $modelo->delete();
        return response()->noContent();
    }

    public function filterByProducto($producto)
    {
        return ModeloResource::collection(Modelo::with(['producto', 'origen'])->where('producto_id', $producto)->get());
    }
}
