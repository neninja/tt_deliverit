<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Illuminate\Pagination\Paginator;
use Illuminate\Http\Request;
use App\Http\Resources\ProvaResource;

use Core\UseCases\CadastroProva\{
    CadastroProvaUC,
    CadastroProvaDTO,
};

class ProvaController extends Controller
{
    public function __construct(
        CadastroProvaUC $cadastroProvaUC
    ) {
        $this->cadastroProvaUC = $cadastroProvaUC;
    }

    /**
     * @OA\Get(
     *     tags={"prova"},
     *     path="/provas",
     *     description="Lista provas",
     *     @OA\Parameter(
     *         description="Id do tipo de prova",
     *         in="query",
     *         name="tipo",
     *         required=false,
     *         @OA\Schema(type="int", example="1")
     *     ),
     *     @OA\Parameter(
     *         description="Data da prova",
     *         in="query",
     *         name="nome",
     *         required=false,
     *         @OA\Schema(type="string", example="20210706")
     *     ),
     *     @OA\Response(response="200", description="Lista de provas")
     * )
     */
    public function index(Request $req)
    {
        $qtd = $req->qtd ?: 2;
        $page = $req->page ?: 1;
        $data = $req->data ?: "";
        $tipo = $req->tipo ?: "";

        Paginator::currentPageResolver(function() use ($page){
            return $page;
        });

        $qb = DB::table('provas');

        if(!empty($data))
            $qb->where('data', '=', $data);

        if(!empty($tipo))
            $qb->where('id_tiposProva', '=', $tipo);

        $provas = $qb
            ->join('tiposProva', 'tiposProva.id', '=', 'provas.id_tipoProva')
            ->select(
                'provas.id as id',
                'provas.data',
                'provas.id_tipoProva',
                'tiposProva.distanciaEmKM'
            )
            ->get();

        return ['data' => $provas];
    }

    /**
     * @OA\Post(
     *     tags={"prova"},
     *     path="/provas",
     *     description="Cadastro prova",
     *     @OA\RequestBody(
     *         @OA\MediaType(mediaType="application/json;charset=UTF-8",
     *         @OA\Schema(
     *             @OA\Property(
     *                  property="tipo",
     *                  type="int",
     *                  example="1"
     *             ),
     *             @OA\Property(
     *                  property="data",
     *                  type="string",
     *                  example="20210706"
     *             )
     *         )
     *         )
     *     ),
     *     @OA\Response(response="200", description="Prova criada")
     * )
     */
    public function store(Request $req)
    {
        $dto = new CadastroProvaDTO();
        $dto->tipo = $req->tipo;
        $dto->data = $req->data
            ? \DateTime::createFromFormat('Ymd', $req['data'])
            : null;

        $prova = $this->cadastroProvaUC->execute($dto);

        return new ProvaResource($prova);
    }
}
