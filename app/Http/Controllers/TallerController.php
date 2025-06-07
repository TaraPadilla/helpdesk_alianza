<?php

namespace App\Http\Controllers;

use App\Models\Taller;
use App\Http\Resources\TallerResource;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Models\Tecnico;

class TallerController extends Controller
{
    public function index()
    {
        return TallerResource::collection(
            Taller::with('tecnicos')
                ->get()
        );
    }

    public function store(Request $request)
    {
        try {
            Log::info('store Taller', ['request' => $request->all()]);
            $validated = $request->validate([
                'nombre' => 'required|string|max:100',
                'ciudad_id' => 'required|exists:ciudades,id',
            ]);

            $taller = Taller::create($validated);
            
            return new TallerResource($taller);
        } catch (\Exception $e) {
            Log::error('Error storing taller', ['error' => $e->getMessage()]);
            throw $e;
        }
    }

    public function show(Taller $taller)
    {
        return new TallerResource($taller);
    }

    public function update(Request $request, Taller $taller)
    {
        try {
            Log::info('update Taller', ['request' => $request->all()]);
            $validated = $request->validate([
                'nombre' => 'sometimes|required|string|max:100',
                'ciudad_id' => 'sometimes|required|exists:ciudades,id',
            ]);

            $taller->update($validated);
            
            return new TallerResource($taller);
        } catch (\Exception $e) {
            Log::error('Error updating taller', ['error' => $e->getMessage()]);
            throw $e;
        }
    }

    public function destroy(Taller $taller)
    {
        $taller->delete();
        return response()->noContent();
    }
}
