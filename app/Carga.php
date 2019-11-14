<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Carga extends Model
{
    //
    protected $table = 'carga';
    protected $primaryKey = 'id_carga';
    protected $fillable=[
        'id_empleado', 'descripcion', 'inicioTramo', 'finTramo', 'valor', 'estado'
    ];
    public function empleadoCarga(){
        return $this->hasMany('App\Empleado');
    }
    public function sucursal(){
        return $this->hasOne('App\Sucursal');
    }
}
