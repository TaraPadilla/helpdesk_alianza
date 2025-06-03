<?php

namespace App\Http\Controllers;

use App\Models\Cliente;
use App\Models\ModeloAdquirido;
use App\Http\Resources\ClienteResource;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ClienteController extends Controller
{
    public function index()
    {
        return ClienteResource::collection(Cliente::with(['modelosAdquiridos', 'ciudad'])->get());
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nombre' => 'required|string|max:255',
            'apellido' => 'required|string|max:255',
            'categoria' => 'required|in:final,mayorista',
            'telefono' => 'required|string|max:50',
            'direccion' => 'required|string|max:255',
            'ciudad_id' => 'required|exists:ciudades,id',
        ]);

        $cliente = Cliente::create($validated);
        return new ClienteResource($cliente->load('ciudad'));
    }

    public function show(Cliente $cliente)
    {
        return new ClienteResource($cliente->load(['modelosAdquiridos', 'ciudad']));
    }

    public function update(Request $request, Cliente $cliente)
    {
        $validated = $request->validate([
            'nombre' => 'sometimes|required|string|max:255',
            'apellido' => 'sometimes|required|string|max:255',
            'categoria' => 'sometimes|required|in:final,mayorista',
            'telefono' => 'required|string|max:50',
            'direccion' => 'required|string|max:255',
            'ciudad_id' => 'required|exists:ciudades,id',
        ]);

        $cliente->update($validated);
        return new ClienteResource($cliente->load('ciudad'));
    }

    public function destroy(Cliente $cliente)
    {
        $cliente->delete();
        return response()->noContent();
    }

    public function modelosAdquiridos(Cliente $cliente)
    {
        return $cliente->modelosAdquiridos()->get();
    }
}
