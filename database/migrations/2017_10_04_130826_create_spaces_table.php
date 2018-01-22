<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSpacesTable extends Migration
{

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('spaces', function(Blueprint $table) {
            $table->increments('id');
            $table->string('name')->notNull();
            $table->float('cost')->notNull()->default(0);
            $table->integer('host_number')->notNull()->default(0);
            $table->integer('tec_number')->notNull()->default(0);
            $table->integer('number_available')->notNull()->default(1);
            $table->boolean('state')->notNull()->default(1);
            $table->integer('space_type_id')->unsigned();
            $table->foreign('space_type_id')->references('id')->on('space_types')->onDelete('cascade');
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
		Schema::drop('spaces');
	}

}
