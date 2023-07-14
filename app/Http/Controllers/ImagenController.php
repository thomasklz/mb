<?php

namespace App\Http\Controllers;

use App\Models\Imagen;
use Illuminate\Http\Request;
use CloudinaryLabs\CloudinaryLaravel\Facades\Cloudinary;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;


class ImagenController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public $rulesImagenes = array(

        'imagen_url' => 'required',
    );
    public $mensajes = array(

        'imagen_url.required' => 'Se requiere una imagen.',
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
        $usuario = Auth::guard('sanctum')->user();
        if ($usuario->rol !== 'participante') {
            return response()->json(["error" => "no autorizado"], 403);
        }

        $validator = Validator::make($request->all(), $this->rulesImagenes, $this->mensajes);
        if ($validator->fails()) {
            $messages = $validator->getMessageBag();
            return response()->json([
                'messages' => $messages,
            ], 500);
        }
        try {
            $imagen = Imagen::create([
                "imagen_url" => $request->imagen_url,
            ]);
            return response()->json(['message' => "imagen subida", "imagen" => $imagen], 200);
        } catch (\Throwable $e) {
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
            $imagen = Imagen::findOrFail($id);
            $fileName = basename($imagen->imagen_url);
            $deleted = Storage::disk('s3')->delete('images/' . $fileName);
            if ($deleted) {
                // Archivo eliminado correctamente
                $imagen->delete();
                return response()->json(['message' => 'Imagen eliminada correctamente'], 200);
            } else {
                // Error al eliminar el archivo
                return response()->json(['message' => 'Error al eliminar la imagen'], 500);
            }
        } catch (\Throwable $e) {
            return response()->json([
                'message' => "error al eliminar la foto",
                "exception" => $e->getMessage()
            ], 500);
        }
    }
}
