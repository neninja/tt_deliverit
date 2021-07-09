<?php

namespace Core\UseCases\CadastroProva;

use Core\Models\Prova;
use Core\Contracts\Repositories\{
    IProvasRepository,
    ITiposProvaRepository,
};

class CadastroProvaUC
{
    private IProvasRepository $provasRepo;
    private ITiposProvaRepository $tiposProvaRepo;

    public function __construct(
        IProvasRepository $provasRepo,
        ITiposProvaRepository $tiposProvaRepo
    ) {
        $this->provasRepo = $provasRepo;
        $this->tiposProvaRepo = $tiposProvaRepo;
    }

    public function execute(CadastroProvaDTO $dto)
    {
        $tipo = $this
            ->tiposProvaRepo
            ->findById($dto->tipo);

        $novaProva = new Prova(null, $tipo, $dto->data);

        $prova = $this
            ->provasRepo
            ->save($novaProva);

        return $prova;
    }
}

