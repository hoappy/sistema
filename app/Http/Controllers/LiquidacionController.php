<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
//use Illuminate\Support\Facades\DB;
use App\Liquidacion;

class LiquidacionController extends Controller
{
    
    public function selectLiquidacion(Request $request){
        if (!$request->ajax()) return redirect('/');
        $liquidacions = Liquidacion::where('estado','=','1')
        ->select('*')->orderBy('id_liquidacion', 'asc')->get();
        return ['liquidacions' => $liquidacions];
    }

    public function index(Request $request)
    {
        if (!$request->ajax()) return redirect('/');

        $buscar = $request->buscar;
        $criterio = $request->criterio;
        
        if ($buscar==''){
            $liquidacions = Liquidacion::join('empleado','empleado.id_empleado','=','liquidacion.id_empleado')
            ->join('contrato','contrato.id_empleado','=','empleado.id_empleado')
            ->join('empresa','empresa.id_empresa','=','contrato.id_empresa')
            ->select('empleado.rut as rutT', 'empleado.dv as dvT','liquidacion.*',
            'empleado.nombre as nombre','empleado.apellido1 as apellido1','empleado.apellido2 as apellido2',
            'liquidacion.fecha as fecha','empresa.rut as rutE', 'empresa.dv as dvE','empresa.razonSocial as razonSocial',
            'empresa.direccion as direccionE'
                )
            ->orderBy('estado', 'desc')->paginate(15);
        }
        else{
            $liquidacions = Liquidacion::join('empleado','empleado.id_empleado','=','liquidacion.id_empleado')
            ->join('contrato','contrato.id_empleado','=','empleado.id_empleado')
            ->join('empresa','empresa.id_empresa','=','contrato.id_empresa')
            ->select('empleado.rut as rutT', 'empleado.dv as dvT','liquidacion.*',
            'empleado.nombre as nombre','empleado.apellido1 as apellido1','empleado.apellido2 as apellido2',
            'liquidacion.fecha as fecha','empresa.rut as rutE', 'empresa.dv as dvE','empresa.razonSocial as razonSocial',
            'empresa.direccion as direccionE'
                )
            ->where($criterio, 'like', '%'. $buscar . '%')
            ->orderBy('estado', 'desc')->paginate(15);
        }
        

        return [
            'pagination' => [
                'total'        => $liquidacions->total(),
                'current_page' => $liquidacions->currentPage(),
                'per_page'     => $liquidacions->perPage(),
                'last_page'    => $liquidacions->lastPage(),
                'from'         => $liquidacions->firstItem(),
                'to'           => $liquidacions->lastItem(),
            ],
            'liquidacions' => $liquidacions
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
        $liquidacion = new Liquidacion();
        $liquidacion->id_empleado = $request->id_empleado;
        $liquidacion->detalle = $request->detalle;
        $liquidacion->fecha = $request->fecha;
        $liquidacion->totalImponible = $request->totalImponible;
        $liquidacion->movilizacion = $request->movilizacion;
        $liquidacion->diasTrabajados = $request->diasTrabajados;
        $liquidacion->horasExtra = $request->horasExtra;
        $liquidacion->ahorroVoluntario = $request->ahorroVoluntario;
        $liquidacion->totalImpuesto = $request->totalImpuesto;
        $liquidacion->totalDescuento = $request->totalDescuento;
        $liquidacion->totalLiquido = $request->totalLiquido;
        $liquidacion->totalColacion = $request->totalColacion;
        $liquidacion->totalLiquidacion = $request->totalLiquidacion;
        $liquidacion->totalHaberes = $request->totalHaberes;
        $liquidacion->gratificacion = $request->gratificacion;

        $liquidacion->estado = '1';
        $liquidacion->save();
    }
  

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id_liquidacion
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        if (!$request->ajax()) return redirect('/');
        $liquidacion = Liquidacion::findOrFail($request->id_liquidacion);
        $liquidacion->id_empleado = $request->id_empleado;
        $liquidacion->detalle = $request->detalle;
        $liquidacion->fecha = $request->fecha;
        $liquidacion->totalImponible = $request->totalImponible;
        $liquidacion->movilizacion = $request->movilizacion;
        $liquidacion->diasTrabajados = $request->diasTrabajados;
        $liquidacion->horasExtra = $request->horasExtra;
        $liquidacion->ahorroVoluntario = $request->ahorroVoluntario;
        $liquidacion->totalImpuesto = $request->totalImpuesto;
        $liquidacion->totalDescuento = $request->totalDescuento;
        $liquidacion->totalLiquido = $request->totalLiquido;
        $liquidacion->totalColacion = $request->totalColacion;
        $liquidacion->totalLiquidacion = $request->totalLiquidacion;
        $liquidacion->totalHaberes = $request->totalHaberes;
        $liquidacion->gratificacion = $request->gratificacion;

        $liquidacion->estado = '1';
        $liquidacion->save();
    }

    public function desactivar(Request $request)
    {
        if (!$request->ajax()) return redirect('/');
        $liquidacion = Liquidacion::findOrFail($request->id_liquidacion);
        $liquidacion->estado = '0';
        $liquidacion->save();
    }

    public function activar(Request $request)
    {
        if (!$request->ajax()) return redirect('/');
        $liquidacion = Liquidacion::findOrFail($request->id_liquidacion);
        $liquidacion->estado = '1';
        $liquidacion->save();
    }
}
