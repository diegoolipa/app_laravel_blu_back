<?php

namespace App\Http\Controllers\Person;

use App\Http\Controllers\Controller;
use App\Models\User;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class PersonaController extends Controller
{
    public function listar(){
        $data = [];
        try {
            $data = DB::select('select * from users');
            return $this->successResponse($data, 200);
        } catch (Exception $e) {
            return $this->errorResponse($e->getMessage(), 400);
        }
    }
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

    public function mostrar($id_persona){
        $data = [];
        try {
            $data = DB::select('select * from users where id = ?', [$id_persona]);
            if (!$data) {
                throw new Exception("Usuario no encontrado");
            }
            return $this->successResponse($data, 200);
        } catch (Exception $e) {
            return $this->errorResponse($e->getMessage(), 400);
        }
    }
    public function actualizar(Request $request, $id_persona){
        //? Validar datos de entrada
        $request->validate([
            'name' => 'sometimes|string|max:100|min:2',
            'email' => 'sometimes|email|unique:users,email,',
            'password' => 'nullable|same:c_password',
        ]);

        try {
            //? Buscar al usuario
            $usuario = User::findOrFail($id_persona);

            //? Actualizar campos si están presentes
            if ($request->has('name')) {
                $usuario->name = $request->name;
            }
            if ($request->has('email')) {
                $usuario->email = $request->email;
            }
            if ($request->has('password')) {
                $usuario->password = Hash::make($request->password);
            }

            //? Guardar cambios
            $usuario->save();

            return $this->successResponse('Usuario actualizado con éxito', 200);
        } catch (Exception $e) {
            return $this->errorResponse($e->getMessage(), 400);
        }
    }
    public function eliminar($id_persona){
        try {
            //? Buscar al usuario
            $usuario = User::findOrFail($id_persona);

            //? Eliminar al usuario
            $usuario->delete();

            return $this->successResponse('Usuario eliminado con éxito', 200);
        } catch (Exception $e) {
            return $this->errorResponse($e->getMessage(), 400);
        }
    }
}
