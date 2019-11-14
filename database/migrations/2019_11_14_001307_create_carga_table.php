<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCargaTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('carga', function (Blueprint $table) {
            $table->increments('id_carga');
            $table->integer('id_empleado')->unsigned();

            $table->integer('inicioTramo');
            $table->integer('finTramo');
            $table->string('descripcion');
            $table->string('valor');
             
            $table->boolean('estado')->default(1);
            $table->timestamps();

            $table->foreign('id_empleado')->references('id_empleado')->on('empleado');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('carga');
    }
}
