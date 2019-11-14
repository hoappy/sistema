<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
//use Illuminate\Support\Facades\DB;
use App\Licencia;

class LicenciaController extends Controller
{
    
    public function index(Request $request)
    {
        if (!$request->ajax()) return redirect('/');

        $buscar = $request->buscar;
        $criterio = $request->criterio;
        
        if ($buscar==''){
            $licencias = Licencia::orderBy('estado', 'desc')->paginate(15);
        }
        else{
            $licencias = Licencia::where($criterio, 'like', '%'. $buscar . '%')->orderBy('estado', 'desc')->paginate(15);
        }
        

        return [
            'pagination' => [
                'total'        => $licencias->total(),
                'current_page' => $licencias->currentPage(),
                'per_page'     => $licencias->perPage(),
                'last_page'    => $licencias->lastPage(),
                'from'         => $licencias->firstItem(),
                'to'           => $licencias->lastItem(),
            ],
            'licencias' => $licencias
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
        $licencia = new Licencia();
        $licencia->id_empleado = $request->id_empleado;
        $licencia->causa = $request->causa;
        $licencia->fechaInicio = $request->fechaInicio;
        
        $licencia->fechaFin = $request->fechaFin;
        $licencia->descripcion = $request->descripcion;
        
        $licencia->estado = '1';
        $licencia->save();
    }
  

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id_licencia
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        if (!$request->ajax()) return redirect('/');
        $licencia = Licencia::findOrFail($request->id_licencia);
        $licencia->id_empleado = $request->id_empleado;
        $licencia->causa = $request->causa;
        $licencia->fechaInicio = $request->fechaInicio;
        
        $licencia->fechaFin = $request->fechaFin;
        $licencia->descripcion = $request->descripcion;
        
        $licencia->estado = '1';
        $licencia->save();
    }

    public function desactivar(Request $request)
    {
        if (!$request->ajax()) return redirect('/');
        $licencia = Licencia::findOrFail($request->id_licencia);
        $licencia->estado = '0';
        $licencia->save();
    }

    public function activar(Request $request)
    {
        if (!$request->ajax()) return redirect('/');
        $licencia = Licencia::findOrFail($request->id_licencia);
        $licencia->estado = '1';
        $licencia->save();
    }
}
