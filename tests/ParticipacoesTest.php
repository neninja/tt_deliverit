<?php

namespace Tests;

use Laravel\Lumen\Testing\DatabaseMigrations;
use Laravel\Lumen\Testing\DatabaseTransactions;

class ParticipacoesTest extends TestCase
{
    use DatabaseMigrations;

    public function testDeveListarInscricoes()
    {
        $response = $this->call('GET', '/participacoes');

        $this->assertEquals(200, $response->status());
    }
}
