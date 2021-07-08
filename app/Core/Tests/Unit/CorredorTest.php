<?php

namespace Core\Tests\Unit;

use Core\Models\Corredor;

use Core\Exceptions\CoreException;

class CorredorTest extends \PHPUnit\Framework\TestCase
{
    public function testDeveFalharComCorredorMenorDeIdade()
    {
        try {
            $corredor = new Corredor(
                null,
                "Ricardo",
                "37128197060",
                \DateTime::createFromFormat('Ymd', '20200508')
            );
            self::fail('Deve cair no catch');
        } catch (CoreException $e) {
            self::assertEquals(
                $e->mensagemAmigavel(), "Corredor não pode ser menor de idade"
            );
        }
    }
}

