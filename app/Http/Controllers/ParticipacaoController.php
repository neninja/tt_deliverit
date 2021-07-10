<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Illuminate\Pagination\Paginator;
use Illuminate\Http\Request;
use App\Http\Resources\ParticipacaoResource;
use Core\UseCases\{
    InscricaoProva\InscricaoProvaUC,
    InscricaoProva\InscricaoProvaDTO,
    CadastroResultado\CadastroResultadoUC,
    CadastroResultado\CadastroResultadoDTO,
};

class ParticipacaoController extends Controller
{
    public function __construct(
        InscricaoProvaUC $inscricaoProvaUC,
        CadastroResultadoUC $cadastroResultadoUC
    ) {
        $this->inscricaoProvaUC = $inscricaoProvaUC;
        $this->cadastroResultadoUC = $cadastroResultadoUC;
    }

    /**
     * @OA\Get(
     *     tags={"participação"},
     *     path="/participacoes",
     *     description="Lista inscrições de corredores em provas",
     *     @OA\Parameter(
     *         description="Id do corredor",
     *         in="query",
     *         name="corredor",
     *         required=false,
     *         @OA\Schema(type="int", example="1")
     *     ),
     *     @OA\Parameter(
     *         description="Id da prova",
     *         in="query",
     *         name="prova",
     *         required=false,
     *         @OA\Schema(type="int", example="1")
     *     ),
     *     @OA\Response(response="200", description="Lista de inscricoes")
     * )
     */
    public function index(Request $req)
    {
        $qtd = $req->qtd ?: 2;
        $page = $req->page ?: 1;
        $corredor = $req->data ?: "";
        $prova = $req->tipo ?: "";

        Paginator::currentPageResolver(function() use ($page){
            return $page;
        });

        $qb = DB::table('participacoes');

        if(!empty($corredor))
            $qb->where('id_corredor', '=', $corredor);

        if(!empty($prova))
            $qb->where('id_prova', '=', $prova);

        $provas = $qb
            ->join('corredores', 'corredores.id', '=', 'participacoes.id_corredor')
            ->join('provas', 'provas.id', '=', 'participacoes.id_prova')
            ->join('tiposProva', 'tiposProva.id', '=', 'provas.id_tipoProva')
            ->select(
                'participacoes.id as id',
                'participacoes.id_prova',
                'participacoes.id_corredor',
                'corredores.nome',
                'provas.data',
                'tiposProva.distanciaEmKM'
            )
            ->get();

        return ['data' => $provas];
    }

    /**
     * @OA\Post(
     *     tags={"participação"},
     *     path="/participacoes",
     *     description="Inscrição de corredor em prova",
     *     @OA\RequestBody(
     *         @OA\MediaType(mediaType="application/json;charset=UTF-8",
     *         @OA\Schema(
     *             @OA\Property(
     *                  property="corredor",
     *                  type="int",
     *                  example="1"
     *             ),
     *             @OA\Property(
     *                  property="prova",
     *                  type="int",
     *                  example="1"
     *             )
     *         )
     *         )
     *     ),
     *     @OA\Response(response="200", description="Inscrição criada")
     * )
     */
    public function store(Request $req)
    {
        $dto = new InscricaoProvaDTO();
        $dto->corredor = $req->corredor;
        $dto->prova = $req->prova;

        $participacao = $this->inscricaoProvaUC->execute($dto);

        return new ParticipacaoResource($participacao);
    }

    /**
     * @OA\Put(
     *     tags={"participação"},
     *     path="/participacoes",
     *     description="Atualização da inscrição do corredor na prova",
     *     @OA\RequestBody(
     *         @OA\MediaType(mediaType="application/json;charset=UTF-8",
     *         @OA\Schema(
     *             @OA\Property(
     *                  property="corredor",
     *                  type="int",
     *                  example="1"
     *             ),
     *             @OA\Property(
     *                  property="prova",
     *                  type="int",
     *                  example="1"
     *             ),
     *             @OA\Property(
     *                  property="horarioInicio",
     *                  type="string",
     *                  example="09:00"
     *             ),
     *             @OA\Property(
     *                  property="horarioFim",
     *                  type="string",
     *                  example="11:00"
     *             )
     *         )
     *         )
     *     ),
     *     @OA\Response(response="200", description="Participação atualizada")
     * )
     */
    public function update(Request $req)
    {
        $dto = new CadastroResultadoDTO();
        $dto->corredor = $req->corredor;
        $dto->prova = $req->prova;

        $dto->horarioInicio = date_create_from_format(
            'H:i', $req->horarioInicio
        ) ?? null;

        $dto->horarioFim = date_create_from_format(
            'H:i', $req->horarioFim
        ) ?? null;

        $participacao = $this->cadastroResultadoUC->execute($dto);

        return new ParticipacaoResource($participacao);
    }
}

