<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSpacesTypesData extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        /** @var App\Repositories\SpaceTypeRepository $repository */
        $repository = app(\App\Repositories\SpaceTypeRepository::class);
        foreach ($this->getData() as $spaceTypeArray) {
            $repository->create($spaceTypeArray);
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
        /** @var App\Repositories\SpaceTypeRepository $repository */
        $repository = app(\App\Repositories\SpaceTypeRepository::class);
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
                'name' => 'Auditório',
                'tag'  => 'audit'
            ],
            [
                'name' => 'other',
                'tag'  => 'other'
            ],
            [
                'name' => 'Externo',
                'tag'  => 'external'
            ],
        ];
    }
}
