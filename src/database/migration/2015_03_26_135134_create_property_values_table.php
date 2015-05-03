<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePropertyValuesTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('property_values',function(Blueprint $table){
            $table->increments('id');
            $table->integer('property_id')->unsigned()->nullable();
            $table->integer('element_id')->unsigned()->nullable();
            $table->text('value');
            $table->timestamps();

            $table->unique(['property_id','element_id']);

            $table->foreign('property_id')
                ->references('id')
                ->on('properties')
                ->onDelete('CASCADE');
        });
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
        Schema::table('property_values', function($table)
        {
            $table->dropForeign('property_values_property_id_foreign');
        });
		Schema::drop('property_values');
	}

}
