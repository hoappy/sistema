<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Mutual extends Model
{
    protected $table = 'mutual';
    protected $primaryKey = 'id_mutual';
    protected $fillable=[
        'nombre', 'descripcion', 'estado'
    ];
    public function empresaMutual(){
        return $this->hasOne('App\Empresa');
    }
}
