<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCollaboratorTypeData extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        /** @var App\Repositories\CollaboratorTypeRepository $repository */
        $repository = app(\App\Repositories\CollaboratorTypeRepository::class);
        foreach ($this->getData() as $collaboratorTypeArray) {
            $repository->create($collaboratorTypeArray);
            sleep(1); // faz com que o feech espera um segundo ate ao proximo registo
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        /** @var App\Repositories\CollaboratorTypeRepository $repository */
        $repository = app(\App\Repositories\CollaboratorTypeRepository::class);
        $repository->skipPresenter(true);
        $count = count($this->getData());
        foreach (range(1, $count) as $value){
            $model = $repository->find($value);
            $model->delete();
        }
    }

    public function getData() {
        return [
            [
                'name' => 'Host',
                'tag' => 'host',
            ],
            [
                'name' => 'Technician',
                'tag' => 'technician',
            ],
            [
                'name' => 'Mix',
                'tag' => 'mix',
            ],

        ];
    }
}
