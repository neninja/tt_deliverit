<?php

namespace Core\UseCases\CadastroResultado;

use Core\Exceptions\UseCaseException;
use Core\Models\Participacao;
use Core\Contracts\Repositories\{
    IParticipacoesRepository,
    ICorredoresRepository,
    IProvasRepository,
};

class CadastroResultadoUC
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

    public function execute(CadastroResultadoDTO $dto)
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

        $participacao = $this
            ->participacoesRepo
            ->findByCorredorProva($corredor->id, $prova->id);

        if(is_null($participacao)) {
            throw new UseCaseException(
                "Corredor não foi inscrito para esta prova"
            );
        }

        $participacao->horarioInicio = $dto->horarioInicio;
        $participacao->horarioFim = $dto->horarioFim;

        $inscricao = $this
            ->participacoesRepo
            ->save($participacao);

        return $inscricao;
    }
}
