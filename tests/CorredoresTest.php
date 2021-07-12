<?php

namespace Tests;

use Laravel\Lumen\Testing\DatabaseMigrations;
use Laravel\Lumen\Testing\DatabaseTransactions;

class CorredoresTest extends TestCase
{
    use DatabaseMigrations;

    /**
     * @group http
     * @group db
     */
    public function testDeveListarCorredores()
    {
        $response = $this->call('GET', '/corredores');

        $this->assertEquals(200, $response->status());
    }
}
