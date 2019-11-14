<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Haber extends Model
{
    //
    protected $table = 'haber';
    protected $primaryKey = 'id_haber';
    protected $fillable=[
        'id_liquidacion', 'descripcion', 'tipo', 'valor', 'estado'
    ];
    public function liquidacionHaber(){
        return $this->hasMany('App\Liquidacion');
    }
}
