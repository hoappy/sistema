<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEmpleadoTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('empleado', function (Blueprint $table) {
            $table->increments('id_empleado');
            $table->integer('id_salud')->unsigned();
            $table->integer('id_afp')->unsigned();
            $table->integer('rut');
            $table->string('dv');
            $table->string('nombre');
            $table->string('apellido1');
            $table->string('apellido2');
            $table->date('fechaNnaci');
            $table->boolean('sexo');
            $table->integer('diasVacas');
            $table->string('direccion');
            $table->integer('seguroCesantia');
            $table->integer('descuentosSalud');
            $table->string('estaoCivil');
            $table->integer('valorSalud');
            $table->string('jornada');
            $table->string('cargo');
            $table->string('tipo');
            $table->boolean('estado')->default(1);
            $table->timestamps();

            $table->foreign('id_salud')->references('id_salud')->on('salud');
            $table->foreign('id_afp')->references('id_afp')->on('afp');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('empleado');
    }
}