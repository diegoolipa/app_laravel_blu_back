<?php

namespace App\Http\Controllers\Person;

use App\Http\Controllers\Controller;
use App\Models\User;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class PersonaController extends Controller
{
    public function guardar(Request $request)
    {
        //? valida datos
        $request->validate([
            'name' => 'required|string|max:100|min:2',
            'email' => 'required|email|unique:users',
            'password' => 'required|same:c_password',
        ]);
        try {
            //? registrar en la db
            $usuario = new User();
            $usuario->name = $request->name;
            $usuario->email = $request->email;
            $usuario->password = Hash::make($request->password);
            $usuario->save();
            //? responder
            return $this->successResponse('Usuario creado con éxito', 200);
        } catch (Exception $e) {
            return $this->errorResponse($e->getMessage(), 400);
        };
    }
}
