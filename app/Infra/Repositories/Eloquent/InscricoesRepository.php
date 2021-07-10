<?php

namespace App\Infra\Repositories\Eloquent;

use Core\Models\Inscricao;
use App\Models\Inscricao as M;

class InscricoesRepository implements \Core\Contracts\Repositories\IInscricoesRepository
{
    public static function e2m(Inscricao $e)
    {
        $m = new M();
        if(!is_null($e->id)){
            $m->id = $e->id;
        }
        $m->id_corredor = $e->corredor->id;
        $m->id_prova = $e->prova->id;
        return $m;
    }

    public static function m2e(?M $m): ?Prova
    {
        return $m ? new Prova(
            $m->id,
            CorredoresRepository::m2e($m->corredor),
            ProvaRepository::m2e($m->prova)
        ) : null;
    }

    public function save(Inscricao $e): Inscricao
    {
        $m = self::e2m($e);
        $m->save();
        $e->id = $m->id;
        return $e;
    }

    public function findById(int $id): ?Inscricao
    {
        $m = M::find($id);
        return self::m2e($m);
    }

    public function possuiInscricaoNoDia(\DateTime $dia): bool
    {
        $inscricoes = M::whereHas('prova', function ($query) {
            return $query->whereDate('data', '=', $dia->format('Y-m-d'));
        })->get();

        return empty($inscricoes);
    }
}

