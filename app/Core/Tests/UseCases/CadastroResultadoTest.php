<?php

namespace Core\Tests\UseCases;

use Core\Exceptions\CoreException;
use Core\Models\{
    Prova,
    TipoProva,
    Corredor,
    Participacao,
};
use Core\UseCases\CadastroResultado\{
    CadastroResultadoUC,
    CadastroResultadoDTO,
};
use Core\Contracts\Repositories\{
    IProvasRepository,
    ICorredoresRepository,
    IParticipacoesRepository,
};

class CadastroResultadoTest extends \PHPUnit\Framework\TestCase
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
            ->getMockBuilder(CadastroResultadoUC::class)
            ->setConstructorArgs([
                $this->doubleParticipacoesRepo,
                $this->doubleCorredoresRepo,
                $this->doubleProvasRepo,
            ])
            ->setMethods($methodsToMock)
            ->getMock();
    }

    public function testDeveAtualizarParticipacaoDoCorredor()
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

        $participacao = new Participacao(
            64543157,
            $corredor,
            $prova,
        );

        $dto = new CadastroResultadoDTO();
        $dto->corredor = $corredor->id;
        $dto->prova = $prova->id;
        $dto->horarioInicio = date_create_from_format('H:i', '08:00');
        $dto->horarioFim = date_create_from_format('H:i', '11:00');

        $this
            ->doubleCorredoresRepo
            ->method('findById')
            ->willReturn($corredor);

        $this
            ->doubleProvasRepo
            ->method('findById')
            ->willReturn($prova);

        $this
            ->doubleParticipacoesRepo
            ->method('findByCorredorProva')
            ->willReturn($participacao);

        $participacao->horarioInicio = date_create_from_format('H:i', '08:00');
        $participacao->horarioFim = date_create_from_format('H:i', '11:00');

        $this
            ->doubleParticipacoesRepo
            ->method('save')
            ->willReturn($participacao);

        $sut = $this->newSut();

        $participacaoAtualizada = $sut->execute($dto);

        self::assertEquals(
            $participacaoAtualizada->horarioInicio,
            $participacao->horarioInicio
        );

        self::assertEquals(
            $participacaoAtualizada->horarioFim,
            $participacao->horarioFim
        );
    }
}

