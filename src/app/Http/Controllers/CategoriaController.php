<?php

namespace App\Http\Controllers;

use App\Models\Categoria;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class CategoriaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function verTodo(){

        $todosDatosCategoria=Categoria::all();
        return response()->json([
            "status"=>"ok",
            "operation"=>"SHOW ALL DATA",
            "data"=>$todosDatosCategoria
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
        $datosCategoria=request()->except('_token');

        $messages = [
            'nombre.required'=>'El nombre es obligatorio',
            'nombre.max' => 'El tamaño no debe ser mayor a 150 caracteres'
        ];

        $validator = Validator::make($request->all(), [
            'nombre' => 'required|max:150',
        ], $messages);

        if($validator->fails()){
            return response()->json([
                "status"=>"error",
                "operation"=>"error",
                "errors" =>$validator->errors()
            ], 400);
        }
        $date_=date("Y-m-d h:i:s",  strtotime('-5 hour'));
        $datoGuardado=Categoria::create(
            [
                'nombre'=>$datosCategoria['nombre'],
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
     * @param  \App\Models\Categoria  $categoria
     * @return \Illuminate\Http\Response
     */
    public function ver($id)
    {
        //
        $datoMostrar=Categoria::where('id', $id)->get();

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
     * @param  \App\Models\Categoria  $categoria
     * @return \Illuminate\Http\Response
     */
    public function edit(Categoria $categoria)
    {
        
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Categoria  $categoria
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
            'nombre.required'=>'El nombre es obligatorio',
            'nombre.max' => 'El tamaño no debe ser mayor a 150 caracteres'
        ];

        $validator = Validator::make($request->all(), [
            'nombre' => 'required|max:150',
        ], $messages);

        
        if($validator->fails()){
            return response()->json([
                "status"=>"error",
                "operation"=>"error",
                "errors" =>$validator->errors()
            ], 400);
        }

        $datosCategoria=request()->except('_token');
        $datoModificado= Categoria::where('id', '=', $id)->update(
                array(
                    'nombre'=>$datosCategoria['nombre'],
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
     * @param  \App\Models\Categoria  $categoria
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
        $datoEliminado = Categoria::where('id', $id)->delete();
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
