<?php

namespace App\Http\Controllers;

use App\Models\Cliente;
use App\Models\ModeloAdquirido;
use App\Http\Resources\ClienteResource;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Exception;
use Illuminate\Validation\ValidationException;

class ClienteController extends Controller
{
    public function index()
    {
        return ClienteResource::collection(Cliente::with(['modelosAdquiridos', 'ciudad'])->get());
    }

    public function getCategorias()
    {
        return response()->json([
            'data' => [
                ['id' => 'final', 'nombre' => 'Final'],
                ['id' => 'mayorista', 'nombre' => 'Mayorista']
            ]
        ]);
    }

    public function store(Request $request)
    {
        Log::info($request->all());
        try {
            $validated = $request->validate([
                'nombre' => 'required|string|max:255',
                'apellido' => 'required|string|max:255',
                'categoria' => 'required|in:final,mayorista',
                'direccion' => 'string|max:255',
                'email' => 'string|max:255',
                'telefono' => 'string|max:15',
                'documento' => 'nullable|numeric|unique:clientes,documento',
                'ciudad_id' => 'required|exists:ciudades,id',
            ]);

            // Convertir el teléfono a string para almacenarlo
            $validated['telefono'] = strval($validated['telefono']);

            $cliente = Cliente::create($validated);
        } catch (ValidationException $th) {
            Log::error($th);
            return response()->json([
                'message' => 'Error al crear el cliente',
                'error' => $th->getMessage()
            ], 500);
        }

        return new ClienteResource($cliente->load('ciudad'));
    }

    public function show(Cliente $cliente)
    {
        return new ClienteResource($cliente->load(['modelosAdquiridos', 'ciudad']));
    }

    public function update(Request $request, Cliente $cliente)
    {
        Log::info('update', $request->all());
        $validated = $request->validate([
            'nombre' => 'sometimes|required|string|max:255',
            'documento' => 'sometimes|required|numeric|unique:clientes,documento,' . $cliente->id,
            'apellido' => 'sometimes|required|string|max:255',
            'categoria' => 'sometimes|required|in:final,mayorista',
            'telefono' => 'sometimes|required|string|max:15',
            'direccion' => 'sometimes|required|string|max:255',
            'email' => 'sometimes|required|string|max:255',
            'ciudad_id' => 'sometimes|required|exists:ciudades,id',       
        ]);

        $validated['telefono'] = strval($validated['telefono']);
        
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
