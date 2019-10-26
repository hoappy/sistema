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
            $table->string('causa');
            $table->date('fecha_aviso');
            $table->date('fecha_termino');
            $table->string('detalle');
            $table->string('articulos');
            $table->boolean('estado')->default(1);
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
        Schema::dropIfExists('finiquito');
    }
}