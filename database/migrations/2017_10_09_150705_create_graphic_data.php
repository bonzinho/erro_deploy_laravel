<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateGraphicData extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        /** @var App\Repositories\GraphicRepository $repository */
        $repository = app(\App\Repositories\GraphicRepository::class);
        foreach ($this->getData() as $graphicArray) {
            $repository->create($graphicArray);
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
        /** @var App\Repositories\GraphicRepository $repository */
        $repository = app(\App\Repositories\GraphicRepository::class);
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
                'name' => 'Cartazes',
                'price' => 1,
            ],
            [
                'name' => 'Flyers',
                'price' => 1,
            ],
            [
                'name' => 'Programas',
                'price' => 1,
            ],
            [
                'name' => 'Imagem para púlpito',
                'price' => 1,
            ],
            [
                'name' => 'Imagem para mesa',
                'price' => 1,
            ],
            [
                'name' => 'Pendões para palco',
                'price' => 1,
            ],
            [
                'name' => 'Website',
                'price' => 1,
            ],

        ];
    }
}
