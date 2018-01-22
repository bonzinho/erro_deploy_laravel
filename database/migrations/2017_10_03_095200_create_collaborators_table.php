<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCollaboratorsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('collaborators', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->string('student_number')->nullable();
            $table->string('genre')->notNull();
            $table->string('phone')->notNull();
            $table->tinyInteger('type')->notNull()->default(2); //0 ->tecnico 1->hospedeiro 2->mix
            $table->string('address')->nullable();
            $table->string('postal_code')->nullable();
            $table->string('locality')->nullable();
            $table->string('cc')->notNull();
            $table->string('nif')->notNull();
            $table->string('iban')->notNull();
            $table->string('photo')->notNull();
            $table->string('cv')->nullable();
            $table->string('password')->notNull();
            $table->string('email')->unique();
            $table->integer('state')->notNull()->default(0); //0 não aprovado, 1 - ativo, 2 - inativo
            $table->string('role')->notNull()->default('collaborator');
            $table->string('locker')->nullable();
            $table->tinyInteger('payment_type')->nullable();
            $table->rememberToken();
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
        Schema::drop('collaborators');
    }
}
