<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCollaboratorTaskPivotTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('collaborator_task', function (Blueprint $table) {
            $table->integer('collaborator_id')->unsigned()->index();
            $table->foreign('collaborator_id')->references('id')->on('collaborators')->onDelete('cascade');
            $table->integer('task_id')->unsigned()->index();
            $table->foreign('task_id')->references('id')->on('tasks')->onDelete('cascade');
            $table->primary(['collaborator_id', 'task_id']);
            $table->boolean('allocation')->nullable();
            $table->time('init_time_correction')->nullable();
            $table->time('end_time_correction')->nullable();
            $table->float('normal_hour_value_total')->nullable()->default(0);
            $table->float('extra_hour_value_total')->nullable()->default(0);
            $table->tinyInteger('validate_confirm_schedule')->default(0);
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
        Schema::drop('collaborator_task');
    }
}
