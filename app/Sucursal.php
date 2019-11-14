<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Sucursal extends Model
{
    protected $table = 'sucursal';
    protected $primaryKey = 'id_sucursal';
    protected $fillable=[
        'id_empresa', 'nombre', 'telefono', 'direccion', 'ciudad', 'comuna', 'region', 'estado'
    ];
    
    public function empresa(){
        return $this->belongsTo('App\empresa');
    }
    public function sucursalContrato(){
        return $this->hasOne('App\Contrato');
    }

}
