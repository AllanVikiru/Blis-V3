<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateContactPointsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('contact_points', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('user_id')->unsigned()
                ->references('users')->on('id')->onUpdate('cascade');
            $table->integer('system')->unsigned();                  
            $table->string('value');
            $table->integer('use')->unsigned();                  
            $table->integer('rank')->unsigned()->nullable();
            $table->date('period')->nullable();
            $table->timestamps();

            //Relationships
            $table->foreign('system')->references('id')->on('codeable_concepts')->onUpdate('cascade');
            $table->foreign('use')->references('id')->on('codeable_concepts')->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('contact_points');
    }
}
