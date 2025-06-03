<?php

namespace App\Http\Controllers;

use App\Models\Ciudad;
use App\Http\Resources\CiudadResource;
use Illuminate\Http\Request;

class CiudadController extends Controller
{
    public function index()
    {
        return CiudadResource::collection(Ciudad::withCount('clientes')->get());
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'ciudad' => 'required|string|max:100',
            'provincia' => 'required|string|max:100',
            'ciudad_provincia' => 'unique:ciudades,ciudad,provincia',
        ]);

        $ciudad = Ciudad::create($validated);
        return new CiudadResource($ciudad);
    }

    public function show(Ciudad $ciudad)
    {
        return new CiudadResource($ciudad->load('clientes'));
    }

    public function update(Request $request, Ciudad $ciudad)
    {
        $validated = $request->validate([
            'ciudad' => 'required|string|max:100|unique:ciudades,ciudad,' . $ciudad->id . ',id,provincia,' . $ciudad->provincia,
            'provincia' => 'required|string|max:100',
        ]);

        $ciudad->update($validated);
        return new CiudadResource($ciudad);
    }

    public function destroy(Ciudad $ciudad)
    {
        $ciudad->delete();
        return response()->noContent();
    }

    public function ciudadesPorProvincia(Request $request)
    {
        $validated = $request->validate([
            'provincia' => 'required|string|max:100',
        ]);

        return CiudadResource::collection(
            Ciudad::where('provincia', $validated['provincia'])
                ->withCount('clientes')
                ->get()
        );
    }
}
