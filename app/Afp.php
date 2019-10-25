<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Afp extends Model
{
    protected $table = 'afp';
    protected $primaryKey = 'id_afp';
    protected $fillable=[
        'nombre', 'descripcion', 'valor', 'estado'
    ];
    public function empresaCdc(){
        return $this->hasOne('App\Empresa');
    }
}
