<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
//use Illuminate\Support\Facades\DB;
use App\Cdc;

class CdcController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if (!$request->ajax()) return redirect('/');

        $buscar = $request->buscar;
        $criterio = $request->criterio;
        
        if ($buscar==''){
            $cdcs = Cdc::orderBy('id_cdc', 'desc')->paginate(10);
        }
        else{
            $cdcs = Cdc::where($criterio, 'like', '%'. $buscar . '%')->orderBy('id_cdc', 'desc')->paginate(15);
        }
        

        return [
            'pagination' => [
                'total'        => $cdcs->total(),
                'current_page' => $cdcs->currentPage(),
                'per_page'     => $cdcs->perPage(),
                'last_page'    => $cdcs->lastPage(),
                'from'         => $cdcs->firstItem(),
                'to'           => $cdcs->lastItem(),
            ],
            'cdcs' => $cdcs
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
        $cdc = new Cdc();
        $cdc->nombre = $request->nombre;
        $cdc->descripcion = $request->descripcion;
        $cdc->valor = $request->valor;
        $cdc->estado = '1';
        $cdc->save();
    }
  

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id_cdc
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        if (!$request->ajax()) return redirect('/');
        $cdc = Cdc::findOrFail($request->id_cdc);
        $cdc->nombre = $request->nombre;
        $cdc->descripcion = $request->descripcion;
        $cdc->valor = $request->valor;
        $cdc->estado = '1';
        $cdc->save();
    }

    public function desactivar(Request $request)
    {
        if (!$request->ajax()) return redirect('/');
        $cdc = Cdc::findOrFail($request->id_cdc);
        $cdc->estado = '0';
        $cdc->save();
    }

    public function activar(Request $request)
    {
        if (!$request->ajax()) return redirect('/');
        $cdc = Cdc::findOrFail($request->id_cdc);
        $cdc->estado = '1';
        $cdc->save();
    }

    
}
