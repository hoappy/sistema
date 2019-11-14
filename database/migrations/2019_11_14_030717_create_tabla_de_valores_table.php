<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTablaDeValoresTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tabla_de_valores', function (Blueprint $table) {
            $table->increments('id_tablaValor');

            $table->boolean('tipoValor');
            $table->string('tipo');
            $table->string('descripcion');
            $table->string('valor');
             
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
        Schema::dropIfExists('tabla_de_valores');
    }
}
