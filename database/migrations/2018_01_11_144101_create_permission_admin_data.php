<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePermissionAdminData extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        /** @var App\Repositories\SpaceRepository $repository */
        $repository = app(\Spatie\Permission\Models\Role::class);
        foreach ($this->getData() as $data) {
            $repository->create($data);
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
        $repository = app(\Spatie\Permission\Models\Role::class);
        $count = count($this->getData());
        foreach (range(1, $count) as $value){
            $model = $repository->find($value);
            $model->delete();
        }
    }


    public function getData() {
        return [
            [
                'name' => 'su',
                'guard_name' => 'admin',
            ],
            [
                'name' => 'gestor',
                'guard_name' => 'admin',
            ],
            [
                'name' => 'gestor_agenda',
                'guard_name' => 'admin',
            ],
            [
                'name' => 'gestor_tecnico',
                'guard_name' => 'admin',
            ],
            [
                'name' => 'gestor_financeiro',
                'guard_name' => 'admin',
            ],
        ];
    }
}
