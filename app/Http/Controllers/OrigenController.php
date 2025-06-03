<?php

namespace App\Http\Controllers;

use App\Http\Resources\OrigenResource;
use App\Models\Origen;
use Illuminate\Http\Request;

class OrigenController extends Controller
{
    public function index()
    {
        return OrigenResource::collection(Origen::all());
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nombre' => 'required|string|max:100',
        ]);

        $origen = Origen::create($validated);
        return new OrigenResource($origen);
    }

    public function show(Origen $origen)
    {
        return new OrigenResource($origen);
    }

    public function update(Request $request, Origen $origen)
    {
        $validated = $request->validate([
            'nombre' => 'required|string|max:100',
        ]);

        $origen->update($validated);
        return new OrigenResource($origen);
    }

    public function destroy(Origen $origen)
    {
        $origen->delete();
        return response()->noContent();
    }
}
