<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
//use Illuminate\Support\Facades\DB;
use App\Contrato;

class ContratoController extends Controller
{
    
    public function index(Request $request)
    {
        if (!$request->ajax()) return redirect('/');

        $buscar = $request->buscar;
        $criterio = $request->criterio;
        
        if ($buscar==''){
            $contratos = Contrato::join('empresa','contrato.id_empresa','=','empresa.id_empresa')
            ->join('empleado','contrato.id_empleado','=','empleado.id_empleado')
            ->join('sucursal','contrato.id_sucursal','=','sucursal.id_sucursal')
            ->select('contrato.*', 'empleado.rut as rutT','empleado.dv as dvT','empleado.nombre as nombre','empleado.apellido1 as apellido1',
            'empleado.apellido2 as apellido2', 'empresa.rut as rutE','empresa.dv as dvE', 'empresa.razonSocial as razonSocial','sucursal.nombre as sucursal'
                )
            ->orderBy('contrato.estado', 'desc')->paginate(15);
        
        }
        else{
            $contratos = Contrato::$contratos = Contrato::join('empresa','contrato.id_empresa','=','empresa.id_empresa')
            ->join('empleado','contrato.id_empleado','=','empleado.id_empleado')
            ->join('sucursal','contrato.id_sucursal','=','sucursal.id_sucursal')
            ->select('contrato.*', 'empleado.rut as rutE','empleado.dv as dvE','empleado.nombre as nombre','empleado.apellido1 as apellido1',
            'empleado.apellido2 as apellido2', 'empresa.rut as rut','empresa.dvE as dv', 'empresa.razonSocial as razonSocial'
                )
            ->where($criterio, 'like', '%'. $buscar . '%')
            ->orderBy('estado', 'desc')->paginate(15);
        }
        

        return [
            'pagination' => [
                'total'        => $contratos->total(),
                'current_page' => $contratos->currentPage(),
                'per_page'     => $contratos->perPage(),
                'last_page'    => $contratos->lastPage(),
                'from'         => $contratos->firstItem(),
                'to'           => $contratos->lastItem(),
            ],
            'contratos' => $contratos
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
        $contrato = new Contrato();
        $contrato->id_empleado = $request->id_empleado;
        $contrato->id_empresa = $request->id_empresa;
        $contrato->id_sucursal = $request->id_sucursal;
        $contrato->fechaInicio = $request->fechaInicio;
        $contrato->sueldoBase = $request->sueldoBase;
        $contrato->fechaFin = $request->fechaFin;
        $contrato->colacion = $request->colacion;
        $contrato->detalle = $request->detalle;
        $contrato->estado = '1';
        $contrato->save();
    }
  

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id_contrato
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        if (!$request->ajax()) return redirect('/');
        $contrato = Contrato::findOrFail($request->id_contrato);
        $contrato->id_empleado = $request->id_empleado;
        $contrato->id_sucursal = $request->id_sucursal;
        $contrato->id_empresa = $request->id_empresa;
        $contrato->fechaInicio = $request->fechaInicio;
        $contrato->sueldoBase = $request->sueldoBase;
        $contrato->fechaFin = $request->fechaFin;
        $contrato->colacion = $request->colacion;
        $contrato->detalle = $request->detalle;
        $contrato->estado = '1';
        $contrato->save();
    }

    public function desactivar(Request $request)
    {
        if (!$request->ajax()) return redirect('/');
        $contrato = Contrato::findOrFail($request->id_contrato);
        $contrato->estado = '0';
        $contrato->save();
    }

    public function activar(Request $request)
    {
        if (!$request->ajax()) return redirect('/');
        $contrato = Contrato::findOrFail($request->id_contrato);
        $contrato->estado = '1';
        $contrato->save();
    }
}
