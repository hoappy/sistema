<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateLiquidacionTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('liquidacion', function (Blueprint $table) {
            $table->increments('id_liquidacion');
            $table->integer('id_empleado')->unsigned();
            $table->string('detalle');
            $table->date('fecha');
            $table->integer('totalImponible');
            $table->integer('movilizacion');
            $table->integer('diasTrabajados');
            $table->integer('horasExtra');
            $table->integer('ahorroVoluntario');
            $table->integer('totalImpuesto');
            $table->integer('totalDescuento');
            $table->integer('totalLiquido');
            $table->integer('totalColacion');
            $table->integer('totalLiquidacion');
            $table->integer('totalHaberes');
            $table->integer('gratificacion');
            
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
        Schema::dropIfExists('liquidacion');
    }
}
