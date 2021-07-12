<?php

namespace Core\UseCases\InscricaoProva;

use Core\Exceptions\UseCaseException;
use Core\Models\Participacao;
use Core\Contracts\Repositories\{
    IParticipacoesRepository,
    ICorredoresRepository,
    IProvasRepository,
};

class InscricaoProvaUC
{
    private IParticipacoesRepository $participacoesRepository;
    private ICorredoresRepository $corredoresProvaRepo;
    private IProvasRepository $provasRepo;

    public function __construct(
        IParticipacoesRepository $participacoesRepository,
        ICorredoresRepository $corredoresRepo,
        IProvasRepository $provasRepo
    ) {
        $this->participacoesRepo = $participacoesRepository;
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
            ->participacoesRepo
            ->possuiParticipacaoNoDia($corredor->id, $prova->data);

        if($diaJaOcupado) {
            throw new UseCaseException(
                "Corredor já cadastrado no mesmo dia"
            );
        }

        $novaInscricao = new Participacao(null, $corredor, $prova);

        $inscricao = $this
            ->participacoesRepo
            ->save($novaInscricao);

        return $inscricao;
    }
}

