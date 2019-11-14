<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Licencia extends Model
{
    //
    protected $table = 'licencia';
    protected $primaryKey = 'id_licencia';
    protected $fillable=[
        'id_empleado', 'descripcion', 'fechaInicio', 'fechaFin', 'estado'
    ];
    public function empleadoLicencia(){
        return $this->hasMany('App\Empleado');
    }
}
