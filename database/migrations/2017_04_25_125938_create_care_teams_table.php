<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCareTeamsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('care_teams', function (Blueprint $table) {
            $table->increments('id');
            $table->string('identifiers')->nullable();
            $table->integer('status')->unsigned(); //status id
            $table->integer('category')->unsigned();
            $table->string('name');
            $table->string('subject')->nullable();
            $table->integer('context')->unsigned(); //episode of care id
            $table->integer('period')->nullable();
            $table->string('reason_code')->nullable();
            $table->string('reason_reference')->nullable();
            $table->integer('managing_organization')->unsigned(); //org id
            $table->string('comment')->nullable();
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
        Schema::dropIfExists('care_teams');
    }
}
