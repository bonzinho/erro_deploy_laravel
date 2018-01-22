<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTypesData extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        /** @var App\Repositories\TypeRepository $repository */
        $repository = app(\App\Repositories\TypeRepository::class);
        foreach ($this->getData() as $typesArray) {
            $repository->create($typesArray);
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
        /** @var App\Repositories\TypeRepository $repository */
        $repository = app(\App\Repositories\TypeRepository::class);
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
                'name' => 'Interno',
                'collaborator_pay_hour' => 9.5,
                'collaborator_pay_extra_hour' => 0.5,
                'collaborator_audit_pay_period' => 138,
                'collaborator_audit_pay_extra_hour' => 0.5,
                'collaborator_audit_all_day' => 414,
                'discount' => 0.75,
            ],
            [
                'name' => 'Misto',
                'collaborator_pay_hour' => 10,
                'collaborator_pay_extra_hour' => 0.5,
                'collaborator_audit_pay_period' => 162,
                'collaborator_audit_pay_extra_hour' => 0.5,
                'collaborator_audit_all_day' => 486,
                'discount' => 0.5,
            ],
            [
                'name' => 'Externo',
                'collaborator_pay_hour' => 11,
                'collaborator_pay_extra_hour' => 0.5,
                'collaborator_audit_pay_period' => 192,
                'collaborator_audit_pay_extra_hour' => 0.5,
                'collaborator_audit_all_day' => 576,
                'discount' => 0,
            ],
        ];
    }
}
