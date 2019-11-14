<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateContratoTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('contrato', function (Blueprint $table) {
            $table->increments('id_contrato');
            $table->integer('id_empleado')->unsigned();
            $table->integer('id_empresa')->unsigned();
            $table->integer('id_sucursal')->unsigned();
            $table->integer('sueldoBase');
            $table->date('fechaInicio');
            $table->date('fechaFin');
            $table->integer('colacion');
            $table->string('detalle');
            $table->boolean('estado')->default(1);

            $table->foreign('id_empleado')->references('id_empleado')->on('empleado');
            $table->foreign('id_empresa')->references('id_empresa')->on('empresa');
            $table->foreign('id_sucursal')->references('id_sucursal')->on('sucursal');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('contrato');
    }
}
