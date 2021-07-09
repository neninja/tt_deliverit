<?php

namespace Core\Tests\UseCases;

use Core\Models\{
    Prova,
    TipoProva,
};
use Core\UseCases\CadastroProva\{
    CadastroProvaUC,
    CadastroProvaDTO,
};
use Core\Contracts\Repositories\{
    IProvasRepository,
    ITiposProvaRepository,
};
use Core\Contracts\Repositories\ICorredoresRepository;

class CadastroProvaTest extends \PHPUnit\Framework\TestCase
{
    protected function setUp(): void
    {
        parent::setUp();
        $this->setUpDoubles();
    }

    private function setUpDoubles()
    {
        $this->doubleProvasRepo = self::createMock(
            IProvasRepository::class
        );

        $this->doubleTiposProvaRepo = self::createMock(
            ITiposProvaRepository::class
        );
    }

    protected function newSut(?array $methodsToMock = null) {
        return $this
            ->getMockBuilder(CadastroProvaUC::class)
            ->setConstructorArgs([
                $this->doubleProvasRepo,
                $this->doubleTiposProvaRepo,
            ])
            ->setMethods($methodsToMock)
            ->getMock();
    }

    public function testDeveRetornarNovaProvaComId()
    {
        $tipo = new TipoProva(1, 3);

        $novoId = 3356598;
        $novaProva = new Prova(
            $novoId,
            $tipo,
            \DateTime::createFromFormat('Y-m-d', '2021-09-17')
        );

        $this
            ->doubleTiposProvaRepo
            ->method('findById')
            ->willReturn($tipo);

        $this
            ->doubleProvasRepo
            ->method('save')
            ->willReturn($novaProva);

        $dto = new CadastroProvaDTO();
        $dto->tipo = $tipo->id;
        $dto->data = $novaProva->data;

        $sut = $this->newSut();

        $provaCriada = $sut->execute($dto);

        self::assertEquals($novoId, $provaCriada->id);
    }
}
