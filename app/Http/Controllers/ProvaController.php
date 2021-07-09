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
