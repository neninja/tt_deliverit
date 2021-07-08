<?php

namespace Core\UseCases\CadastroCorredor;

use Core\Models\Corredor;
use Core\Contracts\Repositories\ICorredoresRepository;

class CadastroCorredorUC
{
    private ICorredoresRepository $repo;

    public function __construct(
        ICorredoresRepository $repo
    ) {
        $this->repo = $repo;
    }

    public function execute(CadastroCorredorDTO $dto)
    {
        $novoCorredor = new Corredor(
            null, $dto->nome, $dto->cpf, $dto->dataNascimento
        );

        $corredor = $this
            ->repo
            ->save($novoCorredor);

        return $corredor;
    }
}
