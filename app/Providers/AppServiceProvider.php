<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

use Core\UseCases\CadastroCorredor\{
    CadastroCorredorUC,
};

use Core\Contracts\Repositories\{
    ICorredoresRepository,
};

use App\Infra\Repositories\Eloquent\{
    CorredoresRepository,
};

class AppServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->app->bind(
            ICorredoresRepository::class, CorredoresRepository::class
        );

        $this->app->bind(CadastroCorredorUC::class, function ($app) {
            return new CadastroCorredorUC(
                $app->make(ICorredoresRepository::class)
            );
        });
    }
}
