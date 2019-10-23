<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Representante extends Model
{
    protected $table = 'representante';
    protected $primaryKey = 'id_representante';
    protected $fillable=[
        'rut', 'dv', 'nombre', 'apellido1', 'apellido2', 'estado'
    ];
}
