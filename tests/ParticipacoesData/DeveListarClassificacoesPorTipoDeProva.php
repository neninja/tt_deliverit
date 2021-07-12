<?php

namespace Tests\ParticipacoesData;

use Laravel\Lumen\Testing\DatabaseMigrations;
use Laravel\Lumen\Testing\DatabaseTransactions;
use Illuminate\Support\Facades\DB;

class DeveListarClassificacoesPorTipoDeProva extends \Tests\TestCase
{
    public static function seed()
    {
        DB::table('tiposProva')->insert([
            ['distanciaEmKM' => 3],
            ['distanciaEmKM' => 5],
            ['distanciaEmKM' => 10],
            ['distanciaEmKM' => 21],
            ['distanciaEmKM' => 42]
        ]);

        DB::table('provas')->insert([
            [ // 1
                'data' => '2010-08-09',
                'id_tipoProva' => 4,
            ],
            [ // 2
                'data' => '2011-08-09',
                'id_tipoProva' => 3,
            ],
            [ // 3
                'data' => '2012-08-09',
                'id_tipoProva' => 5,
            ],
            [ // 4
                'data' => '2010-08-09',
                'id_tipoProva' => 1,
            ],
            [ // 5
                'data' => '2011-08-09',
                'id_tipoProva' => 2,
            ],
            [ // 6
                'data' => '2012-08-09',
                'id_tipoProva' => 3,
            ],
            [ // 7
                'data' => '2013-08-09',
                'id_tipoProva' => 2,
            ]
        ]);


        DB::table('corredores')->insert([
            [ // 1
                'nome' => 'Rafael',
                'cpf' => '42152025075',
                'dataNascimento' => '2000-01-02',
            ],
            [ // 2
                'nome' => 'Lauren',
                'cpf' => '31077098081',
                'dataNascimento' => '2000-02-02',
            ],
            [ // 3
                'nome' => 'Eduarda',
                'cpf' => '30953327000',
                'dataNascimento' => '2000-03-02',
            ],
            [ // 4
                'nome' => 'Ricardo',
                'cpf' => '51055230084',
                'dataNascimento' => '1990-01-03',
            ],
            [ // 5
                'nome' => 'Luiz',
                'cpf' => '20689415036',
                'dataNascimento' => '1990-02-03',
            ],
            [ // 6
                'nome' => 'Rasmus',
                'cpf' => '89977572020',
                'dataNascimento' => '1990-03-03',
            ],
            [ // 7
                'nome' => '7',
                'cpf' => '25364772071',
                'dataNascimento' => '1990-02-03',
            ],
            [ // 8
                'nome' => '8',
                'cpf' => '66448082042',
                'dataNascimento' => '1990-02-03',
            ],
            [ // 9
                'nome' => '9',
                'cpf' => '25943898034',
                'dataNascimento' => '1990-02-03',
            ],
            [ // 10
                'nome' => '10',
                'cpf' => '24257281049',
                'dataNascimento' => '1990-02-03',
            ],
            [ // 11
                'nome' => 'Rafaela',
                'cpf' => '68495046067',
                'dataNascimento' => '1970-02-04',
            ],
            [ // 12
                'nome' => 'Laurena',
                'cpf' => '28187509031',
                'dataNascimento' => '1970-03-04',
            ],
            [ // 13
                'nome' => 'Eduardo',
                'cpf' => '45261342015',
                'dataNascimento' => '1970-04-04',
            ],
            [ // 14
                'nome' => 'Rica',
                'cpf' => '08606919004',
                'dataNascimento' => '1980-02-05',
            ],
            [ // 15
                'nome' => 'Luizo',
                'cpf' => '15376925005',
                'dataNascimento' => '1980-03-05',
            ],
            [ // 16
                'nome' => 'Rod',
                'cpf' => '85395332006',
                'dataNascimento' => '1980-04-05',
            ],
            [ // 17
                'nome' => '17',
                'cpf' => '75645492030',
                'dataNascimento' => '1970-03-05',
            ],
            [ // 18
                'nome' => '18',
                'cpf' => '66344815043',
                'dataNascimento' => '1970-03-05',
            ],
            [ // 19
                'nome' => '19',
                'cpf' => '06749102069',
                'dataNascimento' => '1970-03-05',
            ],
            [ // 20
                'nome' => '20',
                'cpf' => '71455418072',
                'dataNascimento' => '1970-03-05',
            ],
            [ // 21
                'nome' => 'Rafaeli',
                'cpf' => '13986898077',
                'dataNascimento' => '1960-02-06',
            ],
            [ // 22
                'nome' => 'Laureni',
                'cpf' => '01416601040',
                'dataNascimento' => '1960-03-06',
            ],
            [ // 23
                'nome' => 'Edi',
                'cpf' => '05996229030',
                'dataNascimento' => '1960-03-06',
            ]
        ]);

        DB::table('participacoes')->insert([
            [ // 1
                'id_corredor' => 14,
                'id_prova' => 2,
                'horarioInicio' => '8:00',
                'horarioFim' => '13:00',
            ],
            [ // 2
                'id_corredor' => 5,
                'id_prova' => 5,
                'horarioInicio' => '9:00',
                'horarioFim' => '13:00',
            ],
            [ // 3
                'id_corredor' => 3,
                'id_prova' => 4,
                'horarioInicio' => '8:00',
                'horarioFim' => '13:00',
            ],
            [ // 4
                'id_corredor' => 4,
                'id_prova' => 5,
                'horarioInicio' => '7:00',
                'horarioFim' => '12:00',
            ],
            [ // 5
                'id_corredor' => 16,
                'id_prova' => 2,
                'horarioInicio' => '7:00',
                'horarioFim' => '15:00',
            ],
            [ // 6
                'id_corredor' => 1,
                'id_prova' => 2,
                'horarioInicio' => '8:00',
                'horarioFim' => '12:00',
            ],
            [ // 7
                'id_corredor' => 2,
                'id_prova' => 4,
                'horarioInicio' => '8:00',
                'horarioFim' => '10:00',
            ],
            [ // 8
                'id_corredor' => 6,
                'id_prova' => 5,
                'horarioInicio' => '8:00',
                'horarioFim' => '13:00',
            ],
            [ // 9
                'id_corredor' => 1,
                'id_prova' => 4,
                'horarioInicio' => '8:00',
                'horarioFim' => '11:00',
            ],
            [ // 10
                'id_corredor' => 12,
                'id_prova' => 1,
                'horarioInicio' => '8:00',
                'horarioFim' => '10:00',
            ],
            [ // 11
                'id_corredor' => 11,
                'id_prova' => 1,
                'horarioInicio' => '8:00',
                'horarioFim' => '11:00',
            ],
            [ // 12
                'id_corredor' => 13,
                'id_prova' => 1,
                'horarioInicio' => '8:00',
                'horarioFim' => '12:00',
            ],
            [ // 13
                'id_corredor' => 22,
                'id_prova' => 3,
                'horarioInicio' => '8:00',
                'horarioFim' => '10:00',
            ],
            [ // 14
                'id_corredor' => 21,
                'id_prova' => 3,
                'horarioInicio' => '8:00',
                'horarioFim' => '11:00',
            ],
            [ // 15
                'id_corredor' => 23,
                'id_prova' => 3,
                'horarioInicio' => '8:00',
                'horarioFim' => '12:00',
            ],
            [ // 16
                'id_corredor' => 15,
                'id_prova' => 2,
                'horarioInicio' => '8:00',
                'horarioFim' => '12:00',
            ],
        ]);
    }

    public static function data()
    {
        yield '3km' => [
            [
                'id' => 7,
                'posicao' => 1,
                'corredor' => [
                    'id' => 2,
                    'nome' => 'Lauren',
                ],
                'prova' => [
                    'id' => 4,
                    'data' => '2010-08-09',
                    'distanciaEmKM' => 3,
                ]
            ],
            [
                'id' => 9,
                'posicao' => 2,
                'corredor' => [
                    'id' => 1,
                    'nome' => 'Rafael',
                ],
                'prova' => [
                    'id' => 4,
                    'data' => '2010-08-09',
                    'distanciaEmKM' => 3,
                ]
            ],
            [
                'id' => 3,
                'posicao' => 3,
                'corredor' => [
                    'id' => 3,
                    'nome' => 'Eduarda',
                ],
                'prova' => [
                    'id' => 4,
                    'data' => '2010-08-09',
                    'distanciaEmKM' => 3,
                ]
            ],
        ];
        yield '5km' => [
            [
                'id' => 2,
                'posicao' => 1,
                'corredor' => [
                    'id' => 5,
                    'nome' => 'Luiz',
                ],
                'prova' => [
                    'id' => 5,
                    'data' => '2011-08-09',
                    'distanciaEmKM' => 5,
                ]
            ],
            [
                'id' => 4,
                'posicao' => 2,
                'corredor' => [
                    'id' => 4,
                    'nome' => 'Ricardo',
                ],
                'prova' => [
                    'id' => 5,
                    'data' => '2011-08-09',
                    'distanciaEmKM' => 5,
                ]
            ],
            [
                'id' => 8,
                'posicao' => 3,
                'corredor' => [
                    'id' => 6,
                    'nome' => 'Rasmus',
                ],
                'prova' => [
                    'id' => 5,
                    'data' => '2011-08-09',
                    'distanciaEmKM' => 5,
                ]
            ],
        ];
        yield '10km' => [
            [
                'id' => 16,
                'posicao' => 1,
                'corredor' => [
                    'id' => 15,
                    'nome' => 'Luizo',
                ],
                'prova' => [
                    'id' => 2,
                    'data' => '2011-08-09',
                    'distanciaEmKM' => 10,
                ]
            ],
            [
                'id' => 1,
                'posicao' => 2,
                'corredor' => [
                    'id' => 14,
                    'nome' => 'Rica',
                ],
                'prova' => [
                    'id' => 2,
                    'data' => '2011-08-09',
                    'distanciaEmKM' => 10,
                ]
            ],
            [
                'id' => 5,
                'posicao' => 3,
                'corredor' => [
                    'id' => 16,
                    'nome' => 'Rod',
                ],
                'prova' => [
                    'id' => 2,
                    'data' => '2011-08-09',
                    'distanciaEmKM' => 10,
                ]
            ],
        ];
        yield '21km' => [
            [
                'id' => 10,
                'posicao' => 1,
                'corredor' => [
                    'id' => 12,
                    'nome' => 'Laurena',
                ],
                'prova' => [
                    'id' => 1,
                    'data' => '2010-08-09',
                    'distanciaEmKM' => 21,
                ]
            ],
            [
                'id' => 11,
                'posicao' => 2,
                'corredor' => [
                    'id' => 11,
                    'nome' => 'Rafaela',
                ],
                'prova' => [
                    'id' => 1,
                    'data' => '2010-08-09',
                    'distanciaEmKM' => 21,
                ]
            ],
            [
                'id' => 12,
                'posicao' => 3,
                'corredor' => [
                    'id' => 13,
                    'nome' => 'Eduardo',
                ],
                'prova' => [
                    'id' => 1,
                    'data' => '2010-08-09',
                    'distanciaEmKM' => 21,
                ]
            ],
        ];
        yield '42km' => [
            [
                'id' => 13,
                'posicao' => 1,
                'corredor' => [
                    'id' => 22,
                    'nome' => 'Laureni',
                ],
                'prova' => [
                    'id' => 3,
                    'data' => '2012-08-09',
                    'distanciaEmKM' => 42,
                ]
            ],
            [
                'id' => 14,
                'posicao' => 2,
                'corredor' => [
                    'id' => 21,
                    'nome' => 'Rafaeli',
                ],
                'prova' => [
                    'id' => 3,
                    'data' => '2010-08-09',
                    'distanciaEmKM' => 42,
                ]
            ],
            [
                'id' => 15,
                'posicao' => 3,
                'corredor' => [
                    'id' => 23,
                    'nome' => 'Edi',
                ],
                'prova' => [
                    'id' => 3,
                    'data' => '2010-08-09',
                    'distanciaEmKM' => 42,
                ]
            ],
        ];
    }
}
