<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Empleado extends Model
{
    protected $table = 'empleado';
    protected $primaryKey = 'id_empleado';
    protected $fillable=[
        'id_afp', 'id_salud', 'rut', 'dv', 'nombre', 'apellido1', 'apellido2', 'fechaNnaci', 'sexo', 'diasVacas', 'direccion', 'seguroCesantia',
        'descuentosSalud', 'estaoCivil', 'jornada', 'cargo', 'tipo', 'estado', 'valorSalud'
    ];
    public function afp(){
        return $this->hasOne('App\Afp');
    }
    public function salud(){
        return $this->hasOne('App\Salud');
    }
    public function contrato(){
        return $this->belongsTo('App\Contrato');
    }
    public function finiquito(){
        return $this->belongsTo('App\Finiquito');
    }
    public function licencia(){
        return $this->belongsTo('App\Licencia');
    }
    public function carga(){
        return $this->belongsTo('App\Carga');
    }
    public function liquidacion(){
        return $this->belongsTo('App\Liquidacion');
    }

}
