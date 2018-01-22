<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAudiovisualData extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        /** @var App\Repositories\AudiovisualRepository $repository */
        $repository = app(\App\Repositories\AudiovisualRepository::class);
        foreach ($this->getData() as $audiovisualArray) {
            $repository->create($audiovisualArray);
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
        /** @var App\Repositories\AudiovisualRepository $repository */
        $repository = app(\App\Repositories\AudiovisualRepository::class);
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
                'name' => 'Gravação de Video',
                'price' => 1,
            ],
            [
                'name' => 'Gravação de Audio',
                'price' => 1,
            ],
        ];
    }
}
