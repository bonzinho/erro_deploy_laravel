<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEventAudiovisualPivotTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('event_audiovisual', function (Blueprint $table) {
            $table->integer('audiovisual_id')->unsigned()->index();
            $table->foreign('audiovisual_id')->references('id')->on('audiovisuals')->onDelete('cascade');
            $table->integer('event_id')->unsigned()->index();
            $table->foreign('event_id')->references('id')->on('events')->onDelete('cascade');
            $table->string('quantity')->notNull()->default(1);
            $table->primary(['audiovisual_id', 'event_id']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('event_audiovisual');
    }
}
