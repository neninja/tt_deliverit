<?php

namespace Database\Factories;

use App\Models\Corredor;
use Illuminate\Database\Eloquent\Factories\Factory;
use Faker\Factory as FFactory;

class CorredorFactory extends Factory
{
    protected $model = Corredor::class;

    public function definition()
    {
        // locale do faker não é configurável no lumen ainda, somente laravel
        // https://github.com/laravel/lumen-framework/issues/989#issuecomment-543134834
        $fakerptbr = FFactory::create('pt_BR');

        return [
            'nome' => $this->faker->name,
            'cpf' => $fakerptbr->unique()->cpf(false),
            'dataNascimento' => $this->faker->dateTimeInInterval(
                '-30 years', '-20 years', 'UTC'
            ),
        ];
    }
}
