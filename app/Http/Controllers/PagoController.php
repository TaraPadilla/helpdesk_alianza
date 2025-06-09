<?php

namespace App\Http\Controllers;

use App\Models\Pago;
use App\Http\Resources\PagoResource;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Models\Ticket;

class PagoController extends Controller
{
    public function index()
    {
        return PagoResource::collection(
            Pago::with(['ticket'])
                ->get()
        );
    }

    public function store(Request $request)
    {
        try {
            Log::info('store Pago', ['request' => $request->all()]);
            
            $validated = $request->validate([
                'ticket_id' => 'required|exists:tickets,id',
                'garantia' => 'required|boolean',
                'costo_liquidado' => 'required|numeric|min:0',
                'status_pago' => 'required|in:EN TRAMITE,PAGADO',
                'num_factura' => 'nullable|string|max:100',
                'num_transferencia' => 'nullable|string|max:100',
            ]);

            $pago = Pago::create($validated);
            return new PagoResource($pago);
        } catch (\Exception $e) {
            Log::error('Error creating pago', ['error' => $e->getMessage()]);
            throw $e;
        }
    }

    public function show(Pago $pago)
    {
        return new PagoResource($pago->loadMissing(['ticket']));
    }

    public function update(Request $request, Pago $pago)
    {
        try {
            $validated = $request->validate([
                'ticket_id' => 'sometimes|required|exists:tickets,id',
                'garantia' => 'sometimes|required|boolean',
                'costo_liquidado' => 'sometimes|required|numeric|min:0',
                'status_pago' => 'sometimes|required|in:EN TRAMITE,PAGADO',
                'num_factura' => 'sometimes|nullable|string|max:100',
                'num_transferencia' => 'sometimes|nullable|string|max:100',
            ]);

            $pago->update($validated);
            return new PagoResource($pago->loadMissing(['ticket']));
        } catch (\Exception $e) {
            Log::error('Error updating pago', ['error' => $e->getMessage()]);
            throw $e;
        }
    }

    public function destroy(Pago $pago)
    {
        $pago->delete();
        return response()->noContent();
    }

    public function pagosPorTicket(Ticket $ticket)
    {
        return PagoResource::collection(
            $ticket->pagos()->get()
        );
    }

    public function pagosPorStatus($status)
    {
        $validated = $this->validateStatus($status);
        return PagoResource::collection(
            Pago::where('status_pago', $validated)
                ->with('ticket')
                ->get()
        );
    }

    private function validateStatus($status)
    {
        $validStatus = ['EN TRAMITE', 'PAGADO'];
        if (!in_array($status, $validStatus)) {
            throw new \InvalidArgumentException('Status pago inválido. Los valores permitidos son: ' . implode(', ', $validStatus));
        }
        return $status;
    }
}
