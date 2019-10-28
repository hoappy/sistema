<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Empleado extends Model
{
    protected $table = 'empleado';
    protected $primaryKey = 'id_empleado';
    protected $fillable=[
        'id_afp', 'id_salud', 'rut', 'dv', 'nombre', 'apellido1', 'apellido2', 'fechaNnaci', 'sexo', 'diasVacas', 'direccion', 'seguriCesantia',
        'descuentosSalud', 'estaoCivil', 'jornada', 'cargo', 'tipo', 'estado'
    ];
    public function afp(){
        return $this->hasOne('App\Afp');
    }
    public function salud(){
        return $this->hasOne('App\Salud');
    }

}
