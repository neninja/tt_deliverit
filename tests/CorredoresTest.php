<?php

use Laravel\Lumen\Testing\DatabaseMigrations;
use Laravel\Lumen\Testing\DatabaseTransactions;

class CorredoresTest extends TestCase
{
    public function testDeveListarCorredores()
    {
        $response = $this->call('GET', '/corredores');

        $this->assertEquals(200, $response->status());
    }
}
