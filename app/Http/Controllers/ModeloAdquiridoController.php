<?php

namespace App\Http\Controllers;

use App\Models\ModeloAdquirido;
use App\Models\Cliente;
use App\Models\Modelo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ModeloAdquiridoController extends Controller
{
    public function index()
    {
        return ModeloAdquirido::with('cliente', 'modelo')->get();
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'cliente_id' => 'required|exists:clientes,id',
            'modelo_id' => 'required|exists:modelos,id',
            'numero_serie' => 'required|string|max:255|unique:modelos_adquiridos',
            'fecha_compra' => 'required|date',
            'numero_factura' => 'required|string|max:255',
        ]);

        $modeloAdquirido = ModeloAdquirido::create($validated);
        return response()->json($modeloAdquirido->load('cliente', 'modelo'), 201);
    }

    public function show(ModeloAdquirido $modeloAdquirido)
    {
        return $modeloAdquirido->load('cliente', 'modelo');
    }

    public function update(Request $request, ModeloAdquirido $modeloAdquirido)
    {
        $validated = $request->validate([
            'cliente_id' => 'sometimes|required|exists:clientes,id',
            'modelo_id' => 'sometimes|required|exists:modelos,id',
            'numero_serie' => 'sometimes|required|string|max:255|unique:modelos_adquiridos,numero_serie,' . $modeloAdquirido->id,
            'fecha_compra' => 'sometimes|required|date',
            'numero_factura' => 'sometimes|required|string|max:255',
        ]);

        $modeloAdquirido->update($validated);
        return response()->json($modeloAdquirido->load('cliente', 'modelo'));
    }

    public function destroy(ModeloAdquirido $modeloAdquirido)
    {
        $modeloAdquirido->delete();
        return response()->noContent();
    }

    public function modelosPorCliente(Cliente $cliente)
    {
        return $cliente->modelosAdquiridos()->with('modelo')->get();
    }
}
