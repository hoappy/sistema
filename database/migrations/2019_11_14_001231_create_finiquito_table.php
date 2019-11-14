<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateFiniquitoTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('finiquito', function (Blueprint $table) {
            $table->increments('id_finiquito');
            $table->integer('id_empleado')->unsigned();
            $table->string('causa');
            $table->date('fechaAviso');
            $table->date('fechaTermino');
            $table->string('detalle');
            $table->string('articulo');
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
        Schema::dropIfExists('finiquito');
    }
}
