<?php

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->call(AdminTableSeeder::class);
        $this->call(CollaboratorTableSeeder::class);
        $this->call(RolesAndPermissionsSeeder::class);
        $this->call(AddRolesToAdmins::class);

    }
}


//seeder para funcionar, não estav a detetar a class
class RolesAndPermissionsSeeder extends Seeder
{
    public function run()
    {
        // Reset cached roles and permissions
        app()['cache']->forget('spatie.permission.cache');

        $su = \Spatie\Permission\Models\Role::findByName('su');
        $gestor = \Spatie\Permission\Models\Role::findByName('gestor');
        $gestor_agenda = \Spatie\Permission\Models\Role::findByName('gestor_agenda');
        $gestor_tecnico = \Spatie\Permission\Models\Role::findByName('gestor_tecnico');
        $gestor_financeiro = \Spatie\Permission\Models\Role::findByName('gestor_financeiro');

        $su->givePermissionTo([
            'accept event',
            'finish event',
            'archive event',
            'cancel event',
            'edit schedule balance',
            'edit technic balance',
            'manage collaborators',
            'manage availabilities',
            'manage alocation',
            'edit event',
            'add admin',
            'close internal technic balance',
            'close internal schedule balance'
        ]);


        $gestor->givePermissionTo([
            'accept event',
            'finish event',
            'archive event',
            'cancel event',
            'edit technic balance',
            'manage collaborators',
            'manage availabilities',
            'manage alocation',
            'edit event',
            'close internal technic balance',
            'close internal schedule balance'
        ]);

        $gestor_agenda->givePermissionTo([
            'accept event',
            'edit schedule balance',
            'edit event',
            'close internal technic balance',
            'close internal schedule balance'
        ]);

        $gestor_tecnico->givePermissionTo([
            'edit technic balance',
            'manage collaborators',
            'manage availabilities',
            'manage alocation',
            'close internal technic balance',
            'close internal schedule balance'
        ]);

        $gestor_financeiro->givePermissionTo([
            'finish event',
            'archive event',
            'cancel event',
            'edit schedule balance',
            'edit event'
        ]);

    }
}

class AddRolesToAdmins extends Seeder
{
    public function run()
    {
        $su1 = \App\Entities\Admin::findByID(1);
        $su2 = \App\Entities\Admin::findByID(2);
        $gestor = \App\Entities\Admin::findByID(3);
        $gestor_agenda = \App\Entities\Admin::findByID(4);
        $gestor_tecnico = \App\Entities\Admin::findByID(5);
        $gestor_financeiro = \App\Entities\Admin::findByID(6);

        $su1->assignRole('su');
        $su2->assignRole('su');
        $gestor->assignRole('gestor');
        $gestor_agenda->assignRole('gestor_agenda');
        $gestor_tecnico->assignRole('gestor_tecnico');
        $gestor_financeiro->assignRole('gestor_financeiro');

    }
}