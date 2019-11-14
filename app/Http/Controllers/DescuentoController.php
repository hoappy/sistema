<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
//use Illuminate\Support\Facades\DB;
use App\Descuento;

class DescuentoController extends Controller
{
    
    public function selectDescuento(Request $request){
        if (!$request->ajax()) return redirect('/');
        $descuentos = Descuento::where('estado','=','1')
        ->select('id_descuento')->orderBy('id_descuento', 'asc')->get();
        return ['descuentos' => $descuentos];
    }
   
    public function index(Request $request)
    {
        if (!$request->ajax()) return redirect('/');

        $buscar = $request->buscar;
        $criterio = $request->criterio;
        
        if ($buscar==''){
            $descuentos = Descuento::join('liquidacion','descuento.id_liquidacion','=','liquidacion.id_liquidacion')
            ->join('empleado','empleado.id_empleado','=','liquidacion.id_empleado')
            ->select('empleado.rut as rut', 'empleado.dv as dv','descuento.*',
            'empleado.nombre as nombre','empleado.apellido1 as apellido1','empleado.apellido2 as apellido2',
            'liquidacion.fecha as fecha'
                )
            ->orderBy('estado', 'desc')->paginate(15);
        }
        else{
            $descuentos = Descuento::join('liquidacion','descuento.id_liquidacion','=','liquidacion.id_liquidacion')
            ->join('empleado','empleado.id_empleado','=','liquidacion.id_empleado')
            ->select('empleado.rut as rut', 'empleado.dv as dv','descuento.*',
            'empleado.nombre as nombre','empleado.apellido1 as apellido1','empleado.apellido2 as apellido2',
            'liquidacion.fecha as fecha'
                )
                ->where($criterio, 'like', '%'. $buscar . '%')
                ->orderBy('estado', 'desc')->paginate(15);
        }
        

        return [
            'pagination' => [
                'total'        => $descuentos->total(),
                'current_page' => $descuentos->currentPage(),
                'per_page'     => $descuentos->perPage(),
                'last_page'    => $descuentos->lastPage(),
                'from'         => $descuentos->firstItem(),
                'to'           => $descuentos->lastItem(),
            ],
            'descuentos' => $descuentos
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
        $descuento = new Descuento();
        $descuento->id_liquidacion = $request->id_liquidacion;
        $descuento->descripcion = $request->descripcion;
        $descuento->tipo = $request->tipo;
        $descuento->valor = $request->valor;
        $descuento->estado = '1';
        $descuento->save();
    }
  

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id_descuento
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        if (!$request->ajax()) return redirect('/');
        $descuento = Descuento::findOrFail($request->id_descuento);
        $descuento->id_liquidacion = $request->id_liquidacion;
        $descuento->descripcion = $request->descripcion;
        $descuento->tipo = $request->tipo;
        $descuento->valor = $request->valor;
        $descuento->estado = '1';
        $descuento->save();
    }

    public function desactivar(Request $request)
    {
        if (!$request->ajax()) return redirect('/');
        $descuento = Descuento::findOrFail($request->id_descuento);
        $descuento->estado = '0';
        $descuento->save();
    }

    public function activar(Request $request)
    {
        if (!$request->ajax()) return redirect('/');
        $descuento = Descuento::findOrFail($request->id_descuento);
        $descuento->estado = '1';
        $descuento->save();
    }
}
