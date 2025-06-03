<?php

namespace App\Http\Controllers;

use App\Http\Resources\ProductoResource;
use App\Models\Producto;
use Illuminate\Http\Request;

class ProductoController extends Controller
{
    public function index()
    {
        return ProductoResource::collection(Producto::with('linea')->get());
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nombre' => 'required|string|max:100',
            'linea_id' => 'required|exists:lineas,id',
        ]);

        $producto = Producto::create($validated);
        return new ProductoResource($producto->load('linea'));
    }

    public function show(Producto $producto)
    {
        return new ProductoResource($producto->load('linea'));
    }

    public function update(Request $request, Producto $producto)
    {
        $validated = $request->validate([
            'nombre' => 'required|string|max:100',
            'linea_id' => 'required|exists:lineas,id',
        ]);

        $producto->update($validated);
        return new ProductoResource($producto->load('linea'));
    }

    public function destroy(Producto $producto)
    {
        $producto->delete();
        return response()->noContent();
    }
}
