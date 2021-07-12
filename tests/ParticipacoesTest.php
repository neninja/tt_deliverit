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
        $this->get('/participacoes/classificacao-por-idade')
             ->seeJson([ 'data' => $retorno ]);
    }

    /**
     * @dataProvider \Tests\ParticipacoesData\DeveListarClassificacoesPorTipoDeProva::data
     * @group http
     * @group db
     */
    public function testDeveListarClassificacoesPorTipoDeProva($retorno)
    {
        \Tests\ParticipacoesData\DeveListarClassificacoesPorTipoDeProva::seed();
        $this->get('/participacoes/classificacao-por-tipo')
             ->seeJson([ 'data' => $retorno ]);
    }
}
