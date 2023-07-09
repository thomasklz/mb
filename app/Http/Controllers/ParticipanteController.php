<?php

namespace App\Http\Controllers;

use App\Models\Participante;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class ParticipanteController extends Controller
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
    public $rulesParticipante=array(

        'id' => 'integer|exists:participantes,id',
        'cedula'=>'exists:participantes,cedula'
);
    public $mensajes=array(

        'id.integer' => 'Solo se aceptan numeros.',
        'id.exists' => 'Solo identificadores existentes.',
        'cedula.exists' => 'Solo cedulas existentes.',


    );
    public function index()
    {
        //
        $participante = Participante::all();
        return response()->json(['Participantes'=>$participante]);
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
     * @param  \App\Models\Participante  $participante
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //

        $participante = Participante::with('Post','Post.Imagen','Post.Categoria','Post.Like','Post.Comentario_Post','Post.Like')->find($id);
        if (!$participante) {
            return response()->json(['error' => 'Participante no encontrado'], 404);
        }

        return response()->json(['participante' => $participante]);

    }
    public function showByCedula($cedula)
    {
        //

        $participante = Participante::where('cedula', 'LIKE', '%' . $cedula . '%')->get();
        if ($participante->isEmpty()) {
            return response()->json(['error' => 'Ingrese un numero de cedula existente.'], 404);
        }
        return response()->json(['participante' => $participante]);

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Participante  $participante
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Participante $participante)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Participante  $participante
     * @return \Illuminate\Http\Response
     */
    public function destroy(Participante $participante)
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

         $user = Participante::where("email", "=", $request->email)->first();
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
}
