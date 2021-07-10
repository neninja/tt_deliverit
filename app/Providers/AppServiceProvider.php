<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

use Core\UseCases\{
    CadastroCorredor\CadastroCorredorUC,
    CadastroProva\CadastroProvaUC,
    InscricaoProva\InscricaoProvaUC,
};

use Core\Contracts\Repositories\{
    ICorredoresRepository,
    IProvasRepository,
    ITiposProvaRepository,
    IParticipacoesRepository,
};

use App\Infra\Repositories\Eloquent\{
    CorredoresRepository,
    ProvasRepository,
    TiposProvaRepository,
    ParticipacoesRepository,
};

class AppServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->app->bind(
            ICorredoresRepository::class, CorredoresRepository::class
        );

        $this->app->bind(
            IProvasRepository::class, ProvasRepository::class
        );

        $this->app->bind(
            ITiposProvaRepository::class, TiposProvaRepository::class
        );

        $this->app->bind(
            IParticipacoesRepository::class, ParticipacoesRepository::class
        );

        $this->app->bind(CadastroCorredorUC::class, function ($app) {
            return new CadastroCorredorUC(
                $app->make(ICorredoresRepository::class)
            );
        });

        $this->app->bind(CadastroProvaUC::class, function ($app) {
            return new CadastroProvaUC(
                $app->make(IProvasRepository::class),
                $app->make(ITiposProvaRepository::class)
            );
        });

        $this->app->bind(InscricaoProvaUC::class, function ($app) {
            return new InscricaoProvaUC(
                $app->make(IParticipacoesRepository::class),
                $app->make(ICorredoresRepository::class),
                $app->make(IProvasRepository::class)
            );
        });
    }
}
