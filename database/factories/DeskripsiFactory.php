<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class DeskripsiFactory extends Factory
{
    public function definition()
    {
        return [
            'deskripsi' => $this->faker->paragraph()
        ];
    }
}