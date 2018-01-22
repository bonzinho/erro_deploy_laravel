<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEventsTable extends Migration
{

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('events', function(Blueprint $table) {
            $table->increments('id');
            $table->integer('client_id')->unsigned();
            $table->foreign('client_id')->references('id')->on('clients')->onDelete('cascade');
            $table->integer('nature_id')->unsigned();
            $table->foreign('nature_id')->references('id')->on('natures')->onDelete('cascade');
            $table->string('denomination')->notNull();
            $table->dateTime('date_time_init')->notNull();
            $table->dateTime('date_time_end')->notNull();
            $table->longText('work_plan')->nullable();
            $table->longText('technical_raider')->nullable();
            $table->longText('programme')->nullable();
            $table->longText('notes')->nullable();
            $table->float('budget')->nullable();
            $table->float('total_expenses')->notNull()->default(0);
            $table->float('total_recipes')->notNull()->default(0);
            $table->integer('state_id')->unsigned()->default(1);
            $table->foreign('state_id')->references('id')->on('states')->onDelete('cascade');
            $table->integer('number_participants')->notNull()->default(1);
            $table->string('doc_program')->nullable();
            $table->string('doc_procedding')->nullable();
            $table->integer('type_id')->unsigned()->nullable();
            $table->foreign('type_id')->references('id')->on('types')->onDelete('cascade');
            $table->integer('admin_id')->unsigned()->nullable();
            $table->foreign('admin_id')->references('id')->on('admins')->onDelete('cascade');
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
		Schema::drop('events');
	}

}
