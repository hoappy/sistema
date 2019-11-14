<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDescuentoTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('descuento', function (Blueprint $table) {
            $table->increments('id_descuento');
            $table->integer('id_liquidacion')->unsigned();

            $table->string('tipo');
            $table->string('descripcion');
            $table->string('valor');
             
            $table->boolean('estado')->default(1);
            $table->timestamps();

            $table->foreign('id_liquidacion')->references('id_liquidacion')->on('liquidacion');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('descuento');
    }
}
