<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSupportData extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        /** @var App\Repositories\SupportRepository $repository */
        $repository = app(\App\Repositories\SupportRepository::class);
        foreach ($this->getData() as $supportArray) {
            $repository->create($supportArray);
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
        /** @var App\Repositories\SupportRepository $repository */
        $repository = app(\App\Repositories\SupportRepository::class);
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
                'name' => 'Apoio Técnico',
            ],
            [
                'name' => 'Serviço de hospedeiros',
            ],
        ];
    }
}
