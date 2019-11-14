<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
//use Illuminate\Support\Facades\DB;
use App\Finiquito;

class FiniquitoController extends Controller
{
    
    public function index(Request $request)
    {
        if (!$request->ajax()) return redirect('/');

        $buscar = $request->buscar;
        $criterio = $request->criterio;
        
        if ($buscar==''){
            $finiquitos = Finiquito::join('empleado','finiquito.id_empleado','=','empleado.id_empleado')
            ->select('finiquito.*', 'empleado.rut as rut','empleado.dv as dv','empleado.nombre as nombre','empleado.apellido1 as apellido1','empleado.apellido2 as apellido2'
                )
            ->orderBy('finiquito.estado', 'desc')->paginate(15);
        }
        else{
            $finiquitos = Finiquito::join('empleado','finiquito.id_empleado','=','empleado.id_empleado')
            ->select('finiquito.*', 'empleado.rut as rut','empleado.dv as dv','empleado.nombre as nombre','empleado.apellido1 as apellido1','empleado.apellido2 as apellido2'
                )
            ->where($criterio, 'like', '%'. $buscar . '%')
            ->orderBy('estado', 'desc')->paginate(15);
        }
        

        return [
            'pagination' => [
                'total'        => $finiquitos->total(),
                'current_page' => $finiquitos->currentPage(),
                'per_page'     => $finiquitos->perPage(),
                'last_page'    => $finiquitos->lastPage(),
                'from'         => $finiquitos->firstItem(),
                'to'           => $finiquitos->lastItem(),
            ],
            'finiquitos' => $finiquitos
        ];
    }   

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if (!$request->ajax()) return redirect('/');
        $finiquito = new Finiquito();
        $finiquito->id_empleado = $request->id_empleado;
        $finiquito->causa = $request->causa;
        $finiquito->fechaAviso = $request->fechaAviso;
        $finiquito->articulo = $request->articulo;
        
        $finiquito->fechaTermino = $request->fechaTermino;
        $finiquito->detalle = $request->detalle;
        
        $finiquito->estado = '1';
        $finiquito->save();
    }
  

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id_finiquito
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        if (!$request->ajax()) return redirect('/');
        $finiquito = Finiquito::findOrFail($request->id_finiquito);
        $finiquito->id_empleado = $request->id_empleado;
        $finiquito->causa = $request->causa;
        $finiquito->articulo = $request->articulo;
        $finiquito->fechaAviso = $request->fechaAviso;
        
        $finiquito->fechaTermino = $request->fechaTermino;
        $finiquito->detalle = $request->detalle;
        
        $finiquito->estado = '1';
        $finiquito->save();
    }

    public function desactivar(Request $request)
    {
        if (!$request->ajax()) return redirect('/');
        $finiquito = Finiquito::findOrFail($request->id_finiquito);
        $finiquito->estado = '0';
        $finiquito->save();
    }

    public function activar(Request $request)
    {
        if (!$request->ajax()) return redirect('/');
        $finiquito = Finiquito::findOrFail($request->id_finiquito);
        $finiquito->estado = '1';
        $finiquito->save();
    }
}
