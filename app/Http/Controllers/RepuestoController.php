<?php

namespace App\Http\Controllers;

use App\Models\Repuesto;
use App\Http\Resources\RepuestoResource;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class RepuestoController extends Controller
{
    public function index()
    {
        return RepuestoResource::collection(
            Repuesto::all()
        );
    }

    public function store(Request $request)
    {
        try {
            Log::info('store Repuesto', ['request' => $request->all()]);
            
            $validated = $request->validate([
                'codigo' => 'required|string|max:10|unique:repuestos,codigo',
                'nombre' => 'required|string|max:100',
                'tipo' => 'nullable|string|max:20',
            ]);

            $repuesto = Repuesto::create($validated);
            return new RepuestoResource($repuesto);
        } catch (\Exception $e) {
            Log::error('Error creating repuesto', ['error' => $e->getMessage()]);
            throw $e;
        }
    }

    public function show(Repuesto $repuesto)
    {
        return new RepuestoResource($repuesto);
    }

    public function update(Request $request, Repuesto $repuesto)
    {
        try {
            $validated = $request->validate([
                'codigo' => 'sometimes|required|string|max:10|unique:repuestos,codigo,' . $repuesto->id,
                'nombre' => 'sometimes|required|string|max:100',
                'tipo' => 'sometimes|nullable|string|max:20',
            ]);

            $repuesto->update($validated);
            return new RepuestoResource($repuesto);
        } catch (\Exception $e) {
            Log::error('Error updating repuesto', ['error' => $e->getMessage()]);
            throw $e;
        }
    }

    public function destroy(Repuesto $repuesto)
    {
        $repuesto->delete();
        return response()->noContent();
    }

    public function filterByName(Request $request)
    {
        $validated = $request->validate([
            'nombre' => 'required|string',
        ]);

        return RepuestoResource::collection(
            Repuesto::where('nombre', 'LIKE', '%' . $validated['nombre'] . '%')
                ->get()
        );
    }
}
