<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateLicenciaTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('licencia', function (Blueprint $table) {
            $table->increments('id_licencia');
            $table->integer('id_empleado')->unsigned();
            $table->string('causa');
            $table->date('fechaInicio');
            $table->date('fechaFin');
            $table->string('descripcion');
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
        Schema::dropIfExists('licencia');
    }
}
