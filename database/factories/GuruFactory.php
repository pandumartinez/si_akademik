<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Guru;
use Faker\Generator as Faker;

$factory->define(Guru::class, function (Faker $faker) {
    $L = $faker->boolean();
    $gender = $L ? 'male' : 'female';
    return [
        'nip' => strval($faker->randomNumber(8)),
        'nama_guru' => $faker->firstName($gender) . ' ' . $faker->lastName($gender),
        'jk' => $L ? 'L' : 'P',
        'telp' => $faker->e164PhoneNumber,
        'tmp_lahir' => $faker->city,
        'tgl_lahir' => $faker->date('Y-m-d', '-30 years'),
        'foto' => $L ? 'uploads/guru/35251431012020_male.jpg' : 'uploads/guru/23171022042020_female.jpg'
    ];
});
