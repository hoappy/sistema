<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
//use Illuminate\Support\Facades\DB;
use App\TablaDeValores;

class TablaDeValoresController extends Controller
{
    
    public function selectTablaDeValores(Request $request){
        if (!$request->ajax()) return redirect('/');
        $tablaDeValoress = TablaDeValores::where('estado','=','1')
        ->select('*')->orderBy('id_tablaValor', 'asc')->get();
        return ['tablaDeValoress' => $TablaDeValoress];
    }

    public function index(Request $request)
    {
        if (!$request->ajax()) return redirect('/');

        $buscar = $request->buscar;
        $criterio = $request->criterio;
        
        if ($buscar==''){
            $tablaDeValoress = TablaDeValores::orderBy('estado', 'desc')->paginate(15);
        }
        else{
            $tablaDeValoress = TablaDeValores::where($criterio, 'like', '%'. $buscar . '%')->orderBy('estado', 'desc')->paginate(15);
        }
        

        return [
            'pagination' => [
                'total'        => $tablaDeValoress->total(),
                'current_page' => $tablaDeValoress->currentPage(),
                'per_page'     => $tablaDeValoress->perPage(),
                'last_page'    => $tablaDeValoress->lastPage(),
                'from'         => $tablaDeValoress->firstItem(),
                'to'           => $tablaDeValoress->lastItem(),
            ],
            'tablaDeValoress' => $tablaDeValoress
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
        $tablaDeValores = new TablaDeValores();
        $tablaDeValores->tipoValor = $request->tipoValor;
        $tablaDeValores->descripcion = $request->descripcion;
        $tablaDeValores->tipo = $request->tipo;
        $tablaDeValores->valor = $request->valor;
        $tablaDeValores->estado = '1';
        $tablaDeValores->save();
    }
  

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id_tablaDeValores
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        if (!$request->ajax()) return redirect('/');
        $tablaDeValores = TablaDeValores::findOrFail($request->id_tablaValor);
        $tablaDeValores->tipoValor = $request->tipoValor;
        $tablaDeValores->descripcion = $request->descripcion;
        $tablaDeValores->tipo = $request->tipo;
        $tablaDeValores->valor = $request->valor;
        $tablaDeValores->estado = '1';
        $tablaDeValores->save();
    }

    public function desactivar(Request $request)
    {
        if (!$request->ajax()) return redirect('/');
        $tablaDeValores = TablaDeValores::findOrFail($request->id_tablaValor);
        $tablaDeValores->estado = '0';
        $tablaDeValores->save();
    }

    public function activar(Request $request)
    {
        if (!$request->ajax()) return redirect('/');
        $tablaDeValores = TablaDeValores::findOrFail($request->id_tablaValor);
        $tablaDeValores->estado = '1';
        $tablaDeValores->save();
    }
}
