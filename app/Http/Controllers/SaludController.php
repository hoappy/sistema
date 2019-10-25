<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
//use Illuminate\Support\Facades\DB;
use App\Salud;

class SaludController extends Controller
{
    public function selectSalud(Request $request){
        if (!$request->ajax()) return redirect('/');
        $saluds = Salud::where('estado','=','1')
        ->select('id_salud','nombre')->orderBy('nombre', 'asc')->get();
        return ['saluds' => $saluds];
    }

    public function index(Request $request)
    {
        if (!$request->ajax()) return redirect('/');

        $buscar = $request->buscar;
        $criterio = $request->criterio;
        
        if ($buscar==''){
            $saluds = Salud::orderBy('estado', 'desc')->paginate(15);
        }
        else{
            $saluds = Salud::where($criterio, 'like', '%'. $buscar . '%')->orderBy('estado', 'desc')->paginate(15);
        }
        

        return [
            'pagination' => [
                'total'        => $saluds->total(),
                'current_page' => $saluds->currentPage(),
                'per_page'     => $saluds->perPage(),
                'last_page'    => $saluds->lastPage(),
                'from'         => $saluds->firstItem(),
                'to'           => $saluds->lastItem(),
            ],
            'saluds' => $saluds
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
        $salud = new Salud();
        $salud->nombre = $request->nombre;
        $salud->descripcion = $request->descripcion;
        $salud->provision = $request->provision;
        $salud->estado = '1';
        $salud->save();
    }
  

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id_salud
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        if (!$request->ajax()) return redirect('/');
        $salud = Salud::findOrFail($request->id_salud);
        $salud->nombre = $request->nombre;
        $salud->descripcion = $request->descripcion;
        $salud->provision = $request->provision;
        $salud->estado = '1';
        $salud->save();
    }

    public function desactivar(Request $request)
    {
        if (!$request->ajax()) return redirect('/');
        $salud = Salud::findOrFail($request->id_salud);
        $salud->estado = '0';
        $salud->save();
    }

    public function activar(Request $request)
    {
        if (!$request->ajax()) return redirect('/');
        $salud = Salud::findOrFail($request->id_salud);
        $salud->estado = '1';
        $salud->save();
    }

    
}
