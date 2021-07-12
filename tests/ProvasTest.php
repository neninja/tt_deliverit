<?php

namespace Tests;

use Laravel\Lumen\Testing\DatabaseMigrations;
use Laravel\Lumen\Testing\DatabaseTransactions;

class ProvasTest extends TestCase
{
    use DatabaseMigrations;

    /**
     * @group http
     * @group db
     */
    public function testDeveListarProvas()
    {
        $response = $this->call('GET', '/provas');

        $this->assertEquals(200, $response->status());
    }
}
