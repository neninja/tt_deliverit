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

    /**
     * @dataProvider \Tests\ParticipacoesData\DeveListarClassificacoesPorIdade::data
     * @group http
     * @group db
     */
    public function testDeveListarClassificacoesPorIdade($retorno)
    {
        \Tests\ParticipacoesData\DeveListarClassificacoesPorIdade::seed();
        $this->get('/participacoes/1/classificacao-por-idade')
             ->seeJson($retorno);
    }
}
