<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
//use Illuminate\Support\Facades\DB;
use App\Afp;

class AfpController extends Controller
{
    public function selectAfp(Request $request){
        if (!$request->ajax()) return redirect('/');
        $afps = Afp::where('estado','=','1')
        ->select('id_afp','nombre','valor')->orderBy('nombre', 'asc')->get();
        return ['afps' => $afps];
    }

    public function index(Request $request)
    {
        if (!$request->ajax()) return redirect('/');

        $buscar = $request->buscar;
        $criterio = $request->criterio;
        
        if ($buscar==''){
            $afps = Afp::orderBy('estado', 'desc')->paginate(15);
        }
        else{
            $afps = Afp::where($criterio, 'like', '%'. $buscar . '%')->orderBy('estado', 'desc')->paginate(15);
        }
        

        return [
            'pagination' => [
                'total'        => $afps->total(),
                'current_page' => $afps->currentPage(),
                'per_page'     => $afps->perPage(),
                'last_page'    => $afps->lastPage(),
                'from'         => $afps->firstItem(),
                'to'           => $afps->lastItem(),
            ],
            'afps' => $afps
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
        $afp = new Afp();
        $afp->nombre = $request->nombre;
        $afp->descripcion = $request->descripcion;
        $afp->valor = $request->valor;
        $afp->estado = '1';
        $afp->save();
    }
  

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id_afp
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        if (!$request->ajax()) return redirect('/');
        $afp = Afp::findOrFail($request->id_afp);
        $afp->nombre = $request->nombre;
        $afp->descripcion = $request->descripcion;
        $afp->valor = $request->valor;
        $afp->estado = '1';
        $afp->save();
    }

    public function desactivar(Request $request)
    {
        if (!$request->ajax()) return redirect('/');
        $afp = Afp::findOrFail($request->id_afp);
        $afp->estado = '0';
        $afp->save();
    }

    public function activar(Request $request)
    {
        if (!$request->ajax()) return redirect('/');
        $afp = Afp::findOrFail($request->id_afp);
        $afp->estado = '1';
        $afp->save();
    }

    
}
