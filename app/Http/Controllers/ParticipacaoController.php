<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Illuminate\Pagination\Paginator;
use Illuminate\Http\Request;
use App\Models\{
    Participacao,
    TipoProva,
};
use App\Http\Resources\{
    ParticipacaoResource,
    ClassificacaoResource,
};
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

    /**
     * @OA\Get(
     *     tags={"classificação"},
     *     path="/participacoes/{prova}/classificacao-por-idade",
     *     description="Classificação por grupos de idade",
     *     @OA\Parameter(
     *         description="Id da prova",
     *         in="path",
     *         name="prova",
     *         required=false,
     *         @OA\Schema(type="int", example="1")
     *     ),
     *     @OA\Response(response="200", description="Classificação dividida por grupos de idades")
     * )
     */
    public function classificacaoPorIdade(int $idProva)
    {
        $classifica = function(int $idadeMin, int $idadeMax) use ($idProva) {
            return DB::table('participacoes')
                ->join('corredores', 'corredores.id', '=', 'participacoes.id_corredor')
                ->join('provas', 'provas.id', '=', 'participacoes.id_prova')
                ->join('tiposProva', 'tiposProva.id', '=', 'provas.id_tipoProva')
                ->select(
                    'participacoes.id as id',
                    'participacoes.id_prova',
                    'participacoes.id_corredor',
                    'corredores.nome',
                    'corredores.dataNascimento',
                    'provas.data',
                    'tiposProva.distanciaEmKM',
                    'participacoes.horarioInicio',
                    'participacoes.horarioFim',
                    'participacoes.horarioInicio as tempoDeProva',
                )
                ->where('participacoes.id_prova', '=', $idProva)
                ->whereDate('corredores.dataNascimento', '<=', date('Y-m-d', strtotime("-{$idadeMin} year")))
                ->whereDate('corredores.dataNascimento', '>', date('Y-m-d', strtotime("-{$idadeMax} year")))
                ->get()
                ->map(function ($p) {
                    $horarioInicioUnix = date_create_from_format('H:i:s', $p->horarioInicio)->format('U');
                    $horarioFimUnix = date_create_from_format('H:i:s', $p->horarioFim)->format('U');
                    $p->tempoDeProva = $horarioFimUnix - $horarioInicioUnix;
                    $p->total = $horarioFimUnix - $horarioInicioUnix;
                    return $p;
                })
                ->sortBy('tempoDeProva')
                ->values()
                ->map(function ($p, $i) {
                    $p->posicao = $i + 1;
                    return $p;
                })
                ->all()
            ;

        };

        return [
            'data' => [
                '18-25' => ClassificacaoResource::collection($classifica(18, 25)),
                '25-35' => ClassificacaoResource::collection($classifica(25, 35)),
                '35-45' => ClassificacaoResource::collection($classifica(35, 45)),
                '45-55' => ClassificacaoResource::collection($classifica(45, 55)),
                '55+' => ClassificacaoResource::collection($classifica(55, 200)),
            ]
        ];
    }

    /**
     * @OA\Get(
     *     tags={"classificação"},
     *     path="/participacoes/classificacao-por-tipo",
     *     description="Classificação por grupos de idade",
     *     @OA\Response(response="200", description="Classificação dividida por tipos de provas")
     * )
     */
    public function classificacaoPorTipo()
    {
        $classifica = function(int $idTipoProva) {
            return DB::table('participacoes')
                ->join('corredores', 'corredores.id', '=', 'participacoes.id_corredor')
                ->join('provas', 'provas.id', '=', 'participacoes.id_prova')
                ->join('tiposProva', 'tiposProva.id', '=', 'provas.id_tipoProva')
                ->select(
                    'participacoes.id as id',
                    'participacoes.id_prova',
                    'participacoes.id_corredor',
                    'corredores.nome',
                    'corredores.dataNascimento',
                    'provas.data',
                    'tiposProva.distanciaEmKM',
                    'participacoes.horarioInicio',
                    'participacoes.horarioFim',
                    'participacoes.horarioInicio as tempoDeProva',
                )
                ->where('tiposProva.id', '=', $idTipoProva)
                ->get()
                ->map(function ($p) {
                    $horarioInicioUnix = date_create_from_format('H:i:s', $p->horarioInicio)->format('U');
                    $horarioFimUnix = date_create_from_format('H:i:s', $p->horarioFim)->format('U');
                    $p->tempoDeProva = $horarioFimUnix - $horarioInicioUnix;
                    $p->total = $horarioFimUnix - $horarioInicioUnix;
                    return $p;
                })
                ->sortBy('tempoDeProva')
                ->values()
                ->map(function ($p, $i) {
                    $p->posicao = $i + 1;
                    return $p;
                })
                ->all()
            ;

        };

        $classificacoes = DB::table('tiposProva')
            ->select('id')
            ->get()
            ->map(function($t) use ($classifica) {
                return ClassificacaoResource::collection($classifica($t->id));
            });

        return [ 'data' => $classificacoes ];
    }
}

