<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Usuario;
use App\Http\Resources\UsuarioResource;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        $request->validate([
            'correo' => 'required|email',
            'contrasena' => 'required'
        ]);
    
        $usuario = Usuario::where('correo', $request->correo)->first();
    
        if (!$usuario || !Hash::check($request->contrasena, $usuario->contrasena)) {
            return response()->json(['mensaje' => 'Credenciales inválidas'], 401);
        }
    
        $token = $usuario->createToken('token-login')->plainTextToken;
    
        return response()->json([
            'usuario' => $usuario,
            'token' => $token
        ]);
    }

    public function logout(Request $request)
    {
        $request->user()->currentAccessToken()->delete();
        return response()->json(['message' => 'Sesión cerrada correctamente']);
    }

    public function user(Request $request)
    {
        return new UsuarioResource($request->user());
    }
}
