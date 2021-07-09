<?php

namespace App\Infra\Repositories\Eloquent;

use Core\Models\Prova;
use App\Models\Prova as M;

class ProvasRepository implements \Core\Contracts\Repositories\IProvasRepository
{
    protected function e2m(Prova $e)
    {
        $m = new M();
        if(!is_null($e->id)){
            $m->id = $e->id;
        }
        $m->data = $e->data;
        $m->id_tipoProva = $e->tipo->id;
        $m->data = $e->data;
        return $m;
    }

    public function save(Prova $e): Prova
    {
        $m = $this->e2m($e);
        $m->save();
        $e->id = $m->id;
        return $e;
    }
}
