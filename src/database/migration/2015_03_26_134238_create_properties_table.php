<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePropertiesTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('properties', function(Blueprint $table)
        {
            $table->increments('id');
            $table->string('code');
            $table->string('model');
            $table->string('type')->default('text');


            $table->string('title');
            $table->string('description',250)->nullable();

            $table->integer('sort')->nullable();
            $table->boolean('multiple')->default(false);
            $table->boolean('required')->default(false);
            $table->string('rule')->nullable();
            //TODO add sphinx indexed table
            //$table->boolean('search_indexed')->default(false);
            $table->json('default_values')->nullable();


            $table->unique(['code','model']);
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

        Schema::drop('properties');
	}

}
