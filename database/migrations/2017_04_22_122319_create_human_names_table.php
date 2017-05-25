<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateHumanNamesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('human_names', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('user_id')->unsigned()
                ->references('users')->on('id')->onUpdate('cascade');
            $table->integer('use')->unsigned();
            $table->string('text');
            $table->string('family')->nullable();
            $table->string('given')->nullable();
            $table->string('prefix')->nullable();
            $table->string('suffix')->nullable();
            $table->date('period')->nullable();
            $table->timestamps();

            //Relationships
            $table->foreign('use')->references('id')->on('codeable_concepts')->onUpdate('cascade')->onDelete('cascade');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('human_names');
    }
}
