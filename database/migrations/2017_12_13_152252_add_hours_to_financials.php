<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddHoursToFinancials extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('financials', function($table) {
            $table->float('extra_hours')->notNull()->default(0);
            $table->float('normal_hours')->notNull()->default(0);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('financials', function($table) {
            $table->dropColumn('extra_hours');
            $table->dropColumn('normal_hours');
        });
    }
}
