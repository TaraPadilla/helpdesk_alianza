<?php

namespace App\Http\Controllers;

use App\Models\ModeloAdquirido;
use App\Models\Cliente;
use App\Models\Modelo;
use App\Http\Resources\ModeloAdquiridoResource;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;


class ModeloAdquiridoController extends Controller
{
    public function index()
    {
        return ModeloAdquiridoResource::collection(ModeloAdquirido::with('cliente', 'modelo')->get());
    }

    public function store(Request $request)
    {
        try {
            Log::info('store ModeloAdquirido', ['request' => $request->all()]);
    
            $validated = $request->validate([
                'cliente_id' => 'required|exists:clientes,id',
                'modelo_id' => 'required|exists:modelos,id',
                'numero_serie' => 'nullable|string|max:255|unique:modelos_adquiridos',
                'fecha_compra' => 'nullable|date',
                'numero_factura' => 'nullable|string|max:255',
            ]);
    
            Log::debug('Datos validados', $validated);
    
            $modeloAdquirido = ModeloAdquirido::create($validated);
    
            if ($modeloAdquirido) {
                Log::info('ModeloAdquirido guardado con éxito', ['id' => $modeloAdquirido->id]);
            }
    
            return new ModeloAdquiridoResource($modeloAdquirido);
    
        } catch (\Throwable $e) {
            Log::error('Error en store ModeloAdquirido', [
                'message' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
            return response()->json(['error' => 'Error al guardar'], 500);
        }
    }
    

    public function show(ModeloAdquirido $modeloAdquirido)
    {
        return new ModeloAdquiridoResource($modeloAdquirido);
    }

    public function update(Request $request, ModeloAdquirido $modeloAdquirido)
    {
        $validated = $request->validate([
            'cliente_id' => 'sometimes|required|exists:clientes,id',
            'modelo_id' => 'sometimes|required|exists:modelos,id',
            'numero_serie' => 'sometimes|nullable|string|max:255|unique:modelos_adquiridos,numero_serie,' . $modeloAdquirido->id,
            'fecha_compra' => 'sometimes|nullable|date',
            'numero_factura' => 'sometimes|nullable|string|max:255',
        ]);

        $modeloAdquirido->update($validated);
        Log::info('update ModeloAdquirido', ['modeloAdquirido' => $modeloAdquirido]);
        return new ModeloAdquiridoResource($modeloAdquirido);
    }

    public function destroy(ModeloAdquirido $modeloAdquirido)
    {
        $modeloAdquirido->delete();
        Log::info('destroy ModeloAdquirido', ['modeloAdquirido' => $modeloAdquirido]);
        return response()->noContent();
    }

    public function modelosPorCliente(Cliente $cliente)
    {
        return ModeloAdquiridoResource::collection($cliente->modelosAdquiridos()->with('modelo')->get());
    }
}
