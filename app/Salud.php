<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Salud extends Model
{
    protected $table = 'salud';
    protected $primaryKey = 'id_salud';
    protected $fillable=[
        'nombre', 'descripcion', 'provision', 'estado'
    ];
    
}
