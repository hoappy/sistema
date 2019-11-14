<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
//use Illuminate\Support\Facades\DB;
use App\Haber;

class HaberController extends Controller
{
    public function selectHaber(Request $request){
        if (!$request->ajax()) return redirect('/');
        $habers = Haber::where('estado','=','1')
        ->select('id_haber')->orderBy('id_haber', 'asc')->get();
        return ['habers' => $habers];
    }

    public function index(Request $request)
    {
        if (!$request->ajax()) return redirect('/');

        $buscar = $request->buscar;
        $criterio = $request->criterio;
        
        if ($buscar==''){
            $habers = Haber::join('liquidacion','haber.id_liquidacion','=','liquidacion.id_liquidacion')
            ->join('empleado','empleado.id_empleado','=','liquidacion.id_empleado')
            ->select('empleado.rut as rut', 'empleado.dv as dv','haber.*',
            'empleado.nombre as nombre','empleado.apellido1 as apellido1','empleado.apellido2 as apellido2',
            'liquidacion.fecha as fecha'
                )
            ->orderBy('estado', 'desc')->paginate(15);
        }
        else{
            $habers = Haber::$habers = Haber::join('liquidacion','haber.id_liquidacion','=','liquidacion.id_liquidacion')
            ->join('empleado','empleado.id_empleado','=','liquidacion.id_empleado')
            ->select('empleado.rut as rut', 'empleado.dv as dv','haber.*',
            'empleado.nombre as nombre','empleado.apellido1 as apellido1','empleado.apellido2 as apellido2',
            'liquidacion.fecha as fecha'
                )
                ->where($criterio, 'like', '%'. $buscar . '%')
                ->orderBy('estado', 'desc')->paginate(15);
        }
        

        return [
            'pagination' => [
                'total'        => $habers->total(),
                'current_page' => $habers->currentPage(),
                'per_page'     => $habers->perPage(),
                'last_page'    => $habers->lastPage(),
                'from'         => $habers->firstItem(),
                'to'           => $habers->lastItem(),
            ],
            'habers' => $habers
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
        $haber = new Haber();
        $haber->id_liquidacion = $request->id_liquidacion;
        $haber->descripcion = $request->descripcion;
        $haber->tipo = $request->tipo;
        $haber->valor = $request->valor;
        $haber->estado = '1';
        $haber->save();
    }
  

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id_haber
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        if (!$request->ajax()) return redirect('/');
        $haber = Haber::findOrFail($request->id_haber);
        $haber->id_liquidacion = $request->id_liquidacion;
        $haber->descripcion = $request->descripcion;
        $haber->tipo = $request->tipo;
        $haber->valor = $request->valor;
        $haber->estado = '1';
        $haber->save();
    }

    public function desactivar(Request $request)
    {
        if (!$request->ajax()) return redirect('/');
        $haber = Haber::findOrFail($request->id_haber);
        $haber->estado = '0';
        $haber->save();
    }

    public function activar(Request $request)
    {
        if (!$request->ajax()) return redirect('/');
        $haber = Haber::findOrFail($request->id_haber);
        $haber->estado = '1';
        $haber->save();
    }
}
