<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddPermissionsData extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        /** @var App\Repositories\SpaceRepository $repository */
        $repository = app(\Spatie\Permission\Models\Permission::class);
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
        $repository = app(\Spatie\Permission\Models\Permission::class);
        $count = count($this->getData());
        foreach (range(1, $count) as $value){
            $model = $repository->find($value);
            $model->delete();
        }
    }



    public function getData() {
        return [
            [
                'name' => 'accept event',
                'guard_name' => 'admin',
            ],
            [
                'name' => 'finish event',
                'guard_name' => 'admin',
            ],
            [
                'name' => 'archive event',
                'guard_name' => 'admin',
            ],
            [
                'name' => 'cancel event',
                'guard_name' => 'admin',
            ],
            [
                'name' => 'edit schedule balance',
                'guard_name' => 'admin',
            ],
            [
                'name' => 'edit technic balance',
                'guard_name' => 'admin',
            ],
            [
                'name' => 'manage collaborators',
                'guard_name' => 'admin',
            ],
            [
                'name' => 'manage availabilities',
                'guard_name' => 'admin',
            ],
            [
                'name' => 'manage alocation',
                'guard_name' => 'admin',
            ],
            [
                'name' => 'edit event',
                'guard_name' => 'admin',
            ],
            [
                'name' => 'add admin',
                'guard_name' => 'admin',
            ],
            [
                'name' => 'close internal technic balance',
                'guard_name' => 'admin',
            ],
            [
                'name' => 'close internal schedule balance',
                'guard_name' => 'admin',
            ],
        ];
    }
}
