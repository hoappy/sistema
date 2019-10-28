<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
//use Illuminate\Support\Facades\DB;
use App\Empleado;

class EmpleadoController extends Controller
{
    
    public function index(Request $request)
    {
        if (!$request->ajax()) return redirect('/');

        $buscar = $request->buscar;
        $criterio = $request->criterio;
        
        if ($buscar==''){
            $empleados = Empleado::join('afp','empleado.id_afp','=','afp.id_afp')
            ->join('salud','empleado.id_salud','=','salud.id_salud')
            ->select('empleado.*','salud.nombre as salud','salud.valor as valorSalud','afp.nombre as afp','afp.valor as valorA'
                )
            ->orderBy('empleado.estado', 'desc')->paginate(15);
        }
        else{
            $empleados = Empleado::join('afp','empleado.id_afp','=','afp.id_afp')
            ->join('salud','empleado.id_salud','=','salud.id_salud')
            ->select('empleado.*','salud.nombre as salud','salud.valor as valorSalud','afp.nombre as afp','afp.valor as valorA'
                )
            ->where('empleado'.$criterio, 'like', '%'. $buscar . '%')
            ->orderBy('empleado.estado', 'desc')->paginate(15);
        }
        

        return [
            'pagination' => [
                'total'        => $empleados->total(),
                'current_page' => $empleados->currentPage(),
                'per_page'     => $empleados->perPage(),
                'last_page'    => $empleados->lastPage(),
                'from'         => $empleados->firstItem(),
                'to'           => $empleados->lastItem(),
            ],
            'empleados' => $empleados
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
        $empleado = new Empleado();
        $empleado->id_afp = $request->id_afp;
        $empleado->id_salud = $request->id_salud;
        $empleado->rut = $request->rut;
        $empleado->dv = $request->dv;
        $empleado->nombre = $request->nombre;
        $empleado->apellido1 = $request->apellido1;
        $empleado->apellido2 = $request->apellido2;
        $empleado->fechaNaci = $request->fechaNaci;
        $empleado->sexo = $request->sexo;
        $empleado->diasVacas = $request->diasVacas;
        $empleado->direccion = $request->direccion;
        $empleado->seguriCesantia = $request->seguriCesantia;
        $empleado->descuentosSalud = $request->descuentosSalud;
        $empleado->estaoCivil = $request->estaoCivil;
        $empleado->jornada = $request->jornada;
        $empleado->cargo = $request->cargo;
        $empleado->tipo = $request->tipo;
        $empleado->estado = '1';
        $empleado->save();
    }
  

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id_empleado
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        if (!$request->ajax()) return redirect('/');
        $empleado = Empleado::findOrFail($request->id_empleado);
        $empleado->id_afp = $request->id_afp;
        $empleado->id_salud = $request->id_salud;
        $empleado->rut = $request->rut;
        $empleado->dv = $request->dv;
        $empleado->nombre = $request->nombre;
        $empleado->apellido1 = $request->apellido1;
        $empleado->apellido2 = $request->apellido2;
        $empleado->fechaNaci = $request->fechaNaci;
        $empleado->sexo = $request->sexo;
        $empleado->diasVacas = $request->diasVacas;
        $empleado->direccion = $request->direccion;
        $empleado->seguriCesantia = $request->seguriCesantia;
        $empleado->descuentosSalud = $request->descuentosSalud;
        $empleado->estaoCivil = $request->estaoCivil;
        $empleado->jornada = $request->jornada;
        $empleado->cargo = $request->cargo;
        $empleado->tipo = $request->tipo;
        $empleado->estado = '1';
        $empleado->save();
    }

    public function desactivar(Request $request)
    {
        if (!$request->ajax()) return redirect('/');
        $empleado = Empleado::findOrFail($request->id_empleado);
        $empleado->estado = '0';
        $empleado->save();
    }

    public function activar(Request $request)
    {
        if (!$request->ajax()) return redirect('/');
        $empleado = Empleado::findOrFail($request->id_empleado);
        $empleado->estado = '1';
        $empleado->save();
    }
}
