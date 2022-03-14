<?php

namespace App\Http\Controllers;

use App\Models\Comentario;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ComentarioController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function verTodo(){
        $todosDatosComentario=Comentario::all();
        return response()->json([
            "status"=>"ok",
            "operation"=>"SHOW ALL",
            "data"=>$todosDatosComentario
        ], 200);

    }
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
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
        

        $datosPost=request()->except('_token');

        $messages = [
            'Posts_id.exists'=>'No existe ese post',
            'Posts_id.required'=>'El post es obligatorio',
            'contenido.max' => 'El tamaño no debe ser mayor a 500 caracteres',
            'contenido.required' => 'El titulo es obligatorio',
        ];

        $validator = Validator::make($request->all(), [
            'Posts_id' => 'required|exists:posts,id',
            'contenido' => 'required|max:500',
        ], $messages);

        if($validator->fails()){
            return response()->json([
                "status"=>"error",
                "operation"=>"error",
                "errors" =>$validator->errors()
            ], 400);
        }
        $date_=date("Y-m-d h:i:s",  strtotime('-5 hour'));
        $datoGuardado=Comentario::create(
            [
                'contenido'=>$datosPost['contenido'],
                'Posts_id'=>$datosPost['Posts_id'],
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
     * @param  \App\Models\Comentario  $comentario
     * @return \Illuminate\Http\Response
     */
    public function ver($id)
    {
        
        $datoMostrar=Comentario::where('id', $id)->get();
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
     * @param  \App\Models\Comentario  $comentario
     * @return \Illuminate\Http\Response
     */
    public function edit(Comentario $comentario)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Comentario  $comentario
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
            'Posts_id.exists'=>'No existe ese post',
            'Posts_id.required'=>'El post es obligatorio',
            'contenido.max' => 'El tamaño no debe ser mayor a 500 caracteres',
            'contenido.required' => 'El titulo es obligatorio',
        ];

        $validator = Validator::make($request->all(), [
            'Posts_id' => 'required|exists:posts,id',
            'contenido' => 'required|max:500',
        ], $messages);

        if($validator->fails()){
            return response()->json([
                "status"=>"error",
                "operation"=>"error",
                "errors" =>$validator->errors()
            ], 400);
        }
        $datosComentario=request()->except('_token');
        $datoModificado= Comentario::where('id', '=', $id)->update(
            array(
                'contenido'=>$datosComentario['contenido'],
                'Posts_id'=>$datosComentario['Posts_id'],
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
     * @param  \App\Models\Comentario  $comentario
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
        $datoEliminado = Comentario::where('id', $id)->delete();
        $messageData= "NOT DELETED";
        if($datoEliminado){
            $messageData="DELETED";
        }
        return response()->json([
            "status"=>"ok",
            "operation"=>$messageData,
            "data"=>$datoEliminado
        ], 200);
    }
}
