<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Illuminate\Pagination\Paginator;
use Illuminate\Http\Request;
use App\Http\Resources\InscricaoResource;

use Core\UseCases\InscricaoProva\{
    InscricaoProvaUC,
    InscricaoProvaDTO,
};

class InscricaoController extends Controller
{
    public function __construct(
        InscricaoProvaUC $inscricaoProvaUC
    ) {
        $this->inscricaoProvaUC = $inscricaoProvaUC;
    }

    /**
     * @OA\Get(
     *     tags={"inscricao"},
     *     path="/inscricoes",
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

        $qb = DB::table('inscricoes');

        if(!empty($corredor))
            $qb->where('id_corredor', '=', $corredor);

        if(!empty($prova))
            $qb->where('id_prova', '=', $prova);

        $provas = $qb
            ->join('corredores', 'corredores.id', '=', 'inscricoes.id_corredor')
            ->join('provas', 'provas.id', '=', 'inscricoes.id_prova')
            ->join('tiposProva', 'tiposProva.id', '=', 'provas.id_tipoProva')
            ->select(
                'inscricoes.id as id',
                'inscricoes.id_prova',
                'inscricoes.id_corredor',
                'corredores.nome',
                'provas.data',
                'tiposProva.distanciaEmKM'
            )
            ->get();

        return ['data' => $provas];
    }

    /**
     * @OA\Post(
     *     tags={"inscricao"},
     *     path="/inscricoes",
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
     *     @OA\Response(response="200", description="Prova criada")
     * )
     */
    public function store(Request $req)
    {
        $dto = new InscricaoProvaDTO();
        $dto->corredor = $req->corredor;
        $dto->prova = $req->prova;

        $inscricao = $this->inscricaoProvaUC->execute($dto);

        return new InscricaoResource($inscricao);
    }
}

