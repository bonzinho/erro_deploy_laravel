<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSpacesData extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        /** @var App\Repositories\SpaceRepository $repository */
        $repository = app(\App\Repositories\SpaceRepository::class);
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
        /** @var App\Repositories\SpaceRepository $repository */
        $repository = app(\App\Repositories\SpaceRepository::class);
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
                'cost' => 0,
                'host_number' => 1,
                'tec_number' => 2,
                'number_available' => 1,
                'space_type_id' => 1
            ],
            [
                'name' => 'Átrio de Exposições',
                'cost' => 200,
                'host_number' => 0,
                'tec_number' => 0,
                'number_available' => 1,
                'space_type_id' => 2
            ],
            [
                'name' => 'Camarins',
                'cost' => 0,
                'host_number' => 0,
                'tec_number' => 0,
                'number_available' => 2,
                'space_type_id' => 2
            ],
            [
                'name' => 'Sala de Actos',
                'cost' => 300,
                'host_number' => 0,
                'tec_number' => 0,
                'number_available' => 1,
                'space_type_id' => 2
            ],
            [
                'name' => 'Sala do Concelho',
                'cost' => 0,
                'host_number' => 0,
                'tec_number' => 0,
                'number_available' => 1,
                'space_type_id' => 2
            ],
            [
                'name' => 'Sala Nobre',
                'cost' => 300,
                'host_number' => 0,
                'tec_number' => 1,
                'number_available' => 1,
                'space_type_id' => 2
            ],
            [
                'name' => 'Secretariado / Balcão de registos',
                'cost' => 0,
                'host_number' => 0,
                'tec_number' => 1,
                'number_available' => 1,
                'space_type_id' => 2
            ],
            [
                'name' => 'Sala de video conferência',
                'cost' => 100,
                'host_number' => 0,
                'tec_number' => 1,
                'number_available' => 1,
                'space_type_id' => 2
            ],
            [
                'name' => 'Coffee Lounge',
                'cost' => 200,
                'host_number' => 0,
                'tec_number' => 1,
                'number_available' => 1,
                'space_type_id' => 2
            ],
            [
                'name' => 'Corredor Panorâmico',
                'cost' => 100,
                'host_number' => 0,
                'tec_number' => 1,
                'number_available' => 32,
                'space_type_id' => 2
            ],
            [
                'name' => 'Salas de informática até 20 Computadores',
                'cost' => 100,
                'host_number' => 0,
                'tec_number' => 1,
                'number_available' => 17,
                'space_type_id' => 2
            ],
            [
                'name' => 'Salas de informática (>52 Computadores)',
                'cost' => 100,
                'host_number' => 0,
                'tec_number' => 1,
                'number_available' => 3,
                'space_type_id' => 2
            ],
            [
                'name' => 'Salas de aulas práticas até 32 Lugares',
                'cost' => 100,
                'host_number' => 0,
                'tec_number' => 0,
                'number_available' => 22,
                'space_type_id' => 2
            ],
            [
                'name' => 'Salas de aulas práticas (40/50 lugares)',
                'cost' => 100,
                'host_number' => 0,
                'tec_number' => 0,
                'number_available' => 9,
                'space_type_id' => 2
            ],
            [
                'name' => 'Salas de exames até 70 lugares',
                'cost' => 100,
                'host_number' => 0,
                'tec_number' => 0,
                'number_available' => 4,
                'space_type_id' => 2
            ],
            [
                'name' => 'Salas de exames até 80 lugares',
                'cost' => 100,
                'host_number' => 0,
                'tec_number' => 0,
                'number_available' => 3,
                'space_type_id' => 2
            ],
            [
                'name' => 'Anfiteatros até 53 lugares',
                'cost' => 200,
                'host_number' => 0,
                'tec_number' => 0,
                'number_available' => 10,
                'space_type_id' => 2
            ],
            [
                'name' => 'Anfiteatros até 60 lugares',
                'cost' => 200,
                'host_number' => 0,
                'tec_number' => 0,
                'number_available' => 8,
                'space_type_id' => 2
            ],
            [
                'name' => 'Anfiteatros até 99 lugares',
                'cost' => 200,
                'host_number' => 0,
                'tec_number' => 0,
                'number_available' => 13,
                'space_type_id' => 2
            ],
            [
                'name' => 'Anfiteatros até 184 lugares',
                'cost' => 200,
                'host_number' => 0,
                'tec_number' => 0,
                'number_available' => 3,
                'space_type_id' => 2
            ],
            [
                'name' => 'Estacionamento',
                'cost' => 200,
                'host_number' => 0,
                'tec_number' => 0,
                'number_available' => 10,
                'space_type_id' => 2
            ],
            [
                'name' => 'Empedrado Central',
                'cost' => 200,
                'host_number' => 0,
                'tec_number' => 0,
                'number_available' => 1,
                'space_type_id' => 2
            ],
            [
                'name' => 'Relvado central',
                'cost' => 200,
                'host_number' => 0,
                'tec_number' => 0,
                'number_available' => 1,
                'space_type_id' => 2
            ],
            [
                'name' => 'Externo',
                'cost' => 0,
                'host_number' => 0,
                'tec_number' => 0,
                'number_available' => 1,
                'space_type_id' => 3
            ],

        ];
    }
}
