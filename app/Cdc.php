<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Cdc extends Model
{
    protected $table = 'cdc';
    protected $primaryKey = 'id_cdc';
    protected $fillable=[
        'nombre', 'descripcion', 'valor', 'estado'
    ];
    public function empresaCdc(){
        return $this->hasOne('App\Empresa');
    }
}
