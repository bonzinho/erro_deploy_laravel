<?php

use Illuminate\Database\Seeder;

class CollaboratorTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(\App\Entities\Collaborator::class, 1)
            ->create([
                'name' => 'Vitor Bonzinho',
                'email' => 'bonzinho@fe.up.pt',
                'type' => 2,
            ]);
        factory(\App\Entities\Collaborator::class, 3)->create();
    }
}