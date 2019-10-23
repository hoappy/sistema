<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMutualTable extends Migration
{
    public function up()
    {
        Schema::create('mutual', function (Blueprint $table) {
            $table->increments('id_mutual');
            $table->string('nombre');
            $table->string('descripcion');
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
        Schema::dropIfExists('mutual');
    }
}
