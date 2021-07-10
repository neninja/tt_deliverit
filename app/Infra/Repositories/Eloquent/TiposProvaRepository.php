<?php

namespace App\Infra\Repositories\Eloquent;

use Core\Models\TipoProva;
use App\Models\TipoProva as M;

class TiposProvaRepository implements \Core\Contracts\Repositories\ITiposProvaRepository
{
    public static function e2m(TipoProva $e)
    {
        $m = new M();
        if(!is_null($e->id)){
            $m->id = $e->id;
        }
        $m->distanciaEmKM = $e->distanciaEmKM;
        return $m;
    }

    public static function m2e(?M $m): ?TipoProva
    {
        return $m ? new TipoProva(
            $m->id,
            $m->distanciaEmKM
        ) : null;
    }

    public function findById(int $id): ?TipoProva
    {
        $m = M::find($id);
        return self::m2e($m);
    }
}
