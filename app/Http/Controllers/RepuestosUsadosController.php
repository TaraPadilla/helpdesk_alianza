<?php

namespace App\Http\Controllers;

use App\Models\RepuestosUsados;
use App\Http\Resources\RepuestosUsadosResource;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class RepuestosUsadosController extends Controller
{
    public function index()
    {
        return RepuestosUsadosResource::collection(
            RepuestosUsados::with(['soporte', 'repuesto'])
                ->get()
        );
    }

    public function store(Request $request)
    {
        try {
            Log::info('store RepuestosUsados', ['request' => $request->all()]);
            
            $validated = $request->validate([
                'soporte_id' => 'required|exists:soportes,id',
                'codigo_repuesto' => 'required|exists:repuestos,codigo',
                'numero_factura_repuesto' => 'nullable|string|max:100',
            ]);

            $repuestosUsados = RepuestosUsados::create($validated);
            return new RepuestosUsadosResource($repuestosUsados);
        } catch (\Exception $e) {
            Log::error('Error creating repuestosUsados', ['error' => $e->getMessage()]);
            throw $e;
        }
    }

    public function show(RepuestosUsados $repuestosUsados)
    {
        return new RepuestosUsadosResource($repuestosUsados->loadMissing(['soporte', 'repuesto']));
    }

    public function update(Request $request, RepuestosUsados $repuestosUsados)
    {
        try {
            $validated = $request->validate([
                'soporte_id' => 'sometimes|required|exists:soportes,id',
                'codigo_repuesto' => 'sometimes|required|exists:repuestos,codigo',
                'numero_factura_repuesto' => 'sometimes|nullable|string|max:100',
            ]);

            $repuestosUsados->update($validated);
            return new RepuestosUsadosResource($repuestosUsados->loadMissing(['soporte', 'repuesto']));
        } catch (\Exception $e) {
            Log::error('Error updating repuestosUsados', ['error' => $e->getMessage()]);
            throw $e;
        }
    }

    public function destroy(RepuestosUsados $repuestosUsados)
    {
        $repuestosUsados->delete();
        return response()->noContent();
    }

    public function repuestosUsadosPorSoporte(Soporte $soporte)
    {
        return RepuestosUsadosResource::collection(
            $soporte->repuestosUsados()->with('repuesto')->get()
        );
    }

    public function repuestosUsadosPorRepuesto(Repuesto $repuesto)
    {
        return RepuestosUsadosResource::collection(
            RepuestosUsados::where('codigo_repuesto', $repuesto->codigo)
                ->with('soporte')
                ->get()
        );
    }
}
