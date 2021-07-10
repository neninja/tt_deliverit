<?php

namespace Core\Tests\UseCases;

use Core\Exceptions\CoreException;
use Core\Models\{
    Prova,
    TipoProva,
    Corredor,
    Participacao,
};
use Core\UseCases\InscricaoProva\{
    InscricaoProvaUC,
    InscricaoProvaDTO,
};
use Core\Contracts\Repositories\{
    IProvasRepository,
    ICorredoresRepository,
    IParticipacoesRepository,
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
        $this->doubleParticipacoesRepo = self::createMock(
            IParticipacoesRepository::class
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
                $this->doubleParticipacoesRepo,
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
        $novaInscricao = new Participacao($novoId, $corredor, $prova);

        $this
            ->doubleCorredoresRepo
            ->method('findById')
            ->willReturn($corredor);

        $this
            ->doubleParticipacoesRepo
            ->method('possuiParticipacaoNoDia')
            ->willReturn(false);

        $this
            ->doubleProvasRepo
            ->method('findById')
            ->willReturn($prova);

        $this
            ->doubleParticipacoesRepo
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
        $novaInscricao = new Participacao($novoId, $corredor, $prova);

        $this
            ->doubleCorredoresRepo
            ->method('findById')
            ->willReturn($corredor);

        $this
            ->doubleParticipacoesRepo
            ->method('possuiParticipacaoNoDia')
            ->willReturn(true);

        $this
            ->doubleProvasRepo
            ->method('findById')
            ->willReturn($prova);

        $this
            ->doubleParticipacoesRepo
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
                "Corredor já cadastrado no mesmo dia"
            );
        }
    }
}

