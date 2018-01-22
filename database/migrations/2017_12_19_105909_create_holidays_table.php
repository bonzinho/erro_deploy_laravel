<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateHolidaysTable extends Migration
{

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('holidays', function(Blueprint $table) {
            $table->integer('id')->default(\Carbon\Carbon::now()->format('Y'));
            $table->primary(array('id'));
            $table->string('janeiro')->default('1')->nullable();
            $table->string('fevereiro')->default('')->nullable();
            $table->string('marco')->default('')->nullable();
            $table->string('abril')->default('14;16;25')->nullable();
            $table->string('maio')->default('1')->nullable();
            $table->string('junho')->default('10,15')->nullable();
            $table->string('julho')->default('')->nullable();
            $table->string('agosto')->default('15')->nullable();
            $table->string('setembro')->default('15')->nullable();
            $table->string('outubro')->default('5')->nullable();
            $table->string('novembro')->default('1')->nullable();
            $table->string('dezembro')->default('1;8;25')->nullable();
            $table->timestamps();
		});
	}

	/**hpp
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('holidays');
	}

}
