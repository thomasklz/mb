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
        $usuario = Auth::guard('sanctum')->user();
        if ($usuario->rol !== 'participante') {
            return response()->json(["error" => "no autorizado"], 403);
        }

        /* $validator = Validator::make($request->all(), $this->rulesImagenes, $this->mensajes);
        if ($validator->fails()) {
            $messages = $validator->getMessageBag();
            return response()->json([
                'messages' => $messages
            ], 500);
        } */

        try {
            $imagen = $request->file('imagen');
            // Validar que se haya seleccionado un archivo
            if ($imagen) {
                // Guardar la imagen con un nombre único utilizando el ID
                // Generar un nombre único para la imagen
                $nombreImagen = uniqid() . '.' . $imagen->getClientOriginalExtension();

                // Guardar la imagen en el almacenamiento local
                $imagen->storeAs('public/imagenes', $nombreImagen);

                // Obtener la ruta completa de la imagen guardada
                $rutaImagen = '/storage/imagenes/' . $nombreImagen;
                $imagen = Imagen::create([
                    "imagen_url" => $rutaImagen,
                    "nombre"=>$nombreImagen
                ]);
                // Aquí puedes realizar otras operaciones, como guardar el nombre de la imagen en la base de datos, etc.
                return response()->json(['message' => "imagen subida", "imagen" => $imagen], 200);
            }
            return response()->json(['error' => "no se ha seleccionado ninguna imagen"], 500);
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
            $imagen = Imagen::findOrFail($id);
                Storage::delete('public/imagenes/' . $imagen->nombre);
                $imagen->delete();
                return response()->json(['message' => 'Imagen eliminada exitosamente'], 200);
        } catch (\Throwable $e) {
            return response()->json([
                'message' => "error al eliminar la foto",
                "exception" => $e->getMessage()
            ], 500);
        }
    }
}
