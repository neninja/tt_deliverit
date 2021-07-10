<?php

use Laravel\Lumen\Testing\DatabaseMigrations;
use Laravel\Lumen\Testing\DatabaseTransactions;

class InscricoesTest extends TestCase
{
    public function testDeveListarInscricoes()
    {
        $response = $this->call('GET', '/inscricoes');

        $this->assertEquals(200, $response->status());
    }
}
