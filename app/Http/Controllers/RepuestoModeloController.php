<?php

namespace App\Http\Controllers;

use App\Models\RepuestoModelo;
use App\Http\Resources\RepuestoModeloResource;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class RepuestoModeloController extends Controller
{
    public function index()
    {
        return RepuestoModeloResource::collection(
            RepuestoModelo::with(['modelo', 'repuesto'])->get()
        );
    }

    public function store(Request $request)
    {
        try {
            Log::info('store RepuestoModelo', ['request' => $request->all()]);
            $validated = $request->validate([
                'modelo_id' => 'required|exists:modelos,id',
                'repuesto_id' => 'required|exists:repuestos,id',
            ]);
            $repuestoModelo = RepuestoModelo::create($validated);
            return new RepuestoModeloResource($repuestoModelo);
        } catch (\Exception $e) {
            Log::error('Error creating repuesto_modelo', ['error' => $e->getMessage()]);
            throw $e;
        }
    }

    public function show(RepuestoModelo $repuestoModelo)
    {
        return new RepuestoModeloResource($repuestoModelo->loadMissing(['modelo', 'repuesto']));
    }

    public function update(Request $request, RepuestoModelo $repuestoModelo)
    {
        try {
            $validated = $request->validate([
                'modelo_id' => 'sometimes|required|exists:modelos,id',
                'repuesto_id' => 'sometimes|required|exists:repuestos,id',
            ]);
            $repuestoModelo->update($validated);
            return new RepuestoModeloResource($repuestoModelo->loadMissing(['modelo', 'repuesto']));
        } catch (\Exception $e) {
            Log::error('Error updating repuesto_modelo', ['error' => $e->getMessage()]);
            throw $e;
        }
    }

    public function destroy(RepuestoModelo $repuestoModelo)
    {
        $repuestoModelo->delete();
        return response()->noContent();
    }
}
