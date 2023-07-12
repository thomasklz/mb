<?php

namespace App\Http\Controllers;

use App\Models\Imagen;
use Illuminate\Http\Request;
use CloudinaryLabs\CloudinaryLaravel\Facades\Cloudinary;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;


class ImagenController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

     public $rulesImagenes=array(

        'imagen' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:10000|min:1000|dimensions:max_width=4032,max_height=4032',
);
    public $mensajes=array(

        'imagen.required' => 'Se requiere una imagen.',
        'imagen.image' => 'Solo se permite imagenes.',
        'imagen.mimes' => 'Tipo de imagen no valido.',
        'imagen.max' => 'El tamaño máximo de la imagen es de 10 MB.',
        'imagen.dimensions' => 'Esta imagen supero el ancho o alto permitido.',
        'imagen.min' => 'El tamaño minimo de la imagen es de 1 MB.',
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

       /*  $validator= Validator::make($request->all(),$this->rulesImagenes,$this->mensajes);
        if($validator -> fails()){
            $messages=$validator->getMessageBag();
            return response()->json([
                'messages'=>$messages
            ],500);
        } */
        $file = $request->file('imagen');
        try{
        $obj = Cloudinary::upload($file->getRealPath(),['folder'=>'AmbienteSaludable']);
        $imagen_id = $obj->getPublicId();
        $url = $obj->getSecurePath();

        $imagen = Imagen::create([

            'imagen_url'=>$url,
            'id_imagen'=>$imagen_id,

        ]);
        return response()->json(['messages'=>'Se creo una la imagen con exito.','imagen'=> $imagen]);
    } catch (\Exception $e) {
        return response()->json(['error' => $e->getMessage()], 500);
    }

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Imagen  $imagen
     * @return \Illuminate\Http\Response
     */
    public function show(Imagen $imagen)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Imagen  $imagen
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Imagen $imagen)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Imagen  $imagen
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        try {
            $producto = Imagen::findOrFail($id);
            $public_id = $producto->id_imagen;
            Cloudinary::destroy($public_id);
            return response()->json([
                'messages' => "foto eliminada"
            ], Response::HTTP_OK);
        } catch (\Throwable $e) {
            return response()->json([
                'message' => "error al eliminar la foto",
                "exception" => $e->getMessage()
            ], 500);
        }
    }
}
