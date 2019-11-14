<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TablaDeValores extends Model
{
    //
    protected $table = 'tabla_de_valores';
    protected $primaryKey = 'id_tablaValor';
    protected $fillable=[
        'tipoValor', 'descripcion', 'tipo', 'valor', 'estado'
    ];
}
