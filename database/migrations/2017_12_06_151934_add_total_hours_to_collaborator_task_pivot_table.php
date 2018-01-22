<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddTotalHoursToCollaboratorTaskPivotTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('collaborator_task', function (Blueprint $table) {
            $table->float('total_extra_hour')->nullable();
            $table->float('total_normal_hour')->nullable();
            $table->tinyInteger('payment')->default(0)->notNull();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('collaborator_task', function (Blueprint $table) {
            $table->dropColumn('total_extra_hour');
            $table->dropColumn('total_normal_hour');
            $table->dropColumn('payment');
        });
    }
}
