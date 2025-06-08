<?php

namespace App\Http\Controllers;

use App\Models\Soporte;
use App\Http\Resources\SoporteResource;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class SoporteController extends Controller
{
    public function index()
    {
        return SoporteResource::collection(
            Soporte::with(['ticket', 'tecnico'])
                ->get()
        );
    }

    public function store(Request $request)
    {
        try {
            Log::info('store Soporte', ['request' => $request->all()]);
            
            $validated = $request->validate([
                'ticket_id' => 'required|exists:tickets,id',
                'tecnico_id' => 'required|exists:tecnicos,id',
                'fecha_visita' => 'required|date',
                'descripcion_dano' => 'nullable|string',
                'descripcion_reparacion' => 'nullable|string',
                'parte_afectada' => 'nullable|string|max:100',
                'orden_trabajo' => 'nullable|string|max:100',
            ]);

            $soporte = Soporte::create($validated);
            return new SoporteResource($soporte);
        } catch (\Exception $e) {
            Log::error('Error creating soporte', ['error' => $e->getMessage()]);
            throw $e;
        }
    }

    public function show(Soporte $soporte)
    {
        return new SoporteResource($soporte->loadMissing(['ticket', 'tecnico']));
    }

    public function update(Request $request, Soporte $soporte)
    {
        try {
            $validated = $request->validate([
                'ticket_id' => 'sometimes|required|exists:tickets,id',
                'tecnico_id' => 'sometimes|required|exists:tecnicos,id',
                'fecha_visita' => 'sometimes|required|date',
                'descripcion_dano' => 'sometimes|nullable|string',
                'descripcion_reparacion' => 'sometimes|nullable|string',
                'parte_afectada' => 'sometimes|nullable|string|max:100',
                'orden_trabajo' => 'sometimes|nullable|string|max:100',
            ]);

            $soporte->update($validated);
            return new SoporteResource($soporte->loadMissing(['ticket', 'tecnico']));
        } catch (\Exception $e) {
            Log::error('Error updating soporte', ['error' => $e->getMessage()]);
            throw $e;
        }
    }

    public function destroy(Soporte $soporte)
    {
        $soporte->delete();
        return response()->noContent();
    }

    public function soportesPorTicket(Ticket $ticket)
    {
        return SoporteResource::collection($ticket->soportes()->get());
    }

    public function soportesPorTecnico(Tecnico $tecnico)
    {
        return SoporteResource::collection($tecnico->soportes()->get());
    }
}
