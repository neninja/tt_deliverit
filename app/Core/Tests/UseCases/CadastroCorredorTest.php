<?php

namespace Core\Tests\UseCases;

use Core\Models\Corredor;
use Core\UseCases\CadastroCorredor\{
    CadastroCorredorUC,
    CadastroCorredorDTO,
};
use Core\Contracts\Repositories\ICorredoresRepository;

class CadastroCorredorTest extends \PHPUnit\Framework\TestCase
{
    protected function setUp(): void
    {
        parent::setUp();
        $this->setUpDoubles();
    }

    private function setUpDoubles()
    {
        $this->doubleRepo = self::createMock(
            ICorredoresRepository::class
        );
    }

    protected function newSut(?array $methodsToMock = null) {
        return $this
            ->getMockBuilder(CadastroCorredorUC::class)
            ->setConstructorArgs([
                $this->doubleRepo,
            ])
            ->setMethods($methodsToMock)
            ->getMock();
    }

    public function testDeveRetornarNovoCorredorComId()
    {
        $novoId = 3356598;
        $novoCorredor = new Corredor(
            $novoId,
            "Eduardo",
            "03475703998",
            \DateTime::createFromFormat('Y-m-d', '1997-09-17')
        );

        $this
            ->doubleRepo
            ->method('save')
            ->willReturn($novoCorredor);

        $dto = new CadastroCorredorDTO();
        $dto->nome = $novoCorredor->nome;
        $dto->cpf = $novoCorredor->cpf->getNumero();
        $dto->dataNascimento = $novoCorredor->dataNascimento;

        $sut = $this->newSut();

        $corredorCriado = $sut->execute($dto);

        self::assertEquals($novoId, $corredorCriado->id);
    }
}
