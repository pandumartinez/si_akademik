<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class SiswaFactory extends Factory
{
    public function definition()
    {
        $L = $this->faker->boolean();
        $gender = $L ? 'male' : 'female';
        return [
            'nis' => strval($this->faker->randomNumber(5)),
            'nisn' => strval($this->faker->randomNumber(8)),
            'nama_siswa' => $this->faker->firstName($gender) . ' ' . $this->faker->lastName($gender),
            'jk' => $L ? 'L' : 'P',
            'telp' => $this->faker->e164PhoneNumber,
            'tmp_lahir' => $this->faker->city,
            'tgl_lahir' => $this->faker->dateTimeBetween('-17 years', '-14 years'),
            'foto' => $L ? 'uploads/siswa/52471919042020_male.jpg' : 'uploads/siswa/50271431012020_female.jpg'
        ];
    }
}
