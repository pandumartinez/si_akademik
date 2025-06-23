<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class GuruFactory extends Factory
{
    public function definition()
    {
        $L = $this->faker->boolean();
        $gender = $L ? 'male' : 'female';
        return [
            'nip' => strval($this->faker->randomNumber(8)),
            'nama_guru' => $this->faker->firstName($gender) . ' ' . $this->faker->lastName($gender),
            'jk' => $L ? 'L' : 'P',
            'telp' => $this->faker->e164PhoneNumber,
            'tmp_lahir' => $this->faker->city,
            'tgl_lahir' => $this->faker->date('Y-m-d', '-30 years'),
            'foto' => $L ? 'uploads/guru/35251431012020_male.jpg' : 'uploads/guru/23171022042020_female.jpg'
        ];
    }
}
