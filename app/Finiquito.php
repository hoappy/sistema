<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Finiquito extends Model
{
    protected $table = 'finiquito';
    protected $primaryKey = 'id_finiquito';
    protected $fillable=[
        'id_empleado', 'causa', 'detalle', 'articulo', 'fechaAviso', 'fechaTermino', 'estado'
    ];
    public function empleadoFiniquito(){
        return $this->hasMany('App\Empleado');
    }

}
