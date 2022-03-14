<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePostsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('posts', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('Categorias_id');
            $table->string('titulo',150)->nullable(false);
            $table->text('contenido')->nullable(false);
            $table->timestamp('fecha_creacion')->nullable(true);
            $table->timestamp('fecha_actualizacion')->nullable(true);
            $table->foreign('Categorias_id')->references('id')->on('categorias');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('posts');
    }
}
