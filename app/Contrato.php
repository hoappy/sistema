<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Contrato extends Model
{
    //
    protected $table = 'contrato';
    protected $primaryKey = 'id_contrato';
    protected $fillable=[
        'id_empleado', 'id_empresa', 'id_sucursal','sueldoBase', 'detalle', 'colacion', 'fechaInicio', 'fechaFin', 'estado'
    ];
    public function empleadoContrato(){
        return $this->hasMany('App\Empleado');
    }
    public function empresaContrato(){
        return $this->hasMany('App\Empresa');
    }
    public function mutual(){
        return $this->hasOne('App\Mutual');
    }
}
