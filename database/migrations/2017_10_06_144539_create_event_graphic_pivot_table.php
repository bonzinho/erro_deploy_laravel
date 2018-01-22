<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEventGraphicPivotTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('event_graphic', function (Blueprint $table) {
            $table->integer('event_id')->unsigned()->index();
            $table->foreign('event_id')->references('id')->on('events')->onDelete('cascade');
            $table->integer('graphic_id')->unsigned()->index();
            $table->foreign('graphic_id')->references('id')->on('graphics')->onDelete('cascade');
            $table->integer('quantity')->notNull()->default(1);
            $table->primary(['event_id', 'graphic_id']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('event_graphic');
    }
}
