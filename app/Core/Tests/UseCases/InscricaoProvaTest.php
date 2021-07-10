<?php

namespace Core\Tests\UseCases;

use Core\Exceptions\CoreException;
use Core\Models\{
    Prova,
    TipoProva,
    Corredor,
    Inscricao,
};
use Core\UseCases\InscricaoProva\{
    InscricaoProvaUC,
    InscricaoProvaDTO,
};
use Core\Contracts\Repositories\{
    IProvasRepository,
    ICorredoresRepository,
    IInscricoesRepository,
};

class InscricaoProvaTest extends \PHPUnit\Framework\TestCase
{
    protected function setUp(): void
    {
        parent::setUp();
        $this->setUpDoubles();
    }

    private function setUpDoubles()
    {
        $this->doubleInscricoesRepo = self::createMock(
            IInscricoesRepository::class
        );

        $this->doubleCorredoresRepo = self::createMock(
            ICorredoresRepository::class
        );

        $this->doubleProvasRepo = self::createMock(
            IProvasRepository::class
        );
    }

    protected function newSut(?array $methodsToMock = null) {
        return $this
            ->getMockBuilder(InscricaoProvaUC::class)
            ->setConstructorArgs([
                $this->doubleInscricoesRepo,
                $this->doubleCorredoresRepo,
                $this->doubleProvasRepo,
            ])
            ->setMethods($methodsToMock)
            ->getMock();
    }

    public function testDeveRetornarNovaInscricaoComId()
    {
        $prova = new Prova(
            3356598,
            new TipoProva(1, 3),
            \DateTime::createFromFormat('Y-m-d', '2021-09-17')
        );

        $corredor = new Corredor(
            46834351,
            "Gabriel",
            "03475703998",
            \DateTime::createFromFormat('Y-m-d', '1997-09-17')
        );

        $novoId = 5454668456;
        $novaInscricao = new Inscricao($novoId, $corredor, $prova);

        $this
            ->doubleCorredoresRepo
            ->method('findById')
            ->willReturn($corredor);

        $this
            ->doubleInscricoesRepo
            ->method('possuiInscricaoNoDia')
            ->willReturn(false);

        $this
            ->doubleProvasRepo
            ->method('findById')
            ->willReturn($prova);

        $this
            ->doubleInscricoesRepo
            ->method('save')
            ->willReturn($novaInscricao);

        $dto = new InscricaoProvaDTO();
        $dto->corredor = $corredor->id;
        $dto->prova = $prova->id;

        $sut = $this->newSut();

        $inscricaoCriada = $sut->execute($dto);

        self::assertEquals($novoId, $inscricaoCriada->id);
    }

    public function testDeveFalharInscricaoDaSegundaProvaNoMesmoDia()
    {
        $prova = new Prova(
            3356598,
            new TipoProva(1, 3),
            \DateTime::createFromFormat('Y-m-d', '2021-09-17')
        );

        $corredor = new Corredor(
            46834351,
            "Gabriel",
            "03475703998",
            \DateTime::createFromFormat('Y-m-d', '1997-09-17')
        );

        $novoId = 5454668456;
        $novaInscricao = new Inscricao($novoId, $corredor, $prova);

        $this
            ->doubleCorredoresRepo
            ->method('findById')
            ->willReturn($corredor);

        $this
            ->doubleInscricoesRepo
            ->method('possuiInscricaoNoDia')
            ->willReturn(true);

        $this
            ->doubleProvasRepo
            ->method('findById')
            ->willReturn($prova);

        $this
            ->doubleInscricoesRepo
            ->method('save')
            ->willReturn($novaInscricao);

        $dto = new InscricaoProvaDTO();
        $dto->corredor = $corredor->id;
        $dto->prova = $prova->id;

        $sut = $this->newSut();

        try {
            $inscricaoCriada = $sut->execute($dto);
            self::fail('Deve cair no catch');
        } catch (CoreException $e) {
            self::assertEquals(
                $e->mensagemAmigavel(),
                "Corredor já cadastrado em outra prova no mesmo dia"
            );
        }
    }
}

