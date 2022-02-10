<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateActorFilmTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('actor_film', function (Blueprint $table) {
            $table->unsignedBigInteger('film_id')->nullable();
            $table->foreign('film_id')
                ->references('id')
                ->on('films')->onDelete('cascade');
            $table->unsignedBigInteger('actor_id')->nullable();
            $table->foreign('actor_id')
                ->references('id')
                ->on('actors')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('actor_film');
    }
}
