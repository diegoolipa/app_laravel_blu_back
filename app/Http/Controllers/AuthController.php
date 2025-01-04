<?php

namespace App\Http\Controllers;

use App\Models\User;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function  funLogin(Request $request) {
        $credenciales = $request->validate([
            'email' => 'required',
            'password' => 'required',
        ]);

        //?autenticacion
        if (!Auth::attempt($credenciales)) {
            return response()->json([
                'message' => 'Credenciales invalidas',401
            ]);
        }
        //?generar token
        $token = $request->user()->createToken('auth_token')->plainTextToken;
        return response([
            'access_token'=>$token,
            'usuario' =>$request->user()
        ],201);

    }
    public function funRegister(Request $request) {

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
            return response()->json([
                'message' => 'Usuario creado con éxito',
            ]);

        } catch (Exception $e) {
            return response()->json([
                'estatus' => 'error',
                'message' => 'Usuario creado con éxito',
            ]);
        };
    }
    public function funProfile(Request $request) {}
    public function funLogout(Request $request) {}
}
