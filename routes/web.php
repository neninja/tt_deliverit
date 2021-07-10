<?php

$router->get('/', function () use ($router) {
    return $router->app->version();
});

$router->get('/swagger', function () use ($router) {
    return redirect('/public/swagger');
});

$router->get('corredores', 'CorredorController@index');
$router->post('corredores', 'CorredorController@store');

$router->get('provas', 'ProvaController@index');
$router->post('provas', 'ProvaController@store');

$router->get('participacoes', 'ParticipacaoController@index');
$router->post('participacoes', 'ParticipacaoController@store');
$router->put('participacoes', 'ParticipacaoController@update'); // chave composta
