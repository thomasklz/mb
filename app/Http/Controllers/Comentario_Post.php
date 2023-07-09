<?php

namespace App\Http\Controllers;

use App\Models\Comentario;
use App\Models\Comentario_Post as ComentarioModel;
use App\Models\Comentario_Post as ModelsComentario_Post;
use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class Comentario_Post extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public $rulesComentario=array(

        'fecha' => 'required|date',

);
    public $mensajes=array(

        'fecha.required' => 'El campo es requerido.',
        'fecha.date' => 'Solo fecha valida.',



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
        $usuario=Auth::guard('sanctum')->user();
        if($usuario->rol!=='participante'){
            return response()->json(["error"=>"no autorizado"],403);
        }

        $validator= Validator::make($request->all(),$this->rulesComentario,$this->mensajes);
        if($validator -> fails()){
            $messages=$validator->getMessageBag();
            return response()->json([
                'messages'=>$messages
            ],500);
        };
        $comentarioExistente = ModelsComentario_Post::where('participante_id', $usuario->id)
        ->where('post_id', $request->post_id)
        ->first();
        if ($comentarioExistente) {
            return response()->json(['error' => 'El usuario ya ha comentado este post'], 400);
        }
        try{
        $comentario =ComentarioModel::create([
            'fecha'=>$request->fecha,
            'comentario_id'=>$request->comentario_id,
            'participante_id'=>$usuario->id,
            'post_id'=>$request->post_id,
        ]);
        return response()->json(['messages'=>'Se creo  con exito.','comentario'=> $comentario]);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
