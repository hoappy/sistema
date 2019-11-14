<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
//use Illuminate\Support\Facades\DB;
use App\Carga;

class CargaController extends Controller
{
    
    public function index(Request $request)
    {
        if (!$request->ajax()) return redirect('/');

        $buscar = $request->buscar;
        $criterio = $request->criterio;
        
        if ($buscar==''){
            $cargas = Carga::join('empleado','carga.id_empleado','=','empleado.id_empleado')
            ->select('carga.*', 'empleado.rut as rut','empleado.dv as dv','empleado.nombre as nombre','empleado.apellido1 as apellido1','empleado.apellido2 as apellido2'
                )
            ->orderBy('carga.estado', 'desc')->paginate(15);
        }
        else{
            $cargas = Carga::join('empleado','carga.id_empleado','=','empleado.id_empleado')
            ->select('carga.*', 'empleado.rut as rut','empleado.dv as dv','empleado.nombre as nombre','empleado.apellido1 as apellido1','empleado.apellido2 as apellido2'
                )
            ->where($criterio, 'like', '%'. $buscar . '%')
            ->orderBy('estado', 'desc')->paginate(15);
        }
        

        return [
            'pagination' => [
                'total'        => $cargas->total(),
                'current_page' => $cargas->currentPage(),
                'per_page'     => $cargas->perPage(),
                'last_page'    => $cargas->lastPage(),
                'from'         => $cargas->firstItem(),
                'to'           => $cargas->lastItem(),
            ],
            'cargas' => $cargas
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
        $carga = new Carga();
        $carga->id_empleado = $request->id_empleado;
        $carga->inicioTramo = $request->inicioTramo;
        $carga->finTramo = $request->finTramo;
        $carga->descripcion = $request->descripcion;
        $carga->valor = $request->valor;
        $carga->estado = '1';
        $carga->save();
    }
  

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id_carga
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        if (!$request->ajax()) return redirect('/');
        $carga = Carga::findOrFail($request->id_carga);
        $carga->id_empleado = $request->id_empleado;
        $carga->inicioTramo = $request->inicioTramo;
        $carga->finTramo = $request->finTramo;
        $carga->descripcion = $request->descripcion;
        $carga->valor = $request->valor;
        $carga->estado = '1';
        $carga->save();
    }

    public function desactivar(Request $request)
    {
        if (!$request->ajax()) return redirect('/');
        $carga = Carga::findOrFail($request->id_carga);
        $carga->estado = '0';
        $carga->save();
    }

    public function activar(Request $request)
    {
        if (!$request->ajax()) return redirect('/');
        $carga = Carga::findOrFail($request->id_carga);
        $carga->estado = '1';
        $carga->save();
    }
}
