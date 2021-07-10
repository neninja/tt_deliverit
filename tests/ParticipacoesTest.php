<?php

use Laravel\Lumen\Testing\DatabaseMigrations;
use Laravel\Lumen\Testing\DatabaseTransactions;

class ParticipacoesTest extends TestCase
{
    public function testDeveListarInscricoes()
    {
        $response = $this->call('GET', '/participacoes');

        $this->assertEquals(200, $response->status());
    }
}
