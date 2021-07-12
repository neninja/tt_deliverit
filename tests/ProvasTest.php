<?php

namespace Tests;

use Laravel\Lumen\Testing\DatabaseMigrations;
use Laravel\Lumen\Testing\DatabaseTransactions;

class ProvasTest extends TestCase
{
    public function testDeveListarProvas()
    {
        $response = $this->call('GET', '/provas');

        $this->assertEquals(200, $response->status());
    }
}
