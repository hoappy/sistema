<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
//use Illuminate\Support\Facades\DB;
use App\Empresa;

class EmpresaController extends Controller
{
    
    public function index(Request $request)
    {
        if (!$request->ajax()) return redirect('/');

        $buscar = $request->buscar;
        $criterio = $request->criterio;
        
        if ($buscar==''){
            $empresas = Empresa::join('representante','empresa.id_representante','=','representante.id_representante')
            ->join('mutual','empresa.id_mutual','=','mutual.id_mutual')
            ->join('cdc','empresa.id_cdc','=','cdc.id_cdc')
            ->select('empresa.id_empresa','empresa.id_mutual','empresa.id_representante','empresa.id_cdc','empresa.razonSocial',
                'mutual.nombre as mutual','cdc.nombre as cdc','representante.nombre as representanteNombre','representante.apellido1 as representanteAp1',
                'representante.apellido2 as representanteAp2','empresa.rut','empresa.dv','empresa.giro','empresa.correo','empresa.telefono',
                'empresa.direccion','empresa.ciudad','empresa.comuna','empresa.region','empresa.estado'
                )
            ->orderBy('empresa.estado', 'desc')->paginate(15);
        }
        else{
            $empresas = Empresa::join('representante','empresa.id_representante','=','representante.id_representante')
            ->join('mutual','empresa.id_mutual','=','mutual.id_mutual')
            ->join('cdc','empresa.id_cdc','=','cdc.id_cdc')
            ->select('empresa.id_empresa','empresa.id_mutual','empresa.id_representante','empresa.id_cdc','empresa.razonSocial',
                'mutual.nombre as mutual','cdc.nombre as cdc','representante.nombre as representanteNombre','representante.apellido1 as representanteAp1',
                'representante.apellido2 as representanteAp2','empresa.rut','empresa.dv','empresa.giro','empresa.correo','empresa.telefono',
                'empresa.direccion','empresa.ciudad','empresa.comuna','empresa.region','empresa.estado'
                )
            ->where('empresa'.$criterio, 'like', '%'. $buscar . '%')
            ->orderBy('empresa.estado', 'desc')->paginate(15);
        }
        

        return [
            'pagination' => [
                'total'        => $empresas->total(),
                'current_page' => $empresas->currentPage(),
                'per_page'     => $empresas->perPage(),
                'last_page'    => $empresas->lastPage(),
                'from'         => $empresas->firstItem(),
                'to'           => $empresas->lastItem(),
            ],
            'empresas' => $empresas
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
        $empresa = new Empresa();
        $empresa->id_mutual = $request->id_mutual;
        $empresa->id_representante = $request->id_representante;
        $empresa->id_cdc = $request->id_cdc;
        $empresa->rut = $request->rut;
        $empresa->dv = $request->dv;
        $empresa->razonSocial = $request->razonSocial;
        $empresa->giro = $request->giro;
        $empresa->correo = $request->correo;
        $empresa->telefono = $request->telefono;
        $empresa->direccion = $request->direccion;
        $empresa->comuna = $request->comuna;
        $empresa->ciudad = $request->ciudad;
        $empresa->region = $request->region;
        $empresa->estado = '1';
        $empresa->save();
    }
  

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id_empresa
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        if (!$request->ajax()) return redirect('/');
        $empresa = Empresa::findOrFail($request->id_empresa);
        $empresa->id_mutual = $request->id_mutual;
        $empresa->id_representante = $request->id_representante;
        $empresa->id_cdc = $request->id_cdc;
        $empresa->rut = $request->rut;
        $empresa->dv = $request->dv;
        $empresa->razonSocial = $request->razonSocial;
        $empresa->giro = $request->giro;
        $empresa->correo = $request->correo;
        $empresa->telefono = $request->telefono;
        $empresa->direccion = $request->direccion;
        $empresa->comuna = $request->comuna;
        $empresa->ciudad = $request->ciudad;
        $empresa->region = $request->region;
        $empresa->estado = '1';
        $empresa->save();
    }

    public function desactivar(Request $request)
    {
        if (!$request->ajax()) return redirect('/');
        $empresa = Empresa::findOrFail($request->id_empresa);
        $empresa->estado = '0';
        $empresa->save();
    }

    public function activar(Request $request)
    {
        if (!$request->ajax()) return redirect('/');
        $empresa = Empresa::findOrFail($request->id_empresa);
        $empresa->estado = '1';
        $empresa->save();
    }
}
