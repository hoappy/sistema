<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Empresa extends Model
{
    protected $table = 'empresa';
    protected $primaryKey = 'id_empresa';
    protected $fillable=[
        'id_mutual', 'id_representante', 'id_cdc', 'rut', 'dv', 'razonSocial', 'giro', 'correo', 'telefono', 'direccion', 'ciudad', 'comuna', 'region', 'estado'
    ];
    public function mutual(){
        return $this->hasOne('App\Mutual');
    }
    public function representante(){
        return $this->belongsTo('App\Representante');
    }
    public function cdc(){
        return $this->hasOne('App\Cdc');
    }

}
