<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Descuento extends Model
{
    //
    protected $table = 'descuento';
    protected $primaryKey = 'id_descuento';
    protected $fillable=[
        'id_liquidacion', 'descripcion', 'tipo', 'valor', 'estado'
    ];
    public function liquidacionDescuento(){
        return $this->hasMany('App\Liquidacion');
    }
}
