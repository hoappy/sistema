<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Liquidacion extends Model
{
    //
    protected $table = 'liquidacion';
    protected $primaryKey = 'id_liquidacion';
    protected $fillable=[
        'id_empleado', 'detalle','fecha','totalImponible','movilizacion','diasTrabajados',
        'horasExtra','ahorroVoluntario','totalImpuesto','totalDescuento','totalLiquido',
        'totalColacion','totalLiquidacion','totalHaberes','gratificacion','estado'
    ];
    public function empleadoLiquidacion(){
        return $this->hasMany('App\Empleado');
    }
    public function Haber(){
        return $this->belongsTo('App\Haber');
    }
    public function Descuento(){
        return $this->belongsTo('App\Descuento');
    }
}
