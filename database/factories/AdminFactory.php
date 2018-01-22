<?php

use Faker\Generator as Faker;

/*
|--------------------------------------------------------------------------
| Model Factories
|--------------------------------------------------------------------------
|
| This directory should contain each of the model factory definitions for
| your application. Factories provide a convenient way to generate new
| model instances for testing / seeding your application's database.
|
*/

/**
 * @param Faker $faker
 * @return array
 */
/** @var \Illuminate\Database\Eloquent\Factory $factory */
$factory->define(\App\Entities\Admin::class, function (Faker $faker) {
    static $password;
    return [
        'name' => $faker->name,
        'email' => $faker->unique()->email,
        'password' => bcrypt('secret'),
        'remember_token' => str_random(10),
        'phone' => $faker->phoneNumber,
    ];
});

$factory->define(\App\Entities\Collaborator::class, function (Faker $faker) {
    static $password;
    return [
        'role' => 'collaborator',
        'cv' => 'files/collaborators/cv/cv.pdf',
        'type' => rand(0,2),
        'photo' => 'files/collaborators/photo/photo.jpg',
        'iban' => $faker->bankAccountNumber,
        'nif' => '000 000 000',
        'cc' => '111 111 111',
        'locality' => $faker->city,
        'postal_code' => $faker->postcode,
        'address' => $faker->address,
        'phone' => $faker->phoneNumber,
        'genre' => $faker->randomElement(['m', 'f']),
        'name' => $faker->name,
        'password' => bcrypt('secret'),
        'email' => $faker->email,
        'state' => $faker->boolean(),
    ];
});
