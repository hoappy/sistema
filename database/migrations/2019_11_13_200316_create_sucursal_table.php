<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSucursalTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sucursal', function (Blueprint $table) {
            $table->increments('id_sucursal');
            $table->integer('id_empresa')->unsigned();
            $table->string('nombre');
            $table->integer('telefono');
            $table->string('direccion');
            $table->string('ciudad');
            $table->string('comuna');
            $table->string('region');
            $table->boolean('estado')->default(1);
            $table->timestamps();

            $table->foreign('id_empresa')->references('id_empresa')->on('empresa');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('sucursal');
    }
}