<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
//use Illuminate\Support\Facades\DB;
use App\Sucursal;

class SucursalController extends Controller
{
    
    public function selectSucursal(Request $request){
        if (!$request->ajax()) return redirect('/');
        $sucursals = Sucursal::where('estado','=','1')
        ->select('id_sucursal','nombre')->orderBy('nombre', 'asc')->get();
        return ['sucursals' => $sucursals];
    }
    
    public function index(Request $request)
    {
        if (!$request->ajax()) return redirect('/');

        $buscar = $request->buscar;
        $criterio = $request->criterio;
        
        if ($buscar==''){
            $sucursals = Sucursal::orderBy('estado', 'desc')->paginate(15);
        }
        else{
            $sucursals = Sucursal::where($criterio, 'like', '%'. $buscar . '%')->orderBy('estado', 'desc')->paginate(15);
        }
        

        return [
            'pagination' => [
                'total'        => $sucursals->total(),
                'current_page' => $sucursals->currentPage(),
                'per_page'     => $sucursals->perPage(),
                'last_page'    => $sucursals->lastPage(),
                'from'         => $sucursals->firstItem(),
                'to'           => $sucursals->lastItem(),
            ],
            'sucursals' => $sucursals
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
        $sucursal = new Sucursal();
        $sucursal->id_empresa = $request->id_empresa;
        $sucursal->nombre = $request->nombre;
        $sucursal->telefono = $request->telefono;
        $sucursal->direccion = $request->direccion;
        $sucursal->comuna = $request->comuna;
        $sucursal->ciudad = $request->ciudad;
        $sucursal->region = $request->region;
        $sucursal->estado = '1';
        $sucursal->save();
    }
  

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id_sucursal
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        if (!$request->ajax()) return redirect('/');
        $sucursal = Sucursal::findOrFail($request->id_sucursal);
        $sucursal->id_empresa = $request->id_empresa;
        $sucursal->nombre = $request->nombre;
        $sucursal->telefono = $request->telefono;
        $sucursal->direccion = $request->direccion;
        $sucursal->comuna = $request->comuna;
        $sucursal->ciudad = $request->ciudad;
        $sucursal->region = $request->region;
        $sucursal->estado = '1';
        $sucursal->save();
    }

    public function desactivar(Request $request)
    {
        if (!$request->ajax()) return redirect('/');
        $sucursal = Sucursal::findOrFail($request->id_sucursal);
        $sucursal->estado = '0';
        $sucursal->save();
    }

    public function activar(Request $request)
    {
        if (!$request->ajax()) return redirect('/');
        $sucursal = Sucursal::findOrFail($request->id_sucursal);
        $sucursal->estado = '1';
        $sucursal->save();
    }
}
