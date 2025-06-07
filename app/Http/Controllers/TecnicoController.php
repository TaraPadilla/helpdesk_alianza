<?php

namespace App\Http\Controllers;

use App\Models\Tecnico;
use App\Http\Resources\TecnicoResource;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class TecnicoController extends Controller
{
    public function index()
    {
        return TecnicoResource::collection(
            Tecnico::with('taller')
                ->get()
        );
    }

    public function store(Request $request)
    {
        try {
            Log::info('store Tecnico', ['request' => $request->all()]);
            $validated = $request->validate([
                'documento' => 'nullable|integer|unique:tecnicos,documento',
                'nombre' => 'required|string|max:100',
                'apellido' => 'required|string|max:100',
                'email' => 'nullable|email|max:255',
                'taller_id' => 'required|integer|exists:talleres,id',
            ]);

            $tecnico = Tecnico::create($validated);
            
            return new TecnicoResource($tecnico);
        } catch (\Exception $e) {
            Log::error('Error storing tecnico', ['error' => $e->getMessage()]);
            throw $e;
        }
    }

    public function show(Tecnico $tecnico)
    {
        return new TecnicoResource($tecnico->loadMissing('taller'));
    }

    public function update(Request $request, Tecnico $tecnico)
    {
        try {
            Log::info('update Tecnico', ['request' => $request->all()]);
            $validated = $request->validate([
                'documento' => 'nullable|integer|unique:tecnicos,documento,' . $tecnico->id,
                'nombre' => 'required|string|max:100',
                'apellido' => 'required|string|max:100',
                'email' => 'nullable|email|max:255',
                'taller_id' => 'required|integer|exists:talleres,id',
            ]);

            $tecnico->update($validated);
            
            return new TecnicoResource($tecnico->loadMissing('taller'));
        } catch (\Exception $e) {
            Log::error('Error updating tecnico', ['error' => $e->getMessage()]);
            throw $e;
        }
    }

    public function destroy(Tecnico $tecnico)
    {
        $tecnico->delete();
        return response()->noContent();
    }
}
