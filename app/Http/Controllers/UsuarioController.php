<?php

namespace App\Http\Controllers;

use App\Models\Usuario;
use App\Http\Resources\UsuarioResource;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UsuarioController extends Controller
{
    public function index()
    {
        return UsuarioResource::collection(Usuario::all());
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nombre' => 'required|string|max:255',
            'correo' => 'required|string|email|max:255|unique:usuarios,correo',
            'contrasena' => 'required|string|min:6',
            'rol' => 'required|string|max:50',
        ]);
        $validated['contrasena'] = Hash::make($validated['contrasena']);
        $usuario = Usuario::create($validated);
        return new UsuarioResource($usuario);
    }

    public function show(Usuario $usuario)
    {
        return new UsuarioResource($usuario);
    }

    public function update(Request $request, Usuario $usuario)
    {
        $validated = $request->validate([
            'nombre' => 'sometimes|required|string|max:255',
            'correo' => 'sometimes|required|string|email|max:255|unique:usuarios,correo,' . $usuario->id,
            'contrasena' => 'sometimes|required|string|min:6',
            'rol' => 'sometimes|required|string|max:50',
        ]);
        if (isset($validated['contrasena'])) {
            $validated['contrasena'] = Hash::make($validated['contrasena']);
        }
        $usuario->update($validated);
        return new UsuarioResource($usuario);
    }

    public function destroy(Usuario $usuario)
    {
        $usuario->delete();
        return response()->json(['message' => 'Usuario eliminado correctamente']);
    }
}
