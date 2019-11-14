<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateHaberTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('haber', function (Blueprint $table) {
            $table->increments('id_haber');
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
        Schema::dropIfExists('haber');
    }
}
