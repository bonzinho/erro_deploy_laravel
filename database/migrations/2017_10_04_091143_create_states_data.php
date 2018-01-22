<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;



class CreateStatesData extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        /** @var App\Repositories\StateRepository $repository */
        $repository = app(\App\Repositories\StateRepository::class);
        foreach ($this->getData() as $stateArray) {
            $repository->create($stateArray);
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
        /** @var App\Repositories\StateRepository $repository */
        $repository = app(\App\Repositories\StateRepository::class);
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
                'name' => 'Pendente',
            ],
            [
                'name' => 'Em processamento',
            ],
            [
                'name' => 'Concluído',
            ],
            [
                'name' => 'Arquivado',
            ],
            [
                'name' => 'Cancelado',
            ],
        ];
    }
}
