<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
//use Illuminate\Support\Facades\DB;
use App\Mutual;

class MutualController extends Controller
{
    public function selectMutual(Request $request){
        if (!$request->ajax()) return redirect('/');
        $mutuals = Mutual::where('estado','=','1')
        ->select('id_mutual','nombre')->orderBy('nombre', 'asc')->get();
        return ['mutuals' => $mutuals];
    }
    
    public function index(Request $request)
    {
        if (!$request->ajax()) return redirect('/');

        $buscar = $request->buscar;
        $criterio = $request->criterio;
        
        if ($buscar==''){
            $mutuals = Mutual::orderBy('estado', 'desc')->paginate(15);
        }
        else{
            $mutuals = Mutual::where($criterio, 'like', '%'. $buscar . '%')->orderBy('estado', 'desc')->paginate(15);
        }
        

        return [
            'pagination' => [
                'total'        => $mutuals->total(),
                'current_page' => $mutuals->currentPage(),
                'per_page'     => $mutuals->perPage(),
                'last_page'    => $mutuals->lastPage(),
                'from'         => $mutuals->firstItem(),
                'to'           => $mutuals->lastItem(),
            ],
            'mutuals' => $mutuals
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
        $mutual = new Mutual();
        $mutual->nombre = $request->nombre;
        $mutual->descripcion = $request->descripcion;
        $mutual->estado = '1';
        $mutual->save();
    }
  

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id_mutual
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        if (!$request->ajax()) return redirect('/');
        $mutual = Mutual::findOrFail($request->id_mutual);
        $mutual->nombre = $request->nombre;
        $mutual->descripcion = $request->descripcion;
        $mutual->estado = '1';
        $mutual->save();
    }

    public function desactivar(Request $request)
    {
        if (!$request->ajax()) return redirect('/');
        $mutual = Mutual::findOrFail($request->id_mutual);
        $mutual->estado = '0';
        $mutual->save();
    }

    public function activar(Request $request)
    {
        if (!$request->ajax()) return redirect('/');
        $mutual = Mutual::findOrFail($request->id_mutual);
        $mutual->estado = '1';
        $mutual->save();
    }
}
