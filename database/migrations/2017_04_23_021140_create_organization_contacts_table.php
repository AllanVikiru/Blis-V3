<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateOrganizationContactsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('organization_contacts', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('organization_id')
                ->references('organizations')->on('id')->onUpdate('cascade')->onDelete('cascade');
            $table->enum('purpose', ['billing', 'administrative', 'human_resource', 'payor', 'patient', 'press']);
            $table->integer('name')
                ->references('human_names')->on('id')->onUpdate('cascade')->onDelete('cascade');
            $table->integer('telecom')
                ->references('contact_points')->on('id')->onUpdate('cascade')->onDelete('cascade');
            $table->integer('address')->nullable()
                ->references('addresses')->on('id')->onUpdate('cascade')->onDelete('cascade');
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
        Schema::dropIfExists('organization_contacts');
    }
}
