<?php

namespace Database\Factories;

use App\Models\Prova;
use Illuminate\Database\Eloquent\Factories\Factory;

class ProvaFactory extends Factory
{
    protected $model = Prova::class;

    public function definition()
    {
        return [
            'id_tipoProva' => $this->faker->numberBetween(1, 5), // padrão da aplicação
            'data' => $this->faker->dateTimeInInterval(
                '-10 days', '+10 days', 'UTC'
            ),
        ];
    }
}

