<?php

namespace App\Http\Controllers;

use App\Models\User as Jurado;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    private  $rulesLogin = array(
        'email' => 'required|email',
        'password' => 'required'
    );
    private $messagesLogin = array(
        'email.unique' => 'ya existe ese email.',
        'email.required' => 'email es requerido.',
        'email.email' => 'debe ser un email correcto.',
        'password.required' => 'debe ingresar una password',
    );
    public function index()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Jurado  $jurado
     * @return \Illuminate\Http\Response
     */
    public function show(Jurado $jurado)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Jurado  $jurado
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Jurado $jurado)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Jurado  $jurado
     * @return \Illuminate\Http\Response
     */
    public function destroy(Jurado $jurado)
    {
        //
    }



    public function login(Request $request)
    {
        $validator = Validator::make($request->all(), $this->rulesLogin, $this->messagesLogin);
        if ($validator->fails()) {
            $messages = $validator->messages();
            return response()->json(["messages" => $messages], 500);
        }

         $user = Jurado::where("email", "=", $request->email)->first();
        if (isset($user->id)) {
            if (Hash::check($request->password, $user->password)) {
                //creamos el token
                $token = $user->createToken("auth_token")->plainTextToken;
                //si está todo ok
                return response()->json([

                    "messages" => "¡Usuario logueado exitosamente!",
                    "access_token" => $token
                ],200);
            }  else {
            return response()->json([
                "status" => 0,
                "error" => "credenciales incorrectas",
            ], 500);
        }
    }else{
        return response()->json([
            "status" => 0,
            "error" => "Usuario no registrado",
        ], 404);
    }
}

    public function userProfile()
    {
        $usuario=Auth::guard('sanctum')->user();

        return response()->json([
            "msg" => "Acerca del perfil de usuario",
            "user" => $usuario,
            /* "usuario"=>$user, */
        ]);
    }

    public function logout()
    {
       /*  auth()->user()->tokens()->delete(); */
       Auth::guard('sanctum')->user()->tokens()->delete();
        return response()->json([
            "status" => 1,
            "messages" => "Cierre de Sesión",
        ]);
    }
    public function exportar()
    {
        $path = storage_path('app/public/seeds/datosPassword.xlsx');

        return response()->download($path);
    }
}
