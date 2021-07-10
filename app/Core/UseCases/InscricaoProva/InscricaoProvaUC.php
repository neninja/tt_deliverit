<?php

namespace Core\UseCases\InscricaoProva;

use Core\Exceptions\UseCaseException;
use Core\Models\Inscricao;
use Core\Contracts\Repositories\{
    IInscricoesRepository,
    ICorredoresRepository,
    IProvasRepository,
};

class InscricaoProvaUC
{
    private IInscricoesRepository $inscricoesRepo;
    private ICorredoresRepository $corredoresProvaRepo;
    private IProvasRepository $provasRepo;

    public function __construct(
        IInscricoesRepository $inscricoesRepo,
        ICorredoresRepository $corredoresRepo,
        IProvasRepository $provasRepo
    ) {
        $this->inscricoesRepo = $inscricoesRepo;
        $this->corredoresRepo = $corredoresRepo;
        $this->provasRepo = $provasRepo;
    }

    public function execute(InscricaoProvaDTO $dto)
    {
        $corredor = $this
            ->corredoresRepo
            ->findById($dto->corredor);

        if(is_null($corredor)){
            throw new UseCaseException("Corredor não encontrado");
        }

        $prova = $this
            ->provasRepo
            ->findById($dto->prova);

        if(is_null($prova)){
            throw new UseCaseException("Prova não encontrada");
        }

        $diaJaOcupado = $this
            ->inscricoesRepo
            ->possuiInscricaoNoDia($prova->data);

        if($diaJaOcupado) {
            throw new UseCaseException(
                "Corredor já cadastrado em outra prova no mesmo dia"
            );
        }


        $novaInscricao = new Inscricao(null, $corredor, $prova);

        $inscricao = $this
            ->inscricoesRepo
            ->save($novaInscricao);

        return $inscricao;
    }
}


