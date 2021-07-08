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
            ->select('nome', 'cpf', 'dataNascimento')
            ->get();

        return [
            'c' => $corredores
        ];


        return UsuarioResource::collection(
            $usuarios
        );
    }

    public function store(Request $req)
    {
        $dto = new CadastroCorredorDTO();
        $dto->nome = $req->nome;
        $dto->cpf = $req->cpf;
        $dto->dataNascimento = $req->dataNascimento
            ? \DateTime::createFromFormat('Ymd', $req['dataNascimento'])
            : null;

        $corredor = $this->cadastroCorredorUC->execute($dto);

        return new CorredorResource(
            $corredor
        );
    }
}
