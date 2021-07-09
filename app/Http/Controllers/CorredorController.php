<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Illuminate\Pagination\Paginator;
use Illuminate\Http\Request;
use App\Http\Resources\CorredorResource;

use Core\UseCases\CadastroCorredor\{
    CadastroCorredorUC,
    CadastroCorredorDTO,
};

class CorredorController extends Controller
{
    public function __construct(
        CadastroCorredorUC $cadastroCorredorUC
    ) {
        $this->cadastroCorredorUC = $cadastroCorredorUC;
    }

    /**
     * @OA\Get(
     *     tags={"corredor"},
     *     path="/corredores",
     *     description="Lista corredores",
     *     @OA\Parameter(
     *         description="Nome do corredor",
     *         in="query",
     *         name="nome",
     *         required=false,
     *         @OA\Schema(type="string", example="Diego")
     *     ),
     *     @OA\Parameter(
     *         description="CPF do corredor",
     *         in="query",
     *         name="cpf",
     *         required=false,
     *         @OA\Schema(type="string", example="45681355322")
     *     ),
     *     @OA\Response(response="200", description="Lista de corredores")
     * )
     */
    public function index(Request $req)
    {
        $qtd = $req->qtd ?: 2;
        $page = $req->page ?: 1;
        $nome = $req->nome ?: "";
        $cpf = $req->cpf ?: "";

        Paginator::currentPageResolver(function() use ($page){
            return $page;
        });

        $qb = DB::table('corredores');

        if(!empty($nome))
            $qb->where('nome', '=', $nome);

        if(!empty($cpf))
            $qb->where('cpf', '=', $cpf);

        $corredores = $qb
            ->select('id', 'nome', 'cpf', 'dataNascimento')
            ->get();

        return ['data' => $corredores];
    }

    /**
     * @OA\Post(
     *     tags={"corredor"},
     *     path="/corredores",
     *     description="Cadastro corredor",
     *     @OA\RequestBody(
     *         @OA\MediaType(mediaType="application/json;charset=UTF-8",
     *         @OA\Schema(
     *             @OA\Property(
     *                  property="nome",
     *                  type="string",
     *                  example="Diego"
     *             ),
     *             @OA\Property(
     *                  property="cpf",
     *                  type="string",
     *                  example="37128197060"
     *             ),
     *             @OA\Property(
     *                  property="dataNascimento",
     *                  type="string",
     *                  example="19800507"
     *             )
     *         ),
     *         )
     *     ),
     *     @OA\Response(response="200", description="Corredor criado")
     * )
     */
    public function store(Request $req)
    {
        $dto = new CadastroCorredorDTO();
        $dto->nome = $req->nome;
        $dto->cpf = $req->cpf;
        $dto->dataNascimento = $req->dataNascimento
            ? \DateTime::createFromFormat('Ymd', $req['dataNascimento'])
            : null;

        $corredor = $this->cadastroCorredorUC->execute($dto);

        return new CorredorResource($corredor);
    }
}
