<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEmpresaTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('empresa', function (Blueprint $table) {
            $table->increments('id_empresa');
            $table->integer('id_mutual')->unsigned();
            $table->integer('id_representante')->unsigned();
            $table->integer('id_cdc')->unsigned();
            $table->integer('rut');
            $table->string('dv');
            $table->string('razonSocial');
            $table->string('giro');
            $table->string('correo');
            $table->integer('telefono');
            $table->string('direccion');
            $table->string('ciudad');
            $table->string('comuna');
            $table->string('region');
            $table->boolean('estado')->default(1);
            $table->timestamps();

            $table->foreign('id_mutual')->references('id_mutual')->on('mutual');
            $table->foreign('id_representante')->references('id_representante')->on('representante');
            $table->foreign('id_cdc')->references('id_cdc')->on('cdc');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('empresa');
    }
}