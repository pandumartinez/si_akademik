<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Siswa;
use Faker\Generator as Faker;

$factory->define(Siswa::class, function (Faker $faker) {
    $L = $faker->boolean();
    $gender = $L ? 'male' : 'female';
    return [
        'nis' => strval($faker->randomNumber(5)),
        'nisn' => strval($faker->randomNumber(8)),
        'nama_siswa' => $faker->firstName($gender) . ' ' . $faker->lastName($gender),
        'jk' => $L ? 'L' : 'P',
        'telp' => $faker->e164PhoneNumber,
        'tmp_lahir' => $faker->city,
        'tgl_lahir' => $faker->dateTimeBetween('-17 years', '-14 years'),
        'foto' => $L ? 'uploads/siswa/52471919042020_male.jpg' : 'uploads/siswa/50271431012020_female.jpg'
    ];
});
