<?php

use Illuminate\Database\Seeder;

class AdminTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $user = factory(\App\Entities\Admin::class, 1)
            ->create([
                'name' => 'Vitor Bonzinho',
                'email' => 'bonzinho@fe.up.pt',
                'password' => bcrypt('secret'),
            ]);

        $su = factory(\App\Entities\Admin::class, 1)
            ->create([
                'name' => 'Cristina Soares',
                'email' => 'soares@fe.up.pt',
                'password' => bcrypt('secret'),
            ]);


        $gestor = factory(\App\Entities\Admin::class, 1)
            ->create([
                'name' => 'Ana Paupério',
                'email' => 'anap@fe.up.pt',
                'password' => bcrypt('secret'),
            ]);


        $gestor_agenda = factory(\App\Entities\Admin::class, 1)
            ->create([
                'name' => 'Ana Carvalho',
                'email' => 'anaisabel@fe.up.pt',
                'password' => bcrypt('secret'),
            ]);

        $gestor_tecnico = factory(\App\Entities\Admin::class, 1)
            ->create([
                'name' => 'Vitor Bonzinho',
                'email' => 'scadiaa@gmail.com',
                'password' => bcrypt('secret'),
            ]);

        $gestor_financeiro = factory(\App\Entities\Admin::class, 1)
            ->create([
                'name' => 'Manuel Fontes',
                'email' => 'mfsf@fe.up.pt',
                'password' => bcrypt('secret'),
            ]);
    }
}
