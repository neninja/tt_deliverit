<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('tiposProva')->insert([
            ['distanciaEmKM' => 3],
            ['distanciaEmKM' => 5],
            ['distanciaEmKM' => 10],
            ['distanciaEmKM' => 21],
            ['distanciaEmKM' => 42]
        ]);
    }
}
