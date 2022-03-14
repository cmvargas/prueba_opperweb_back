<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\Categoria;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function verTodo(){
        $todosDatosPost=Post::all();
        return response()->json([
            "status"=>"ok",
            "data"=>$todosDatosPost
        ], 200);

    }
    public function index()
    {
        
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $datosPost=request()->except('_token');

        $messages = [
            'Categorias_id.exists'=>'No existe esa categoria',
            'titulo.max' => 'El tamaño no debe ser mayor a 150 caracteres',
            'titulo.required' => 'El titulo es obligatorio',
            'contenido.required' => 'El contenido es obligatorio'
        ];

        $validator = Validator::make($request->all(), [
            'Categorias_id' => 'required|exists:categorias,id',
            'titulo' => 'required|max:150',
            'contenido' => 'required',
        ], $messages);

        if($validator->fails()){
            return response()->json([
                "status"=>"error",
                "operation"=>"error",
                "errors" =>$validator->errors()
            ], 400);
        }
        $date_=date("Y-m-d h:i:s",  strtotime('-5 hour'));
        $datoGuardado=Post::create(
            [
                'titulo'=>$datosPost['titulo'],
                'contenido'=>$datosPost['contenido'],
                'Categorias_id'=>$datosPost['Categorias_id'],
                'fecha_creacion'=>$date_,
                'fecha_actualizacion'=>$date_,
            ]
        );
        return response()->json([
            "status"=>"ok",
            "operation"=>"CREATED",
            "data"=>$datoGuardado
        ], 200);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function ver($id)
    {

        $datoMostrar=Post::where('id', $id)->get();
        $messageData= "NOT SHOW";
        if($datoMostrar){
            $messageData="SHOW";
        }

        return response()->json([
            "status"=>"ok",
            "operation"=>$messageData,
            "data"=>$datoMostrar
        ], 200);

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function edit(Post $post)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {

        if(!isset($id)){
            return response()->json([
                "status"=>"error",
                "operation"=>"error",
                "errors" =>["id"=>"Hace falta el id"]
            ], 400);
        }

        $messages = [
            'Categorias_id.exists'=>'No existe esa categoria',
            'titulo.max' => 'El tamaño no debe ser mayor a 150 caracteres',
            'titulo.required' => 'El titulo es obligatorio',
            'contenido.required' => 'El contenido es obligatorio'
        ];

        $validator = Validator::make($request->all(), [
            'Categorias_id' => 'required|exists:categorias,id',
            'titulo' => 'required|max:150',
            'contenido' => 'required',
        ], $messages);

        if($validator->fails()){
            return response()->json([
                "status"=>"error",
                "operation"=>"error",
                "errors" =>$validator->errors()
            ], 400);
        }

        $datosPost=request()->except('_token');
        $datoModificado= Post::where('id', '=', $id)->update(
                array(
                    'titulo'=>$datosPost['titulo'],
                    'contenido'=>$datosPost['contenido'],
                    'Categorias_id'=>$datosPost['Categorias_id'],
                    'fecha_actualizacion'=>date("Y-m-d h:i:s",  strtotime('-5 hour')),
                    )
        );
        $messageData= "NOT MODIFIED";
        if($datoModificado){
            $messageData="MODIFIED";
        }
        return response()->json([
            "status"=>"ok",
            "operation"=>$messageData,
            "data"=>$datoModificado
        ], 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        
        if(!isset($id)){
            return response()->json([
                "status"=>"error",
                "operation"=>"error",
                "errors" =>"Hace falta el id"
            ], 400);
        }

        try {
            $datoEliminado = Post::where('id', $id)->delete();
            $messageData= "NOT DELETED";
            if($datoEliminado){
                $messageData="DELETED";
            }
            return response()->json([
                "status"=>"ok",
                "operation"=>$messageData,
                "data"=>$datoEliminado
            ], 200);
        } catch (\Throwable $th) {
            return response()->json([
                "status"=>"error",
                "operation"=>"error",
                "data"=>''
            ], 502);
        }


    }
}
