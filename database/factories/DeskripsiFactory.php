<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Deskripsi;
use Faker\Generator as Faker;

$factory->define(Deskripsi::class, function (Faker $faker) {
    return [
        'deskripsi' => $faker->paragraph()
    ];
});
