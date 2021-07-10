<?php

namespace Database\Seeders;

use App\Models\Corredor;
use App\Models\Prova;
use Illuminate\Database\Seeder;

class FakeSeeder extends Seeder
{
    public function run()
    {
        Corredor::factory()->count(3)->create();
        Prova::factory()->count(5)->create();
    }
}
