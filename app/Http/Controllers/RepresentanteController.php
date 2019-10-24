<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
//use Illuminate\Support\Facades\DB;
use App\Representante;

class RepresentanteController extends Controller
{
    
    public function index(Request $request)
    {
        if (!$request->ajax()) return redirect('/');

        $buscar = $request->buscar;
        $criterio = $request->criterio;
        
        if ($buscar==''){
            $representantes = Representante::orderBy('estado', 'desc')->paginate(15);
        }
        else{
            $representantes = Representante::where($criterio, 'like', '%'. $buscar . '%')->orderBy('estado', 'desc')->paginate(15);
        }
        

        return [
            'pagination' => [
                'total'        => $representantes->total(),
                'current_page' => $representantes->currentPage(),
                'per_page'     => $representantes->perPage(),
                'last_page'    => $representantes->lastPage(),
                'from'         => $representantes->firstItem(),
                'to'           => $representantes->lastItem(),
            ],
            'representantes' => $representantes
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
        $representante = new Representante();
        $representante->rut = $request->rut;
        $representante->dv = $request->dv;
        $representante->nombre = $request->nombre;
        $representante->apellido1 = $request->apellido1;
        $representante->apellido2 = $request->apellido2;
        $representante->estado = '1';
        $representante->save();
    }
  

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id_representante
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        if (!$request->ajax()) return redirect('/');
        $representante = Representante::findOrFail($request->id_representante);
        $representante->rut = $request->rut;
        $representante->dv = $request->dv;
        $representante->nombre = $request->nombre;
        $representante->apellido1 = $request->apellido1;
        $representante->apellido2 = $request->apellido2;
        $representante->estado = '1';
        $representante->save();
    }

    public function desactivar(Request $request)
    {
        if (!$request->ajax()) return redirect('/');
        $representante = Representante::findOrFail($request->id_representante);
        $representante->estado = '0';
        $representante->save();
    }

    public function activar(Request $request)
    {
        if (!$request->ajax()) return redirect('/');
        $representante = Representante::findOrFail($request->id_representante);
        $representante->estado = '1';
        $representante->save();
    }
}
