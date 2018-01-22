<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTypesTable extends Migration
{

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('types', function(Blueprint $table) {
            $table->increments('id');
            $table->string('name')->notNull();
            $table->boolean('state')->notNull()->default(1);
            $table->float('collaborator_pay_hour')->notNull();
            $table->float('collaborator_pay_extra_hour')->notNull();
            $table->float('collaborator_audit_pay_period')->notNull()->default(0);
            $table->float('collaborator_audit_pay_extra_hour')->notNull()->default(0);
            $table->float('collaborator_audit_all_day')->notNull()->default(0);
            $table->float('discount')->notNull()->default(0.0);
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
		Schema::drop('types');
	}

}
